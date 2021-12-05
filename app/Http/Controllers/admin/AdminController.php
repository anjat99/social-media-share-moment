<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Location;
use App\Models\Menu;
use App\Models\Post;
use App\Models\User;
use App\Models\UserActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public $data;

    public function __construct()
    {
        $this->data["menu"] = Menu::all();
    }

    public function index()
    {
        $this->data["activities"] = UserActivity::getActivities();
        $this->data["users"] = User::latestFiveRegistered();
        $this->data["allClients"] = User::all();
        $this->data["allStories"] = Post::all();
        $this->data["allMessages"] = Contact::all();
        $this->data["unreadMessages"] = Contact::unreadMessages();
        $this->data["allLocations"] = Location::all();

        return view('admin.pages.index', $this->data);
    }

    public function filterByDate(Request $request){
        $activities = UserActivity::getActivities($request->dateFrom,$request->dateTo);
        return response()->json($activities);
    }

    public function logout(Request $request) {
        if(session()->has('user')){
            $userActivity = new UserActivity();
            $userActivity->user_id = session()->get("user")->id;
            $userActivity->ip_address = request()->ip();
            $userActivity->date = date("Y-m-d H:i:s");
            $userActivity->activity = "logout admin";

            $userActivity->save();
        }

        $request->session()->remove("user");
        return redirect()->route("login.create")->with("success", "Admin successfully logged out.");
    }
}
