<?php

namespace AndyTruong\TypedData\TestCases;

class AnyTest extends TypedDataTestCase
{

    private function getSchema()
    {
        $schema = array('type' => 'any');
        return $schema;
    }

    public function testAnyType()
    {
        $schema = $this->getSchema();

        $input = array();
        $input[] = NULL;
        $input[] = 'String';
        $input[] = array('Array Input');
        foreach ($input as $_input) {
            $data = $this->getManager()->getDataType($schema, $_input);
            $this->assertTrue($data->validate());
            $this->assertEquals($_input, $data->getValue());
        }
    }

}
