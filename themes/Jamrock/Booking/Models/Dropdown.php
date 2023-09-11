<?php

namespace Themes\Jamrock\Booking\Models;

use App\BaseModel;

class Dropdown extends BaseModel
{

    protected $table = 'bravo_extras_dropdown';


    public function options(){
        return $this->hasMany(Options::class, 'dropdown_id', 'id');
    }

}
