@extends('layouts.template')

@section('title') Profile - Dashboard @endsection
@section('description') The largest social media for sharing memories to the whole world or let it stay private with you. Browse millions of users that use it and connect with them. @endsection
@section('keywords') share, login, moments, friends, diary @endsection

@section('content')
{{--    @dd($friends)--}}
{{--    @dd($stories)--}}
     <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
         @if($user->id !== session("user")->id)
            <h1 class="h2">Friends list of {{ $user->username }}</h1>
         @else
             <h1 class="h2">My friends list</h1>
         @endif

             <div class="btn-toolbar mb-2 mb-md-0">
                 @if (session()->has('successCancelReport'))
                     <div class="alert alert-success">
                         <h3>{{ session('successCancelReport') }}</h3>
                     </div>
                 @endif
                 @if (session()->has('errorCancelReport'))
                     <div class="alert alert-danger">
                         <h3>{{ session('errorCancelReport') }}</h3>
                     </div>
                 @endif
                 @if (session()->has('successReportUser'))
                     <div class="alert alert-success">
                         <h3>{{ session('successReportUser') }}</h3>
                     </div>
                 @endif
                 @if (session()->has('errorReportUser'))
                     <div class="alert alert-danger">
                         <h3>{{ session('errorReportUser') }}</h3>
                     </div>
                 @endif
                 @if (session()->has('successFollowUser'))
                     <div class="alert alert-success">
                         <h3>{{ session('successFollowUser') }}</h3>
                     </div>
                 @endif
                 @if (session()->has('errorFollowUser'))
                     <div class="alert alert-danger">
                         <h3>{{ session('errorFollowUser') }}</h3>
                     </div>
                 @endif
                 @if (session()->has('successUnfollowUser'))
                     <div class="alert alert-success">
                         <h3>{{ session('successUnfollowUser') }}</h3>
                     </div>
                 @endif
                 @if (session()->has('errorUnfollowUser'))
                     <div class="alert alert-danger">
                         <h3>{{ session('errorUnfollowUser') }}</h3>
                     </div>
                 @endif
             </div>
    </div>

    <div class="row pt-3 pb-2 mb-3">
        <div class="col-lg-11 col-md-11 col-sm-11 mb-4 m-auto">
            <!-- list users -->
            <div class="d-flex  justify-content-between flex-wrap " id="listUsers">
                @foreach($user->friends as $friend)

                <div class="col-lg-6 d-flex justify-content-between align-items-center text-center mb-4 mt-2">
                    <div class="d-flex align-items-center justify-content-around">
                        <div class="user-icon">
                            @if($friend->profile_image !== null)
                                <img
                                    src="{{ asset('/assets/img/avatars/'. $friend->profile_image) }}"
                                    alt="profile pic"
                                />
                            @elseif($friend->profile_image === null && $friend->gender->name === "male")
                                <img
                                    src="{{ asset('assets/images/default-avatar.png') }}"
                                    alt="profile pic"
                                />
                            @elseif($friend->profile_image === null && $friend->gender->name === "female")
                                <img
                                    src="{{ asset('assets/images/woman-avatar.png') }}"
                                    alt="profile pic"
                                />
                            @endif
                        </div>
                        <div>
                            <h3 class="profile_title">{{ $friend->first_name }} {{ $friend->last_name }}</h3>
                            <h4 class="profile_subtitle">{{ $friend->username }}</h4>
                            <p>{{ count($friend->friends) }} friends</p>
                        </div>
                    </div>

                    <div class="d-flex flex-column justify-content-between align-items-between">
                        @if($friend->id !== session("user")->id)
                            <a href="{{ route("friend.friends", $friend->id) }}" class="btn btn-sm btn-outline-secondary"> <i class="fas fa-users actionsIcons"></i>
                                {{ count($friend->friends) }}</a>
                            <a href="{{ route('friends.show', $friend->id) }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-eye actionsIcons"></i>
                                View profile
                            </a>

                                @if(in_array($friend->id, session("user")->friends->pluck('id')->toArray()))
                                    <form method="POST" action="{{ route('unfollow-user', $friend->id) }}">
                                        @method("DELETE")
                                        @csrf
                                        <button class="btn btn-sm btn-outline-danger mb-1 mr-2" title="block user">
                                            <i class="fas fa-user-minus actionsIcons"></i>
                                            Unfollow
                                        </button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('follow-user', $friend->id) }}">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-danger mb-1 mr-2" title="block user">
                                            <i class="fas fa-user-plus actionsIcons"></i>
                                            Follow
                                        </button>
                                    </form>
                                @endif

                                @if($friend->is_reported == 0)
                                    <form method="POST" action="{{ route('report-user', $friend->id) }}">
                                        @method("PUT")
                                        @csrf
                                        <button class="btn btn-sm btn-outline-warning" title="block user">
                                            <i class="fas fa-user-lock  actionsIcons"></i>
                                            Report
                                        </button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('cancel-report-user', $friend->id) }}">
                                        @method("PUT")
                                        @csrf
                                        <button class="btn btn-sm btn-outline-warning" title="block user">
                                            <i class="fas fa-unlock actionsIcons"></i>
                                            Cancel Report
                                        </button>
                                    </form>
                                @endif


                        @endif


                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    @if($user->id !== session("user")->id)
        <a href="{{ route('friends.show',$user->id) }}" class="btn btn-outline-danger">go to profile of {{ $user->username }}</a>
    @else
            <a href="{{ route('profile.index') }}" class="btn btn-outline-danger">go to my profile</a>
    @endif
</div>
@endsection
