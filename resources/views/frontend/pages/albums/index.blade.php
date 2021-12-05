@extends('layouts.template')

@section('title') Profile - Dashboard @endsection
@section('description') The largest social media for sharing memories to the whole world or let it stay private with you. Browse millions of users that use it and connect with them. @endsection
@section('keywords') share, login, moments, friends, diary @endsection

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Manage Albums</h1>
        <div class="btn-toolbar mb-2 mb-md-0" id="responseAlbums">
            @if (session()->has('successAddAlbum'))
                <div class="alert alert-success">
                    <h3>{{ session('successAddAlbum') }}</h3>
                </div>
            @endif
            @if (session()->has('successUpdateAlbum'))
                <div class="alert alert-success">
                    <h3>{{ session('successUpdateAlbum') }}</h3>
                </div>
            @endif
        </div>
    </div>


    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 mb-4">
            <div class="row albums">
{{--                @foreach($albums as $a)--}}
{{--                <div class="col-sm-12 col-md-6 col-lg-4 mb-5">--}}
{{--                    <div class="card">--}}
{{--                        <div class="card-header">--}}
{{--                            {{ $a->category->name }}--}}
{{--                        </div>--}}
{{--                        <img src="{{ asset('assets/images/feed-image-1.png') }}" class="card-img-top" alt="...">--}}
{{--                        <div class="card-body">--}}
{{--                            <h5 class="card-title">{{ $a->title }}</h5>--}}
{{--                            <div class="d-flex justify-content-between align-items-center">--}}
{{--                                <a href="{{ route('albums.show', $a->id) }}" class="btn btn-primary">OPEN</a>--}}
{{--                                <div class="d-flex">--}}
{{--                                    <a href="{{ route('albums.edit', $a->id) }}" class="btn p-1" data-id="{{ $a->id }}">--}}
{{--                                        <i class="fa fa-edit actionsIcons"></i>--}}
{{--                                    </a>--}}
{{--                                    <form method="POST" action="{{ route('albums.destroy', $a->id ) }}">--}}
{{--                                        @method("DELETE")--}}
{{--                                        @csrf--}}
{{--                                        <button class="btn p-1" title="delete album">--}}
{{--                                            <i class="fa fa-trash  actionsIcons"></i>--}}
{{--                                        </button>--}}
{{--                                    </form>--}}
{{--                                    <a class="btn p-1 btnDeleteAlbum" href="#" data-number="{{ count($a->stories) }}" data-id="{{ $a->id }}" title="delete album">--}}
{{--                                        <i class="fa fa-trash actionsIcons"></i>--}}
{{--                                    </a>--}}


{{--                                </div>--}}

{{--                            </div>--}}

{{--                        </div>--}}
{{--                        <div class="card-footer">--}}
{{--                            <small class="text-muted">Last updated 3 mins ago</small>--}}

{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                @endforeach--}}

            </div>
        </div>
    </div>
@endsection
@section("javascript")
    <script src="{{asset("assets/js/feed.js")}}"></script>
@endsection
