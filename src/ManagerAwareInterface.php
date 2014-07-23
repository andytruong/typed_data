<?php

namespace AndyTruong\TypedData;

interface ManagerAwareInterface
{

    /**
     * Inject manager.
     *
     * @param \AndyTruong\TypedData\Manager $manager
     */
    public function setManager(Manager $manager);
}
