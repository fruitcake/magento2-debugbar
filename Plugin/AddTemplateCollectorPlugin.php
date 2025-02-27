<?php

namespace Fruitcake\MagentoDebugbar\Plugin;

use Fruitcake\MagentoDebugbar\DataCollector\TemplateCollector;
use Fruitcake\MagentoDebugbar\MagentoDebugbar;

/**
 * Adds the Time collector
 *
 */
class AddTemplateCollectorPlugin extends AbstractAddCollectorPlugin
{
    public function __construct(MagentoDebugbar $debugbar, TemplateCollector $collector)
    {
        parent::__construct($debugbar, $collector);
    }
}
