<!DOCTYPE html>
<html lang="en">

@include('frontend.fixed.head')

@section('title') Login @endsection
@section('description') Login in ShareMoment social media in order to share your old and make new memories for you and favourite ones. @endsection
@section('keywords') share, login, moments, friends, diary @endsection

<body>
    <div class="signup__container @if ($errors->any()) register-small-err @endif"">
        <div class="container__child signup__thumbnail">
            <div class="thumbnail__logo">
                <div class=" mr-0 px-3 m-3 logo-text"  href="#" id="logo">
                    <h3>Share <span>Moments</span></h3>
                </div>
            </div>
            <div class="thumbnail__content text-center">
                <h2 class="heading--secondary text-dark">Are you ready to join us and share your special moments?</h2>
            </div>
            <div class="signup__overlay"></div>
        </div>
        <div class="container__child signup__form mt-0">
            <form action="{{ route('login.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="email">Email</label>
                    <input class="form-control"
                           type="text"
                           name="email"
                           id="email"
                           placeholder="john.doe@gmail.com"
                           required />
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input class="form-control"
                           type="password"
                           name="password"
                           id="password"
                           placeholder="********"
                           required />
                </div>
                <div class="m-t-lg">
                    <ul class="list-inline d-flex flex-column  justify-content-between">
                        <li>
                            <input class="btn btn--form  mt-2 mb-3" type="submit" value="Sign In" />
                        </li>
                        <li>
                            <a class="signup__link" href="{{ route("register.create") }}">Don't have an account? Create it easily</a>
                        </li>
                    </ul>
                </div>
            </form>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session()->has('warning'))
                <div class="alert alert-warning">
                    <h3>{{ session('warning') }}</h3>
                </div>
            @endif
            @if (session()->has('success'))
                <div class="alert alert-success">
                    <h3>{{ session('success') }}</h3>
                </div>
            @endif
            @if (session()->has('error'))
                <div class="alert alert-success">
                    <h3>{{ session('error') }}</h3>
                </div>
            @endif
        </div>
    </div>

 
</body>
</html>
