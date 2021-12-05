@extends('layouts.admin')

@section('title') Profile - Dashboard @endsection
@section('description') The largest social media for sharing memories to the whole world or let it stay private with you. Browse millions of users that use it and connect with them. @endsection
@section('keywords') share, login, moments, friends, diary @endsection

@section('content')
{{--    @dd($albums)--}}
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Manage Albums</h1>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>#ID</th>
                    <th>NAME</th>
                    <th>DESCRIPTION</th>
                    <th>CATEGORY</th>
                    <th>NO. STORIES</th>
                    <th>CREATED BY</th>
                </tr>
            </thead>
            <tbody>
                @foreach($albums as $album)
                    <tr>
                        <td>{{ $album->id }}</td>
                        <td>{{ $album->title }}</td>
                        <td class="text-justify">
                            {{ $album->description }}
                        </td>
                        <td>{{ $album->category->name }}</td>
                        <td>
                            <span data-feather="file"></span>
                            {{ count($album->stories) }}
                        </td>
                        <td>{{ $album->user->username }}</td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
@endsection
