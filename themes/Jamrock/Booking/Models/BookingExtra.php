<?php

namespace Themes\Jamrock\Booking\Models;

use App\BaseModel;

class BookingExtra extends BaseModel
{

    protected $table = 'bravo_booking_extra';

    protected $fillable = [
        'booking_id',
        'extra_id',
        'number',
        'price',
        'options',
    ];

    protected $casts = [
        'options'=>'array'
    ];

    public function extra(){
        return $this->belongsTo(Extra::class,'extra_id');
    }
}
