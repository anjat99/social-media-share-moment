@extends('layouts.admin')

@section('title') Add New Category @endsection
@section('description') The largest social media for sharing memories to the whole world or let it stay private with you. Browse millions of users that use it and connect with them. @endsection
@section('keywords') share, categories, moments, friends, diary @endsection
{{--@section('token')--}}
{{--    <meta name="csrf-token" content="{{ csrf_token() }}">--}}
{{--@endsection--}}


@section('content')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Add New Category</h1>
    </div>

    <form action="{{ route('categories.store') }}"  method="POST" class="d-flex flex-column justify-content-center align-items-center mt-5">
        @csrf
        <div class="form-group col-lg-9">
            <label for="inputName">Name of Category</label>
            <input type="text" name="categoryName" class="form-control" id="inputName" >
        </div>
        <div class="form-group col-lg-9">
            <label for="taDescription">Description:</label>
            <textarea class="form-control" name="description" id="taDescription" ></textarea>
        </div>

        <div class="col-sm-12 mb-2 mt-4 d-flex justify-content-center">
            <input type="submit" class="btn btn-warning btnSubmitA" name="btnUpdateUser" id="btnUpdateUser" value="SAVE AND EXIT" />
            <a href="{{ route('categories.index') }}" class="btn btn-dark ml-2"><i class="fa fa-arrow-left"></i>  CANCEL </a>
        </div>

    </form>

    @if (session()->has('errorInsertCategory'))
        <div class="alert alert-info">
            <h3>{{ session('errorInsertCategory') }}</h3>
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
