<?php

namespace AndyTruong\TypedData\TestCases;

class ConstantTest extends TypedDataTestCase
{
    private function getSchema()
    {
        $schema = array('type' => 'constant');
        return $schema;
    }

    public function testConstantType()
    {
        $schema = $this->getSchema();

        if (!defined('MENU_DEFAULT_LOCAL_TASK')) {
            define('MENU_DEFAULT_LOCAL_TASK', 140);
        }

        $data = $this->getManager()->getDataType($schema, 'MENU_DEFAULT_LOCAL_TASK');
        $this->assertTrue($data->validate($error));
        $this->assertEquals(constant('MENU_DEFAULT_LOCAL_TASK'), $data->getValue());

        $data = $this->getManager()->getDataType($schema, 'NON_VALID_CONSTANT_THIS_IS');
        $this->assertFalse($data->validate($error));
        $this->assertEquals('Constant is not defined.', $error);
        $this->assertNull($data->getValue());

        $data = $this->getManager()->getDataType($schema, 'in valid ^^');
        $this->assertFalse($data->validate($error));

        $data = $this->getManager()->getDataType($schema, array('also', 'invalidate'));
        $this->assertFalse($data->validate($error));
    }

}
