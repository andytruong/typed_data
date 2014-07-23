<?php

namespace AndyTruong\TypedData\TestCases\DataType;

class StringTest extends TypedDataTestCase
{

    private function getSchema()
    {
        $schema = array('type' => '');
        return $schema;
    }

    public function testStringType()
    {
        $schema = array('type' => 'string');

        $input = 'I am string';
        $data = $this->getManager()->getDataType($schema, $input);
        $this->assertTrue($data->validate());
        $this->assertEquals($input, $data->getValue());
        $this->assertFalse($data->isEmpty());

        $data = $this->getManager()->getDataType($schema, '');
        $this->assertTrue($data->validate());
        $this->assertEquals('', $data->getValue());
        $this->assertTrue($data->isEmpty());

        $data = $this->getManager()->getDataType($schema, array('I am array'));
        $this->assertFalse($data->validate());
        $this->assertNull($data->getValue());
    }

}
