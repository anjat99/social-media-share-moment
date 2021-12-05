@extends('layouts.admin')

@section('title') Profile - Dashboard @endsection
@section('description') The largest social media for sharing memories to the whole world or let it stay private with you. Browse millions of users that use it and connect with them. @endsection
@section('keywords') share, login, moments, friends, diary @endsection

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Manage Users</h1>
    <div class="btn-toolbar mb-2 mb-md-0" id="responseMessages">
        @if (session()->has('successDeleteUser'))
            <div class="alert alert-success">
                <h3>{{ session('successDeleteUser') }}</h3>
            </div>
        @endif
        @if (session()->has('errorDeleteUser'))
            <div class="alert alert-danger">
                <h3>{{ session('errorDeleteUser') }}</h3>
            </div>
        @endif
        @if (session()->has('successUnblocked'))
            <div class="alert alert-success">
                <h3>{{ session('successUnblocked') }}</h3>
            </div>
        @endif
        @if (session()->has('errorUnblocked'))
            <div class="alert alert-danger">
                <h3>{{ session('errorUnblocked') }}</h3>
            </div>
        @endif
        @if (session()->has('successBlocked'))
            <div class="alert alert-success">
                <h3>{{ session('successBlocked') }}</h3>
            </div>
        @endif
        @if (session()->has('errorBlocked'))
            <div class="alert alert-danger">
                <h3>{{ session('errorBlocked') }}</h3>
            </div>
        @endif
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th>#ID</th>
                <th>PROFILE IMAGE</th>
                <th>BASIC INFO</th>
                <th>ROLE</th>
                <th>NO.FRIENDS</th>
                <th>NO.STORIES</th>
                <th>IS REPORTED</th>
                <th>IS BLOCKED</th>
                <th>DATE OF REGISTER</th>
                <th>ACTIONS</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>
                        @if($user->profile_image !== null)
                            <img
                                src="{{ asset('/assets/img/avatars/'. $user->profile_image) }}"
                                alt="profile pic" width="50" height="50"
                            />
                        @elseif($user->profile_image === null && $user->gender->name === "male")
                            <img
                                src="{{ asset('assets/images/default-avatar.png') }}"
                                alt="profile pic" width="50" height="50"
                            />
                        @elseif($user->profile_image === null && $user->gender->name === "female")
                            <img
                                src="{{ asset('assets/images/woman-avatar.png') }}"
                                alt="profile pic" width="50" height="50"
                            />
                        @endif
                    </td>
                    <td>
                        <div class="menu_table__user">
                            <div class="menu_table__meta ">
                                <h3 class="text-dark"> {{ $user->first_name ." ".$user->last_name }}</h3>
                                <span class="text-dark">{{ $user->email }}</span>
                                <span class="text-dark">{{ $user->username }}</span>
                            </div>
                        </div>
                    </td>

                    <td>{{ $user->role->name }}</td>
                    <td>
                        <span data-feather="users"></span>
                        {{ count($user->friends) == 0 ? "No friends" :  count($user->friends)}}
                    </td>
                    <td>
                        <span data-feather="file"></span>
                        {{ count($user->stories) == 0 ? "No stories" :  count($user->stories)}}
                    </td>
                    <td>
                        @php
                            if($user->is_reported == 0){
                                echo "NOT REPORTED";
                            }else{
                                echo "REPORTED". "<br>($user->reported_at)";
                            }

                        @endphp
                    </td>
                    <td>
                        @php
                            if($user->is_blocked == 0){
                                echo "NOT BLOCKED";
                            }else{
                                echo "BLOCKED AT". "<br>($user->blocked_at)";
                            }

                        @endphp
                    </td>
                    <td>{{ date("d,M Y H:i", strtotime($user->created_at)) }}</td>
                    <td class="d-flex align-items-center justify-content-center">
                        <a class="btn" href="{{ route('users.show', $user->id) }}" title="list of friends">
                            <i class="fas fa-user-friends"></i>
                        </a>
                        <form method="POST" action="{{ route('users.destroy', $user->id ) }}">
                            @method("DELETE")
                            @csrf
                            <button class="btn"> <i class="fa fa-trash" title="delete user"></i> </button>
                        </form>
                        @if($user->is_blocked == 0)
                            <form method="POST" action="{{ route('block-user', $user->id) }}">
                                @method("PUT")
                                @csrf
                                <button class="btn" title="block user"> <i class="fas fa-user-lock"></i></button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('unblock-user', $user->id) }}">
                                @method("PUT")
                                @csrf
                                <button class="btn" title="unblock user"><i class="fas fa-unlock"></i></button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
</div>
<div class="d-flex justify-content-end mt-4" >
    {{$users->links()}}
</div>
@endsection
