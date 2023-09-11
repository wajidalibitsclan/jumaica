@extends('layouts.app')
@push('css')
    <link href="{{ asset('dist/frontend/module/tour/css/tour.css?_ver='.config('app.asset_version')) }}"
          rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset("libs/ion_rangeslider/css/ion.rangeSlider.min.css") }}"/>
@endpush
@section('content')
    <div class="bravo_faqs">
        <div class="main-form">
            <div class="container">
                <form action="{{ route('faq.search') }}"
                      class="d-flex form-search justify-content-center  position-relative mb-1">
                    <input class="form-control" type="text" name="s" value="{{ request()->input('s') }}"
                           placeholder="{{ __("Search For") }}">
                    <button type="submit" class="btn btn-primary position-absolute">{{ __("Search") }}</button>
                </form>
                <div class="list-category d-flex">
                    <div class="item {{ !request()->has('cat_id') ? "active":""  }}">
                        <a class="btn btn-primary " href="{{ route('faq.search') }}">
                            All
                        </a>
                    </div>
                    <?php
                    $current_category_ids = Request::query('cat_id');
                    $traverse = function ($categories, $prefix = '') use (&$traverse, $current_category_ids) {
                    $i = 0;
                    foreach ($categories as $category) {
                    $checked = '';
                    if (!empty($current_category_ids)) {
                        foreach ($current_category_ids as $key => $current) {
                            if ($current == $category->id)
                                $checked = 'active';
                        }
                    }
                    $traslate = $category->translateOrOrigin(app()->getLocale())
                    ?>
                    <div class="item {{$checked}}">
                        <a class="btn btn-primary" href="{{ route('faq.search',['cat_id[]'=>$category->id]) }}">
                            {{$prefix}} {{$traslate->name}}
                        </a>
                    </div>
                    <?php
                    $i++;
                    $traverse($category->children, $prefix . '-');
                    }
                    };
                    $traverse($faq_category);
                    ?>
                </div>
            </div>
        </div>
        <div class="box-content">
            <div class="">
                <div class="row">
                    <div class="col-md-12">
                        <div class="bg-white border d-flex flex-row justify-content-between p-3">
                            <div class="title">
                                {{ $title_page  }}
                            </div>
                            <div class="text-secondary">
                                {{ $rows->total()  }} FAQs Found
                            </div>
                        </div>
                        <div class="box-list">
                            <div id="accordion" class="lits-accordion">
                                @if($rows->total() > 0)
                                    @foreach($rows as $row)
                                        @php  $translation = $row->translateOrOrigin(app()->getLocale()); @endphp
                                        <div class="card">
                                            <div class="card-header collapsed" id="headingOne_{{$row->id}}"
                                                 data-toggle="collapse" data-target="#collapseOne_{{$row->id}}"
                                                 aria-expanded="true" aria-controls="collapseOne_{{$row->id}}">
                                                {{ $translation->title }}
                                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M3.33301 7.5L9.99967 14.1667L16.6663 7.5"
                                                          stroke-width="2.33333" stroke-linecap="round"
                                                          stroke-linejoin="round"/>
                                                </svg>
                                            </div>
                                            <div id="collapseOne_{{$row->id}}" class="collapse"
                                                 aria-labelledby="headingOne_{{$row->id}}" data-parent="#accordion">
                                                <div class="card-body">
                                                    {!! $translation->content !!}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    {{__("Faq not found")}}
                                @endif
                            </div>
                            <div class="bravo-pagination mb-2 mt-5">
                                {{$rows->appends(request()->query())->links()}}
                                @if($rows->total() > 0)
                                    <span
                                        class="count-string">{{ __("Showing :from - :to of :total Faqs",["from"=>$rows->firstItem(),"to"=>$rows->lastItem(),"total"=>$rows->total()]) }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script type="text/javascript" src="{{ asset("libs/ion_rangeslider/js/ion.rangeSlider.min.js") }}"></script>
    <script type="text/javascript"
            src="{{ asset('module/tour/js/tour.js?_ver='.config('app.asset_version')) }}"></script>
@endpush
