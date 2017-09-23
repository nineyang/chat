@if ($paginator->hasPages())
    <center>
        <nav aria-label="Page navigation">
            <ul class="pagination">

                @if ($paginator->onFirstPage())
                    <li class="previous disabled">
                        <span aria-hidden="true">&laquo;</span>
                    </li>
                @else
                    <li>
                        <a href="{{ $paginator->previousPageUrl() }}" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                @endif

                @foreach ($elements as $element)
                    @if (is_string($element))
                        <li class="disabled"><span>{{ $element }}</span></li>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="active"><a href="{{$url}}">{{$page}}</a></li>
                            @else
                                <li><a href="{{$url}}">{{$page}}</a></li>
                            @endif
                        @endforeach
                    @endif
                @endforeach


                @if ($paginator->hasMorePages())
                    <li>
                        <a href="{{ $paginator->nextPageUrl() }}" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                @else
                    <li class="next disabled">
                        <span aria-hidden="true">&raquo;</span>
                    </li>
                @endif

            </ul>
        </nav>
    </center>
@endif
