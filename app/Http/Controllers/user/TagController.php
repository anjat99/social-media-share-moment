<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FrontendController;
use App\Http\Requests\admin\InsertTagRequest;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class TagController extends FrontendController
{
    public function index(Request $request)
    {
        $this->data["tags"] =  Tag::all();
        return view('frontend.pages.tags.index', $this->data);
    }

    public function create()
    {
        return view('frontend.pages.tags.add', $this->data);
    }

    public function store(InsertTagRequest $request)
    {
        try{
            $tag = new Tag();
            $tag->title = $request->title;

            $tag->save();
            return redirect()->route('stories.create')->with('successInsertTag', 'Tag created successfully!');

        }catch (\Exception $e){
            \Log::error($e->getMessage());
            return redirect()->route('tags.create' )->with('errorInsertTag', $e->getMessage());
        }
    }
}
