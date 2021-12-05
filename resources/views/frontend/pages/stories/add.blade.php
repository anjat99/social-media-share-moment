@extends('layouts.template')

@section('title') Profile - Dashboard @endsection
@section('description') The largest social media for sharing memories to the whole world or let it stay private with you. Browse millions of users that use it and connect with them. @endsection
@section('keywords') share, login, moments, friends, diary @endsection

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Add New Post</h1>
        <div class="btn-toolbar mb-2 mb-md-0" id="responseLocations">
            @if (session()->has('errorInsertStory'))
                <div class="alert alert-success">
                    <h3>{{ session('errorInsertStory') }}</h3>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>



    <div class="row pt-3 pb-2 mb-3">
        <!-- Users Stats -->
        <div class="col-lg-11 col-md-11 col-sm-11 mb-4 m-auto">
            <div id="createPost">
                <form method="POST" action="{{ route('stories.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-lg-6">
                            <label for="">Caption*</label>
                            <input type="text" name="title" class="form-control ">
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="inputState">Albums</label>
                            <select id="album" name="album" class="form-control">
                                <option value="0" selected>Choose now or Later...</option>
                                @foreach($albums as $a)
                                    <option value="{{ $a->id }}" > {{ $a->title }}</option>
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
                                        <option value="{{ $l->id }}" > {{ $l->name }}</option>
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
                                    <option value="{{ $s->id }}" > {{ $s->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="inputLName">Cover Image</label>
                            <input type="file" class="form-control adminForm" name="image" id="image">
                        </div>
                    </div>
                    <div class="form-group">

                        <label for="inputLName">Choose Tags now OR LAter</label>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="row mx-1 col-lg-9">
                                @foreach($tags as $t)
                                    <div class="custom-control custom-checkbox mr-5">
                                        <input type="checkbox" class="custom-control-input" id="tag{{ $t->id }}" name="tag_id[]" value="{{ $t->id }}" />
                                        <label class="custom-control-label" for="tag{{ $t->id }}">{{ $t->title }}</label>
                                    </div>
                                @endforeach
                            </div>
                            <div lass="form-group col-lg-3">
                              <span>
                                <a href="{{ route('tags.create') }}" class="btn btn-outline-dark">Add new tag</a>
                              </span>
                            </div>
                        </div>


                    </div>
                    <div class="form-group">
                        <label for="">Description</label>
                        <textarea class="form-control adminForm" name="description" cols="30" rows="5"></textarea>
                    </div>

                    <div class="col-sm-8 mb-2 mt-5 d-flex justify-content-center">
                        <input id="btn-signup" type="submit" class="btn btn-info btnSubmitA" name="btnUpdateRoomType" id="btnUpdateRoomType" value="INSERT AND EXIT" />
                        <a href="{{ route('stories.index') }}" class="btn btn-dark ml-3"><i class="fa fa-arrow-left"></i>  CANCEL </a>
                    </div>


                </form>
            </div>


        </div>
        <!-- End Users Stats -->
    </div>
@endsection

