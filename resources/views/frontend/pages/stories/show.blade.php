@extends('layouts.template')

@section('title') Profile - Dashboard @endsection
@section('description') The largest social media for sharing memories to the whole world or let it stay private with you. Browse millions of users that use it and connect with them. @endsection
@section('keywords') share, login, moments, friends, diary @endsection

@section('content')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2 ">{{ $story->caption }}</h1>

        <p class="alert alert-dark">
            <span data-feather="map-pin"></span>
            {{  $story->location->name }}
        </p>

    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 mb-4">
            <div class="row">
                <div class="col-lg-12">
                    <div class="story__details d-flex flex-column justify-content-center">
                        <div class="d-flex justify-content-center story__image">
                            <img class="img-fluid" src="{{ asset('/assets/img/stories/'. $story->cover) }}" alt="" width="600" height="300">
                        </div>
                        <div class="d-flex justify-content-center">
                            <h1>{{ $story->caption }}</h1>
                        </div>
                        <div class="user_details">
                            <div class="float-left">
                                @if($story->status->name !== "friends")
                                     <p class="alert alert-secondary">Status: {{ $story->status->name }}</p>
                                @else
                                    <p class="alert alert-danger">Shared with friends</p>
                                @endif
                            </div>
                            <div class="float-right mt-sm-0">
                                <div class="media">
                                    <div class="media-body">

                                        Last updated: @php
                                            if($story->updated_at == null){
                                                $publishedDate = $story->published_at;
                                                $newFormat = date('d M, Y', strtotime($publishedDate));
                                                echo $newFormat;
                                            }else{
                                                $updatedDate = $story->updated_at;
                                                $newFormat = date('d M, Y', strtotime($updatedDate));
                                                echo $newFormat;
                                            }

                                        @endphp

                                    </div>
                                    <div class="d-flex">
                                        @if(session("user")->profile_image !== null)
                                            <img
                                                class="user__icon rounded-circle"
                                                src="{{ asset('/assets/storage/img/avatars/'. session("user")->profile_image) }}"
                                                alt="profile pic"
                                                width="40" height="40"
                                            />
                                        @elseif(session("user")->profile_image === null && session("user")->gender->name === "male")
                                            <img
                                                class="user__icon rounded-circle"
                                                src="{{ asset('assets/images/default-avatar.png') }}"
                                                alt="profile pic"
                                                width="40" height="40"
                                            />
                                        @elseif(session("user")->profile_image === null && session("user")->gender->name === "female")
                                            <img
                                                class="user__icon rounded-circle"
                                                src="{{ asset('assets/images/woman-avatar.png') }}"
                                                width="40" height="40"
                                                alt="profile pic"
                                            />
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <blockquote class='post mt-0'>
                            <p class='mb-0 text-justify'>{{ $story->description}}</p>
                        </blockquote>

                    </div>


                </div>
                @foreach($story->tags as $tag)
                    <p class="alert alert-secondary mr-1 @if ($loop->first) ml-3 @endif">
                        <span data-feather="tag"></span>
                        {{ $tag->title}}
                    </p>
                    @if(!$loop->index == count($story->tags) -1)

                    @endif
                @endforeach
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="rd-comments d-flex flex-column">
                        <h4 class="float-left">Comments <i class="far fa-comments"></i> {{ count($story->comments) }}</h4>
                        @if(session()->has('user'))
                            <span><a href="#!" id="btnShowFormAddComment" class="btn btn-dark mb-3 ml-3"> ADD COMMENT </a></span>
                            <br>


                            @include('frontend.pages.stories.create-comment-form')
                        @endif
                        <div id="comments">


                            @if(count($story->comments) <= 0)
                                <p class="text-darker">Currently don't have any comment for this story.</p>
                            @else
                                @foreach($story->comments as $i=>$comment)
                                    <div class="comment-item">
                                        <div class="ri-pic">
                                            @if($comment->user->profile_image !== null)
                                                <img
                                                    src="{{ asset('/assets/img/avatars/'. $comment->user->profile_image) }}"
                                                    alt="profile pic"
                                                    class="mb-3"
                                                    width="70" height="90"
                                                />
                                            @elseif($comment->user->profile_image === null && $comment->user->gender->name === "male")
                                                <img
                                                    src="{{ asset('assets/images/default-avatar.png') }}"
                                                    alt="profile pic"
                                                    class="mb-3"
                                                    width="70" height="90"
                                                />
                                            @elseif($comment->user->profile_image === null && $comment->user->gender->name === "female")
                                                <img
                                                    src="{{ asset('assets/images/woman-avatar.png') }}"
                                                    alt="profile pic"
                                                    class="mb-3"
                                                    width="70" height="90"
                                                />
                                            @endif
                                        </div>
                                        <div class="ri-text">
                                            <span> {{ date('d M Y H:i:s',strtotime($comment->created_at))  }} </span>
                                            <h5>{{ $comment->user->first_name }}  {{ $comment->user->last_name }}</h5>
                                            <p>{{ $comment->comment_text }}</p>
                                        </div>
                                    </div>
                                @endforeach

                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="d-flex justify-content-end">
                        <div>
                            <a href="{{ route('stories.index') }}" class="btn btn-outline-info ml-5"><i class="fa fa-arrow-left"></i>  Back to all stories</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script src="{{asset('assets/js/feed.js')}}"></script>
@endsection
