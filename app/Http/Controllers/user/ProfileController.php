<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FrontendController;
use App\Http\Requests\admin\UpdateUserRequest;
use App\Http\Requests\user\ChangePasswordRequest;
use App\Models\Gender;
use App\Models\User;
use App\Models\UserActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ProfileController extends FrontendController
{
    public function index(Request $request)
    {
        $this->data['user'] =  User::with('role','gender','albums','stories','activities','comments','friends')->where('id',$request->session()->get('user')->id)->first();
        return view("frontend.pages.profile.main", $this->data);
    }

    public function edit($id){
        $this->data['user'] = User::with('role','gender')->find($id);
        $this->data["genders"] = Gender::all();
        return view('frontend.pages.profile.edit', $this->data);
    }

    public function update(UpdateUserRequest $request, $id){
        try{
            $user = User::find($id);
            $user->first_name = $request->firstName;
            $user->last_name = $request->lastName;
            $user->birthdate = $request->birthDate;
            $user->email = $request->email;
            $user->username = $request->username;
            $user->gender_id = $request->gender;

            if($user->email !== $request->email)
            {
                $exists = User::where('email',$request->email)->exists();
                if($exists)
                    return redirect()->back()->with('warningUpdateProfile','There is already an user with that email!');
                $user->email = $request->email;
            }
            if($request->has('image')){
                $image = User::uploadAvatar($request->image);
                User::deleteAvatar($user->image);
                $newImage = User::uploadAvatar($request->image);
                $user->profile_image = $newImage;
                $user->save();
            }



            $user->save();
            $user = User::find($user->id);
            session()->put('user',$user);

            if(session()->has('user')){
                $userActivity = new UserActivity();
                $userActivity->user_id = session()->get("user")->id;
                $userActivity->ip_address = request()->ip();
                $userActivity->date = date("Y-m-d H:i:s");
                $userActivity->activity = "update profile";

                $userActivity->save();
            }

            return redirect()->route('profile.index', $user->id)->with('successUpdateProfile', "User profile updated successfully!");
        }catch(\Exception $e){
            return redirect()->back()->with('errorUpdateProfile', $e->getMessage());
        }
    }

    public function formChangePassword($id){
        $this->data["u"] = User::find($id);
        return view('frontend.pages.profile.change-password', $this->data);
    }

    public function changePassword(ChangePasswordRequest $request, $id){
        try {
            $user = User::find($id);
            if($user->password !== md5($request->current_password))
            {
                return redirect()->back()->with('warningChangePassword','Please provide a valid current password.');
            }
            if($request->password !== $request->password_confirmation)
            {
                return redirect()->back()->with('warningChangePassword','The new password needs to match filed for confirmation.');
            }
            $user->password = md5($request->password);
            $user->save();

            session()->put('user',$user);

            if(session()->has('user')){
                $userActivity = new UserActivity();
                $userActivity->user_id = session()->get("user")->id;
                $userActivity->ip_address = request()->ip();
                $userActivity->date = date("Y-m-d H:i:s");
                $userActivity->activity = "update password";

                $userActivity->save();
            }
            return redirect()->back()->with('successChangePassword','You have successfully changed your password!');
        }catch (\Exception $e)
        {
            return redirect()->back()->with('errorChangePassword','There was an error occured during changing  your password!');
        }
    }

}
