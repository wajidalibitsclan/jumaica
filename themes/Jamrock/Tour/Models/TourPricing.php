<?php

namespace Themes\Jamrock\Tour\Models;

use App\BaseModel;

class TourPricing extends BaseModel
{
    protected $table='bravo_tour_pricing';
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
