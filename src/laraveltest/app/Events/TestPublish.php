<?php

namespace App\Events;

use Illuminate\Support\Facades\Log;

class TestPublish
{
    private $msg;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($str)
    {
        $this->msg = $str;
        //
    }

    /**
     *
     */
    public function execEvent()
    {
        Log::debug('TestPublish execEvent() ' . $this->msg);
    }

    /**
     *
     */
    public function execQueEvent()
    {
        Log::debug('TestPublish execQueEvent() ' . $this->msg);
    }
}
