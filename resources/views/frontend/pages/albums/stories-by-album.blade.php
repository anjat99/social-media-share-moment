@extends('layouts.template')

@section('title') Profile - Dashboard @endsection
@section('description') The largest social media for sharing memories to the whole world or let it stay private with you. Browse millions of users that use it and connect with them. @endsection
@section('keywords') share, login, moments, friends, diary @endsection


@section('content')
{{--    @dd($storiesByAlbum)--}}
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Album - {{ $storiesByAlbum->title }}</h1>
        <div class="btn-toolbar mb-2 mb-md-0" id="responseLocations">
            @if (session()->has('successDeleteStory'))
                <div class="alert alert-success">
                    <h3>{{ session('successDeleteStory') }}</h3>
                </div>
            @endif
        </div>
    </div>
<blockquote class='blockquote'>
    <p class='mb-0 text-justify'>{{ $storiesByAlbum->description}}</p>
</blockquote>


    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 mb-4">
            <div class="row">
                @foreach($storiesByAlbum->stories as $s)
                <div class="col-lg-4 col-md-6 col-sm-12 mb-5">
                    <div class="card">
                        <img src="{{ asset('/assets/img/stories/'. $s->cover)}}" class="card-img-top" alt="..." width="150" height="150">
                        <div class="card-body">
                            <h3 class="card-title profile_title"> {{ $s->caption }}</h3>
                            <h4 class="profile_subtitle">
                                <span data-feather="map-pin"></span>
                                {{ $s->location->name }}
                            </h4>


                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('story', $s->id) }}" class="btn btn-primary">READ</a>
                                <div class="d-flex">
                                    <a href="{{ route('stories.edit', $s->id) }}" class="btn p-1" data-id="{{ $s->id }}">
                                        <i class="fa fa-edit actionsIcons"></i>
                                    </a>
                                    <a class="btn p-1 btnDeleteStory" href="#" data-id="{{ $s->id }}" title="delete album">
                                        <i class="fa fa-trash actionsIcons"></i>
                                    </a>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer">
                            <small class="text-muted">Last updated {{ date("d,M Y H:i", strtotime($s->updated_at)) }}</small>
                        </div>
                    </div>
                </div>

                @endforeach

            </div>
        </div>
    </div>
@endsection
