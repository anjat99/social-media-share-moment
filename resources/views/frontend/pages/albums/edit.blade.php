@extends('layouts.template')

@section('title') Profile - Dashboard @endsection
@section('description') The largest social media for sharing memories to the whole world or let it stay private with you. Browse millions of users that use it and connect with them. @endsection
@section('keywords') share, login, moments, friends, diary @endsection

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Edit Album</h1>
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
            @if (session()->has('warningUpdateAlbum'))
                <div class="alert alert-warning">
                    <h3>{{ session('warningUpdateAlbum') }}</h3>
                </div>
            @endif @if (session()->has('errorUpdateAlbum'))
                <div class="alert alert-warning">
                    <h3>{{ session('errorUpdateAlbum') }}</h3>
                </div>
            @endif
        </div>
    </div>

    <div class="row pt-3 pb-2 mb-3">
        <div class="col-lg-11 col-md-11 col-sm-11 mb-4 m-auto">
            <div id="createPost">
                <form method="POST" action="{{ route('albums.update', $album->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="">Title</label>
                        <input type="text" name="title" class="form-control " value="{{ $album->title }}">
                    </div>
                    <div class="form-group">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="form-group col-lg-9">
                                <label for="inputState">Category</label>
                                <select class="form-control adminFormWhite" id="ddlCatUpdate" name="category_id">
                                    @foreach($categories as $c)
                                        <option value="{{ $c->id }}" {{ $c->id == $album->category_id ? "selected" : "" }}>{{$c->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="form-group">
                        <label for="">Description</label>
                        <textarea class="form-control adminForm"name="description" cols="30" rows="10">{{$album->title}} </textarea>
                    </div>

                    <div class="col-sm-12 mb-2 mt-4 d-flex justify-content-center">
                        <input type="submit" class="btn btn-warning btnSubmitA" value="SAVE AND EXIT" />
                        <a href="{{ route('albums.index') }}" class="btn btn-dark ml-2"><i class="fa fa-arrow-left"></i>  CANCEL </a>
                    </div>
                </form>
{{--                @if ($errors->any())--}}
{{--                    <div class="alert alert-danger">--}}
{{--                        <ul>--}}
{{--                            @foreach ($errors->all() as $error)--}}
{{--                                <li>{{ $error }}</li>--}}
{{--                            @endforeach--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--                @endif--}}
{{--                @if (session()->has('errorAddHService'))--}}
{{--                    <div class="alert alert-warning">--}}
{{--                        <h3>{{ session('errorAddHService') }}</h3>--}}
{{--                    </div>--}}
{{--                @endif--}}


            </div>
        </div>
    </div>
@endsection
