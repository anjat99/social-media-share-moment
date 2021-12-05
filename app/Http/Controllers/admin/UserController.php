<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends AdminController
{

    public function index()
    {
        $this->data["users"] = User::with('role', 'gender','albums', 'stories', 'comments', 'friends')->where('role_id','<>',1)->paginate(4);
        return view('admin.pages.users.index', $this->data);
    }

    public function show($id)
    {
        $this->data["user"] =  User::with('friends')->with('friends.role','friends.gender', 'friends.stories', 'friends.friends')->find($id);
        return view('admin.pages.users.friend-list',$this->data);
    }

    public function edit($id)
    {
        $this->data["user"] = User::with('role')->find($id);
        return view('admin.pages.users.edit', $this->data);
    }

    public function blockUser($id){
        try {
            $user = User::find($id);
            $user->is_blocked = 1;
            $user->blocked_at = date("Y-m-d H:i:s");
            $user->is_active = 0;
            $user->save();

            return redirect()->back()->with('successBlocked', 'User successfully blocked!');
        }catch (\Exception $ex){
            return redirect()->back()->with('errorBlocked', $ex->getMessage());
        }
    }

    public function unblockUser($id){
        try {
            $user = User::find($id);
            $user->is_blocked = 0;
            $user->blocked_at = null;
            $user->is_active = 1;
            $user->save();

            return redirect()->back()->with('successUnblocked', 'User successfully unblocked!');
        }catch (\Exception $ex){
            return redirect()->back()->with('errorUnblocked', $ex->getMessage());
        }
    }

    public function update(UpdateUserRequest $request, $id)
    {
//        try{
//            $user = User::with('role')->find($id);
//            $user->first_name = $request->firstname;
//            $user->last_name = $request->lastname;
//            if($user->email !== $request->email)
//            {
//                $exists = User::where('email',$request->email)->exists();
//                if($exists)
//                    return redirect()->back()->with('warningUpdateUser','There is already an user with that email!');
//                $user->email = $request->email;
//            }
//            if($user->username !== $request->username)
//            {
//                $exists = User::where('username',$request->username)->exists();
//                if($exists)
//                    return redirect()->back()->with('warningUpdateUser','There is already an user with that email!');
//                $user->email = $request->email;
//            }
//
////            $user->email = $request->email;
//            $user->role_id = $request->userRole;
//            $user->save();
//
//            return redirect()->route('users.index', $user->id)->with('successUpdateUser', "User updated successfully!");
//        }catch(\Exception $e){
//            return redirect()->route('users.edit', $user->id)->with('warningUpdateUser', $e->getMessage());
//        }
    }

    public function destroy($id)
    {
        try {
            $user = User::find($id);
            $userEmail = $user->email;

            $user->albums()->delete();
            $user->stories()->delete();
            $user->comments()->delete();
            $user->friends()->detach();
            $user->delete();

            return redirect()->back()->with('successDeleteUser', 'User with email ' . ' '. $userEmail .' deleted successfully!');
        }catch (\Exception $ex) {
            return redirect()->back()->with('errorDeleteUser', $ex->getMessage());
        }
    }
}
