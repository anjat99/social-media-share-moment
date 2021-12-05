@extends('layouts.admin')

@section('title') Message Details @endsection
@section('description') The largest social media for sharing memories to the whole world or let it stay private with you. Browse millions of users that use it and connect with them. @endsection
@section('keywords') share, messages, moments, friends, diary @endsection


@section('content')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Details of Message</h1>
    </div>

    <!-- <div class="table-responsive">
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
          <tr>
            <td>1</td>
            <td>Pera Peric</td>
            <td>perap@gmail.com</td>
            <td>Test Message</td>
            <td>Family sharing? Hobby group? Office? Great for organizing your stories. Optionally share it with select friends so they can add stories too.</td>
            <td>2019-01-01</td>
            <td>READ (2019-01-01)</td>
            <td>
              <a class="btn" href="#">
                <span data-feather="info"></span>
              </a>
              <a class="btn" href="#">
                <span data-feather="delete"></span>
              </a>
            </td>
          </tr>
          <tr>
            <td>2</td>
            <td>Pera Peric</td>
            <td>perap@gmail.com</td>
            <td>Test Message</td>
            <td>In just 2 minutes every other week, create a story about your child. Whether it's a precious moment or just a slice of life, it'll be a treasure for you and your child to look back on one day!</td>
            <td>2018-12-03</td>
            <td>UNREAD</td>
            <td>
              <a class="btn" href="#">
                <span data-feather="info"></span>
              </a>
              <a class="btn" href="#">
                <span data-feather="delete"></span>
              </a>
            </td>
          </tr>
          <tr>
            <td>3</td>
            <td>Una Jovanovic</td>
            <td>unaj@gmail.com</td>
            <td>Proba Subject</td>
            <td>Easily capture a life story, bit by bit, over time. Yours, your parents, a grandparent. It'll be an honor for them and a treasure for your kids!</td>
            <td>2020-04-08</td>
            <td>READ (2020-04-08)</td>
            <td>
              <a class="btn" href="#">
                <span data-feather="info"></span>
              </a>
              <a class="btn" href="#">
                <span data-feather="delete"></span>
              </a>
            </td>
          </tr>
          <tr>
            <td>4</td>
            <td>Ana Petrovic</td>
            <td>anap@gmail.com</td>
            <td>Test Subject</td>
            <td>Easily capture a life story, bit by bit, over time. Yours, your parents, a grandparent. It'll be an honor for them and a treasure for your kids!</td>
            <td>2019-08-05</td>
            <td>READ (2019-08-05)</td>
            <td>
              <a class="btn" href="#">
                <span data-feather="info"></span>
              </a>
              <a class="btn" href="#">
                <span data-feather="delete"></span>
              </a>
            </td>
          </tr>
          <tr>
            <td>5</td>
            <td>Jova Jovic</td>
            <td>jovaj@gmail.com</td>
            <td>Subject Test</td>
            <td>Easily capture a life story, bit by bit, over time. Yours, your parents, a grandparent. It'll be an honor for them and a treasure for your kids!</td>
            <td>2018-12-12</td>
            <td>UNREAD</td>
            <td>
              <a class="btn" href="#">
                <span data-feather="info"></span>
              </a>
              <a class="btn" href="#">
                <span data-feather="delete"></span>
              </a>
            </td>
          </tr>

        </tbody>
      </table>
    </div> -->

    <div class="table-responsive menu_table" id="messagesTable">
        <table class="table tablesorter main__table">
            <tbody>
            <tr>
                <td class="text-white head__table">SENDER NAME </td>
                <td>
                    <div class="main__table-text">{{ $message->name }}</div>
                </td>
            </tr>
            <tr>
                <td class="text-white head__table">SENDER EMAIL</td>
                <td>
                    <div class="main__table-text font-weight-bold">{{ $message->email }}</div>
                </td>
            </tr>
            <tr>
                <td class="text-white head__table">SUBJECT</td>
                <td>
                    <div class="main__table-text main__table-text--green font-weight-bold">{{ $message->subject }}</div>
                </td>
            </tr>
            <tr>
                <td class="text-white head__table">MESSAGE</td>
                <td>
                    <div class="main__table-text main__table-text--green">{{ $message->message }}</div>
                </td>
            </tr>
            <tr>
                <td class="text-white head__table">DATE OF SENT</td>
                <td>
                    <div class="main__table-text main__table-text--green">
                        {{ date("d,M Y H:i",strtotime($message->created_at)) }}
                    </div>
                </td>
            </tr>
            <tr>
                <td class="text-white head__table" colspan="2">
                    <a href="{{ route('messages.index') }}" class="btn btn-dark ml-2"><i class="fa fa-arrow-left"></i>  Back to list of messages</a>
                </td>
            </tr>
            </tbody>

        </table>
    </div>

@endsection
