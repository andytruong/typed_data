<?php

namespace AndyTruong\TypedData\TestCases;

class TestDefaultValue extends DataType\TypedDataTestCase
{

    public function getSchema()
    {
        return [
            'label'   => 'Person',
            'type'    => 'mapping',
            'mapping' => [
                'name' => ['type' => 'string', 'default' => 'James T.'],
                'age'  => ['type' => 'integer', 'default' => 1]
            ]
        ];
    }

    public function testDefaultValue()
    {
        $schema = $this->getSchema();
        $person = $this->getManager()->getDataType($schema);
        $person->getDefinition();
    }

}
