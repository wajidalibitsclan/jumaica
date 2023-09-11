<?php

namespace Themes\Jamrock\Booking\Models;

use App\BaseModel;

class Combination extends BaseModel
{

    protected $table = 'bravo_extras_combinations';


    protected $casts = [
        'option'=>'array'
    ];

    public function dropdown(){
        return $this->belongsTo(Dropdown::class, 'dropdown_id', 'id');
    }

    public function option(){
        return $this->belongsTo(Options::class, 'option_id', 'id');
    }

}
