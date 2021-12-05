<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends AdminController
{

    public function index()
    {
        $this->data["stories"] = Post::with('location', 'user', 'status', 'comments', 'tags', 'album')->paginate(5);
        return view('admin.pages.stories.index', $this->data);
    }

    public function show($id)
    {
        $this->data["story"] = Post::with('location', 'user', 'status', 'comments', 'tags', 'album')->find($id);
        return view('admin.pages.stories.details',$this->data);
    }

    public function approveStory($id){
        try {
            $story = Post::find($id);
            $story->published = 1;
            $story->published_at = date("Y-m-d H:i:s");
            $story->is_active = 1;

            $story->save();
            return redirect()->route('stories-manage.index')->with('successPublished', 'Story successfully published!');
        }catch (\Exception $e){
            return redirect()->back()->with('errorPublished', $ex->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $story = Post::find($id);

            $story->tags()->detach();
            $story->comments()->delete();
            $story->delete();

            return redirect()->back()->with('successDeleteStory', 'Story deleted successfully!');
        }catch (\Exception $ex) {
            return redirect()->back()->with('errorDeleteStory', $ex->getMessage());
        }
    }
}
