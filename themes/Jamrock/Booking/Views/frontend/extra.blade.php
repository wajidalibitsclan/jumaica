@extends('layouts.app')
@push('css')
    <style>
        .bravo_footer {
            display: none !important;
        }
    </style>
@endpush
@section('content')
    {{--   <div class="bg" style="background:url({{get_file_url(setting_item("tour_page_search_banner"),'full')}})">
           <div class="container text-center pt-100 pb-100 header-banner" >
               <h1>A Bit Extra</h1>
               <p>Goes A long Way</p>
           </div>
       </div>--}}


    <br>
    <form style="background: #FAFAFA" action="{{route('booking.extra.store',['code'=>$booking->code])}}" method="post">
        @csrf
        <div class=" pb-100 main-container-extra">
            <div class="bg-white d-flex justify-content-between mb-3 px-2">
                <div>
                    <h2 class="extra-title">Extras</h2>
                    <p class="extra-desc">Add a bit extra to make it special</p>
                </div>
                <div><a class="btn btn-sm btn-outline-primary" style="    border: 2px solid #0070C0;"
                        href="/booking/{{$booking->code}}/checkout">Skip Extras</a></div>
            </div>

            <div class="row mb-3">
                @foreach($rows as $row)
                    <div class="col-md-4 mb-3">
                        <div class="extra-item h-full">

                            <div class="mb-3">
                                <div class="e-img text-center" style="width: 100%">
                                    <div class="d-block position-relative p-1" style="width: 100%">
                                        <div class="bg-white e-name mb-3 position-absolute text-15 text-center"
                                             style="border-radius: 6px;padding: 5px 15px">{{$row->title}}</div>
                                        <div class="float-right">
                                            <a href="#" class="video-url"
                                               data-url="{{handleVideoUrl($row->video_url)}}">
                                                <img style="width: 50px;"
                                                     src="{{ asset('themes/jamrock/images/video.png') }}">
                                            </a>
                                        </div>
                                        {!! get_image_tag($row->image_id) !!}
                                    </div>


                                </div>
                                <div class="mb-2">
                                    <div class="collapse" id="extra-{{$row->id}}">
                                        @if(!empty($row->exclude))
                                            @foreach($row->include as $item)
                                                <div class="mb-2 d-flex align-items-center">
                                                    <svg class="mr-2" width="20" height="20" viewBox="0 0 20 20"
                                                         fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M17.8128 3.71094H16.4476C16.2562 3.71094 16.0745 3.79883 15.9573 3.94922L7.90461 14.1504L4.04328 9.25781C3.98487 9.18365 3.91042 9.12368 3.82551 9.08241C3.74061 9.04114 3.64745 9.01965 3.55305 9.01953H2.18782C2.05696 9.01953 1.98469 9.16992 2.06477 9.27148L7.41438 16.0488C7.66438 16.3652 8.14485 16.3652 8.3968 16.0488L17.9359 3.96094C18.0159 3.86133 17.9437 3.71094 17.8128 3.71094Z"
                                                            fill="#00B050"/>
                                                    </svg>
                                                    {{$item['title'] ?? ''}}
                                                </div>
                                            @endforeach
                                        @endif
                                        @if(!empty($row->exclude))
                                            @foreach($row->exclude as $item)
                                                <div class="mb-2 d-flex align-items-center">
                                                    <svg class="mr-2" width="20" height="20" viewBox="0 0 20 20"
                                                         fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M17.8128 3.71094H16.4476C16.2562 3.71094 16.0745 3.79883 15.9573 3.94922L7.90461 14.1504L4.04328 9.25781C3.98487 9.18365 3.91042 9.12368 3.82551 9.08241C3.74061 9.04114 3.64745 9.01965 3.55305 9.01953H2.18782C2.05696 9.01953 1.98469 9.16992 2.06477 9.27148L7.41438 16.0488C7.66438 16.3652 8.14485 16.3652 8.3968 16.0488L17.9359 3.96094C18.0159 3.86133 17.9437 3.71094 17.8128 3.71094Z"
                                                            fill="#DE3E3E"/>
                                                    </svg>
                                                    {{$item['title'] ?? ''}}
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                <div class="pl-3 ml-auto d-flex justify-content-between">

                                    <div class="extra_box mb-2">
                                        <span class="btn rounded" style="    border: 2px solid #00B050;
                                            color: #00B050 !important;
                                            padding: 6px 15px;">
                                            From ${{ round($row->price, 0) }}
                                        </span>
                                    </div>
                                    {{--                                    <div class="extra_box mb-2 blue">--}}
                                    {{--                                        <div>--}}
                                    {{--                                            <a href="#" class="video-url" data-url="{{handleVideoUrl($row->video_url)}}">--}}
                                    {{--                                                <div class="text-15 mb-1">Video</div>--}}
                                    {{--                                               <i class="fa fa-video-camera text-20"></i>--}}

                                    {{--                                            </a>--}}
                                    {{--                                        </div>--}}
                                    {{--                                    </div>--}}

                                    <div class="extra_box mb-2">
                                        <a class="btn rounded" style="border: 2px solid #0070C0;
                                                color: #0070C0 !important;
                                                padding: 6px 15px;" href="#" data-toggle="collapse"
                                           data-target="#extra-{{$row->id}}">
                                            MORE INFO
                                        </a>
                                    </div>
                                    <div class="extra_box mb-2 text-white">
                                        <div>
                                            <a class="btn btn-primary rounded"
                                               style="padding: 6px 20px;border: 2px solid #0070C0"
                                               data-toggle="collapse"
                                               data-target="#extra-price-{{$row->id}}">
                                                ADD ME
                                            </a>
                                        </div>
                                    </div>

                                <!--                                    <div class="d-flex mb-3 d-flex justify-content-between">
                                        <a href="#" class="video-url" data-url="{{handleVideoUrl($row->video_url)}}">
                                            <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="22" cy="22" r="22" fill="#0070C1"/>
                                                <path d="M19.2004 15.0001C19.2004 14.2301 18.5704 13.6001 17.8004 13.6001H10.8004C10.0304 13.6001 9.40039 14.2301 9.40039 15.0001C9.40039 15.7981 10.0864 16.4001 10.8004 16.4001H17.8004C18.5704 16.4001 19.2004 15.7701 19.2004 15.0001ZM27.6004 22.0001L33.2004 16.4001V30.4001L27.6004 24.8001V22.0001ZM26.2004 27.6001V19.2001C26.2004 18.4301 25.5704 17.8001 24.8004 17.8001H13.6004C12.8304 17.8001 12.2004 18.4301 12.2004 19.2001V27.6001C12.2004 28.3701 12.8304 29.0001 13.6004 29.0001H24.8004C25.5704 29.0001 26.2004 28.3701 26.2004 27.6001Z" fill="white"/>
                                            </svg>

                                        </a>
                                        <a href="#" data-toggle="collapse" data-target="#extra-{{$row->id}}">
                                            <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="22" cy="22" r="22" fill="#0070C1"/>
                                                <path d="M24.9889 18.6312L19.6969 19.2945L19.5079 20.173L20.5492 20.362C21.2264 20.5247 21.3612 20.768 21.2142 21.4453L19.5079 29.455C19.0617 31.5252 19.7529 32.5 21.3752 32.5C22.6352 32.5 24.0947 31.919 24.7579 31.1193L24.9609 30.1585C24.5007 30.5645 23.8234 30.7273 23.3772 30.7273C22.7419 30.7273 22.5127 30.281 22.6737 29.4953L24.9889 18.6312ZM25.1482 13.81C25.1482 14.4226 24.9048 15.0102 24.4716 15.4434C24.0384 15.8766 23.4508 16.12 22.8382 16.12C22.2255 16.12 21.6379 15.8766 21.2047 15.4434C20.7715 15.0102 20.5282 14.4226 20.5282 13.81C20.5282 13.1973 20.7715 12.6098 21.2047 12.1766C21.6379 11.7434 22.2255 11.5 22.8382 11.5C23.4508 11.5 24.0384 11.7434 24.4716 12.1766C24.9048 12.6098 25.1482 13.1973 25.1482 13.81Z" fill="white"/>
                                            </svg>
                                        </a>
                                    </div>-->
                                <!--                                    <div class="flx-grow-1 d-flex justify-content-end align-items-end">
                                        <div class="mr-3">
                                            <div>{{__("from")}}</div>
                                            <div class="text-price text-blue-800 text-14 font-500">{{ $row->price }}</div>
                                        </div>
                                        <div>
                                            <a class="btn btn-primary" data-toggle="collapse" data-target="#extra-price-{{$row->id}}">
                                                <svg width="8" height="13" viewBox="0 0 8 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M1.6123 1.50977L6.78086 6.67832L1.6123 11.8469" stroke="white" stroke-width="2.00999" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>-->
                                </div>
                            </div>


                            <div class="collapse" id="extra-price-{{$row->id}}">
                                @if (is_array($row->dropdown) || is_object($row->dropdown))
                                    @foreach ($row->dropdown as $dropdown)
                                        @php
                                            $drop = \Themes\Jamrock\Booking\Models\Dropdown::find($dropdown);
                                            $options = \Themes\Jamrock\Booking\Models\Options::where('dropdown_id', $dropdown)->get();
                                        @endphp
                                        <div class="">
                                            <select name="option[]" style="border-radius: 5px;" class="border option_list w-100 p-1 mt-1 " required>
                                                <option class="text-10" value="">{{$drop->title}}</option>
                                                @foreach($options as $option)
                                                    <option class="text-10"
                                                            value="{{$option->id}}">{{$option->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endforeach
                                @endif

                                <div class="d-flex mb-2 justify-content-between align-items-center">
                                    <div class="btn" style="border: 2px solid #00B050;
                                            color: #00B050 !important;
                                            padding: 0px 29px;">
                                         <span>
                                             Total:
                                            <span class="e-price ml-1" data-base="{{$row->price}}">
                                                0
                                            </span>
                                        </span>
                                    </div>
                                   <div class="d-flex my-2 justify-content-between align-items-center">
                                       <div class="mx-4">
                                           <a href="javascript:;" class="e-minus cursor-pointer">
                                               <i class="fa fa-minus-circle text-secondary text-20"></i>
                                           </a>
                                           <!--                                        <svg class="e-minus cursor-pointer" width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                                       <circle cx="25" cy="25" r="25" fill="#979797"/>
                                                                                       <rect x="34" y="24" width="2" height="18" transform="rotate(90 34 24)" fill="white"/>
                                                                                   </svg>-->

                                       </div>

                                       <div class="d-flex align-items-center justify-content-center">

                                           <input name="extra[{{$row->id}}]"
                                                  class="ml-2 e-number text-center border-radius-3 border"
                                                  style="max-width: 50px;font-size: 15px" readonly value="0"/>
                                       </div>
                                       <div class="ml-4">
                                           <a href="javascript:;" class="e-plus cursor-pointer">
                                               <i class="fa fa-plus-circle text-primary text-20"></i>
                                           </a>
                                           <!--                                        <svg class="e-plus cursor-pointer" width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                                       <circle cx="25" cy="25" r="25" fill="#00B050"/>
                                                                                       <rect x="24" y="16" width="2" height="18" fill="white"/>
                                                                                       <rect x="34" y="24" width="2" height="18" transform="rotate(90 34 24)" fill="white"/>
                                                                                   </svg>-->
                                       </div>
                                   </div>
                                </div>

                                <div class="mt-2 store_extra d-flex align-items-start justify-content-center">
                                    <button type="button"  style="width: 45%;" class="btn btn-default bg-gray py-1"
                                            onclick="$('#extra-price-'+{{$row->id}}).toggleClass('show')">Cancel
                                    </button>
                                    <button type="button" style="width: 45%;" class="btn btn-primary py-1 ml-auto save_extra"
                                            data-extra="{{$row->id}}">Confirm
                                    </button>
                                </div>

                            <!--                                <div class="text-center font-weight-bold">
                                    Price: <span class="e-price" data-base="{{$row->price}}">
                                            0
                                        </span>
                                </div>-->
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{$service->getDetailUrl()}}" class="btn btn-secondary" style="min-width: 105px">Back</a>
                <a href="{{url('booking')}}/{{$booking->code}}/checkout" style="min-width: 105px" type="button"
                   class="btn btn-primary">Continue</a>
            </div>
        </div>
    </form>
    <div class="modal" id="video_modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item bravo_embed_video" src="" allowscriptaccess="always"
                                allow="autoplay"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $('.video-url').click(function (e) {
            e.preventDefault();
            $('#video_modal iframe').attr('src', $(this).data('url'));
            $('#video_modal').modal('show');
        });


        $('.option_list').on('change', function () {
            var items = []
            var parent = $(this).closest('.extra-item');
            $(parent).find('select[name="option[]"]').each(function () {
                var option = parseInt($(this).val());
                if (option) {
                    items.push(option);
                }
            });

            $.ajax({
                url: '{{url('get-combination')}}',
                data: {
                    items: items,
                    _token: "{{csrf_token()}}",
                },
                context: this,
                dataType: 'json',
                type: 'post',
                success: function (res) {
                    var parent = $(this).closest('.extra-item');
                    parent.find('.e-price').attr('data-base', res);
                }
            })
        })


        $('.e-minus').click(function () {
            var parent = $(this).closest('.extra-item');
            var num = parseInt(parent.find('.e-number').val());
            if (num > 0) {
                parent.find('.e-number').val(num - 1)
            }
            calculatePrice(parent);
        })
        $('.e-plus').click(function () {
            var parent = $(this).closest('.extra-item');
            var num = parseInt(parent.find('.e-number').val());
            parent.find('.e-number').val(num + 1)
            calculatePrice(parent);
        })

        function calculatePrice(parent) {
            var num = parseInt(parent.find('.e-number').val());
            var price = parseFloat(parent.find('.e-price').data('base'));

            parent.find('.e-price').html(bravo_format_money(price * num));
        }


        $('.save_extra').on('click', function () {
            var id = $(this).attr('data-extra');
            var extra_id = id;
            var booking_id = '{{$booking->code}}';
            var number = $('input[name="extra[' + id + ']"]').val()

            if (number < 1) {
                alert('Please at least select quantity 1');
                return false;
            }

            var items = []
            var parent = $(this).closest('.extra-item');
            $(parent).find('select[name="option[]"]').each(function () {
                var option = parseInt($(this).val());
                if (option) {
                    items.push(option);
                }
            });
            $.ajax({
                url: '{{url('save_extra')}}',
                data: {
                    extra_id: extra_id,
                    booking_id: booking_id,
                    number: number,
                    items: items,
                    _token: "{{csrf_token()}}",
                },
                context: this,
                dataType: 'json',
                type: 'post',
                success: function (res) {
                    alert('Extra successfully added')
                    $(parent).find('.btn-primary.rounded').html('Added');
                    $('#extra-price-' + id).toggleClass('show');

                    $(parent).find('select[name="option[]"]').each(function () {
                        $(this).val('')
                    });

                    $(parent).find('input').each(function () {
                        $(this).val('0')
                    });
                }
            })
        })


    </script>
@endpush

