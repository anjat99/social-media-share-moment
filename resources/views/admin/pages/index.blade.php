@extends('layouts.admin')

@section('title') Profile - Dashboard @endsection
@section('description') The largest social media for sharing memories to the whole world or let it stay private with you. Browse millions of users that use it and connect with them. @endsection
@section('keywords') share, login, moments, friends, diary @endsection


@section('content')
{{--    @dd($allMessages)--}}
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
    </div>

    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    <span data-feather="users"></span>
                    No. Clients
                    <span class="ml-5">{{ count($allClients) }}</span>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('users.index') }}">View More</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">
                    <span data-feather="file"></span>
                    No. Stories
                    <span class="ml-5">{{ count($allStories) }}</span>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('stories-manage.index') }}">View More</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">
                    <span data-feather="mail"></span>
                    No. Messages
                    <span class="ml-5">{{ count($allMessages) }}</span> <br>
                    Unread messages: {{ count($unreadMessages) }}
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('messages.index') }}">View More</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-danger text-white mb-4">
                <div class="card-body">
                    <span data-feather="map"></span>
                    No. Locations
                    <span class="ml-5">{{ count($allLocations) }}</span>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('locations-manage.index') }}">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Users Stats -->
        <div class="col-lg-12 col-md-12 col-sm-12 mb-4">
            <div class="card card-small">
                <div class="card-header border-bottom">
                    <h4 class="m-0">
                        <span data-feather="activity"></span>
                        ACTIVITIES OF USERS</h4>
                </div>
                <div class="card-body pt-0 p-4">
                    <div class="row border-bottom py-2 bg-light">
                        <div class="container-fluid col-12">
                            <div class="d-flex justify-content-between input-group-sm my-auto ml-auto mr-auto ml-sm-auto mr-sm-0">
                                <div class="d-flex flex-column">
                                    <label for="start">Date from</label>
                                    <input type="date" class="input-sm form-control date" name="start" placeholder="Start Date" id="dateFrom">
                                </div>
                                <div class="d-flex flex-column">
                                    <label for="end">Date to</label>
                                    <input type="date" class="input-sm form-control date" name="end" placeholder="End Date" id="dateTo">
                                </div>


                                <span class="input-group-append">
                              <span class="input-group-text">
                                <i class="material-icons"></i>
                              </span>
                            </span>
                            </div>
                        </div>

                    </div>
                    <div class="table-responsive p-3" id="no-activities">
                        <table class="table table-striped table-sm ">
                            <thead>
                            <tr>
                                <th>FROM (IP ADDRESS)</th>
                                <th>EMAIL</th>
                                <th>USERNAME</th>
                                <th>ROLE</th>
                                <th>ACTIVITY</th>
                                <th>DATE</th>
                            </tr>
                            </thead>
                            <tbody id="activities">
                                 @foreach($activities as $a)
                                     <tr>
                                         <td class="text-center">
                                             {{$a->ip_address }}
                                         </td>
                                         <td class="text-center">
                                             {{$a->user->email }}
                                         </td>
                                         <td class="text-center">
                                             {{$a->user->username }}
                                         </td>
                                         @if($a->user->role_id == 2)
                                             <td class="text-center">
                                                 user
                                             </td>
                                         @else
                                             <td class="text-center">
                                                 admin
                                             </td>
                                         @endif
                                         <td class="text-center">
                                             {{ $a->activity }}
                                         </td>
                                         <td class="text-center">
                                             {{ $a->date }}
                                         </td>
                                     </tr>
                                 @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-4" id="paging">
                        {{$activities->links("frontend.partials.pagination")}}
                    </div>
                </div>
            </div>
        </div>
        <!-- End Users Stats -->
    </div>

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <div class="card-header border-bottom">
            <!-- <h6 class="">Users</h6> -->
            <h3 class="h2 m-0">
                <span data-feather="bell"></span>
                Latest Registered Users
            </h3>
        </div>

        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
                <button type="button" class="btn btn-sm btn-outline-secondary">View all</button>
            </div>
        </div>

        <!-- <div class="col-12 col-sm-6 d-flex mb-2 mb-sm-0">
          <button type="button" class="btn btn-sm btn-white ml-auto mr-auto ml-sm-auto mr-sm-0 mt-3 mt-sm-0">View Full Report &rarr;</button>
        </div> -->
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
            <tr>
                <th>FULLNAME</th>
                <th>EMAIL</th>
                <th>USERNAME</th>
                <th>DATE OF REGISTER</th>
            </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td class="text-center">
                            {{ $user->first_name ." ".$user->last_name }}
                        </td>
                        <td class="text-center">
                            {{ $user->email }}
                        </td>
                        <td class="text-center">
                            {{ $user->username }}
                        </td>
                        <td class="text-center">
                            {{ date("d,M Y H:i",strtotime($user->created_at))}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection

@section("adminScripts")
    <script src="{{asset("assets/js/pagination.js")}}"></script>
@endsection

