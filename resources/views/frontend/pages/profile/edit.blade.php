@extends('layouts.template')

@section('title') Profile - Dashboard @endsection
@section('description') The largest social media for sharing memories to the whole world or let it stay private with you. Browse millions of users that use it and connect with them. @endsection
@section('keywords') share, login, moments, friends, diary @endsection

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Edit Profile</h1>
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

            @if (session()->has('warningUpdateProfile'))
                <div class="alert alert-warning">
                    <h3>{{ session('warningUpdateProfile') }}</h3>
                </div>
            @endif
            @if (session()->has('errorUpdateProfile'))
                <div class="alert alert-warning">
                    <h3>{{ session('errorUpdateProfile') }}</h3>
                </div>
            @endif
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-sm-12 mt-4">
            <div class="panel panel-info">
                <div class="panel-body" >
                    <form id="signupform" action="{{ route('profile.update', $user->id) }}" method="POST" class="form-horizontal" role="form" enctype="multipart/form-data">
                        @csrf
                        @method("PUT")
                        <div class="form-row">
                            <div class="form-group col-lg-6 col-md-12">
                                <label for="firstName" class=" control-label ml-3">First Name</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="firstName" value="{{ $user->first_name }}">
                                </div>
                            </div>
                            <div class="form-group col-lg-6 col-md-12">
                                <label for="lastName" class="col-md-3 control-label">Last Name</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="lastName" value="{{ $user->last_name }}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="birthDate" class="col-md-3 control-label">Birthdate</label>
                            <div class="col-md-9">
                                <input type="date" class="form-control" name="birthDate" value="{{ date('Y-m-d',strtotime($user->birthdate)) }}">
                            </div>
                        </div>



                        <div class="form-row">
                            <div class="form-group col-lg-6 col-md-12">
                                <label for="email" class="col-md-3 control-label">Email</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="email" value="{{ $user->email }}">
                                </div>
                            </div>
                            <div class="form-group col-lg-6 col-md-12">
                                <label for="username" class="col-md-3 control-label">Username</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="username" value="{{ $user->username }}">
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-lg-6 col-md-12">
                                <label for="picture" class=" control-label ml-3">Change Profile image</label>
                                <div class="col-md-9">
                                    <input type="file" class="form-control" id="picture" name="image" placeholder="Avatar">
                                </div>
                            </div>
                            <div class="form-group col-lg-6 col-md-12">
                                <label for="gender" class="col-md-3 control-label">Gender</label>
                                <div class="col-md-9">
                                    <select name="gender"  class="form-control">
                                        <option value="0" disabled>Choose...</option>
                                        @foreach($genders as $g)
                                            <option value="{{ $g->id }}" {{ $user->gender_id == $g->id ? "selected" : "" }}> {{ $g->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-8 mb-2 mt-5 d-flex justify-content-center">
                            <input id="btn-signup" type="submit" class="btn btn-info btnSubmitA" name="btnUpdateRoomType" id="btnUpdateRoomType" value="UPDATE AND EXIT" />
                            <a href="{{ route('profile.index') }}" class="btn btn-dark ml-3"><i class="fa fa-arrow-left"></i>  CANCEL </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
