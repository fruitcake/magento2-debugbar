<?php

namespace Fruitcake\MagentoDebugbar\Plugin;

use Fruitcake\MagentoDebugbar\MagentoDebugbar;
use DebugBar\DataCollector\DataCollectorInterface;

/**
 * Plugin to add a collector to the Debugbar
 *
 * Example usage in etc/di.xml:
 *
 * <type name="Magento\Framework\AppInterface">
 *   <plugin name="MyCollectorPlugin" type="MyCollectorPlugin" sortOrder="0" />
 * </type>
 *
 */
abstract class AbstractAddCollectorPlugin
{
    /** @var  MagentoDebugbar */
    protected $debugbar;

    /** @var DataCollectorInterface  */
    protected $collector;

    /**
     * Constructor
     *
     * @param MagentoDebugbar $debugbar
     * @param DataCollectorInterface $collector
     */
    public function __construct(MagentoDebugbar $debugbar, DataCollectorInterface $collector)
    {
        $this->debugbar = $debugbar;
        $this->collector = $collector;
    }

    /**
     * Add the collector
     *
     */
    public function beforeLaunch()
    {
        $this->debugbar->addCollector($this->collector);
    }
}
