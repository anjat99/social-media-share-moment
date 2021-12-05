<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\InsertCategoryRequest;
use App\Http\Requests\admin\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class CategoryController extends AdminController
{

    public function index()
    {
        $this->data["categories"] = Category::all();
        return view('admin.pages.categories.index', $this->data);
    }

    public function getAll()
    {
        $this->data["apiCategories"] = Category::all();
        return response()->json($this->data);
    }

    public function create()
    {
        return view('admin.pages.categories.add',$this->data);
    }

    public function store(InsertCategoryRequest $request)
    {
        try {
            $category = new Category();
            $category->name = $request->categoryName;
            $category->description = $request->description;

            $category->save();
            return redirect()->route('categories.index')->with('successInsertCategory', 'Category created successfully!');

        } catch (\Exception $e) {
            return redirect()->route('categories.create')->with('errorInsertCategory', $e->getMessage());
        }
    }

    public function edit($id)
    {
        $this->data["category"] = Category::find($id);
        return view('admin.pages.categories.edit', $this->data);
    }

    public function update(UpdateCategoryRequest $request, $id)
    {
        try {
            $category = Category::find($id);
            $category->name = $request->categoryName;
            $category->description = $request->description;

            $category->save();
            return redirect()->route('categories.index', $category->id)->with('successUpdateCategory', 'Category updated successfully!');
        } catch (\Exception $e) {
            return redirect()->route('categories.edit', $category->id)->with('errorUpdateCategory', $e->getMessage());
        }
    }
}
