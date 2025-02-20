<?php

namespace Fruitcake\MagentoDebugbar\DataCollector;

use DebugBar\DataCollector\DataCollector;
use DebugBar\DataCollector\DataCollectorInterface;
use DebugBar\DataCollector\Renderable;
use Magento\Framework\App\Request\Http;

class RequestCollector extends DataCollector implements DataCollectorInterface, Renderable
{
    /** @var Http $request */
    protected $request;

    /**
     * Create a new SymfonyRequestCollector
     *
     * @param Http $request
     */
    public function __construct(Http $request)
    {
        $this->request = $request;
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'request';
    }

    /**
     * {@inheritDoc}
     */
    public function getWidgets()
    {
        $widgets = [
            "request" => [
                "icon" => "tags",
                "widget" => "PhpDebugBar.Widgets.HtmlVariableListWidget",
                "map" => "request.data",
                "default" => "{}"
            ]
        ];

        $widgets['currentrequest'] = [
            "icon" => "share",
            "map" => "request.data.fullAction",
            "link" => "request",
            "default" => ""
        ];
        $widgets['currentrequest:tooltip'] = [
            "map" => "request.tooltip",
            "default" => "{}"
        ];

        return $widgets;
    }

    /**
     * {@inheritdoc}
     */
    public function collect()
    {
        $request = $this->request;

        $data = [
            'path' => $request->getPathInfo(),
            'baseUrl' => $request->getDistroBaseUrl(),
            'module' => $request->getModuleName(),
            'controller' => $request->getControllerModule(),
            'action' => $request->getActionName(),
            'fullAction' => $request->getFullActionName(),
            'route' => $request->getRouteName(),
        ];


        $tooltip = [
            'path' => $data['path'],
            'module' => $data['module'],
            'fullAction' => $data['fullAction'],
        ];

        return [
            'data' => $data,
            'tooltip' => array_filter($tooltip)
        ];
    }

}
