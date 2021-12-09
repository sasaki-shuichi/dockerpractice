<?php

namespace App\Services;

class TestService
{
    private $counter;

    public function __construct()
    {
        $this->counter = 0;
    }

    public function test1()
    {
        return $this->counter += 1;
    }

    public function test2()
    {
        return $this->counter += 2;
    }

    public function getCounter()
    {
        return $this->counter;
    }
}
