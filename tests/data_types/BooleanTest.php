<?php

namespace AndyTruong\TypedData\TestCases\DataType;

class BooleanTest extends TypedDataTestCase
{

    private function getSchema()
    {
        $schema = array('type' => 'boolean');
        return $schema;
    }

    public function testBooleanType()
    {
        $schema = $this->getSchema();

        $data_1 = $this->getManager()->getDataType($schema, true);
        $this->assertTrue($data_1->validate());
        $this->assertTrue($data_1->getValue());
        $this->assertFalse($data_1->isEmpty());

        $data_0 = $this->getManager()->getDataType($schema, false);
        $this->assertTrue($data_0->validate());
        $this->assertFalse($data_0->getValue());
        $this->assertTrue($data_0->isEmpty());

        $data_f = $this->getManager()->getDataType($schema, 'I am string');
        $this->assertFalse($data_f->validate());
        $this->assertNull($data_f->getValue());
    }

}
