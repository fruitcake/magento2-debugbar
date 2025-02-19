<?php
namespace Fruitcake\MagentoDebugbar\Plugin;

use Fruitcake\MagentoDebugbar\DataCollector\EventCollector;
use Fruitcake\MagentoDebugbar\MagentoDebugbar;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Event\ConfigInterface;

/**
 * Plugin to add Debugbar to the Response add the
 * end of the body
 */
class EventManagerPlugin
{
    /** @var MagentoDebugbar  */
    protected $debugbar;

    /** @var EventCollector  */
    protected $eventCollector;

    /** @var ObserverCollector  */
    protected $observerCollector;

    /** @var ConfigInterface */
    protected $config;

    public function __construct(
        MagentoDebugbar $debugbar,
        EventCollector $eventCollector,
        ConfigInterface $config
    ) {
        $this->debugbar = $debugbar;
        $this->eventCollector = $eventCollector;
        $this->config = $config;
    }

    public function aroundDispatch(
        ManagerInterface $subject,
        \Closure $proceed,
        $eventName,
        array $data = []
    ) {
        $start = microtime(true);
        $res = $proceed($eventName, $data);
        $end = microtime(true);

        if ($this->debugbar->shouldCollectorRun($this->eventCollector)) {
            if ($observers = $this->config->getObservers($eventName)) {
                $data['__observers'] = $observers;
            }

            $this->eventCollector->addEvent($eventName, $start, $end, $data);
        }

        return $res;
    }

}
