<?php

namespace AndyTruong\TypedData;

interface DataTypeInterface
{

    /**
     * Set definition for typed-data.
     *
     * @param array $definition
     */
    public function setDefinition($definition);

    /**
     * Get definition of typed-data.
     *
     * @return array
     */
    public function getDefinition();

    /**
     * Set input for typed-data.
     *
     * @param mixed $value
     */
    public function setInput($value);

    /**
     * Get input for typed-data.
     *
     * @return mixed
     */
    public function getInput();

    /**
     * Get value.
     *
     * @return mixed
     */
    public function getValue();

    /**
     * Check if data is empty.
     *
     * @return boolean
     */
    public function isEmpty();

    /**
     * Validate typed-data value.
     */
    public function validate(&$error);
}
