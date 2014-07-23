<?php

namespace AndyTruong\TypedData;

use AndyTruong\Event\EventAware;
use AndyTruong\TypedData\Plugin\DataTypeInterface;
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
        'type.any'      => 'AndyTruong\TypedData\Plugin\Any',
        'type.boolean'  => 'AndyTruong\TypedData\Plugin\Boolean',
        'type.constant' => 'AndyTruong\TypedData\Plugin\Constant',
        'type.function' => 'AndyTruong\TypedData\Plugin\Fn',
        'type.integer'  => 'AndyTruong\TypedData\Plugin\Integer',
        'type.list'     => 'AndyTruong\TypedData\Plugin\ItemList',
        'type.callback' => 'AndyTruong\TypedData\Plugin\Callback',
        'type.mapping'  => 'AndyTruong\TypedData\Plugin\Mapping',
        'type.string'   => 'AndyTruong\TypedData\Plugin\String',
    );

    public function registerDataType($id, $class_name)
    {
        if (isset(self::$plugins[$id])) {
            throw new Exception('Typed-data plugin is already registered: ' . strip_tags($id));
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
                $msg = sprintf('Class for typed data %s does not implement %s', $id, 'AndyTruong\TypedData\Plugin\DataTypeInterface');
                throw new Exception($msg);
            }

            if ($obj instanceof ManagerAwareInterface) {
                $obj->setManager($this);
            }

            return $obj;
        }

        throw new Exception('Unknow typed-data plugin: ' . strip_tags($id));
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
        $plugin->setInput($input);
        return $plugin;
    }

}
