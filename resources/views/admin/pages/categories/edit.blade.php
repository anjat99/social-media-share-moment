@extends('layouts.admin')

@section('title') Edit Category @endsection
@section('description') The largest social media for sharing memories to the whole world or let it stay private with you. Browse millions of users that use it and connect with them. @endsection
@section('keywords') share, categories, moments, friends, diary @endsection
{{--@section('token')--}}
{{--    <meta name="csrf-token" content="{{ csrf_token() }}">--}}
{{--@endsection--}}


@section('content')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Edit Category</h1>
    </div>

    <form action="{{ route('categories.update',  $category->id) }}" method="POST" class="d-flex flex-column justify-content-center align-items-center mt-5">
        @csrf
        @method('PUT')
        <div class="form-group col-lg-9">
            <label for="inputName">Name of Album</label>
            <input type="text" name="categoryName" class="form-control" id="inputName" value="{{ $category->name }}">
        </div>
        <div class="form-group col-lg-9">
            <label for="taDescription">Description:</label>
            <textarea class="form-control" name="description" id="taDescription">{{ $category->description }}</textarea>
        </div>

        <div class="col-sm-8 mb-2 mt-2 d-flex justify-content-center">
            <input type="submit" class="btn btn-info btnSubmitA" name="btnUpdateRoomType" id="btnUpdateRoomType" value="UPDATE AND EXIT" />
            <a href="{{ route('categories.index') }}" class="btn btn-dark ml-3"><i class="fa fa-arrow-left"></i>  CANCEL </a>
        </div>


    </form>

    @if (session()->has('errorUpdateCategory'))
        <div class="alert alert-info">
            <h3>{{ session('errorUpdateCategory') }}</h3>
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

@endsection
