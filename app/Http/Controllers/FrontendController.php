<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Menu;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public  $data;
    const STORIES_LIMIT = 8;

    public function __construct()
    {
        $this->data["categories"] = Category::with('albums','albums.stories')->get();
        $this->data["menu"] = Menu::all();
    }

    public function index(Request $request)
    {
        $this->data["tags"] = Tag::with('stories')->get();
        $this->data["stories"] = Post::getStories()->join('statuses as vs', 'status_id','=','vs.id')->where('vs.name','<>','private')->where('published','=',1)->paginate(self::STORIES_LIMIT);
        return view("frontend.pages.index", $this->data);
    }

    public function fetchStories(Request $request){
        $data["currentUser"] = session("user");
        $data["tags"] = Tag::with('stories')->get();
        $data["stories"] = Post::sortFilterSearchAndPageStories($request)->paginate(self::STORIES_LIMIT);
        $data['page'] = isset($request->page) ? $request->page : 1;

        return response()->json($data);
    }

    public function showAllUsers()
    {
        $users = User::with('role', 'gender','albums', 'stories', 'comments', 'friends')->where('id', '!=', session()->get('user')->id)->where('role_id','<>',1)->where("is_active",'=',1);

        if (session()->get('user')->friends->count()) {
            $users->whereNotIn('id', session()->get('user')->friends->modelKeys());
        }

        $users = $users->get();

        return view('frontend.pages.users.index',$this->data)->with('users',$users);
    }

    public function showUserProfile($id)
    {
        $this->data["users"] = User::with('role', 'gender','albums', 'stories', 'comments', 'friends')->where('role_id','<>',1)->where("id",$id)->first();
        return view('frontend.pages.users.index', $this->data);
    }
}
