@if ($paginator->hasPages())
    <nav>
        <div class="">
            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a class="btn btn-secondary btn-block btn-lg" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">{{\App\EventDetail::whereName('next_survey_button')->first()->content}}</a>
            @else
                <a data-toggle="modal" href="{{ route('home') }}" class="btn btn-secondary text-white btn-block btn-lg" rel="next" aria-label="@lang('pagination.next')">{{\App\EventDetail::whereName('finish_survey_button')->first()->content}}</a>
            @endif
        </div>
    </nav>
@else
    <nav>
        <div class="">
            <a data-toggle="modal" href="{{ route('home') }}" class="btn btn-secondary text-white btn-block btn-lg" rel="next" aria-label="@lang('pagination.next')">{{\App\EventDetail::whereName('finish_survey_button')->first()->content}}</a>
        </div>
    </nav>
@endif