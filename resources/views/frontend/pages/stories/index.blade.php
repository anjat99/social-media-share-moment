@extends('layouts.template')

@section('title') Profile - Dashboard @endsection
@section('description') The largest social media for sharing memories to the whole world or let it stay private with you. Browse millions of users that use it and connect with them. @endsection
@section('keywords') share, login, moments, friends, diary @endsection

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Manage My Stories</h1>

        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('stories.create') }}" class="btn btn-sm btn-outline-secondary">
                <span data-feather="plus"></span>
                ADD NEW STORY
            </a>
        </div>
        <form >
            <div class="form-check">
                <label class="form-check-label labelSidebarElement">
                    @foreach($statuses as $status)
                        <input type="checkbox" name="statuses[]" class="form-check-input statuses" id="{{ $status->id }}" value="{{ $status->id }}">
                        <label for="{{ $status->id }}">{{ $status->name }}</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    @endforeach
                </label>
            </div>
        </form>
    </div>

    <blockquote class='blockquote'>
        <div class="btn-toolbar mb-2 mb-md-0" id="responseStories">
            @if (session()->has('successInsertStory'))
                <div class="alert alert-success">
                    <h3>{{ session('successInsertStory') }}</h3>
                </div>
            @endif
            @if (session()->has('successUpdateStory'))
                <div class="alert alert-success">
                    <h3>{{ session('successUpdateStory') }}</h3>
                </div>
            @endif
            @if (session()->has('successDeleteStory'))
                <div class="alert alert-success">
                    <h3>{{ session('successDeleteStory') }}</h3>
                </div>
            @endif
            @if (session()->has('errorDeleteStory'))
                <div class="alert alert-danger">
                    <h3>{{ session('errorDeleteStory') }}</h3>
                </div>
            @endif
        </div>
    </blockquote>

    <div class="row">
{{--        @dd($stories)--}}
        <div class="col-lg-12 col-md-12 col-sm-12 mb-4">
            <div class="row" id="stories">
                @foreach($stories as $story)
            <div class="col-sm-12 col-md-6 col-lg-4 mb-5">
                <div class="card">
                    <img src="{{ asset('/assets/img/stories/'. $story->cover) }}" class="card-img-top" alt="..." width="150" height="150">
                    <div class="card-body">
                        <h4 class="card-title profile_title">{{ $story->caption }}</h4>
                        <h5 class="profile_subtitle">
                            <i class="fas fa-map-marker-alt"></i>
                            {{ $story->location->name }}</h5>


                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('story', $story->id) }}" class="btn btn-primary">READ</a>
                            <div class="d-flex">
                                <a href="{{ route('stories.edit', $story->id) }}" class="btn p-1" data-id="{{ $story->id }}">
                                    <i class="fa fa-edit actionsIcons"></i>
                                </a>
{{--                                <a class="btn p-1 btnDeleteStory" href="#" data-id="{{ $story->id }}" title="delete story">--}}
{{--                                    <i class="fa fa-trash actionsIcons"></i>--}}
{{--                                </a>--}}

                                <form method="POST" action="{{ route('stories.destroy', $story->id ) }}">
                                    @method("DELETE")
                                    @csrf
                                    <button class="btn p-1"> <i class="fa fa-trash actionsIcons" title="delete story"></i> </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted">Last updated:
                            @php
                                if($story->updated_at == null){
                                    $publishedDate = $story->published_at;
                                    $newFormat = date('d M, Y H:i', strtotime($publishedDate));
                                    echo $newFormat;
                                }else{
                                    $updatedDate = $story->updated_at;
                                    $newFormat = date('d M, Y H:i', strtotime($updatedDate));
                                    echo $newFormat;
                                }

                            @endphp
                        </small>
                    </div>
                </div>
            </div>
                @endforeach


            </div>


        </div>
    </div>
@endsection
@section("javascript")
    <script src="{{asset("assets/js/feed.js")}}"></script>
@endsection
