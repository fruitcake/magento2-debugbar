<?php

namespace Fruitcake\MagentoDebugbar\Plugin;

use Fruitcake\MagentoDebugbar\DataCollector\MessagesCollector;
use Fruitcake\MagentoDebugbar\MagentoDebugbar;

/**
 * Adds the Events collector
 *
 */
class AddMessagesCollectorPlugin extends AbstractAddCollectorPlugin
{
    public function __construct(MagentoDebugbar $debugbar, MessagesCollector $collector)
    {
        parent::__construct($debugbar, $collector);
    }
}
