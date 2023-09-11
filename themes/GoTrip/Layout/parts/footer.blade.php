@php
    $headerStyle = $row->header_style ?? '';
@endphp
<div class="footer -type-1 {{$headerStyle != 'transparent' ? 'text-white bg-dark-2' : ''}}">
    <div class="container">
        <div class="{{ $headerStyle  == 'transparent' ? 'footer_one' : '' }} pt-60 pb-60">
            <div class="row y-gap-40 justify-between xl:justify-start">
                @if($list_widget_footers = setting_item_with_lang("list_widget_footer"))
                    <?php $list_widget_footers = json_decode($list_widget_footers); ?>
                    @foreach($list_widget_footers as $key=>$item)
                            <div class="col-xl-2 col-lg-4 col-sm-6">
                                <h5 class="text-16 fw-500 mb-30">{{ $item->title }}</h5>
                                {!! $item->content  !!}
                            </div>
                    @endforeach
                @endif
            </div>
        </div>

        <section class="footer_middle_area py-20 {{ $headerStyle  == 'transparent' ? 'border-top-light' : 'border-top-white-15' }}">
            <div class="row justify-between items-center y-gap-10">
                <div class="col-auto">
                    {!! setting_item_with_lang("footer_text_left") ?? ''  !!}
                </div>
                <div class="col-auto">
                    <div class="row y-gap-10 items-center">
                        <div class="col-auto">
                            <div class="d-flex items-center">
                                @include('Core::frontend.currency-switcher')
                                @include('Language::frontend.switcher-dropdown')
                            </div>
                        </div>
                        <div class="col-auto">
                            {!! setting_item_with_lang("footer_text_right") ?? ''  !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

@if(Auth::id())
    @include('Media::browser')
@endif

{!! App\Helpers\MapEngine::scripts() !!}

<!-- Custom script for all pages -->
<script src="{{ asset('libs/lodash.min.js') }}"></script>
<script src="{{ asset('libs/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('libs/vue/vue'.(!env('APP_DEBUG') ? '.min':'').'.js') }}"></script>
<script type="text/javascript" src="{{asset('themes/gotrip/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{ asset('libs/bootbox/bootbox.min.js') }}"></script>
<script type="text/javascript" src="{{asset('themes/gotrip/js/vendors.js')}}"></script>
<script type="text/javascript" src="{{asset('themes/gotrip/js/main.js')}}"></script>
@if(Auth::id())
    <script src="{{ asset('module/media/js/browser.js?_ver='.config('app.version')) }}"></script>
@endif
@if(setting_item('cookie_agreement_enable')==1 and request()->cookie('booking_cookie_agreement_enable') !=1 and !is_api()  and !isset($_COOKIE['booking_cookie_agreement_enable']))
    <div class="booking_cookie_agreement p-3 d-flex fixed-bottom">
        <div class="content-cookie">{!! clean(setting_item_with_lang('cookie_agreement_content')) !!}</div>
        <button class="btn save-cookie">{!! clean(setting_item_with_lang('cookie_agreement_button_text')) !!}</button>
    </div>
    <script>
        var save_cookie_url = '{{route('core.cookie.check')}}';
    </script>
    <script src="{{ asset('js/cookie.js?_ver='.config('app.version')) }}"></script>
@endif

{{-- home.js --}}
<script src="{{ asset('js/functions.js?_ver='.config('app.version')) }}"></script>
<script src="{{ asset('js/home.js?_ver='.config('app.version')) }}"></script>
<script src="{{ asset('themes/gotrip/js/custom.js?_ver='.config('app.version')) }}"></script>

@php \App\Helpers\ReCaptchaEngine::scripts() @endphp
@stack('js')
