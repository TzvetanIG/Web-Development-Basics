<?php
namespace Models;

use GFramework\Validation;

abstract class BaseModel
{
    /**
     * @var Validation
     */
    public  $validator;

    public function __construct()
    {
        $this->validator = new Validation();
    }
}