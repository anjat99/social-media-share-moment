@extends('layouts.template')

@section('title') Profile - Dashboard @endsection
@section('description') The largest social media for sharing memories to the whole world or let it stay private with you. Browse millions of users that use it and connect with them. @endsection
@section('keywords') share, login, moments, friends, diary @endsection

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">My Profile</h1>
        <div class="btn-toolbar mb-2 mb-md-0" id="responseCategories">
            @if (session()->has('successUpdateProfile'))
                <div class="alert alert-danger">
                    <h3>{{ session('successUpdateProfile') }}</h3>
                </div>
            @endif
            @if (session()->has('successChangePassword'))
                <div class="alert alert-danger">
                    <h3>{{ session('successChangePassword') }}</h3>
                </div>
            @endif
        </div>
    </div>




    <div class="row justify-content-center">
        <div class="col-sm-12 col-md-8 col-lg-8 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">{{ $user->first_name }} {{ $user->last_name }}</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-3 col-lg-3 text-center user-icon">
                            @if($user->profile_image !== null)
                                <img
                                    src="{{ asset('/assets/img/avatars/'. session("user")->profile_image) }}"
                                    alt="profile pic" width="100"
                                />
                            @elseif($user->profile_image === null && $user->gender->name === "male")
                                <img
                                    src="{{ asset('assets/images/default-avatar.png') }}"
                                    alt="profile pic" width="100"
                                />
                            @elseif($user->profile_image === null && $user->gender->name === "female")
                                <img
                                    src="{{ asset('assets/images/woman-avatar.png') }}"
                                    alt="profile pic" width="100"
                                />
                            @endif
                        </div>
                        <div class=" col-md-9 col-lg-9 ">
                            <table class="table table-user-information">
                                <tbody>
                                    <tr>
                                        <td>Username</td>
                                        <td>{{ $user->username }}</td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
                                    </tr>
                                    <tr>
                                        <td>Birthdate</td>
                                        <td>{{ date('d/m/Y',strtotime($user->birthdate)) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Gender</td>
                                        <td>{{ $user->gender->name }}</td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                           <span class="pull-left">
                           Friends: <a href="{{ route("userFriends",$user->id) }}" class="btn btn-sm btn-outline-secondary"> <span data-feather="eye"></span>{{ count($user->friends) }}</a>
                           </span>
                         <span class="pull-right">
                              <a href="{{ route('profile.edit',$user->id) }}" class="btn btn-sm btn-outline-danger mt-1 mb-1">
                                <span data-feather="edit"></span>
                                Change basic info
                            </a>
                             <a href="{{ route('change-password.edit',$user->id) }}" class="btn btn-sm btn-outline-secondary mt-1 mb-1">
                                <span data-feather="edit"></span>
                                Change password
                            </a>
                       </span>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
