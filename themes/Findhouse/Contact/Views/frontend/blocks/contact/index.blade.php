<!-- Inner Page Breadcrumb -->
@php
    $file_banner = get_file_url(setting_item("contact_banner"));
@endphp
<section class="inner_page_breadcrumb" style="background: url('{{$file_banner}}')">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="breadcrumb_content">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url("/") }}">{{ __('Home')  }}</a></li>
                        @if(isset($breadcrumbs) && count($breadcrumbs) > 0)
                            @foreach($breadcrumbs as $breadcrumb)
                                <li class="breadcrumb-item active" aria-current="page">
                                    @if(!empty($breadcrumb['url']))
                                        <a href="{{url($breadcrumb['url'])}}">{{ $breadcrumb['name'] }}</a>
                                    @else
                                        {{$breadcrumb['name']}}
                                    @endif
                                </li>
                            @endforeach
                        @endif
                    </ol>
                    <h4 class="breadcrumb_title">{{ __('Contact Us') }}</h4>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Our Contact -->
<section class="our-contact pb0 bgc-f7">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-xl-8">
                <div class="form_grid">
                    <h4 class="mb5">{{ setting_item('page_contact_title') }}</h4>
                    <p>{{ setting_item('page_contact_sub_title') }}</p>
                    @include('admin.message')
                    <form class="contact_form bravo-contact-block-form" id="contact_form" name="contact_form" action="{{ route("contact.store") }}" method="post" novalidate="novalidate">
                        {{csrf_field()}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input id="form_name" name="name" class="form-control" type="text" placeholder="{{ __('Name') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input id="form_email" name="email" class="form-control required email"  type="email" placeholder="{{ __('Email') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input id="form_phone" name="phone" class="form-control required phone" required="required" type="phone" placeholder="{{ __('Phone') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input id="form_subject" name="subject" class="form-control required" required="required" type="text" placeholder="{{ __('Subject') }}">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <textarea id="form_message" name="message" class="form-control required" rows="8" required="required" placeholder="{{ __('Your Message') }}"></textarea>
                                </div>
                                
                            </div>
                            <div class="col-sm-12">
                                @if(setting_item("enable_contact_recaptcha"))
                                    <div class="form-group">
                                        {{recaptcha_field($captcha_action ?? 'contact')}}
                                    </div>
                                @endif
                            </div>
                            <div class="col-12">
                                <div class="form-group mb0">
                                    <button type="submit" class="btn btn-lg btn-thm">{{ __('Send Message') }}</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-mess"></div>
                    </form>
                </div>
            </div>
            <div class="col-lg-5 col-xl-4">
                <div class="contact_localtion">
                    @if($list_info_contacts = setting_item_with_lang("list_info_contact"))
                        <?php $list_info_contacts = json_decode($list_info_contacts); ?>
                        @foreach($list_info_contacts as $info)
                            <div class="content_list">
                                <h5>{{ $info->title }}</h5>
                                {!! $info->content !!}
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid p0 mt50">
        <div class="row">
            <div class="col-lg-12">
                <div class="h600" id="map-canvas"></div>
            </div>
        </div>
    </div>
</section>

<!-- Start Partners -->
<section class="start-partners bgc-thm pt50 pb50">
    <div class="container">
        <div class="row">
            <?php 
                $contact_partners_title = setting_item_with_lang('contact_partners_title',request()->query('lang')) ?? '';
                $contact_partners_sub_title = setting_item_with_lang('contact_partners_sub_title',request()->query('lang')) ?? '';
                $contact_partners_button_text = setting_item_with_lang('contact_partners_button_text',request()->query('lang')) ?? '';
                $contact_partners_button_link = setting_item_with_lang('contact_partners_button_link',request()->query('lang')) ?? '';
            ?>
            <div class="col-lg-8">
                <div class="start_partner tac-smd">
                    <h2>{{ $contact_partners_title }}</h2>
                    <p>{{ $contact_partners_sub_title }}</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="parner_reg_btn text-right tac-smd">
                    <a class="btn btn-thm2" href="{{ $contact_partners_button_link }}">{{ $contact_partners_button_text }}</a>
                </div>
            </div>
        </div>
    </div>
</section>


@section('footer')
    <script>
        jQuery(function ($) {
            @if(setting_item('map_contact_lat') && setting_item('map_contact_long'))
            new BravoMapEngine('map-canvas', {
                disableScripts: true,
                fitBounds: true,
                center: [{{ setting_item('map_contact_lat') }}, {{ setting_item('map_contact_long') }}],
                zoom:{{setting_item('map_contact_zoom') ?? "8"}},
                ready: function (engineMap) {
                    engineMap.addMarker([{{setting_item('map_contact_lat')}}, {{setting_item('map_contact_long')}}], {
                        icon_options: {}
                    });
                }
            });
            @endif
        })
    </script>
@endsection