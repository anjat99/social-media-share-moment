@extends('layouts.admin')

@section('title') Profile - Dashboard @endsection
@section('description') The largest social media for sharing memories to the whole world or let it stay private with you. Browse millions of users that use it and connect with them. @endsection
@section('keywords') share, login, moments, friends, diary @endsection

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Manage Locations</h1>
        <div class="btn-toolbar mb-2 mb-md-0" id="responseLocations">
            @if (session()->has('successInsertLocation'))
                <div class="alert alert-success">
                    <h3>{{ session('successInsertLocation') }}</h3>
                </div>
            @endif
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('locations-manage.create') }}" class="btn btn-sm btn-outline-secondary">
                <span data-feather="plus"></span>
                ADD NEW LOCATION
            </a>
        </div>
    </div>

    <div class="table-responsive locationsAdmin" id="locationsAdmin">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>#ID</th>
                    <th>COUNTRY NAME</th>
                </tr>
            </thead>
            <tbody>
                @foreach($locations as $location)
                <tr>
                    <td>{{ $location->id }}</td>
                    <td>{{ $location->name }}</td>
                </tr>
                    @endforeach
            </tbody>
        </table>
    </div>

@endsection
