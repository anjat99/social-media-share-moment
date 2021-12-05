@extends('layouts.admin')

@section('title') Story Details @endsection
@section('description') The largest social media for sharing memories to the whole world or let it stay private with you. Browse millions of users that use it and connect with them. @endsection
@section('keywords') share, stories, moments, friends, diary @endsection


@section('content')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Details of Story</h1>
    </div>

    @if (session()->has('errorPublished'))
        <div class="alert alert-info">
            <h3>{{ session('errorPublished') }}</h3>
        </div>
    @endif


    <div class="table-responsive menu_table" id="messagesTable">
        <table class="table tablesorter main__table">
            <tbody>
            <tr>
                <td class="text-white head__table">CAPTION</td>
                <td>
                    <div class="main__table-text">{{ $story->caption }}</div>
                </td>
            </tr>
            <tr>
                <td class="text-white head__table">COVER IMAGE</td>
                <td>
                    <div class="main__table-text">
                        <img width="500" src="{{ asset('/assets/img/stories/'. $story->cover)}}" class="img-fluid">
                    </div>
                </td>
            </tr>
            <tr>
                <td class="text-white head__table">ALBUM</td>
                <td>
                    <div class="main__table-text">
                        <span data-feather="folder"></span>

                            @if($story->album !== null)
                                {{ $story->album->title }}
                            @else
                               This story does not belong to any album.
                            @endif

                    </div>
                </td>
            </tr>
            <tr>
                <td class="text-white head__table">DESCRIPTION</td>
                <td>
                    <div class="main__table-text main__table-text--green text-justify">{{ $story->description }}</div>
                </td>
            </tr>
            <tr>
                <td class="text-white head__table">TAGS</td>
                <td>
                    <div class="main__table-text">
                        @forelse ($story->tags as $i => $tag)

                            @if($i != count($story->tags) - 1)
                                {{ $tag->title }},
                            @else
                                {{ $tag->title }}
                            @endif
                        @empty
                            No tags.
                        @endforelse
                    </div>
                </td>
            </tr>
            <tr>
                <td class="text-white head__table">LOCATION</td>
                <td>
                    <div class="main__table-text">
                        {{ $story->location->name }}
                    </div>
                </td>
            </tr>
            <tr>
                <td class="text-white head__table">STATUS</td>
                <td>
                    <div class="main__table-text">
                        {{ $story->status->name }}
                    </div>
                </td>
            </tr>
            <tr>
                <td class="text-white head__table">CREATED BY</td>
                <td>
                    <div class="main__table-text">
                        {{ $story->user->first_name }} {{ $story->user->last_name }} ({{$story->user->username}})
                    </div>
                </td>
            </tr>
            <tr>
                <td class="text-white head__table">STATE</td>
                <td>
                    <div class="main__table-text">
                        @php
                            if($story->published == 0){
                                echo "WAITING FOR PUBLISHING";
                            }else{
                                echo "PUBLISHED AT". "&nbsp;  $story->published_at";
                            }

                        @endphp
                    </div>
                </td>
            </tr>

            <tr>
                <td class="text-white head__table" colspan="2">
                    <div class="d-flex justify-content-center align-items-center">
                        @if($story->published == 0)
                            <form method="POST" action="{{ route('approve-story', $story->id) }}" class="btn btn-dark mr-2">
                                @method("PUT")
                                @csrf
                                <button class="btn text-white"><i class="fa fa-check"></i>APPROVE STORY</button>
                            </form>
                        @endif
                            <a href="{{ route('stories-manage.index') }}" class="btn btn-dark ml-2"><i class="fa fa-arrow-left"></i>  Back to list of stories</a>
                    </div>

                </td>
            </tr>
            </tbody>

        </table>
    </div>

@endsection
