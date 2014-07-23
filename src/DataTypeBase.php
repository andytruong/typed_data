<?php

namespace AndyTruong\TypedData;

use AndyTruong\TypedData\DataTypeInterface;

abstract class DataTypeBase implements DataTypeInterface
{

    /** @var array */
    protected $definition;

    /** @var mixed */
    protected $input;

    public function __construct($definition = null, $input = null)
    {
        !is_null($definition) && $this->setDefinition($definition);
        !is_null($input) && $this->setInput($input);
    }

    public function setDefinition($def)
    {
        $this->definition = $def;

        if (isset($this->definition['default']) && null === $this->input) {
            $this->input = $this->definition['default'];
        }

        return $this;
    }

    public function getDefinition()
    {
        return $this->definition;
    }

    public function setInput($input)
    {
        $this->input = $input;
        return $this;
    }

    public function getInput()
    {
        return $this->input;
    }

    public function isEmpty()
    {
        return false;
    }

    /**
     * Alias of self::validate()
     * @return boolean
     */
    public function isValid(&$error = null)
    {
        return $this->validate($error);
    }

    public function getValue()
    {
        if ($this->validate()) {
            return $this->input;
        }
    }

    public function validate(&$error = null)
    {
        return $this->validateDefinition($error) && $this->validateInput($error);
    }

    protected function validateDefinition(&$error)
    {
        if (!is_array($this->definition)) {
            $error = 'Data definition must be an array.';
            return false;
        }
        return true;
    }

    protected function validateInput(&$error)
    {
        if (!empty($this->definition['validate'])) {
            return $this->validateUserCallacks($error);
        }
        return true;
    }

    protected function validateUserCallacks(&$error)
    {
        foreach ($this->definition['validate'] as $callback) {
            if (is_callable($callback) && !$callback($this->input, $error)) {
                return false;
            }
        }

        return true;
    }

}
