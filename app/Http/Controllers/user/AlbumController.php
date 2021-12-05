<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FrontendController;
use App\Http\Requests\user\InsertAlbumRequest;
use App\Http\Requests\user\UpdateAlbumRequest;
use App\Models\Album;
use App\Models\Category;
use App\Models\User;
use App\Models\UserActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AlbumController extends FrontendController
{
    public function index(Request $request)
    {
        $this->data["albums"] = Album::with('category','user','stories')->where('user_id',session()->get('user')->id)->get();
        return view("frontend.pages.albums.index", $this->data);
    }

    public function createAlbum($id)
    {
        $this->data["category"] = Category::find($id);
        return view("frontend.pages.albums.add", $this->data);
    }

    public function store(InsertAlbumRequest $request)
    {
        try {
            $album = new Album();
            $album->title = $request->title;
            $album->description = $request->description;
            $album->category_id = $request->category_id;
            $album->user_id = session()->get("user")->id;
            $album->save();

            $user = User::find($album->user_id);
            session()->put('user',$user);
            if(session()->has('user')){
                $userActivity = new UserActivity();
                $userActivity->user_id = session()->get("user")->id;
                $userActivity->ip_address = request()->ip();
                $userActivity->date = date("Y-m-d H:i:s");
                $userActivity->activity = "Making new Album";

                $userActivity->save();
            }
            return redirect()->route('albums.index')->with('successAddAlbum', 'Collection/Album added successfully!');


        }catch (\Exception $e){
            \Log::error($e->getMessage());
            return redirect()->back()->with('errorAddAlbum', $e->getMessage());
        }
    }

    public function show($id)
    {
        $this->data["storiesByAlbum"] = Album::with('category','user','stories')->where('user_id',session("user")->id)->where('id',$id)->first();
        return view("frontend.pages.albums.stories-by-album", $this->data);
    }

    public function edit($id)
    {
        $this->data["categories"] = Category::all();
        $this->data["album"] = Album::find($id);
        return view("frontend.pages.albums.edit", $this->data);
    }

    public function update(UpdateAlbumRequest $request, $id)
    {
        try{
            $album = Album::where("user_id", session("user")->id)->find($id);
            if($album->title !== $request->title)
            {
                $exists = Album::where('title',$request->title)->exists();
                if($exists)
                    //Log::warning("You already have an album with this title!");
                    return redirect()->back()->with('warningUpdateAlbum','You already have an album with this title!');
                $album->title = $request->title;
            }
            $album->description = $request->description;
            $album->category_id = $request->category_id;
            $album->user_id = session()->get("user")->id;

            $album->save();

            $user = User::find($album->user_id);
            session()->put('user',$user);

            $titleAlbum =  $album->title;

            if(session()->has('user')){
                $userActivity = new UserActivity();
                $userActivity->user_id = session()->get("user")->id;
                $userActivity->ip_address = request()->ip();
                $userActivity->date = date("Y-m-d H:i:s");
                $userActivity->activity = "update Album: ". $titleAlbum;

                $userActivity->save();
            }
            return redirect()->route('albums.index', $album->id)->with('successUpdateAlbum', 'Album edited successfully!');

        }catch (\Exception $e){
            Log::error($e->getMessage());
            return redirect()->back()->with('errorUpdateAlbum', $e->getMessage());
        }
    }

    public function getAll()
    {
        $this->data["apiAlbums"] = Album::with('category','stories')->where("user_id", session("user")->id)->get();
        return response()->json($this->data);
    }

    public function destroy(Request $request, $id)
    {
        try{
            $album = Album::find($id);
            $user = User::find(session("user")->id);
            $album->stories()->detach();
            $album->delete();
            if($request->ajax()){
                session()->put('user',$user);
                return response()->json(["message" => "Successfully deleted album"]);
            }
            return redirect()->route("albums.index")->with('successDeleteAlbum', 'Successfully deleted album');
        }catch (\Exception $e){
            Log::error($e->getMessage());
            return redirect()->back()->with('errorUpdateAlbum', $e->getMessage());
        }
    }
}
