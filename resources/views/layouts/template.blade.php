
<!DOCTYPE html>
<html lang="en">
@include('frontend.fixed.head')
<body>

<!-- Header Section Begin -->
@include('frontend.fixed.header')
<!-- Header End -->


<div class="container-fluid ">
    <div class="row">

        <!-- Sidebar Section Begin -->
        @include('frontend.fixed.sidebar')
        <!-- Sidebar End -->

        <main role="main" class="col-md-8 ml-sm-auto col-lg-9 px-md-4 ">
            @yield('content')
        </main>
    </div>
</div>

@include('frontend.fixed.scripts')

@yield('javascript')

</body>
</html>
