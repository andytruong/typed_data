<?php

namespace AndyTruong\TypedData\TestCases\DataType;

class IntegerTest extends TypedDataTestCase
{

    private function getSchema()
    {
        $schema = array('type' => '');
        return $schema;
    }

    public function testIntegerType()
    {
        $schema = array('type' => 'integer');

        $data = $this->getManager()->getDataType($schema, 1);
        $this->assertTrue($data->validate());
        $this->assertEquals(1, $data->getValue());
        $this->assertFalse($data->isEmpty());

        $data = $this->getManager()->getDataType($schema, -1);
        $this->assertTrue($data->validate());
        $this->assertEquals(-1, $data->getValue());
        $this->assertFalse($data->isEmpty());

        $data = $this->getManager()->getDataType($schema, 0);
        $this->assertTrue($data->validate());
        $this->assertEquals(0, $data->getValue());
        $this->assertTrue($data->isEmpty());

        $data = $this->getManager()->getDataType($schema, 'I am string');
        $this->assertFalse($data->validate());
        $this->assertNull($data->getValue());
    }

}
