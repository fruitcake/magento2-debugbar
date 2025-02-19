<?php
namespace Fruitcake\MagentoDebugbar\Plugin;

use Fruitcake\MagentoDebugbar\MagentoDebugbar;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\View\LayoutInterface;

/**
 * Plugin to add Debugbar to the Response add the
 * end of the body
 */
class ResponsePlugin
{
    /** @var MagentoDebugbar  */
    protected $debugbar;

    /**
     * Constructor
     *
     * @param MagentoDebugbar $debugbar
     */
    public function __construct(MagentoDebugbar $debugbar)
    {
        $this->debugbar = $debugbar;
    }

    /**
     * Add our debugbar to the response
     *
     * @param ResponseInterface $response
     */
    public function beforeSendResponse(ResponseInterface $response)
    {
        $this->debugbar->modifyResponse($response);
    }

}
