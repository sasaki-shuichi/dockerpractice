<?php

namespace App\Events;

use App\Events\TestPublish;

class TestSubscriber
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  TestPublish  $event
     * @return void
     */
    public function handle(TestPublish $event)
    {
        $event->execEvent();
    }
}
