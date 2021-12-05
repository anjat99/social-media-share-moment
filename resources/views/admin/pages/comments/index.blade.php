@extends('layouts.admin')

@section('title') Profile - Dashboard @endsection
@section('description') The largest social media for sharing memories to the whole world or let it stay private with you. Browse millions of users that use it and connect with them. @endsection
@section('keywords') share, login, moments, friends, diary @endsection

@section('content')
{{--@dd($comments)--}}
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Manage Comments</h1>
        <div class="btn-toolbar mb-2 mb-md-0" id="responseMessages">
            @if (session()->has('successDeleteComment'))
                <div class="alert alert-success">
                    <h3>{{ session('successDeleteComment') }}</h3>
                </div>
            @endif
            @if (session()->has('errorDeleteComment'))
                <div class="alert alert-danger">
                    <h3>{{ session('errorDeleteComment') }}</h3>
                </div>
            @endif
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>#ID</th>
                    <th>CONTENT TEXT</th>
                    <th>IS REPORTED</th>
                    <th>POST</th>
                    <th>USER</th>
                    <th>DATE OF POST</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @foreach($comments as $comment)
                    <tr>
                        <td>{{ $comment->id }}</td>
                        <td>
                            @php
                                if(strlen($comment->comment_text)<=80){
                                    echo $comment->comment_text;
                                }else{
                                    $comment->comment_text=substr($comment->comment_text,0,80) . '...';
                                        echo $comment->comment_text;
                                }

                            @endphp

                        </td>
                        <td>
                            @php
                                if($comment->is_reported == 0){
                                    echo "NOT REPORTED";
                                }else{
                                    echo "REPORTED". "<br>($comment->reported_at)";
                                }

                            @endphp
                        </td>
                        <td>{{ $comment->story->caption }}</td>
                        <td>
                            {{ $comment->user->username }}
                        </td>
                        <td>{{date("d,M Y H:i",strtotime($comment->created_at))}}</td>
                        <td>
                            <a class="btn" href="{{ route('comments-manage.show', $comment->id ) }}">
                                <span data-feather="info"></span>
                            </a>
                            <form method="POST" action="{{ route('comments-manage.destroy', $comment->id ) }}">
                                @method("DELETE")
                                @csrf
                                <button class="btn"> <i class="fa fa-trash"></i> </button>
                            </form>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
<div class="d-flex justify-content-end mt-4" >
    {{$comments->links()}}
</div>
@endsection
