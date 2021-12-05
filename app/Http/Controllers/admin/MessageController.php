<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class MessageController extends AdminController
{

    public function index()
    {
        $this->data["messages"] = Contact::paginate(5);
        return view('admin.pages.messages.index', $this->data);
    }

    public function getAll(Request $request)
    {
        $this->data["apiMessages"] = Contact::paginate(5);
        return response()->json($this->data);
    }

    public function show($id)
    {
        $this->data["message"] = Contact::find($id);

        $message = Contact::find($id);
        $message->is_read = 1;
        $message->save();
        return view('admin.pages.messages.details',$this->data);
    }

    public function destroy(Request $request, $id)
    {
        try{
            $message = Contact::find($id);
            $message->delete();
            if($request->ajax()){
                return response()->json(["message" => "Successfully deleted message"]);
            }
            return redirect()->route("messages.index")->with("success","message");
        }catch (\Exception $exception){
            return redirect()->route("messages.index")->with("error",$exception->getMessage());
        }
    }
}
