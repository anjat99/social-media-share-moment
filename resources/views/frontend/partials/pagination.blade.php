@if ($paginator->hasPages())
    <div class="row">
        <nav class="col-12 d-flex justify-content-center" aria-label="...">
            <ul class="pagination pagination-sm" id="paginacija">
                @foreach ($elements as $element)
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            <li class="page-item @if ($page == $paginator->currentPage()) active @endif"><a class="page-link" id="link{{$page}}" data-page="{{$page}}" href="{{$url}}">{{$page}}</a></li>
                        @endforeach
                    @endif
                @endforeach
            </ul>
        </nav>
    </div>
@endif
