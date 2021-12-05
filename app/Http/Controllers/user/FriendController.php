<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FrontendController;
use App\Models\User;
use App\Models\UserActivity;
use App\Models\UserFriend;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class FriendController extends FrontendController
{
    const USERS_LIMIT = 5;
    public function index(Request $request)
    {
        return view("frontend.pages.friends.index", $this->data);
    }

    public function userFriends($id){
        $this->data['user'] = User::with('friends')->with('friends.albums','friends.stories','friends.friends')->where('id',$id)->first();
        return view("frontend.pages.friends.index", $this->data);
    }

    public function getFriends($id){
        $this->data['user'] = User::with('friends')->with('friends.albums','friends.stories','friends.friends')->find($id);
        return view("frontend.pages.friends.index", $this->data);
    }

    public function show($id){
        $this->data['user'] =  User::with('role','gender','stories', 'friends')->with('friends.stories','friends.friends')->with('stories.location', 'stories.status')->find($id);
        return view("frontend.pages.users.show", $this->data);
    }

    public function search(Request $request){

        $not_friends = User::with('role','gender','stories', 'friends')->where('id', '!=', $request->session()->get('user')->id)->where('role_id','<>',1)->where("is_active",'=',1);

        if ($request->session()->get('user')->friends->count()) {
            $not_friends->whereNotIn('id', $request->session()->get('user')->friends->modelKeys());
        }

        $not_friends =  $not_friends->where('username','LIKE',"%".$request->keyword."%");


        $not_friends = $not_friends->get();

        return response()->json($not_friends);
    }

    public function addFriend(Request $request){
        try{
            $friend = new UserFriend();
            $friend->user_id = $request->session()->get('user')->id;
            $friend->friend_id = $request->id;
            $friend->save();

            if(session()->has('user')){
                $userActivity = new UserActivity();
                $userActivity->user_id = session()->get("user")->id;
                $userActivity->ip_address = request()->ip();
                $userActivity->date = date("Y-m-d H:i:s");
                $userActivity->activity = "follow user with id: $friend->friend_id";

                $userActivity->save();
            }

            $user = User::find($friend->user_id);
            session()->put('user',$user);

            $not_friends = User::with('role','gender','stories', 'friends')->where('id', '<>', $request->session()->get('user')->id)->where('role_id','<>',1);

            if ($request->session()->get('user')->friends->count()) {
                $not_friends->whereNotIn('id', $request->session()->get('user')->friends->modelKeys());
            }
            $not_friends = $not_friends->get();

            return response()->json(["data"=>$not_friends,"msg"=>"Added Friend"]);


        }catch (\Exception $e){
            return redirect()->back()->with("error", $e->getMessage());
        }
    }

    public function followUser($id){
        try {
            $user = User::find($id);
            $friend = new UserFriend();
            $friend->user_id = session()->get('user')->id;
            $friend->friend_id = $user->id;
            $friend->save();

            if(session()->has('user')){
                $userActivity = new UserActivity();
                $userActivity->user_id = session()->get("user")->id;
                $userActivity->ip_address = request()->ip();
                $userActivity->date = date("Y-m-d H:i:s");
                $userActivity->activity = "follow user with id: $friend->friend_id";

                $userActivity->save();
            }

            $user = User::find(session()->get("user")->id);
            session()->put('user',$user);


            return redirect()->back()->with('successFollowUser', 'User successfully reported!');
        }catch (\Exception $ex){
            return redirect()->back()->with('errorFollowUser', $ex->getMessage());
        }
    }

    public function unfollowUser($id){
        try {

            UserFriend::where('user_id',session("user")->id)->where('friend_id',$id)->delete();


            if(session()->has('user')){
                $userActivity = new UserActivity();
                $userActivity->user_id = session()->get("user")->id;
                $userActivity->ip_address = request()->ip();
                $userActivity->date = date("Y-m-d H:i:s");
                $userActivity->activity = "unfollow user with id: $id";

                $userActivity->save();
            }

            $user = User::find(session()->get("user")->id);
            session()->put('user',$user);


            return redirect()->back()->with('successUnfollowUser', 'User successfully unfollowed!');
        }catch (\Exception $ex){
            return redirect()->back()->with('errorUnfollowUser', $ex->getMessage());
        }
    }

    public function reportUser($id){
        try {
            $user = User::find($id);
            $user->is_reported = 1;
            $user->reported_at = date("Y-m-d H:i:s");
            $user->is_active = 1;
            $user->save();


            if(session()->has('user')){
                $userActivity = new UserActivity();
                $userActivity->user_id = session()->get("user")->id;
                $userActivity->ip_address = request()->ip();
                $userActivity->date = date("Y-m-d H:i:s");
                $userActivity->activity = "report user with id: $id";

                $userActivity->save();
            }

            $user = User::find(session("user")->id);
            session()->put('user',$user);

            return redirect()->back()->with('successReportUser', 'User successfully reported!');
        }catch (\Exception $ex){
            return redirect()->back()->with('errorReportUser', $ex->getMessage());
        }
    }

    public function cancelReport($id){
        try {
            $user = User::find($id);
            $user->is_reported = 0;
            $user->reported_at = null;
            $user->is_active = 1;
            $user->save();

            $user = User::find(session("user")->id);
            session()->put('user',$user);
            if(session()->has('user')){
                $userActivity = new UserActivity();
                $userActivity->user_id = session()->get("user")->id;
                $userActivity->ip_address = request()->ip();
                $userActivity->date = date("Y-m-d H:i:s");
                $userActivity->activity = "cancel report for user with id: $id";

                $userActivity->save();
            }

            return redirect()->back()->with('successCancelReport', 'Successfully canceled report!');
        }catch (\Exception $ex){
            return redirect()->back()->with('errorCancelReport', $ex->getMessage());
        }
    }
}
