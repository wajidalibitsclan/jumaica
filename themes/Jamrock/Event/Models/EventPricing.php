<?php

namespace Themes\Jamrock\Event\Models;

use App\BaseModel;

class EventPricing extends BaseModel
{
    protected $table='bravo_event_pricing';
    protected $fillable  = [
        'tour_id',
        'gg_from',
        'gg_to',
        'prices',
    ];
    protected $casts=[
      'prices'=>'array',
    ];



}
