<?php

namespace Themes\Jamrock\Tour\Controllers;

use Themes\Jamrock\Tour\Models\Tour;

class TourController extends \Modules\Tour\Controllers\TourController
{

    public function __construct()
    {
        parent::__construct();
        $this->tourClass  = Tour::class;
    }
}
