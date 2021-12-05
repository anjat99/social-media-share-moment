@php
    $u = session('user');

@endphp

<nav id="sidebarMenuUser" class="col-md-4 col-lg-3 d-md-block bg-light sidebar collapse mt-5 p-2">
    <div class="sidebar-sticky pt-3">
        <ul class="nav flex-column mt-4 nav-sidebar" >
            @foreach ($menu as $link)
                @if(session()->has("user") && $link->role_id == 2)
                    <li class="nav-item">
                        <a class="nav-link
                            @if(request()-> routeIs($link->url)) active @endif"
                            href="{{ route($link->url) }}">
                            <span data-feather="{{ $link->icon }}"></span>
                            {{ $link->name }}
                        </a>
                    </li>
                @endif
            @endforeach
            <li class="nav-item">
                <a class="nav-link" href="{{ route("userFriends", session("user")->id) }}">
                    <span data-feather="users"></span>
                    My Friends
                </a>
            </li>
        </ul>
        <hr>
        <h3 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
            <span>Albums</span>
            <button class="d-flex align-items-center btn btn-outline-danger" type="button" id="collection" data-modal="modalCollection">
                <i class="fas fa-plus"></i>
            </button>

            <!-- MODAL -->
            <div id="modalCollection"class="modal p-3">
                <div class="sadrzajModalaLogin d-flex flex-column">
                    <div class="d-flex justify-content-center mb-5 border-bottom modal__collection__header">
                        <a id="zatvoriModalCollections">&times;</a>
                        <h3>Create new collection</h3>
                    </div>


                    <ul class="navbar-nav mr-auto mt-2 mt-lg-0 flex-column nav__collections mt-3">
                        @foreach($categories as $c)
                        <li class="nav-item d-flex align-items-between justify-content-between p-2">
                            <div class="nav-item__icon d-flex align-items-between justify-content-between ">
                                <div class="col-4 border d-flex justify-content-center align-items-center">
                                    <a class="logo-text"  href="#">
                                        <h3>Share <span>Moments</span></h3>
                                    </a>
                                </div>
                                <div class="d-flex flex-column align-items-between justify-content-between mb-4 col-8">
                                    <h4 class="category-heading"> {{ $c->name }}</h4>
                                    <p class="category-desc">{{ $c->description }}</p>
                                    <a href="{{ route('album-create', $c->id) }}" class="btn btn-outline-danger">
                                        create collection
                                    </a>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <!-- endmodal-->
            </div>


        </h3>
        <ul class="nav flex-column mb-5 pb-5" id="sidebarClient">

            @foreach($u->albums as $a)
                <li  class="nav-item  d-flex justify-content-around  mb-2 @if ($loop->first) mt-3 @endif">
                    <div class="d-flex @if(count($a->stories) > 0) align-items-start @else align-items-center  @endif justify-content-start">
                        @if(count($a->stories) > 0)

                        <img src="{{ asset('/assets/img/stories/'. $a->stories->last()->cover)}}" alt="" width="50" height="50">
                        @else
                                <a class="logo-text-albums"  href="#">
                                    <h3>Share <span>Moments</span></h3>
                                </a>
                        @endif
                    </div>
                    <div class="d-flex flex-column  p-2 justify-content-center align-items-baseline">
                        <p class="mb-0 font-weight-bold">
                            {{ $a->title }}
                        </p>
                        <p class="mb-0"> {{ $a->category->name }}</p>
                        <p>{{ count($a->stories)  }} stories</p>
                        <a href="{{ route('albums.show', $a->id) }}" class="btn btn-primary">OPEN</a>
                    </div>


                </li>
            @endforeach


            <li class="nav-item">
                <a href="{{ route('albums.index') }}" class="btn btn-outline-danger d-flex justify-content-center align-items-center mt-4">Manage Albums</a>
            </li>
        </ul>


    </div>
</nav>
