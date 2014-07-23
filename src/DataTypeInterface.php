<?php

namespace AndyTruong\TypedData;

interface DataTypeInterface
{

    /**
     * Set definition for typed-data.
     */
    public function setDefinition($definition);

    /**
     * Get definition of typed-data.
     */
    public function getDefinition();

    /**
     * Set input for typed-data.
     */
    public function setInput($value);

    /**
     * Get input for typed-data.
     */
    public function getInput();

    /**
     * return boolean
     */
    public function isEmpty();

    /**
     * Validate typed-data value.
     */
    public function validate(&$error);
}
