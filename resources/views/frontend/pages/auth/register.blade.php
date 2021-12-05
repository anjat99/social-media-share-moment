<!DOCTYPE html>
<html lang="en">

@include('frontend.fixed.head')

@section('title')
    Register
@endsection

@section('description')
    Register in ShareMoment social media in order to share your old and make new memories for you and favourite ones.

@endsection

@section('keywords')
    share, register, moments, friends, diary
@endsection

<body>

<div class="signup__container register-small  @if ($errors->any()) register-small-err @endif"">
    <div class="container__child signup__thumbnail ">
        <div class="thumbnail__logo">
            <div class=" mr-0 px-3 m-3 logo-text"  href="#" id="logo">
                <h3>Share <span>Moments</span></h3>
            </div>
        </div>
        <div class="thumbnail__content text-center">
            <h2 class="heading--secondary text-dark">Are you ready to join us and share your special moments?</h2>
        </div>
          <div  class="errors-mobile-hide">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>

            @endif
            @if(session()->has('success'))
                <div class="alert alert-success">
                    <h3>{{session('success') }}</h3>
                </div>
            @endif
            @if (session()->has('warning'))
                <div class="alert alert-warning">
                    <h3>{{ session('warning') }}</h3>
                </div>
            @endif
            @if (session()->has('warningChangePassword'))
                <div class="alert alert-warning">
                    <h3>{{ session('warningChangePassword') }}</h3>
                </div>
            @endif
        </div>
        <div class="signup__overlay"></div>
    </div>
    <div class="container__child signup__form  mt-0 ">
        <form action="{{ route('register.store') }}" method="POST">
            @csrf
            <div class="form-group row">
                <div class="col">
                    <label for="firstname">First Name</label>
                    <input type="text"
                           class="form-control"
                           name="firstname"
                           id="firstname"
                           placeholder="John">
                </div>
                <div class="col">
                    <label for="lastname">Last Name</label>
                    <input type="text"
                           class="form-control"
                           name="lastname"
                           id="lastname"
                           placeholder="Doe">
                </div>
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input class="form-control"
                       type="text"
                       name="username"
                       id="username"
                       placeholder="john.doe007"
                       required />
            </div>
            <div class="form-group row d-flex justify-content-around">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="gender" id="rb-male" value="1" checked>
                    <label class="form-check-label" for="rb-male">
                        Male
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="gender" id="rb-female" value="2">
                    <label class="form-check-label" for="rb-female">
                        Female
                    </label>
                </div>
            </div>

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
                <input
                    class="form-control"
                    type="password"
                    name="password"
                    id="password"
                    placeholder="********"
                    required
                />
            </div>
            <div class="form-group">
                <label for="password-confirmation">Repeat Password</label>
                <input
                    type="password"
                    class="form-control"
                    name="password_confirmation"
                    id="password-confirmation"
                    placeholder="********"
                    required
                />
            </div>
            <div class="form-group d-flex justify-content-between">
                <label class="label_dateofbirth" for="dateofbirth">Date Of Birth</label>
                <input type="date"
                       name="birthdate"
                       id="dateofbirth"
                       value=""
                       min="1950-01-01"
                       max="2018-12-31"
                >
                <p class='text-danger' id="datumGreskaRegister"> </p>
            </div>

            <div class="m-t-lg">
                <ul class="list-inline d-flex flex-column justify-content-between">
                    <li>
                        <input class="btn btn--form mt-2 mb-3" type="submit" value="Register" />
                    </li>
                    <li>
                        <a class="signup__link" href="{{ route("login.create") }}">Already have an account? Sign in</a>
                    </li>
                </ul>
            </div>
        </form>
<div class="errors-mobile-show">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>

            @endif
            @if(session()->has('success'))
                <div class="alert alert-success">
                    <h3>{{session('success') }}</h3>
                </div>
            @endif
            @if (session()->has('warning'))
                <div class="alert alert-warning">
                    <h3>{{ session('warning') }}</h3>
                </div>
            @endif
            @if (session()->has('warningChangePassword'))
                <div class="alert alert-warning">
                    <h3>{{ session('warningChangePassword') }}</h3>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Js Plugins -->
@include('frontend.fixed.scripts')

@yield('javascript')
</body>
</html>
