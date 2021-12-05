<div class="comment-add" id="comment-add">
    <form  class="ra-form">

        <div class="row">
            <div class="col-lg-12">
                <textarea id="taMessageComment" name="taMessageComment" class="form-control border-bottom border-dark" placeholder="Your Comment"></textarea>
                <p class="text-danger msgError" id="msgError"></p>
                <a class="btn btn-outline-info" data-story="{{ $story->id }}"  id="btnAddComment">Submit Now</a>
                <br><br>
            </div>
        </div>

    </form>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session()->has('warning'))
        <div class="alert alert-warning">
            <h3>{{ session('warning') }}</h3>
        </div>
    @endif
    @if (session()->has('success'))
        <div class="alert alert-success">
            <h3>{{ session('success') }}</h3>
        </div>
    @endif

</div>

@section('javascript')
    <script src="{{asset('assets/js/feed.js')}}"></script>
@endsection
