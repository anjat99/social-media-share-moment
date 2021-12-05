@extends('layouts.admin')

@section('title') Profile - Dashboard @endsection

@section('description') The largest social media for sharing memories to the whole world or let it stay private with you. Browse millions of users that use it and connect with them. @endsection

@section('keywords') share, login, moments, friends, diary @endsection

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Manage Messages</h1>
        <div class="btn-toolbar mb-2 mb-md-0" id="responseMessages">
            @if (session()->has('successDeleteMessage'))
                <div class="alert alert-success">
                    <h3>{{ session('successDeleteMessage') }}</h3>
                </div>
            @endif
            @if (session()->has('errorDeleteMessage'))
                <div class="alert alert-danger">
                    <h3>{{ session('errorDeleteMessage') }}</h3>
                </div>
            @endif
        </div>
    </div>

    <div class="table-responsive messagesAdmin" id="messagesAdmin">
        <table class="table table-striped table-sm">
            <thead>
            <tr>
                <th>#ID</th>
                <th>NAME</th>
                <th>EMAIL</th>
                <th>SUBJECT</th>
                <th>MESSAGE</th>
                <th>DATE OF SENT</th>
                <th>IS READ?</th>
                <th>ACTIONS</th>
            </tr>
            </thead>
            <tbody>
                @foreach($messages as $message)
                    <tr>
                        <td>{{ $message->id }}</td>
                        <td>{{ $message->name }} </td>
                        <td>{{ $message->email }}</td>
                        <td>{{ $message->subject }}</td>
                        <td>
                            @php
                                if(strlen($message->message)<=80){
                                    echo $message->message;
                                }else{
                                    $message->message=substr($message->message,0,50) . '...';
                                        echo $message->message;
                                }

                            @endphp
                        </td>
                        <td>{{date("d,M Y H:i",strtotime($message->created_at)) }}</td>
                        <td>
                            @php
                                if($message->is_read == 0){
                                    echo "UNREAD";
                                }else{
                                    echo "READ";
                                }

                            @endphp
                        </td>
                        <td>
                            <a class="btn" href="{{ route('messages.show', $message->id) }}">
                                <i class="fas fa-info-circle"></i>
                            </a>
                            <a class="btn btnDeleteMessage" href="#"  data-id="{{ $message->id }}">
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-end mt-4" >
        {{$messages->links("frontend.partials.pagination")}}
    </div>


@endsection
@section("adminScripts")
    <script src="{{asset("assets/js/pagination.js")}}"></script>
@endsection
