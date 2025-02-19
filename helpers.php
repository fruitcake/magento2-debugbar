<?php

if ( ! function_exists('debugbar')) {

    /**
     * @return \Fruitcake\MagentoDebugbar\MagentoDebugbar
     */
    function debugbar()
    {
        /** @var \Fruitcake\MagentoDebugbar\MagentoDebugbar $debugbar */
        $debugbar = \Magento\Framework\App\ObjectManager::getInstance()
            ->get(\Fruitcake\MagentoDebugbar\MagentoDebugbar::class);

        return $debugbar;
    }
}

if ( ! function_exists('debug')) {

    /**
     * @param mixed ...$args
     * @return void
     */
    function debug(...$args)
    {
        /** @var \Fruitcake\MagentoDebugbar\MagentoDebugbar $debugbar */
        $debugbar = \Magento\Framework\App\ObjectManager::getInstance()
            ->get(\Fruitcake\MagentoDebugbar\MagentoDebugbar::class);

        foreach ($args as $value) {
            $debugbar->addMessage($value);
        }
    }
}
