<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends AdminController
{

    public function index()
    {
        $this->data["comments"] = Comment::with('user', 'story')->paginate(5);
        return view('admin.pages.comments.index', $this->data);
    }

    public function show($id)
    {
        $this->data["comment"] = Comment::with('user', 'story')->with('story.user')->find($id);
        return view('admin.pages.comments.details',$this->data);
    }

    public function destroy($id)
    {
        try {
            $comment = Comment::find($id);
            $comment->delete();

            return redirect()->back()->with('successDeleteComment', 'Comment deleted successfully!');
        }catch (\Exception $ex) {
            return redirect()->back()->with('errorDeleteComment', $ex->getMessage());
        }
    }
}
