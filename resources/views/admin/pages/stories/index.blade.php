@extends('layouts.admin')

@section('title') Profile - Dashboard @endsection
@section('description') The largest social media for sharing memories to the whole world or let it stay private with you. Browse millions of users that use it and connect with them. @endsection
@section('keywords') share, login, moments, friends, diary @endsection


@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Manage Stories/Posts</h1>
        <div class="btn-toolbar mb-2 mb-md-0" id="responseStories">
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
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>#ID</th>
                    <th>CAPTION</th>
                    <th>COVER IMG</th>
                    <th>NO.ALBUMS</th>
                    <th>TAGS</th>
                    <th>LOCATION</th>
                    <th>NO.COMMENTS</th>
                    <th>STATUS</th>
                    <th>USER</th>
                    <th>STATE</th>
                    <th>ACTIONS</th>
                    <!-- INFO: CAPTION, COVER IMAGE, ALBUM, DESCRIPTION, TAGS, LOCATION, NO. COMMENTS, STATUS, IS PUBLISHED, USER-->
                </tr>
            </thead>
            <tbody>
                @foreach($stories as $story)
                    <tr>
                        <td>{{ $story->id }}</td>
                        <td>{{ $story->caption }}</td>
                        <td>
                            <img src="{{ asset('/assets/img/stories/'. $story->cover)}}" alt="" width="50" height="50">
                        </td>
                        <td>
                            <span data-feather="folder"></span> {{ $story->album == null ? "No album" :  $story->album->title}}
                        </td>
                        <td>
                            @forelse ($story->tags as $i => $tag)

                                @if($i != count($story->tags) - 1)
                                    {{ $tag->title }},
                                @else
                                    {{ $tag->title }}
                                @endif
                            @empty
                                No tags.
                            @endforelse
                        </td>
                        <td>{{ $story->location->name }}</td>
                        <td>
                            <i class="far fa-comments"></i> {{ count($story->comments) }}
                        </td>
                        <td>{{ $story->status->name }}</td>
                        <td>
                            {{ $story->user->first_name }}  {{ $story->user->last_name }} <br>({{ $story->user->username }})
                        </td>
                        <td>
                            @php
                                if($story->published == 0){
                                    echo "WAITING FOR PUBLISHING";
                                }else{
                                    echo "PUBLISHED";
                                }

                            @endphp
                        </td>
                        <td>
                            <a class="btn" href="{{ route('stories-manage.show', $story->id) }}">
                                <i class="fas fa-info-circle"></i>
                            </a>
{{--                            <a class="btn btnDeleteStory" href="#"  data-id="{{ $story->id }}">--}}
{{--                                <span data-feather="delete"></span>--}}
{{--                            </a>--}}
                            <form method="POST" action="{{ route('stories-manage.destroy', $story->id ) }}">
                                @method("DELETE")
                                @csrf
                                <button class="btn"> <i class="fa fa-trash"></i> </button>
                            </form>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
<div class="d-flex justify-content-end mt-4" >
    {{$stories->links()}}
</div>

@if (session()->has('successPublished'))
    <div class="alert alert-success">
        <h3>{{ session('successPublished') }}</h3>
    </div>
@endif

@endsection
