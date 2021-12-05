@extends('layouts.admin')

@section('title') Edit User @endsection
@section('description') The largest social media for sharing memories to the whole world or let it stay private with you. Browse millions of users that use it and connect with them. @endsection
@section('keywords') share, categories, moments, friends, diary @endsection


@section('content')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Edit User</h1>
    </div>

    <form class="mt-5" action="{{ route('users.update',  $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-row">
            <div class="form-group col-lg-6">
                <label for="inputFName">First Name</label>
                <input type="text" class="form-control" id="inputFName" value="{{ $user->first_name }}">
            </div>
            <div class="form-group col-lg-6">
                <label for="inputLName">Last Name</label>
                <input type="text" class="form-control" id="inputLName"  value="{{ $user->last_name }}">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-lg-6">
                <label for="inputFName">Username</label>
                <input type="text" class="form-control" id="inputFName"  value="{{ $user->username }}">
            </div>
            <div class="form-group col-lg-6">
                <label for="inputLName">Email</label>
                <input type="text" class="form-control" id="inputLName"  value="{{ $user->email }}">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-lg-6">
                <label for="inputState">Role</label>
                <select class="form-control adminFormWhite" id="inputState" name="userRole">
                    @foreach($roles as $r)
                        <option value="{{ $r->id }}"  {{ $r->id == $user->role_id ? "selected" : "" }}>{{$r->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-lg-6">
                <label for="inputLName">Birthdate</label>
                <input type="date"
                       name="dateofbirth"
                       id="dateofbirth"
                       value="{{ $user->birthdate }}"
                       min="1950-01-01"
                       max="2018-12-31"
                >
            </div>

        </div>
        <div class="form-group col-lg-6">
            <label for="inputLName">Profile Image</label>
            <input type="file"  class="form-control adminForm" name="image"  id="image" >
        </div>

        <div class="col-sm-8 mb-2 mt-2 d-flex justify-content-center">
            <input type="submit" class="btn btn-info btnSubmitA" name="btnUpdateRoomType" id="btnUpdateRoomType" value="UPDATE AND EXIT" />
            <a href="{{ route('users.index') }}" class="btn btn-dark ml-3"><i class="fa fa-arrow-left"></i>  CANCEL </a>
        </div>
    </form>

    @if (session()->has('warningUpdateUser'))
        <div class="alert alert-warning">
            <h3>{{ session('warningUpdateUser') }}</h3>
        </div>
    @endif

    @if (session()->has('errorUpdateUser'))
        <div class="alert alert-info">
            <h3>{{ session('errorUpdateUser') }}</h3>
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
