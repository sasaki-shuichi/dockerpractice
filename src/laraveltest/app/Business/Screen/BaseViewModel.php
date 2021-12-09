<?php

namespace App\Business\Screen;

use App\Business\GenericModel;
use App\Business\Utils;
use Illuminate\Support\MessageBag;

abstract class BaseViewModel extends GenericModel
{
    public array $errors = [];
    public array $infos = [];

    /**
     * isError
     */
    public function isError()
    {
        return !Utils::isEmptyArray($this->errors);
    }

    /**
     * isInfo
     */
    public function isInfo()
    {
        return !Utils::isEmptyArray($this->infos);
    }

    /**
     * addErrorMessage
     */
    public function addErrorMessage(string $msg)
    {
        array_push($this->errors, $msg);
    }

    /**
     * addInfoMessage
     */
    public function addInfoMessage(string $msg)
    {
        array_push($this->infos, $msg);
    }

    /**
     * addException
     */
    public function addException(\Exception $e)
    {
        array_push($this->errors, 'Exception[' . $e->getMessage() . ']');
    }

    /**
     * addMessageBag
     */
    public function addMessageBag(MessageBag $mb)
    {
        $this->errors = array_merge($this->errors, $mb->all());
    }
}
