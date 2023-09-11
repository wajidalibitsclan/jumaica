<div class="bravo-list-car layout_{{$style_list}}">
    <style>
        .price_box{
            display: none;

        }
        .bravo_wrap .bravo_header{
            border: none !important;
        }
    </style>
    <div class="container">
        @if($title)
        <div class="title">
            {{$title}}
        </div>
        @endif
        @if($desc)
            <div class="sub-title">
                {{$desc}}
            </div>
        @endif
        <div class="list-item">
            @if($style_list === "normal")
                <div class="row">
                    @foreach($rows as $row)
                        <div class="col-lg-4 col-md-6">
                            @include('Car::frontend.layouts.search.loop-grid')
                        </div>
                    @endforeach
                </div>
            @endif
            @if($style_list === "carousel")
                <div class="owl-carousel">
                    @foreach($rows as $row)
                        @include('Car::frontend.layouts.search.loop-grid')
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
