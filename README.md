# magento2-debugbar
Debugbar with developer functionality

# Overview
Goal is to create an extensible debugbar within Magento 2.
The debugbar is displayed on both frontend and
backend, and contains useful information for both developers and
merchants.

The debugbar is based on https://github.com/php-debugbar/php-debugbar


# Possible tabs
- Observer and events
- Plugin and interceptor (see [magento2-plugin-visualization](https://github.com/magento-hackathon/magento2-plugin-visualization))
- Edit link (in backend) on various frontend pages

## Query Backtrace

Add this in app/etc/env.php to the default database connection.

```php

    'profiler' => [
        'class' => 'Fruitcake\\MagentoDebugbar\\Profiler\\QueryProfiler',
        'enabled' => true
    ]

```
