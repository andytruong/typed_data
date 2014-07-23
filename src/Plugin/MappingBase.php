<?php

namespace AndyTruong\TypedData\Plugin;

use AndyTruong\TypedData\Manager;
use AndyTruong\TypedData\ManagerAwareInterface;

abstract class MappingBase extends TypeBase implements ManagerAwareInterface
{

    protected $allow_extra_properties = TRUE;

    /** @var Manager */
    protected $manager;

    /**
     * {@inheritdoc}
     * @param \AndyTruong\TypedData\Plugin\Manager $manager
     */
    public function setManager(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function setDefinition($def)
    {
        $this->definition = $def;

        if (isset($def['allow_extra_properties'])) {
            $this->allow_extra_properties = $def['allow_extra_properties'];
        }

        return $this;
    }

    public function getValue()
    {
        if ($this->validate()) {
            $value = array();

            foreach ($this->input as $k => $v) {
                $value[$k] = $this->getItemValue($k, $v);
            }

            return $value;
        }
    }

    private function getItemValue($k, $v)
    {
        $return = $v;

        if (isset($this->definition['mapping'][$k]['type'])) {
            $def = array('type' => $this->definition['mapping'][$k]['type']);
            $data = $this->manager->getDataType($def, $v);
            $return = $data->getValue();
        }

        return $return;
    }

}
