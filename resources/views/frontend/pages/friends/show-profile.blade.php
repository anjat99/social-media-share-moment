@extends('layouts.template')

@section('title') Profile - Dashboard @endsection
@section('description') The largest social media for sharing memories to the whole world or let it stay private with you. Browse millions of users that use it and connect with them. @endsection
@section('keywords') share, login, moments, friends, diary @endsection

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            @if (session()->has('successCancelReport'))
                <div class="alert alert-success">
                    <h3>{{ session('successCancelReport') }}</h3>
                </div>
            @endif
            @if (session()->has('errorCancelReport'))
                <div class="alert alert-danger">
                    <h3>{{ session('errorCancelReport') }}</h3>
                </div>
            @endif
            @if (session()->has('successReportUser'))
                <div class="alert alert-success">
                    <h3>{{ session('successReportUser') }}</h3>
                </div>
            @endif
            @if (session()->has('errorReportUser'))
                <div class="alert alert-danger">
                    <h3>{{ session('errorReportUser') }}</h3>
                </div>
            @endif
        </div>
    </div>


    <div class="row justify-content-center">
        <div class="col-sm-12 col-md-6 col-lg-6 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">{{ $user->first_name }} {{ $user->last_name }}</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-3 col-lg-3 text-center user-icon">
                            @if($user->profile_image !== null)
                                <img
                                    src="{{ asset('/assets/img/avatars/'. $user->profile_image) }}"
                                    alt="profile pic"
                                />
                            @elseif($user->profile_image === null && $user->gender->name === "male")
                                <img
                                    src="{{ asset('assets/images/default-avatar.png') }}"
                                    alt="profile pic"
                                />
                            @elseif($user->profile_image === null && $user->gender->name === "female")
                                <img
                                    src="{{ asset('assets/images/woman-avatar.png') }}"
                                    alt="profile pic"
                                />
                            @endif
                        </div>
                        <div class=" col-md-9 col-lg-9 ">
                            <table class="table table-user-information">
                                <tbody>
                                <tr>
                                    <td>Username</td>
                                    <td>{{ $user->username }}</td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
                                </tr>
                                <tr>
                                    <td>Birthdate</td>
                                    <td>{{ date('d/m/Y',strtotime($user->birthdate)) }}</td>
                                </tr>
                                <tr>
                                    <td>Gender</td>
                                    <td>{{ $user->gender->name }}</td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel-footer d-flex justify-content-between">
                             <span class="pull-left">
                          Friends: <a href="{{ route("friend.friends", $user->id) }}" class="btn btn-sm btn-outline-secondary"> <span data-feather="eye"></span>{{ count($user->friends) }}</a>
                           </span>
                    <span class="pull-right d-flex justify-content-around">
                                 @if(in_array($friend->id, session("user")->friends->pluck('id')->toArray()))
                                     <form method="POST" action="{{ route('unfollow-user', $user->id) }}">
                                        @method("DELETE")
                                         @csrf
                                             <button class="btn btn-sm btn-outline-danger mb-1 mr-2" title="block user">
                                                <span data-feather='minus'></span>
                                                    Unfollow
                                             </button>
                                        </form>
                                 @else
                                     <form method="POST" action="{{ route('follow-user', $user->id) }}">
                                            @csrf
                                             <button class="btn btn-sm btn-outline-danger mb-1 mr-2" title="block user">
                                                <span data-feather='plus'></span>
                                                    Follow
                                             </button>
                                        </form>
                                 @endif
                                @if($user->is_reported == 0)
                                     <form method="POST" action="{{ route('report-user', $user->id) }}">
                                            @method("PUT")
                                         @csrf
                                             <button class="btn btn-sm btn-outline-warning" title="block user">
                                                <span data-feather="alert-triangle"></span>
                                                    Report
                                             </button>
                                        </form>
                                 @else
                                     <form method="POST" action="{{ route('cancel-report-user', $user->id) }}">
                                            @method("PUT")
                                         @csrf
                                             <button class="btn btn-sm btn-outline-warning" title="block user">
                                                  <span data-feather="x-octagon"></span>
                                                Cancel Report
                                             </button>
                                        </form>
                                 @endif
                         </span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 m-1 mt-4">
            <div class="row">
                @foreach($user->stories as $story)
                    @if(($story->status->name !== "private") && (in_array(session("user")->id, $user->friends->pluck('id')->toArray())))
                        <div class="col-sm-3 mb-5">
                            <div class="card">
                                <img src="{{ asset('/assets/img/stories/'. $story->cover) }}" class="card-img-top" alt="{{ $story->caption }}" width="150" height="150">
                                <div class="card-body">
                                    <h3 class="card-title profile_title">{{ $story->caption }}</h3>
                                    <h4 class="profile_subtitle"><span data-feather="map-pin"></span>{{ $story->location->name }}</h4>
                                </div>
                                <div class="card-footer">
                                    <small class="text-muted">Last updated @php
                                            if($story->updated_at == null){
                                                $publishedDate = $story->published_at;
                                                $newFormat = date('d M, Y', strtotime($publishedDate));
                                                echo $newFormat;
                                            }else{
                                                $updatedDate = $story->updated_at;
                                                $newFormat = date('d M, Y', strtotime($updatedDate));
                                                echo $newFormat;
                                            }

                                        @endphp</small>
                                </div>
                            </div>
                        </div>

                    @endif

                @endforeach
            </div>
        </div>
    </div>
@endsection
