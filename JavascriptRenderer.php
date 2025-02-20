<?php

namespace Fruitcake\MagentoDebugbar;

use DebugBar\JavascriptRenderer as BaseJavascriptRenderer;
use Magento\Framework\UrlInterface;

class JavascriptRenderer extends BaseJavascriptRenderer
{
    /** @var  UrlInterface */
    protected $url;
    protected $ajaxHandlerAutoShow = false;
    protected $ajaxHandlerEnableTab = true;

    public function __construct(MagentoDebugbar $debugBar, UrlInterface $url)
    {
        $this->url = $url;

        parent::__construct($debugBar);
    }

    /**
     * Renders the html to include needed assets
     *
     * @return string
     */
    public function renderHead()
    {
        $cssUrl = $this->url->getUrl('_debugbar/assets/css?v=' . $this->getAssetsHash('css'));
        $jsUrl = $this->url->getUrl('_debugbar/assets/js?v=' . $this->getAssetsHash('js'));

        $html  = "<link rel='stylesheet' type='text/css' property='stylesheet' href='{$cssUrl}'>";
        $html .= "<script type='text/javascript' src='{$jsUrl}'></script>";

        return $html;
    }

    /**
     * Get the hash of the included assets, based on filename and modified time.
     *
     * @param string $type 'js' or 'css'
     * @return string
     */
    protected function getAssetsHash($type)
    {
        $assets = [];
        foreach ($this->getAssets($type) as $file) {
            $assets[$file] = filemtime($file);
        }
        return md5(serialize($assets));
    }
}
