<?php

namespace Fruitcake\MagentoDebugbar\API;

use DebugBar\DataCollector\DataCollectorInterface;

interface DebugbarStateInterface
{
    /**
     * Check if the Debugbar should be enabled.
     *
     * @return bool
     */
    public function isDebugbarEnabled();

    /**
     * Check if the Debugbar should run at all.
     *
     * @return bool
     */
    public function shouldDebugbarRun();

    /**
     * Determine if a specific collector should run.
     *
     * @param DataCollectorInterface $collector
     * @return bool
     */
    public function shouldCollectorRun(DataCollectorInterface $collector);
}