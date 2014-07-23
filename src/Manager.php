<?php

namespace AndyTruong\TypedData;

use AndyTruong\Event\EventAware;
use AndyTruong\TypedData\DataTypeInterface;
use Exception;
use InvalidArgumentException;

/**
 * Manager for typed-data feature.
 *
 * @event at.typed_data.plugin.load
 */
class Manager extends EventAware
{

    protected $em_name = 'at.typed_data';

    /** @var array */
    protected static $plugins = array(
        'type.any'      => 'AndyTruong\TypedData\DataType\Any',
        'type.boolean'  => 'AndyTruong\TypedData\DataType\Boolean',
        'type.constant' => 'AndyTruong\TypedData\DataType\Constant',
        'type.function' => 'AndyTruong\TypedData\DataType\Fn',
        'type.integer'  => 'AndyTruong\TypedData\DataType\Integer',
        'type.list'     => 'AndyTruong\TypedData\DataType\ItemList',
        'type.callback' => 'AndyTruong\TypedData\DataType\Callback',
        'type.mapping'  => 'AndyTruong\TypedData\DataType\Mapping',
        'type.string'   => 'AndyTruong\TypedData\DataType\String',
    );

    public function registerDataType($id, $class_name)
    {
        if (isset(self::$plugins[$id])) {
            throw new Exception('Datatype is already registered: ' . strip_tags($id));
        }

        $self::$plugins[$id] = $class_name;

        return true;
    }

    protected function loadDataType($id)
    {
        if (!isset(self::$plugins[$id])) {
            $this->trigger('at.typed_data.plugin.load', $this, array('id' => $id));
        }

        if (isset(self::$plugins[$id]) && class_exists(self::$plugins[$id])) {
            $obj = new self::$plugins[$id];

            if (!$obj instanceof DataTypeInterface) {
                $msg = sprintf('Class for data type %s does not implement %s', $id, 'AndyTruong\TypedData\Plugin\DataTypeInterface');
                throw new Exception($msg);
            }

            if ($obj instanceof ManagerAwareInterface) {
                $obj->setManager($this);
            }

            return $obj;
        }

        throw new InvalidArgumentException('Unknow typed-data plugin: ' . $id);
    }

    /**
     * Get plugin object from typed-data definition.
     *
     * @param array $definition
     * @return DataTypeInterface
     */
    protected function findDataTypeFromDefinition(array &$definition)
    {
        if (0 === strpos($definition['type'], 'type.')) {
            $id = $definition['type'];
        }
        else {
            $id = 'type.' . $definition['type'];
        }

        // Special type: list<element_type>
        if (strpos($id, 'type.list<') === 0) {
            $id = 'type.list';
        }

        return $this->loadDataType($id);
    }

    /**
     * Wrapper method to get typed-data plugin.
     *
     * @param array $definition
     * @param mixed $input
     * @return DataTypeInterface
     * @throws \Exception
     */
    public function getDataType(array $definition, $input = null)
    {
        if (!is_array($definition)) {
            throw new Exception('Definition must be an array.');
        }

        if (!isset($definition['type'])) {
            throw new Exception('Missing type key');
        }

        $plugin = $this->findDataTypeFromDefinition($definition);
        $plugin->setDefinition($definition);
        if (null !== $input) {
            $plugin->setInput($input);
        }
        return $plugin;
    }

}
