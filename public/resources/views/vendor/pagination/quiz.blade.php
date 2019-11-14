@if ($paginator->hasPages())
            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a class="btn btn-primary btn-block btn-lg" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">{{\App\EventDetail::whereName('next_survey_button')->first()->content}}</a>
            @else
                <a onclick="finish_quiz()" class="btn btn-primary text-white btn-block btn-lg" rel="next" aria-label="@lang('pagination.next')">{{\App\EventDetail::whereName('finish_survey_button')->first()->content}}</a>
            @endif
@else
            <a onclick="finish_quiz()" class="btn btn-primary text-white btn-block btn-lg" rel="next" aria-label="@lang('pagination.next')">{{\App\EventDetail::whereName('finish_survey_button')->first()->content}}</a>
@endif