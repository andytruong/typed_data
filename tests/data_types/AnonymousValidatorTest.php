<?php

namespace AndyTruong\TypedData\TestCases\DataType;

class AnonymousValidatorTest extends TypedDataTestCase
{

    private function getSchema()
    {
        $schema = array('type' => 'any');
        $schema['validate'][] = function($input, &$error = '') {
            if (!is_numeric($input) || 1 !== $input) {
                $error = 'I only accept 1';
                return false;
            }
            return true;
        };
        return $schema;
    }

    public function testAnonymousValidator()
    {
        $data_0 = $this->getManager()->getDataType($this->getSchema(), 0);
        $this->assertFalse($data_0->validate($error));
        $this->assertEquals('I only accept 1', $error);

        $data_1 = $this->getManager()->getDataType($this->getSchema(), 1);
        $this->assertTrue($data_1->validate());
    }

}
