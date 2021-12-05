@extends('layouts.admin')

@section('title') Manage Categories @endsection
@section('description') The largest social media for sharing memories to the whole world or let it stay private with you. Browse millions of users that use it and connect with them. @endsection
@section('keywords') share, categories, moments, friends, diary @endsection


@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Manage Categories</h1>
        <div class="btn-toolbar mb-2 mb-md-0" id="responseCategories">
                @if (session()->has('successInsertCategory'))
                    <div class="alert alert-success">
                        <h3>{{ session('successInsertCategory') }}</h3>
                    </div>
                @endif
                @if (session()->has('successUpdateCategory'))
                    <div class="alert alert-success">
                        <h3>{{ session('successUpdateCategory') }}</h3>
                    </div>
                @endif
                @if (session()->has('successDeleteCategory'))
                    <div class="alert alert-success">
                        <h3>{{ session('successDeleteCategory') }}</h3>
                    </div>
                @endif
                @if (session()->has('errorDeleteCategory'))
                    <div class="alert alert-danger">
                        <h3>{{ session('errorDeleteCategory') }}</h3>
                    </div>
                @endif

        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('categories.create') }}" class="btn btn-sm btn-outline-secondary">
                <span data-feather="plus"></span>
                ADD NEW CATEGORY
            </a>
        </div>
    </div>

    <div class="table-responsive categoriesAdmin" id="categoriesAdmin">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>#ID</th>
                    <th>NAME</th>
                    <th>DESCRIPTION</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                <tr>
                    <td> {{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->description }}</td>
                    <td>
                        <a class="btn" href="{{ route('categories.edit', $category->id) }}">
                            <i class="fa fa-edit"></i>
                        </a>
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>

@endsection
