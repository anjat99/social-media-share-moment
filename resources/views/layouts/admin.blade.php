<!DOCTYPE html>
<html lang="en">
@include('admin.fixed.head')
<body>

@include('admin.fixed.header')

<div class="container-fluid ">
    <div class="row">

        @include('admin.fixed.sidebar')

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
            @yield('content')
        </main>
    </div>
</div>

@include('admin.fixed.scripts')

@yield('adminScripts')

</body>
</html>

