<?php

namespace AndyTruong\TypedData\TestCases\DataType;

class FunctionTest extends TypedDataTestCase
{

    private function getSchema()
    {
        $schema = array('type' => 'function');
        return $schema;
    }

    public function testFunctionType()
    {
        $schema = $this->getSchema();

        $data = $this->getManager()->getDataType($schema, 'date');
        $this->assertTrue($data->validate());
        $this->assertEquals('date', $data->getValue());

        $data = $this->getManager()->getDataType($schema, 'this_is_invalid_function');
        $this->assertFalse($data->validate($error));
        $this->assertEquals('Function does not exist.', $error);

        $data = $this->getManager()->getDataType($schema, array('I am array'));
        $this->assertFalse($data->validate($error));
        $this->assertEquals('Function name must be a string.', $error);
    }

}
