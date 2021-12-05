@extends('layouts.template')

@section('title') Profile - Dashboard @endsection
@section('description') The largest social media for sharing memories to the whole world or let it stay private with you. Browse millions of users that use it and connect with them. @endsection
@section('keywords') share, login, moments, friends, diary @endsection


@section('content')
    <div class="row pt-3 pb-2 mb-3">

        <div class="col-lg-8 col-md-8 col-sm-8 mb-4 contentPart">
            <div class="messageSender">
                <div class="messageSender__top">
                        @if(session("user")->profile_image != null)
                            <img
                                class="user__avatar"
                                src="{{ asset('/assets/img/avatars/'. session("user")->profile_image) }}"
                                alt="profile pic"
                            />
                        @elseif(session("user")->profile_image == null && session("user")->gender->name == "male")
                            <img
                                class="user__avatar"
                                src="{{ asset('assets/images/default-avatar.png') }}"
                                alt="profile pic"
                            />
                        @elseif(session("user")->profile_image === null && session("user")->gender->name == "female")
                            <img
                                class="user__avatar"
                                src="{{ asset('assets/images/woman-avatar.png') }}"
                                alt="profile pic"
                            />
                        @endif
                    <form>
                        <input class="messageSender__input" placeholder="What's on your mind?" type="text" id="linkOpenCreateNewPost"/>

                    </form>
                </div>
            </div>

            <div id="storiesFriends">
{{--                @foreach($stories as $story)--}}
{{--                <div class="post-container">--}}
{{--                    <div class="post-row">--}}
{{--                        <div class="user-profile">--}}
{{--                            @if(session("user")->profile_image !== null)--}}
{{--                                <img--}}
{{--                                    src="{{ {{ asset('/assets/img/avatars/'. session("user")->profile_image) }}"--}}
{{--                                    alt="profile pic"--}}
{{--                                />--}}
{{--                            @elseif(session("user")->profile_image === null && session("user")->gender->name == "male")--}}
{{--                                <img--}}
{{--                                    src="{{ asset('assets/images/default-avatar.png') }}"--}}
{{--                                    alt="profile pic"--}}
{{--                                />--}}
{{--                            @elseif(session("user")->profile_image == null && session("user")->gender->name === "female")--}}
{{--                                <img--}}
{{--                                    src="{{ asset('assets/images/woman-avatar.png') }}"--}}
{{--                                    alt="profile pic"--}}
{{--                                />--}}
{{--                            @endif--}}
{{--                            <div>--}}
{{--                                <p>{{ $story->user->first_name }} {{ $story->user->last_name }}</p>--}}
{{--                                <span>Last updated @php--}}
{{--                                    if($story->updated_at == null){--}}
{{--                                        if($story->published_at == null){--}}
{{--                                            $printDate = date('d M, Y, H:i');--}}
{{--                                            echo $printDate;--}}
{{--                                        }else{--}}
{{--                                           $publishedDate = $story->published_at;--}}
{{--                                            $newFormat = date('d M, Y, H:i', strtotime($publishedDate));--}}
{{--                                            echo $newFormat;--}}
{{--                                        }--}}
{{--                                    }else{--}}
{{--                                        $updatedDate = $story->updated_at;--}}
{{--                                        $newFormat = date('d M, Y, H:i', strtotime($updatedDate));--}}
{{--                                        echo $newFormat;--}}
{{--                                    }--}}


{{--                                @endphp</span>--}}
{{--                                June 21 2021, 13:40--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <a href="#">--}}
{{--                            <i class="fa fa-ellipsis-v"></i>--}}
{{--                        </a>--}}
{{--                    </div>--}}

{{--                    <p class="post-text">Subscribe <span>@LetsTryThis</span>--}}
{{--                        {{ $story->caption }}--}}
{{--                        {{ $story->description }} <br>--}}

{{--                        @foreach($story->tags as $tag)--}}
{{--                            <a href="#">#{{$tag->title}}</a>--}}
{{--                            @if(!$loop->index == count($story->tags) -1)--}}
{{--                                ,--}}
{{--                            @endif--}}
{{--                        @endforeach--}}

{{--                    </p>--}}
{{--                    <img src="{{ $story->thumbnail_url }}" class="post-img">--}}
{{--                    <div class="post-row">--}}
{{--                        <div class="activity-icons">--}}
{{--                            <div>--}}
{{--                                <img src="{{ asset('assets/images/comments.png') }}">--}}
{{--                                 {{ count($story->comments) }}--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                    </div>--}}
{{--                </div>--}}
{{--                @endforeach--}}
{{--                    <div class="d-flex justify-content-end mt-4" id="paging">--}}
{{--                        {{$stories->links("frontend.partials.pagination")}}--}}
{{--                    </div>--}}

            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-4 mb-4 filterPart">
                <div class="right-sidebar">
                    <div class="sidebar-title">
                        <h4>SORT AND FILTER STORIES</h4>
                    </div>
                    <form>
                        <div class="event justify-content-center">
                            <div class="input-group">
                                <input type="text" class="form-control" id="keyword" name="keyword" placeholder="Search stories">
                                <div class="input-group-append">
                                    <button class="btn btn-secondary" type="button" disabled>
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div class="form-group">
                                <select id="sort" class="form-control">
                                    <option value="0" selected disabled>Sort by: </option>
                                    <option value="Date DESC"> Recent </option>
                                    <option value="Date ASC"> Oldest </option>
                                    <option value="Title ASC"> Title ASC </option>
                                    <option value="Title DESC"> Title DESC </option>
                                </select>
                            </div>
                        </div>
                        <div class="event justify-content-center">
                            <div class="form-group">
                                <label for="inputLName" class="labelSidebar">Tags</label>
                                <div class="form-check">
                                    <label class="form-check-label labelSidebarElement">
                                        @foreach($tags as $tag)
                                            <input type="checkbox" name="tags[]" class="form-check-input tags" id="{{ $tag->id }}" value="{{ $tag->id }}">{{ $tag->title }} <br/>
                                        @endforeach
                                    </label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
        </div>
    </div>




@endsection
@section("javascript")
    <script src="{{asset("assets/js/feed.js")}}"></script>
@endsection
