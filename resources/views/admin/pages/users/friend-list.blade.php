@extends('layouts.admin')

@section('title') Friend List @endsection
@section('description') The largest social media for sharing memories to the whole world or let it stay private with you. Browse millions of users that use it and connect with them. @endsection
@section('keywords') share, stories, moments, friends, diary @endsection


@section('content')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Friends of {{ $user->first_name }} {{ $user->last_name }} (id: {{ $user->id }})</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('users.index') }}" class="btn btn-sm btn-outline-dark">
                <i class="fa fa-arrow-left"></i>
                Back to list of users
            </a>
        </div>
    </div>


    <div  class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
            <tr>
                <th>PROFILE IMAGE</th>
                <th>BASIC INFO</th>
                <th>ROLE</th>
                <th>NO.FRIENDS</th>
                <th>NO.STORIES</th>
                <th>IS REPORTED</th>
                <th>IS BLOCKED</th>
                <th>DATE OF REGISTER</th>
            </tr>
            </thead>
            <tbody>
            @foreach($user->friends as $friend)
            <tr>
                <td>
                    <div class="main__table-text">
                        @if($friend->profile_image !== null)
                            <img
                                src="{{ asset('/assets/img/avatars/'. $friend->profile_image) }}"
                                alt="profile pic" width="100" height="100"
                            />
                        @elseif($friend->profile_image === null && $friend->gender->name === "male")
                            <img
                                src="{{ asset('assets/images/default-avatar.png') }}"
                                alt="profile pic" width="100" height="100"
                            />
                        @elseif($friend->profile_image === null && $friend->gender->name === "female")
                            <img
                                src="{{ asset('assets/images/woman-avatar.png') }}"
                                alt="profile pic" width="100" height="100"
                            />
                        @endif

                    </div>
                </td>
                <td>
                    <div class="menu_table__user">
                        <div class="menu_table__meta">
                            <h3> {{ $friend->first_name ." ".$friend->last_name }}</h3>
                            <span>{{ $friend->email }}</span>
                            <span>{{ $friend->username }}</span>
                        </div>
                    </div>
                </td>

                <td>{{ $friend->role->name }}</td>
                <td>
                    <span data-feather="users"></span>
                    {{ count($friend->friends) == 0 ? "No friends" :  count($friend->friends)}}
                </td>
                <td>
                    <span data-feather="file"></span>
                    {{ count($friend->stories) == 0 ? "No stories" :  count($friend->stories)}}
                </td>
                <td>
                    @php
                        if($friend->is_reported == 0){
                            echo "NOT REPORTED";
                        }else{
                            echo "REPORTED". "<br>($friend->reported_at)";
                        }

                    @endphp
                </td>
                <td>
                    @php
                        if($friend->is_blocked == 0){
                            echo "NOT BLOCKED";
                        }else{
                            echo "BLOCKED AT". "<br>($friend->blocked_at)";
                        }

                    @endphp
                </td>
                <td>{{ date("d,M Y H:i", strtotime($friend->created_at)) }}</td>
            </tr>
            @endforeach
            </tbody>

        </table>


    </div>

@endsection
