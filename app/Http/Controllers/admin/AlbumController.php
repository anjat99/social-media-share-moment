<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Album;
use Illuminate\Http\Request;

class AlbumController extends AdminController
{

    public function index()
    {
        $this->data["albums"] = Album::with('category', 'user', 'stories')->get();
        return view('admin.pages.albums.index', $this->data);
    }
}
