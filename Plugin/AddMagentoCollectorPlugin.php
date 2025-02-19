<?php

namespace Fruitcake\MagentoDebugbar\Plugin;

use Fruitcake\MagentoDebugbar\DataCollector\MagentoCollector;
use Fruitcake\MagentoDebugbar\MagentoDebugbar;

/**
 * Adds the Magento collector
 *
 */
class AddMagentoCollectorPlugin extends AbstractAddCollectorPlugin
{
    public function __construct(MagentoDebugbar $debugbar, MagentoCollector $collector)
    {
        parent::__construct($debugbar, $collector);
    }
}
