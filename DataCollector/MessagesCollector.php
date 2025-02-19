<?php

namespace Fruitcake\MagentoDebugbar\DataCollector;

use DebugBar\DataCollector\MessagesCollector as BaseMessagesCollector;


class MessagesCollector extends BaseMessagesCollector
{
    public function __construct() {
        parent::__construct('messages');
    }
}