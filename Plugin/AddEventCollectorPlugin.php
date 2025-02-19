<?php

namespace Fruitcake\MagentoDebugbar\Plugin;

use Fruitcake\MagentoDebugbar\DataCollector\EventCollector;
use Fruitcake\MagentoDebugbar\MagentoDebugbar;

/**
 * Adds the Magento collector
 *
 */
class AddEventCollectorPlugin extends AbstractAddCollectorPlugin
{
    public function __construct(MagentoDebugbar $debugbar, EventCollector $collector)
    {
        parent::__construct($debugbar, $collector);
    }
}
