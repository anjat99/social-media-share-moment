@extends('layouts.template')

@section('title') Profile - Dashboard @endsection
@section('description') The largest social media for sharing memories to the whole world or let it stay private with you. Browse millions of users that use it and connect with them. @endsection
@section('keywords') share, login, moments, friends, diary @endsection

@section('content')
    @php
        $u = session('user');
    @endphp

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Manage Comments</h1>
        <div class="btn-toolbar mb-2 mb-md-0" id="responseMessages">
            @if (session()->has('successReportComment'))
                <div class="alert alert-success">
                    <h3>{{ session('successReportComment') }}</h3>
                </div>
            @endif
            @if (session()->has('errorReportComment'))
                <div class="alert alert-danger">
                    <h3>{{ session('errorReportComment') }}</h3>
                </div>
            @endif
        </div>
        <div class="btn-toolbar mb-2 mb-md-0" id="responseMessages">
            @if (session()->has('successCancelReportComment'))
                <div class="alert alert-success">
                    <h3>{{ session('successCancelReportComment') }}</h3>
                </div>
            @endif
            @if (session()->has('errorCancelReportComment'))
                <div class="alert alert-danger">
                    <h3>{{ session('errorCancelReportComment') }}</h3>
                </div>
            @endif
        </div>

    </div>


    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
            <tr>
                <th>#</th>
                <th>COMMENT</th>
                <th>REPORTED</th>
                <th>POST</th>
                <th>USER</th>
                <th>CREATED</th>
                <th>REPORT COMMENT</th>
            </tr>
            </thead>
            <tbody>
            @foreach($comments as $comment)
                @if(($comment->story->user_id == session("user")->id ) && ($comment->user_id != session("user")->id))
                <tr>
                    <td>
                        <span data-feather="message-circle"></span>
                    </td>
                    <td> {{ $comment->comment_text }}</td>
                    <td>
                        @php
                            if($comment->is_reported == 0){
                                echo "NOT REPORTED";
                            }else{
                                echo "REPORTED". "<br>($comment->reported_at)";
                            }

                        @endphp
                    </td>
                    <td>
                        {{ $comment->story->caption }}
                    </td>
                    <td> {{ $comment->user->username }}</td>
                    <td>{{ date("d,M Y H:i",strtotime($comment->created_at)) }}</td>
                    <td class="d-flex justify-content-center">
                        @if($comment->is_reported == 0)
                            <form method="POST" action="{{ route('report-comment', $comment->id) }}">
                                @method("PUT")
                                @csrf
                                <button class="btn btn-outline-warning" title="report comment"> <i class="fas fa-user-lock"></i></button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('cancel-report-comment', $comment->id) }}">
                                @method("PUT")
                                @csrf
                                <button class="btn btn-outline-warning" title="cancel report comment"><i class="fas fa-unlock"></i></button>
                            </form>
                        @endif
                    </td>
                </tr>
                @endif
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
