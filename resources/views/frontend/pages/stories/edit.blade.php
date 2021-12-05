@extends('layouts.template')

@section('title') Profile - Dashboard @endsection
@section('description') The largest social media for sharing memories to the whole world or let it stay private with you. Browse millions of users that use it and connect with them. @endsection
@section('keywords') share, login, moments, friends, diary @endsection

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Edit Post</h1>
        <div class="btn-toolbar mb-2 mb-md-0" id="responseCategories">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session()->has('warningUpdateStory'))
                <div class="alert alert-warning">
                    <h3>{{ session('warningUpdateStory') }}</h3>
                </div>
            @endif @if (session()->has('errorUpdateStory'))
                <div class="alert alert-warning">
                    <h3>{{ session('errorUpdateStory') }}</h3>
                </div>
            @endif
        </div>
    </div>



    <div class="row pt-3 pb-2 mb-3">
        <!-- Users Stats -->
        <div class="col-lg-11 col-md-11 col-sm-11 mb-4 m-auto">
            <div id="createPost">
                <form method="POST" action="{{ route('stories.update', $story->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method("PUT")
                    <div class="form-row">
                        <div class="form-group col-lg-6">
                            <label for="">Caption*</label>
                            <input type="text" name="title" class="form-control " value="{{ $story->caption }}">
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="inputState">Albums</label>
                            <select id="album" name="album" class="form-control">
                                <option value="0" selected disabled>Choose now or Later...</option>
                                @foreach($albums as $a)
                                    <option value="{{ $a->id }}"{{ $story->album_id == $a->id ? "selected" : "" }}> {{ $a->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="form-group col-lg-9">
                                <label for="inputState">Location</label>
                                <select id="location" name="location" class="form-control">
                                    <option value="0" selected>Choose now or Later...</option>
                                    @foreach($locations as $l)
                                        <option value="{{ $l->id }}" {{ $story->location_id == $l->id ? "selected" : "" }}> {{ $l->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div lass="form-group col-lg-3">
                              <span>
                                <a href="{{ route('locations.create') }}" class="btn btn-outline-dark">Add new Location</a>
                              </span>
                            </div>
                        </div>

                    </div>
                    <div class="form-row">
                        <div class="form-group col-lg-6">
                            <label for="status">Status</label>
                            <select id="status" name="status" class="form-control">
                                <option value="0" selected>Change...</option>
                                @foreach($statuses as $s)
                                    <option value="{{ $s->id }}" {{ $story->status_id == $s->id ? "selected" : "" }}> {{ $s->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="inputLName">Cover Image</label>
                            <input type="file" class="form-control adminForm" name="image" id="image">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputLName">Choose Tags now OR LAter</label> <br>
                        <div class="row mx-1">
                                @foreach($tags as $tag)
                                <div class="custom-control custom-checkbox mr-5">
                                    <input type="checkbox" class="form-check-input" id="tag{{ $tag->id }}" name="tag[]" value="{{ $tag->id }}"
                                       @if(isset($story) && in_array($tag->id, $story->tags()->pluck('tag_id')->toArray()))
                                        checked
                                       @elseif(is_array(old('tag_id')) && in_array($tag->id, old('tag_id')))
                                        checked
                                      @endif
                                    />
                                    <label class="form-check-label" for="tag{{ $tag->id }}">{{ $tag->title }}</label>
                                </div>
                                @endforeach
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Description</label>
                        <textarea class="form-control adminForm" name="description" cols="30" rows="5">{{ $story->description }}</textarea>
                    </div>

                    <div class="col-sm-8 mb-2 mt-5 d-flex justify-content-center">
                        <input id="btn-signup" type="submit" class="btn btn-info btnSubmitA" name="btnUpdateRoomType" id="btnUpdateRoomType" value="UPDATE AND EXIT" />
                        <a href="{{ route('stories.index') }}" class="btn btn-dark ml-3"><i class="fa fa-arrow-left"></i>  CANCEL </a>
                    </div>


                </form>
            </div>


        </div>
        <!-- End Users Stats -->
    </div>
@endsection
