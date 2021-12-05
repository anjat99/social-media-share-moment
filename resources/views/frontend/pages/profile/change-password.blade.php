@extends('layouts.template')

@section('title') Profile - Dashboard @endsection
@section('description') The largest social media for sharing memories to the whole world or let it stay private with you. Browse millions of users that use it and connect with them. @endsection
@section('keywords') share, login, moments, friends, diary @endsection

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Change Current Password</h1>
        <div class="btn-toolbar mb-2 mb-md-0" id="responseCategories">


            @if (session()->has('errorChangePassword'))
                <div class="alert alert-warning">
                    <h3>{{ session('errorChangePassword') }}</h3>
                </div>
            @endif
            @if (session()->has('warningChangePassword'))
                <div class="alert alert-warning">
                    <h3>{{ session('warningChangePassword') }}</h3>
                </div>
            @endif
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-sm-12 mt-4">
            <div class="panel panel-info">
                <div class="panel-body" >
                    <form id="signupform" action="{{ route('change-password.update', $u->id) }}" method="POST" class="form-horizontal" role="form" enctype="multipart/form-data">
                        @csrf
                        @method("PUT")
                            <div class="form-group col-md-12">
                                <label for="firstName" class=" control-label ml-3">Current password</label>
                                <div class="col-md-9">
                                     <input type="password" class="form-control adminForm" name="current_password" id="tbPasswordOldUpdate">
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="lastName" class="col-md-3 control-label">New password</label>
                                <div class="col-md-9">
                                    <input type="password" class="form-control adminForm" name="password" id="tbPasswordNewUpdate">
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="lastName" class="col-md-3 control-label">Confirm new password</label>
                                <div class="col-md-9">
                                    <input type="password" class="form-control adminForm" name="password_confirmation" id="tbRepeatPasswordNewUpdate">
                                </div>
                            </div>

                        <div class="col-sm-8 mb-2 mt-5 d-flex justify-content-center">
                            <input id="btn-signup" type="submit" class="btn btn-info btnSubmitA" name="btnUpdateRoomType" id="btnUpdateRoomType" value="UPDATE AND EXIT" />
                            <a href="{{ route('profile.index') }}" class="btn btn-dark ml-3"><i class="fa fa-arrow-left"></i>  CANCEL </a>
                        </div>
                    </form>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection
