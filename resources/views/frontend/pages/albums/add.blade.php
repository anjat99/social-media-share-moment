@extends('layouts.template')

@section('title') Profile - Dashboard @endsection
@section('description') The largest social media for sharing memories to the whole world or let it stay private with you. Browse millions of users that use it and connect with them. @endsection
@section('keywords') share, login, moments, friends, diary @endsection

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Add New Album</h1>
        <div class="btn-toolbar mb-2 mb-md-0" id="responseCategories">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session()->has('errorAddAlbum'))
                <div class="alert alert-warning">
                    <h3>{{ session('errorAddAlbum') }}</h3>
                </div>
            @endif
        </div>
    </div>

    <div class="row pt-3 pb-2 mb-3">
        <div class="col-lg-11 col-md-11 col-sm-11 mb-4 m-auto">
            <div id="createPost">
                <form method="POST" action="{{ route('albums.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="">Title</label>
                        <input type="text" name="title" class="form-control ">
                    </div>
                    <div class="form-group">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="form-group col-lg-9">
                                <label for="inputState">Category</label>
                                <select name="category_id" class="form-control">
                                    <option value="{{ $category->id }}" selected> {{ $category->name }}</option>
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="form-group">
                        <label for="">Description</label>
                        <textarea class="form-control adminForm" name="description" cols="30" rows="5"></textarea>
                    </div>

                    <div class="col-sm-12 mb-2 mt-4 d-flex justify-content-center">
                        <input type="submit" class="btn btn-warning btnSubmitA" name="btnUpdateUser" id="btnUpdateUser"  value="SAVE AND EXIT" />
                        <a href="{{ route('albums.index') }}" class="btn btn-dark ml-2"><i class="fa fa-arrow-left"></i>  CANCEL </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
