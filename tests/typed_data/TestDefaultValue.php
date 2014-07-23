<?php

namespace AndyTruong\TypedData\TestCases;

class TestDefaultValue extends DataType\TypedDataTestCase
{

    /**
     * @dataProvider sourceDefaultValue
     */
    public function testDefaultValue($schema)
    {
        $person = $this->getManager()->getDataType($schema);
        $this->assertEquals($schema['default'], $person->getValue());
    }

    public function sourceDefaultValue()
    {
        return [
            [['type' => 'boolean', 'default' => true]],
            [['type' => 'boolean', 'default' => false]],
            [['type' => 'integer', 'default' => 0]],
            [['type' => 'integer', 'default' => 3]],
            [['type' => 'string', 'default' => '']],
            [['type' => 'string', 'default' => 'Hello PHP!']],
        ];
    }

}
