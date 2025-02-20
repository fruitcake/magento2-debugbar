<?php

namespace Fruitcake\MagentoDebugbar\Plugin;

use Fruitcake\MagentoDebugbar\DataCollector\QueryCollector;
use Fruitcake\MagentoDebugbar\MagentoDebugbar;

/**
 * Adds the Magento collector
 *
 */
class AddQueryCollectorPlugin extends AbstractAddCollectorPlugin
{
    public function __construct(MagentoDebugbar $debugbar, QueryCollector $collector)
    {
        parent::__construct($debugbar, $collector);
    }
}
