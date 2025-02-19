<?php

namespace Fruitcake\MagentoDebugbar\Provider;

use DebugBar\DataCollector\DataCollectorInterface;
use Fruitcake\MagentoDebugbar\API\DebugbarStateInterface;
use Magento\Framework\App\Area;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Request\Http as HttpRequest;

class StateProvider implements DebugbarStateInterface
{
    /** @var  ScopeConfigInterface */
    protected $scopeConfig;

    /** @var  HttpRequest */
    protected $request;

    /** @var \Magento\Framework\App\State  */
    protected $state;

    public function __construct(ScopeConfigInterface $scopeConfig, HttpRequest $request,  \Magento\Framework\App\State $state)
    {
        $this->scopeConfig = $scopeConfig;
        $this->request = $request;
        $this->state = $state;
    }

    /**
     * Check if the Debugbar should be enabled.
     *
     * @return bool
     */
    public function isDebugbarEnabled()
    {
        $enabled = $this->getConfigValue('dev/debugbar/enabled');
        if (!$enabled) {
            return false;
        }

        if ($this->isAdminRequest()) {
            return $this->getConfigValue('dev/debugbar/enabled_admin');
        }

        return true;
    }

    /**
     * Check if the Debugbar should run at all.
     *
     * @return bool
     */
    public function shouldDebugbarRun()
    {
        return $this->isDebugbarEnabled() && ! $this->isInternalDebugbarRequest();
    }

    /**
     * Determine if a specific collector should run.
     *
     * @param DataCollectorInterface $collector
     * @return bool
     */
    public function shouldCollectorRun(DataCollectorInterface $collector)
    {
        if ( ! $this->shouldDebugbarRun()) {
            return false;
        }

        $configPath = 'dev/debugbar/' . $collector->getName() .'_collector';

        return (bool) $this->scopeConfig->getValue($configPath);
    }

    /**
     * Check if the Debugbar should be visible on the frontend.
     *
     * @return bool
     */
    public function isDebugbarVisible()
    {
        return true;
    }

    /**
     * Check if the current request is an ajax request.
     *
     * @return bool
     */
    public function isAjaxRequest()
    {
        return $this->request->isAjax();
    }

    /**
     * Check if the current request is an internal Debugbar request.
     *
     * @return bool
     */
    protected function isAdminRequest()
    {
        try {
            return $this->state->getAreaCode() === Area::AREA_ADMINHTML;
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            return false;
        }
    }

    /**
     * Check if the current request is an internal Debugbar request.
     *
     * @return bool
     */
    protected function isInternalDebugbarRequest()
    {
        return $this->request->getModuleName() === 'debugbar';
    }

    /**
     * Get a Config value.
     *
     * @param $path
     * @return mixed
     */
    protected function getConfigValue($path)
    {
        return $this->scopeConfig->getValue($path);
    }
}
