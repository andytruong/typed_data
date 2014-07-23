<?php

namespace AndyTruong\TypedData\TestCases\DataType;

use AndyTruong\TypedData\Manager;
use PHPUnit_Framework_TestCase;

class TypedDataTestCase extends PHPUnit_Framework_TestCase
{

    /** @var Manager */
    private $typed_data_manager;

    protected function getManager()
    {
        if (null === $this->typed_data_manager) {
            $this->typed_data_manager = new Manager();
        }
        return $this->typed_data_manager;
    }

}
