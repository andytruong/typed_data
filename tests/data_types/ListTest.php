<?php

namespace AndyTruong\TypedData\TestCases\DataType;

use stdClass;

class ListTest extends TypedDataTestCase
{

    private function getSchema()
    {
        $schema = array('type' => '');
        return $schema;
    }

    public function testListType()
    {
        $schema = array('type' => 'list');
        $input = array();
        $input[] = array(NULL, TRUE, 1, 'one', array('one'), new stdClass());
        $input[] = array('One', 'Two', 'Three');
        foreach ($input as $in) {
            $data = $this->getManager()->getDataType($schema, $in);
            $this->assertTrue($data->validate($error));
            $this->assertEquals($in, $data->getValue());
        }
    }

    public function testListStrictType()
    {
        $schema = array('type' => 'list<integer>');

        $data = $this->getManager()->getDataType($schema, array(1, 2));
        $this->assertTrue($data->validate());
        $this->assertEquals(array(1, 2), $data->getValue());

        $data = $this->getManager()->getDataType($schema, array(1, 'Two'));
        $this->assertFalse($data->validate($error));
    }

}
