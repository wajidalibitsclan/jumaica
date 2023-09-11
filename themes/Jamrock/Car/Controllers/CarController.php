<?php

namespace Themes\Jamrock\Car\Controllers;

use Themes\Jamrock\Car\Models\Car;

class CarController extends \Modules\Car\Controllers\CarController
{
    public function __construct()
    {
        parent::__construct();
        $this->carClass = Car::class;
    }

}
