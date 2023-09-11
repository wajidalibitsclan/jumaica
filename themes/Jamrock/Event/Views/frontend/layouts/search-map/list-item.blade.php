<div class="bravo-list-item @if(!$rows->count()) not-found @endif">
    @if($rows->count())
        <div class="list-item">
            <div class="row">
                @foreach($rows as $row)
                    <div class="col-lg-4 col-md-6  mb-30px">
                        @include('Event::frontend.layouts.search.loop-grid')
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bravo-pagination">
            {{$rows->appends(array_merge(request()->query(),['_ajax'=>1]))->links()}}
        </div>
    @else
        <div class="not-found-box">
            <h3 class="n-title">{{__("We couldn't find any events.")}}</h3>
            <p class="p-desc">{{__("Try changing your filter criteria")}}</p>
            {{--<a href="#" onclick="return false;" click="" class="btn btn-danger">{{__("Clear Filters")}}</a>--}}
        </div>
    @endif
</div>
