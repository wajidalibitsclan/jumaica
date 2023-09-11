<?php
$extra = $booking->extras;
if(empty($extra)) return;
?>
@foreach($extra as $item)
    <li>
        <div class="label">
            {{$item->extra->title ?? ''}}:
            {{format_money($item->price)}} x {{$item->number}}
            <a href="javascript:;" data-id="{{$item->id }}" class="delete_extra"><i class="text-danger fa fa-times-circle"></i></a>
        </div>
        <div class="val">
            {{format_money($item->price * $item->number)}}
        </div>
    </li>
@endforeach

@push('js')
    <script>
        $(document).ready(function(){
            $('.delete_extra').on('click', function(){
                var id = $(this).attr('data-id');
                var url = '{{url('booking')}}';
                url = url+'/'+id+'/extra/remove';
                $.ajax({
                    url: url,
                    type: 'get',
                    success: function (res) {
                        window.location.reload()
                    }
                })


            })

        })

    </script>

@endpush
