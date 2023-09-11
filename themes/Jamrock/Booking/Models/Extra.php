<?php

namespace Themes\Jamrock\Booking\Models;

use App\BaseModel;

class Extra extends BaseModel
{

    protected $table = 'bravo_extra';

    protected $casts = [
        'include'=>'array',
        'exclude'=>'array',
        'dropdown'=>'array',
    ];
}
