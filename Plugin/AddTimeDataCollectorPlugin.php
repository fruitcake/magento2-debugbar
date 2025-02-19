<?php

namespace Fruitcake\MagentoDebugbar\Plugin;

use Fruitcake\MagentoDebugbar\MagentoDebugbar;
use DebugBar\DataCollector\TimeDataCollector;

/**
 * Adds the Time collector
 *
 */
class AddTimeDataCollectorPlugin extends AbstractAddCollectorPlugin
{
    public function __construct(MagentoDebugbar $debugbar, TimeDataCollector $collector)
    {
        parent::__construct($debugbar, $collector);
    }
}
