@extends('layouts.template')

@section('title') Profile - Dashboard @endsection
@section('description') The largest social media for sharing memories to the whole world or let it stay private with you. Browse millions of users that use it and connect with them. @endsection
@section('keywords') share, login, moments, friends, diary @endsection

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Send message to admin</h1>
        <div class="btn-toolbar mb-2 mb-md-0" id="responseTags">
            <div class="container mt-3" id="responseTags">
                @if (session()->has('successInsertTag'))
                    <div class="alert alert-success">
                        <h3>{{ session('successInsertTag') }}</h3>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="mt-5">
        <form action="#" class="contact-form">

            <div class="row d-flex justify-content-center align-items-center">

                    <div class="col-lg-5">
                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text" disabled id="tbNameContact" class="form-control" name="tbNameContact" data-field="name"  value="{{ session()->get('user')->first_name ." ". session()->get('user')->last_name}}">
                            <p class="text-danger msgErrorName"></p>
                        </div>

                    </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="text" disabled data-field="email" id="tbEmailContact" class="form-control"name="tbEmailContact"  value="{{ session()->get('user')->email }}">
                            <p class="text-danger msgErrorEmail"></p>
                        </div>
                    </div>

                <div class="col-lg-10">
                    <div class="form-group">
                        <label for="">Subject</label>
                        <input type="text" data-field="subject"  id="tbSubjectContact" name="tbSubjectContact" class="form-control">
                    </div>

                    <p class="text-danger msgErrorSubj"></p>
                </div>
                <div class="col-lg-10">
                    <div class="form-group">
                        <label for="">Your message</label>
                        <textarea data-field="message" class="form-control adminForm"  id="taMessageContact" name="taMessageContact" cols="30" rows="5"></textarea>
                    </div>

                    <p class="text-danger msgErrorMessage"></p>
                    <button id="btnSendMessage" class="btn btn-outline-danger d-flex justify-content-center  m-auto" type="submit">Send message</button>
                </div>

            </div>
        </form>
        <div class="errors text-danger"></div>
    </div>

@endsection


