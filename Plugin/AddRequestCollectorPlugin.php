<?php

namespace Fruitcake\MagentoDebugbar\Plugin;

use Fruitcake\MagentoDebugbar\DataCollector\MagentoCollector;
use Fruitcake\MagentoDebugbar\DataCollector\RequestCollector;
use Fruitcake\MagentoDebugbar\MagentoDebugbar;

/**
 * Adds the Magento collector
 *
 */
class AddRequestCollectorPlugin extends AbstractAddCollectorPlugin
{
    public function __construct(MagentoDebugbar $debugbar, RequestCollector $collector)
    {
        parent::__construct($debugbar, $collector);
    }
}
