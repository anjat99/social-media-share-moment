@extends('layouts.template')

@section('title') Profile - Dashboard @endsection
@section('description') The largest social media for sharing memories to the whole world or let it stay private with you. Browse millions of users that use it and connect with them. @endsection
@section('keywords') share, login, moments, friends, diary @endsection

@section('content')
{{--    @dd($users)--}}
     <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">People you may know</h1>
         <div class="btn-toolbar mb-2 mb-md-0">
             <form class="navbar-form navbar-left" action="">
                 <div class="search-box  mt-sm-3">
                     <img src="{{ asset('assets/images/search.png') }}">
                     <input type="text" placeholder="Search" id="keyword" name="keyword">
                 </div>
             </form>
         </div>
    </div>

    <div class="row pt-3 pb-2 mb-3">
        <div class="col-lg-11 col-md-11 col-sm-11 mb-4 m-auto">
            <div class="d-flex justify-content-around flex-wrap people " id="listUsers">

            @foreach($users as $user)
                <div class="col-lg-3 d-flex flex-column align-items-center text-center mb-4 mt-2">
                    <div class="user-icon">
                        @if($user->profile_image !== null)
                            <img
                                src="{{ asset('/assets/img/avatars/'. $user->profile_image) }}"
                                alt="profile pic"
                                class="mb-3"
                                width="70" height="90"
                            />
                        @elseif($user->profile_image === null && $user->gender->name === "male")
                            <img
                                src="{{ asset('assets/images/default-avatar.png') }}"
                                alt="profile pic"
                                class="mb-3"
                                width="70" height="90"
                            />
                        @elseif($user->profile_image === null && $user->gender->name === "female")
                            <img
                                src="{{ asset('assets/images/woman-avatar.png') }}"
                                alt="profile pic"
                                class="mb-3"
                                width="70" height="90"
                            />
                        @endif
                    </div>
                    <div>
                        <h3 class="profile_title">{{ $user->first_name}} {{ $user->last_name }} </h3>
                        <h4 class="profile_subtitle">{{ $user->username }}</h4>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route("friend.friends", $user->id) }}" class="btn btn-sm btn-outline-secondary mr-2"> <i class="fas fa-users actionsIcons"></i>{{ count($user->friends) }}</a>
{{--                            @if(in_array($user->id, session("user")->friends->pluck('id')->toArray()))--}}
{{--                                <a href="#" class="btn btn-outline-danger removeFriend" data-id="{{ $user->id }}"> <span data-feather='minus'></span> Unfollow </a>--}}
{{--                            @else--}}
                                <a href="#" class="btn btn-outline-danger addFriend" data-id="{{ $user->id }}"><i class="fas fa-user-plus actionsIcons"></i> Follow </a>
{{--                            @endif--}}
                        <a href="{{ route('friends.show', $user->id) }}" class="btn btn-sm btn-outline-secondary ml-2">
                            <i class="fas fa-eye actionsIcons"></i>
                            View
                        </a>
                    </div>
                </div>
                @endforeach

            </div>


            <div class="d-flex justify-content-end mt-4" id="navSociety" >
{{--                {{ $users->links() }}--}}
            </div>

        </div>
    </div>
@endsection

@section('javascript')
    <script src="{{asset('assets/js/users.js')}}"></script>
@endsection
