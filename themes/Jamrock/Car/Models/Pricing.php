<?php


namespace Themes\Jamrock\Car\Models;


use App\BaseModel;

class Pricing extends BaseModel
{

    protected $table = 'bravo_taxi_pricing';

    protected $fillable=[
        'car_id',
        'from',
        'to',
        'oneway_price',
        'oneway_discount',
        'roundtrip_price',
        'roundtrip_discount',
    ];

    protected $casts = [
        'oneway_price'=>'float',
        'oneway_discount'=>'float',
        'roundtrip_price'=>'float',
        'roundtrip_discount'=>'float',
    ];
}
