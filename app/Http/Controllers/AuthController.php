<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Models\UserActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view("frontend.pages.auth.login");
    }

    public function login(LoginRequest $request) {
        try {
            $user = User::with('role','gender','albums','stories','activities','comments','friends')->with('albums.stories','friends.albums','friends.stories','friends.comments','friends.friends')->where([
                'email' => $request->email,
                'password' => md5($request->password)
            ])->first();
           

            if ($user) {
                $request->session()->put('user', $user);
                if(session()->has('user')){
                    $userActivity = new UserActivity();
                    $userActivity->user_id = session()->get("user")->id;
                    $userActivity->ip_address = request()->ip();
                    $userActivity->date = date("Y-m-d H:i:s");
                    $userActivity->activity = "login";
                    $userActivity->save();
                }
                return $user->role_id == 1 ? redirect()->route("admin.dashboard")->with("success", "Admin successfully login.") : redirect()->route("user.feed")->with("success", "User successfully logged in .");

            } else {
                return redirect()->back()->with("warning", "Wrong username or password.");
            }
        } catch (\Exception $e) {
            return redirect()->back()->with("error", $e->getMessage());
        }
    }

    public function showRegisterForm()
    {
        return view("frontend.pages.auth.register");
    }

    public function register(RegisterRequest $request){

        try {
            $user = new User();

            $user->first_name = $request->firstname;
            $user->last_name = $request->lastname;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->role_id = 2;
            $user->gender_id = $request->gender;
            $user->birthdate = date("$request->birthdate");
            $user->is_active = 1;
            $user->is_blocked = 0;
            if($request->password !== $request->password_confirmation)
            {
                return redirect()->back()->with('warningChangePassword','The new password needs to match filed for confirmation.');
            }
            $user->password = md5($request->password);
            $user->save();

            if(session()->has('user')){
                $userActivity = new UserActivity();
                $userActivity->user_id = session()->get("user")->id;
                $userActivity->ip_address = request()->ip();
                $userActivity->date = date("Y-m-d H:i:s");
                $userActivity->activity = "registered";
                $userActivity->save();
            }
            return  redirect()->route("login.create")->with("success", "User successfully registered.");
        } catch(\Exception $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with("error", "An error has occurred, please try again later.");
        }
    }

    public function logout(Request $request) {
        if(session()->has('user')){
            $userActivity = new UserActivity();
            $userActivity->user_id = session()->get("user")->id;
            $userActivity->ip_address = request()->ip();
            $userActivity->date = date("Y-m-d H:i:s");
            $userActivity->activity = "logout";
            $userActivity->save();
        }
        $request->session()->remove("user");
        return redirect()->route("login.create")->with("success", "User successfully logged out.");
    }
}
