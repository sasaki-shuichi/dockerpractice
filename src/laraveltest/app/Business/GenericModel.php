<?php

namespace App\Business;

class GenericModel
{
    public array $var = [];

    /**
     * __get
     */
    public function __get($key)
    {
        return $this->get($key);
    }

    /**
     * __set
     */
    public function __set($key, $value)
    {
        $this->set($key, $value);
    }

    /**
     * get
     */
    public function get(string $key, $default = null)
    {
        if (array_key_exists($key, $this->var)) {
            return $this->var[$key];
        }
        return $default;
    }

    /**
     * set
     */
    public function set(string $key, $value)
    {
        $this->var[$key] = $value;
    }
}
