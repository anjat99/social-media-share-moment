@extends('layouts.admin')

@section('title') Comment Details @endsection
@section('description') The largest social media for sharing memories to the whole world or let it stay private with you. Browse millions of users that use it and connect with them. @endsection
@section('keywords') share, comments, moments, friends, diary @endsection


@section('content')
{{--    @dd($comment)--}}

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Details of Comment</h1>

    </div>

    <!-- <div class="table-responsive">
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
          <tr>
            <td>1</td>
            <td>Family sharing? Hobby group? Office? Great for organizing your stories. Optionally share it with select friends so they can add stories too.</td>
            <td>REPORTED (2019-01-01)</td>
            <td>Some POST 1</td>
            <td>perap@gmail.com</td>
            <td>2019-01-01</td>
            <td>
              <a class="btn" href="#">
                <span data-feather="info"></span>
              </a>
              <a class="btn" href="#">
                <span data-feather="delete"></span>
              </a>
              <a class="btn" href="#">
                <span data-feather="alert-triangle"></span>
              </a>
            </td>
          </tr>
          <tr>
            <td>2</td>
            <td>In just 2 minutes every other week, create a story about your child. Whether it's a precious moment or just a slice of life, it'll be a treasure for you and your child to look back on one day!</td>
            <td>NOT REPORTED</td>
            <td>Some POST 1</td>
            <td>radao@gmail.com</td>
            <td>2018-12-03</td>
            <td>
              <a class="btn" href="#">
                <span data-feather="info"></span>
              </a>
              <a class="btn" href="#">
                <span data-feather="delete"></span>
              </a>
              <a class="btn" href="#">
                <span data-feather="alert-triangle"></span>
              </a>
            </td>
          </tr>
          <tr>
            <td>3</td>
            <td>Easily capture a life story, bit by bit, over time. Yours, your parents, a grandparent. It'll be an honor for them and a treasure for your kids!</td>
            <td>REPORTED (2020-04-08)</td>
            <td>Some POST 1</td>
            <td>ivanam@gmail.com</td>
            <td>2020-04-08</td>
            <td>
              <a class="btn" href="#">
                <span data-feather="info"></span>
              </a>
              <a class="btn" href="#">
                <span data-feather="delete"></span>
              </a>
              <a class="btn" href="#">
                <span data-feather="alert-triangle"></span>
              </a>
            </td>
          </tr>
          <tr>
            <td>4</td>
            <td>Easily capture a life story, bit by bit, over time. Yours, your parents, a grandparent. It'll be an honor for them and a treasure for your kids!</td>
            <td>REPORTED (2019-08-05)</td>
            <td>Some POST 2</td>
            <td>anap@gmail.com</td>
            <td>2019-08-05</td>
            <td>
              <a class="btn" href="#">
                <span data-feather="info"></span>
              </a>
              <a class="btn" href="#">
                <span data-feather="delete"></span>
              </a>
              <a class="btn" href="#">
                <span data-feather="alert-triangle"></span>
              </a>
            </td>
          </tr>
          <tr>
            <td>5</td>
            <td>Easily capture a life story, bit by bit, over time. Yours, your parents, a grandparent. It'll be an honor for them and a treasure for your kids!</td>
            <td>NOT REPORTED</td>
            <td>Some POST 5</td>
            <td>jocaj@gmail.com</td>
            <td>2018-12-12</td>
            <td>
              <a class="btn" href="#">
                <span data-feather="info"></span>
              </a>
              <a class="btn" href="#">
                <span data-feather="delete"></span>
              </a>
              <a class="btn" href="#">
                <span data-feather="alert-triangle"></span>
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
                <td class="text-white head__table">POST TITLE </td>
                <td>
                    <div class="main__table-text">{{ $comment->story->caption }}
                         (written by:  &nbsp; <span class="font-weight-bold text-light">{{ $comment->story->user->username }}</span>)</div>
                </td>
            </tr>
            <tr>
                <td class="text-white head__table">USER</td>
                <td>
                    <div class="main__table-text main__table-text--green font-weight-bold">{{ $comment->user->username }}</div>
                </td>
            </tr>
            <tr>
                <td class="text-white head__table">COMMENT TEXT</td>
                <td>
                    <div class="main__table-text main__table-text--green text-justify">{{ $comment->comment_text }}</div>
                </td>
            </tr>
            <tr>
                <td class="text-white head__table">IS REPORTED?</td>
                <td>
                    <div class="main__table-text main__table-text--green">
                        @php
                            if($comment->is_reported == 0){
                                echo "NOT REPORTED";
                            }else{
                                echo "REPORTED".  "&nbsp;&nbsp;($comment->reported_at)";
                            }

                        @endphp
                    </div>
                </td>
            </tr>
            <tr>
                <td class="text-white head__table">DATE OF COMMENT</td>
                <td>
                    <div class="main__table-text main__table-text--green">
                        {{ date("d,M Y H:i",strtotime($comment->created_at)) }}
                    </div>
                </td>
            </tr>
            <tr>
                <td class="text-white head__table" colspan="2">
                    <a href="{{ route('comments-manage.index') }}" class="btn btn-dark ml-2"><i class="fa fa-arrow-left"></i>  Back to list of comments</a>
                </td>
            </tr>
            </tbody>

        </table>
    </div>

@endsection
