<div class="comment-item">
    <div class="ri-pic">
        @if($comment->user->profile_image !== null)
            <img
                src="{{ asset('/assets/img/avatars/'. $comment->user->profile_image) }}"
                alt="profile pic"
                class="mb-3"
                width="70" height="90"
            />
        @elseif($comment->user->profile_image === null && $comment->user->gender->name === "male")
            <img
                src="{{ asset('assets/images/default-avatar.png') }}"
                alt="profile pic"
                class="mb-3"
                width="70" height="90"
            />
        @elseif($comment->user->profile_image === null && $comment->user->gender->name === "female")
            <img
                src="{{ asset('assets/images/woman-avatar.png') }}"
                alt="profile pic"
                class="mb-3"
                width="70" height="90"
            />
        @endif
    </div>
    <div class="ri-text">
        <span> {{ date('d M Y H:i:s',strtotime($comment->created_at))  }} </span>
        <h5>{{ $comment->user->first_name }}  {{ $comment->user->last_name }}</h5>
        <p>{{ $comment->comment_text }}</p>
    </div>
</div>

@section('javascript')
    <script src="{{asset('assets/js/feed.js')}}"></script>
@endsection
