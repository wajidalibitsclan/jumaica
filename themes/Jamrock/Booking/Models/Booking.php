<?php

namespace Themes\Jamrock\Booking\Models;

class Booking extends \Modules\Booking\Models\Booking
{

    public function extras(){
        return $this->hasMany(BookingExtra::class,'booking_id');
    }
}
