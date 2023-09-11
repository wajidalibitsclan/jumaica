<?php

namespace Themes\Jamrock\Event\Controllers;

use Themes\Jamrock\Event\Models\Event;

class EventController extends \Modules\Event\Controllers\EventController
{
    public function __construct()
    {
        parent::__construct();
        $this->eventClass = Event::class;
    }

}
