<?php

namespace AndyTruong\TypedData\DataType;

use AndyTruong\TypedData\DataTypeBase;

class Integer extends DataTypeBase
{

    public function isEmpty()
    {
        if (!is_null($this->input)) {
            return $this->input === 0;
        }
    }

    public function validateInput(&$error = NULL)
    {
        if (!is_int($this->input)) {
            $error = 'Input is not an integer value.';
            return FALSE;
        }
        return parent::validateInput($error);
    }

}
