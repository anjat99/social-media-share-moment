@extends('layouts.template')

@section('title') Profile - Dashboard @endsection
@section('description') The largest social media for sharing memories to the whole world or let it stay private with you. Browse millions of users that use it and connect with them. @endsection
@section('keywords') share, login, moments, friends, diary @endsection

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Manage Tags</h1>
        <div class="btn-toolbar mb-2 mb-md-0" id="responseTags">
            <div class="container mt-3" id="responseTags">
                @if (session()->has('successInsertTag'))
                    <div class="alert alert-success">
                        <h3>{{ session('successInsertTag') }}</h3>
                    </div>
                @endif
            </div>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('tags.create') }}" class="btn btn-sm btn-outline-secondary">
                <span data-feather="plus"></span>
                ADD NEW TAG
            </a>
        </div>
    </div>

    <div class="table-responsive tagsUser">
        <table class="table table-striped table-sm">
            <tbody>
            @foreach($tags as $tag)
                <tr>
                    <td> <span data-feather="tag"></span></td>
                    <td>{{ $tag->title }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection
