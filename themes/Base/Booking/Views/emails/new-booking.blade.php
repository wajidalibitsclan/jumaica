@extends('Email::layout')
@section('content')

    <div class="b-container">
        <div class="b-panel">
            @switch($to)
                @case ('admin')
                    <h3 class="email-headline"><strong>{{__('Hello Administrator')}}</strong></h3>
                    <p>{{__('New booking has been made')}}</p>
                @break
                @case ('vendor')
                    <h3 class="email-headline"><strong>{{__('Hello :name',['name'=>$booking->vendor->nameOrEmail ?? ''])}}</strong></h3>
                    <p>{{__('Your service has new booking')}}</p>
                @break

                @case ('customer')
                    <h3 class="email-headline"><strong>{{__('Hello :name',['name'=>$booking->first_name ?? ''])}}</strong></h3>
                    <p>{{__('Thank you for booking with us. Here are your booking information:')}}</p>
                @if($booking->total > $booking->paid)
                    <p style="color: red">Payment is still outstanding! Your booking may be cancelled. Please make payment to confirm your booking.</p>
                @endif
                @break
            @endswitch
        </div>
        @include('Booking::emails.parts.panel-customer')

        <div class="b-panel">
        @include($service->email_new_booking_file ?? '')
        </div>
        @include('Booking::emails.parts.panel-passengers')
    </div>
@endsection
