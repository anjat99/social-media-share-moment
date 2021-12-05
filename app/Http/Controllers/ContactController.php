<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Models\Contact;
use App\Models\UserActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContactController extends FrontendController
{

    public function create()
    {
        return view("frontend.pages.contact",$this->data);
    }

    public function store(StoreContactRequest $request)
    {
        try {
            $message = new Contact();
            $message->name = $request->input('name');
            $message->email = $request->input('email');
            $message->subject = $request->input('subject');
            $message->message = $request->input('message');
            $message->is_read = 0;

            $result = $message->save();

            if(session()->has('user')){
                $userActivity = new UserActivity();
                $userActivity->user_id = session()->get("user")->id;
                $userActivity->ip_address = request()->ip();
                $userActivity->date = date("Y-m-d H:i:s");
                $userActivity->activity = "send message";

                $userActivity->save();
            }

            if($result)
                return response(['message' => 'Message is created successfully'], Response::HTTP_CREATED);
            else
                return response(['message'=> 'Data is Invalid'], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch(\Exception $ex) {
            \Log::error($ex->getMessage());
            return response(['message'=> $ex->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
