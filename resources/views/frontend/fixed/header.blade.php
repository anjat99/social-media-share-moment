@php
    $u = session('user');
@endphp

<nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow" id="navTop">
    <a class="col-md-3 mr-0 px-3 m-3 logo-text"  href="{{route("user.feed")}}" id="logo">
        <h3>Share <span>Moments</span></h3>
    </a>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenuUser" aria-controls="sidebarMenuUser" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav px-3 mr-0 mt-sm-3 d-flex flex-row justify-content-center align-items-center" id="navTopRight">
        <li class="nav-item text-nowrap d-flex flex-column align-items-center justify-content-center">
            <div class="nav-user-icon m-auto">
                <a class="d-flex align-items-center text-dark" href="{{ route('contact.create') }}" id="createPost">
                    <i class="fas fa-mail-bulk iconsHeader"></i>
                </a>
            </div>
            <div class="text-center mt-2">
                <p>
                    <a class="d-flex align-items-center text-dark" href="{{ route('contact.create') }}" id="createPost">
                        Contact administrator
                    </a>
                </p>
            </div>
        </li>
        <li class="nav-item text-nowrap d-flex flex-column align-items-center justify-content-center">
            <div class="nav-user-icon m-auto">
                <a class="d-flex align-items-center text-dark" href="{{ route('society') }}" id="createPost">
                    <i class="fa fa-users iconsHeader"></i>
                </a>
            </div>
            <div class="text-center mt-2">
                <p>
                    <a class="d-flex align-items-center text-dark" href="{{ route('society') }}" id="createPost">
                        Find Friends
                    </a>
                </p>
            </div>
        </li>
        <li class="nav-item text-nowrap d-flex flex-column align-items-center justify-content-center">
            <div class="nav-user-icon m-auto">
                <a class="d-flex align-items-center text-dark" href="{{ route('stories.create') }}" id="createPost">
                    <i class="fa fa-plus iconsHeader"></i>
                </a>
            </div>
            <div class="text-center mt-2">
                <p>
                    <a class="d-flex align-items-center text-dark" href="{{ route('stories.create') }}" id="createPost">
                        NEW STORY
                    </a>
                </p>
            </div>
        </li>
        <li class="nav-item text-nowrap d-flex flex-column align-items-center justify-content-center">
            <div class="d-flex flex-column">
                <div class="nav-user-icon online m-auto">
                    @if(session("user")->profile_image !== null)
                        <img
                            class="user__avatar"
                            src="{{ asset('/assets/img/avatars/'. session("user")->profile_image) }}"
                            alt="profile pic"
                            id="userIcon"
                            width="40" height="40"
                        />
                    @elseif(session("user")->profile_image === null && session("user")->gender->name === "male")
                        <img
                            class="user__avatar"
                            src="{{ asset('assets/images/default-avatar.png') }}"
                            alt="profile pic"
                            id="userIcon"
                             width="40" height="40"
                        />
                    @elseif(session("user")->profile_image === null && session("user")->gender->name === "female")
                        <img
                            class="user__avatar"
                            src="{{ asset('assets/images/woman-avatar.png') }}"
                            alt="profile pic" id="userIcon"
                             width="40" height="40"
                        />
                    @endif

                </div>
                <div class="text-center mt-2">
                    <p class="text-dark">ME</p>
                </div>
            </div>
            <div class="settings-menu">
{{--                <div id="dark-btn">--}}

{{--                </div>--}}
                <div class="settings-menu-inner">
                    <div class="user-profile">

                        @if(session("user")->profile_image !== null)
                            <img
                                src="{{ asset('/assets/img/avatars/'. session("user")->profile_image) }}"
                                alt="profile pic"
                                width="40" height="40"
                            />
                        @elseif(session("user")->profile_image === null && session("user")->gender->name === "male")
                            <img
                                src="{{ asset('assets/images/default-avatar.png') }}"
                                alt="profile pic"
                                width="40" height="40"
                            />
                        @elseif(session("user")->profile_image === null && session("user")->gender->name === "female")
                            <img
                                src="{{ asset('assets/images/woman-avatar.png') }}"
                                alt="profile pic"
                                width="40" height="40"
                            />
                        @endif

                        <div>
                            <p>{{ $u->first_name }} {{ $u->last_name }}</p>
                            <a href="{{ route('profile.index') }}">See Your Profile</a>
                        </div>
                    </div>

                    <hr>

                    @if(session()->has("user"))
                        <div class="settings-links">
                            <a href="{{ route("user.logout") }}">Logout</a>
                            <img src="{{ asset('assets/images/arrow.png') }}" width="10px">
                        </div>
                    @endif
                </div>
            </div>
        </li>

    </ul>
</nav>
