<?php
$extra = $booking->extras;
if(empty($extra)) return;
?>
@foreach($extra as $item)
    <tr>
        <td class="label" style="font-weight:normal">
            {{$item->extra->title ?? ''}}:
            {{format_money($item->price)}} x {{$item->number}}
        </td>
        <td class="val">
            {{format_money($item->price * $item->number)}}
        </td>
    </tr>
@endforeach
