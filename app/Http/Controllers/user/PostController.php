<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FrontendController;
use App\Http\Requests\user\InsertStoryRequest;
use App\Models\Album;
use App\Models\Location;
use App\Models\Post;
use App\Models\Status;
use App\Models\Tag;
use App\Models\User;
use App\Models\UserActivity;
use App\Models\VisibilityStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends FrontendController
{
    public function index(Request $request)
    {
        $this->data["statuses"] = Status::all();
        $this->data["stories"] = Post::filterStoriesByStatus($request)->where('user_id',session()->get('user')->id)->orderByDesc('posts.published_at')->paginate(self::STORIES_LIMIT);

        return view("frontend.pages.stories.index", $this->data);
    }

    public function filterStories(Request $request){
        $this->data["statuses"] = Status::all();
        $this->data["stories"] = Post::filterStoriesByStatus($request)->orderByDesc('posts.published_at')->paginate(self::STORIES_LIMIT);
        $data['page'] = isset($request->page) ? $request->page : 1;

        return response()->json($this->data);
    }

    public function create()
    {
        $this->data["statuses"] = Status::all();
        $this->data["tags"] = Tag::all();
        $this->data["locations"] = Location::all();
        $this->data["albums"] = Album::where("user_id",session("user")->id)->get();
        return view("frontend.pages.stories.add", $this->data);
    }

    public function store(InsertStoryRequest $request)
    {
        DB::beginTransaction();

        try{
            $story = new Post();
            $story->caption = $request->title;
            $story->description = $request->description;
            $story->status_id = $request->status;
            $story->is_active = 0;
            $story->published = 0;
            $story->user_id = session("user")->id;

            $image = Post::uploadCoverImage($request->image);
            $story->cover = $image;

            if($request->has('location') && $request->get('location') != "0"){
                $story->location_id = $request->location;
                $story->save();
            }else{
                $story->location_id = null;
                $story->save();
            }

            $story->save();
            $insertedPost = $story->id;

            if($request->has('album') && $request->get('album') != "0"){
                $story->album_id = $request->album;
                $story->save();
            }else{
                $story->album_id = null;
                $story->save();
            }

            if($request->has('tag_id')){
                $story->tags()->attach($request->get('tag_id'));
                $story->save();
            }

            DB::commit();

            $user = User::find($story->user_id);
            session()->put('user',$user);

            if(session()->has('user')){
                $userActivity = new UserActivity();
                $userActivity->user_id = session()->get("user")->id;
                $userActivity->ip_address = request()->ip();
                $userActivity->date = date("Y-m-d H:i:s");
                $userActivity->activity = "insert new post";

                $userActivity->save();
            }

            return redirect()->route('stories.index', $story->id)->with('successInsertStory', 'Story added successfully!');
        }catch(\Exception $e){
            DB::rollBack();
            \Log::error($e->getMessage());
            return redirect()->back()->with('errorInsertStory', $e->getMessage());
        }
    }

    public function showMyStory($id)
    {
        $data = Post::getMyStory($id);
        $this->data["story"] = $data['post'];

        return view('frontend.pages.stories.show', $this->data);
    }

    public function showStory($id)
    {
        $data = Post::getStory($id);
        $this->data["story"] = $data['post'];

        return view('frontend.pages.stories.show', $this->data);
    }

    public function edit($id)
    {
        $this->data['story'] = Post::find($id);
        $this->data["statuses"] = Status::all();
        $this->data["tags"] = Tag::all();
        $this->data["locations"] = Location::all();
        $this->data["albums"] = Album::where("user_id",session("user")->id)->get();
        return view("frontend.pages.stories.edit", $this->data);
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try{
            $story = Post::find($id);
            if($story->caption !== $request->title)
            {
                $exists = Post::where('caption',$request->title)->exists();
                if($exists)
                    return redirect()->back()->with('warningUpdateStory','There is already an story with this title!');
                $story->caption = $request->title;
            }

            $story->description = $request->description;
            $story->status_id = $request->status;
            $story->is_active = 0;
            $story->published = 0;
            $story->user_id = session("user")->id;

            $story->save();

            if($request->has('image')){
                $image = Post::uploadCoverImage($request->image);
                Post::deleteCoverImage($story->image);
                $newImage = Post::uploadCoverImage($request->image);
                $story->cover = $newImage;
                $story->save();
            }

            if($request->has('location')){
                $story->location_id = $request->location;
                $story->save();
            }


            $insertedPost = $story->id;

            if($request->has('album')){
                $story->album_id = $request->album;
                $story->save();
            }

            if($request->has('tag')){
                $story->tags()->sync($request->get('tag'));
                $story->save();
            }

            DB::commit();


            $user = User::find($story->user_id);
            session()->put('user',$user);

            if(session()->has('user')){
                $userActivity = new UserActivity();
                $userActivity->user_id = session()->get("user")->id;
                $userActivity->ip_address = request()->ip();
                $userActivity->date = date("Y-m-d H:i:s");
                $userActivity->activity = "update story";

                $userActivity->save();
            }

            return redirect()->route('stories.index')->with('successUpdateStory', "Story updated successfully!");
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            return redirect()->back()->with('errorUpdateStory', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $story = Post::find($id);
            $user = User::find($story->user_id);

            $story->tags()->detach();
            $story->comments()->delete();
            $story->delete();


            session()->put('user',$user);

            if(session()->has('user')){
                $userActivity = new UserActivity();
                $userActivity->user_id = session()->get("user")->id;
                $userActivity->ip_address = request()->ip();
                $userActivity->date = date("Y-m-d H:i:s");
                $userActivity->activity = "delete story";

                $userActivity->save();
            }


            return redirect()->back()->with('successDeleteStory', 'Story deleted successfully!');

        }catch (\Exception $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('errorDeleteStory', $ex->getMessage());
        }
    }
}
