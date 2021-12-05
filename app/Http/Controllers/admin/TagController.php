<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\InsertTagRequest;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class TagController extends AdminController
{

    public function index()
    {
        $this->data["tags"] =  Tag::all();
        return view('admin.pages.tags.index', $this->data);
    }

    public function getAll()
    {
        $this->data["apiTags"] = Tag::all();
        return response()->json($this->data);
    }

    public function create()
    {
        return view('admin.pages.tags.add');
    }

    public function store(InsertTagRequest $request)
    {
        try{
            $tag = new Tag();
            $tag->title = $request->title;

            $tag->save();
            return redirect()->route('tags-manage.index')->with('successInsertTag', 'Tag created successfully!');
        }catch (\Exception $e){
            return redirect()->route('tags-manage.create' )->with('errorInsertTag', $e->getMessage());
        }
    }
}
