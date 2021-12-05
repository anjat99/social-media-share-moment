@extends('layouts.template')

@section('title') Profile - Dashboard @endsection
@section('description') The largest social media for sharing memories to the whole world or let it stay private with you. Browse millions of users that use it and connect with them. @endsection
@section('keywords') share, login, moments, friends, diary @endsection

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Add New Location</h1>
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

            @if (session()->has('errorAddLocation'))
                <div class="alert alert-warning">
                    <h3>{{ session('errorAddLocation') }}</h3>
                </div>
            @endif
            @if (session()->has('successAddLocation'))
                <div class="alert alert-warning">
                    <h3>{{ session('successAddLocation') }}</h3>
                </div>
            @endif
        </div>
    </div>

    <form action="{{ route('locations.store') }}"  method="POST" class="d-flex flex-column justify-content-center align-items-center mt-5">
        @csrf
        <div class="form-group col-lg-9">
            <label for="inputName">Name of Location</label>
            <input type="text" name="locationName" class="form-control" id="inputName" placeholder="New Location X">
        </div>

        <div class="col-sm-12 mb-2 mt-4 d-flex justify-content-center">
            <input type="submit" class="btn btn-warning btnSubmitA" name="btnUpdateUser" id="btnUpdateUser" value="SAVE AND EXIT" />
            <a href="{{ route('stories.create') }}" class="btn btn-dark ml-2"><i class="fa fa-arrow-left"></i>  CANCEL </a>
        </div>
    </form>
@endsection
