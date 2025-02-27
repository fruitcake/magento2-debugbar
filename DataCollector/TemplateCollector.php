<?php

namespace Fruitcake\MagentoDebugbar\DataCollector;

use DebugBar\DataCollector\AssetProvider;
use DebugBar\DataCollector\DataCollector;
use DebugBar\DataCollector\Renderable;
use DebugBar\DataCollector\TimeDataCollector;


class TemplateCollector extends DataCollector implements Renderable, AssetProvider
{
    protected $templates = [];


    public function getName()
    {
        return 'templates';
    }

    public function getWidgets()
    {
        return [
            'views' => [
                'icon' => 'leaf',
                'widget' => 'PhpDebugBar.Widgets.TemplatesWidget',
                'map' => 'templates',
                'default' => '[]'
            ],
            'views:badge' => [
                'map' => 'templates.nb_templates',
                'default' => 0
            ]
        ];
    }

    /**
     * @return array
     */
    public function getAssets()
    {
        return [
            'css' => 'widgets/templates/widget.css',
            'js' => 'widgets/templates/widget.js',
        ];
    }


    public function addTemplate(string $name, array $data, ?string $type, ?string $path)
    {
        // Prevent duplicates
        $hash = $type . $path . $name . implode(array_keys($data));

        $template = [
            'name' => $name,
            'param_count' => count($data),
            'params' => $data,
            'start' => microtime(true),
            'type' => $type,
            'hash' => $hash,
        ];

        if ($path && $this->getXdebugLinkTemplate()) {
            $template['xdebug_link'] = $this->getXdebugLink($path);
        }

        $this->templates[] = $template;
    }

    public function collect()
    {
        $templates = $this->templates;

        return [
            'count' => count($this->templates),
            'nb_templates' => count($this->templates),
            'templates' => $templates,
        ];
    }
}
