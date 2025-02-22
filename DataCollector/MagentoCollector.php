<?php

namespace Fruitcake\MagentoDebugbar\DataCollector;

use DebugBar\DataCollector\DataCollector;
use DebugBar\DataCollector\Renderable;
use Magento\Framework\App\State;
use Magento\Framework\AppInterface;
use Magento\Framework\Locale\ResolverInterface;
use Magento\Framework\App\ProductMetadataInterface;

class MagentoCollector extends DataCollector implements Renderable
{
    /** @var ProductMetadataInterface  */
    protected $productMetadata;

    /** @var ResolverInterface */
    protected $resolver;

    /** @var State  */
    protected $state;

    /**
     * @param ProductMetadataInterface $productMetadata
     * @param ResolverInterface $localeResolver
     */
    public function __construct(
        ProductMetadataInterface $productMetadata,
        ResolverInterface $localeResolver,
        State $state
    ) {
        $this->productMetadata = $productMetadata;
        $this->resolver = $localeResolver;
        $this->state = $state;
    }

    /**
     * {@inheritDoc}
     */
    public function collect()
    {
        return array(
            "version" => $this->productMetadata->getVersion(),
            "locale" => $this->resolver->getLocale(),
            'tooltip' => [
                'PHP Version' => phpversion(),
                'Magento Version' => $this->productMetadata->getVersion(),
                'Mode' => $this->state->getMode(),
                'Area' => $this->state->getAreaCode(),
                'Locale' => $this->resolver->getLocale(),
            ]
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'magento';
    }

    /**
     * {@inheritDoc}
     */
    public function getWidgets()
    {
        return array(
            "version" => array(
                "icon" => "github",
                "tooltip" => "Version",
                "map" => "magento.version",
                "default" => ""
            ),
            "version:tooltip" => [
                "map" => "magento.tooltip",
                "default" => "{}"
            ],
            "locale" => array(
                "icon" => "flag",
                "tooltip" => "Current locale",
                "map" => "magento.locale",
                "default" => "",
            ),
        );
    }
}
