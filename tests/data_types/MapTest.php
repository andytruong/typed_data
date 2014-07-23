<?php

namespace AndyTruong\TypedData\TestCases\DataType;

class MapTest extends TypedDataTestCase
{

    private function getSchema()
    {
        $schema = array('type' => '');
        return $schema;
    }

    public function testMappingType()
    {
        $error = array();

        if (!defined('MENU_NORMAL_ITEM')) {
            define('MENU_NORMAL_ITEM', 6);
        }

        $schema = array(
            'type'    => 'mapping',
            'mapping' => array(
                'title'            => array('type' => 'string'),
                'access arguments' => array('type' => 'list<string>'),
                'page callback'    => array('type' => 'function'),
                'page arguments'   => array('type' => 'list<string>'),
                'type'             => array('type' => 'constant'),
            )
        );

        $input = array(
            'title'            => 'Menu item',
            'access arguments' => array('access content'),
            'page callback'    => 'strip_tags',
            'page arguments'   => array('Drupal'),
            'type'             => 'MENU_NORMAL_ITEM',
        );

        $data = $this->getManager()->getDataType($schema, $input);

        $this->assertEquals($schema, $data->getDefinition(), 'Schema set correctly.');
        $this->assertEquals($input, $data->getInput(), 'Input set correctly.');
        $this->assertTrue($data->validate($error), 'Validation is working');


        $result = $data->getValue();
        $this->assertEquals($input['title'], $result['title']);
        $this->assertEquals($input['access arguments'], $result['access arguments']);
        $this->assertEquals($input['page callback'], $result['page callback']);
        $this->assertEquals($input['page arguments'], $result['page arguments']);
        $this->assertEquals(constant('MENU_NORMAL_ITEM'), $result['type']);
    }

    public function testMappingWrongType()
    {
        $schema = array(
            'type'    => 'mapping',
            'mapping' => array(
                'name' => array('type' => 'string', 'required' => TRUE),
                'girl' => array('type' => 'boolean'),
            ),
        );

        $input = array('name' => array('wrong'), 'girl' => FALSE);

        $data = $this->getManager()->getDataType($schema, $input);
        $this->assertFalse($data->validate($error));
    }

    public function testMappingTypeWithRequiredProperties()
    {
        $schema = array(
            'type'    => 'mapping',
            'mapping' => array(
                'name' => array('type' => 'string', 'required' => TRUE),
                'age'  => array('type' => 'integer', 'required' => TRUE),
            ),
        );

        $data = $this->getManager()->getDataType($schema, array('name' => 'Drupal', 'age' => 13));
        $this->assertTrue($data->validate($error));

        $data = $this->getManager()->getDataType($schema, array('name' => 'Backdrop'));
        $this->assertFalse($data->validate($error));
        $this->assertEquals('Property age is required.', $error);
    }

    public function testMappingTypeWithRequiredOneOf()
    {
        $schema = array(
            'type'           => 'mapping',
            'require_one_of' => array('name', 'id'),
            'mapping'        => array(
                'branch' => array('type' => 'string'),
                'name'   => array('type' => 'string'),
                'id'     => array('type' => 'integer'),
            ),
        );

        $data = $this->getManager()->getDataType($schema, array('name' => 'go_support'));
        $this->assertTrue($data->validate($error));

        $data = $this->getManager()->getDataType($schema, array('id' => 1));
        $this->assertTrue($data->validate($error));

        $data = $this->getManager()->getDataType($schema, array('branch' => 'Acquia'));
        $this->assertFalse($data->validate($error));
        $this->assertTrue(FALSE !== strpos($error, 'Missing one of  required keys: '));
    }

    public function testMappingTypeWithAllowExtraProperties()
    {
        $schema = array(
            'type'                   => 'mapping',
            'mapping'                => array(
                'name'    => array('type' => 'string'),
                'age'     => array('type' => 'integer'),
                'country' => array('type' => 'string')
            ),
            'allow_extra_properties' => FALSE,
        );

        $data = $this->getManager()->getDataType($schema, array('name' => 'Drupal', 'age' => 13, 'city' => 'Paris'));
        $this->assertFalse($data->validate($error));
        $this->assertEquals('Unexpected key found: city.', $error);
    }

}
