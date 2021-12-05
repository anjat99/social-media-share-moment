<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="sidebar-sticky pt-3">
        <ul class="nav flex-column mt-4 nav-sidebar">
            
            @foreach ($menu as $link)
                @if(session()->has("user") && $link->role_id == 1)
                    <li class="nav-item">
                        <a class="nav-link"
                           href="{{ route($link->url) }}">
                            <span data-feather="{{ $link->icon }}"></span>
                            {{ $link->name }}
                        </a>
                    </li>
                    
                @endif
            @endforeach

    </div>
</nav>
