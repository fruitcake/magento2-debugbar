<?php


namespace Fruitcake\MagentoDebugbar\Observer;

use Fruitcake\MagentoDebugbar\DataCollector\TemplateCollector;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\View\Element\AbstractBlock;
use Magento\Framework\View\Element\BlockInterface;
use Magento\Framework\View\Layout\Element;

class AfterLayoutGenerateBlocksObserver implements ObserverInterface
{
    private $elements = [];

    private $layout;

    public function __construct(protected TemplateCollector $templateCollector
    )
    {
    }

    /**
     * @inheritDoc
     */
    public function execute(Observer $observer)
    {
        /** @var \Magento\Framework\View\LayoutInterface|\Magento\Framework\View\Layout $layout */
        $this->layout = $observer->getLayout();

        // Hacky way to get the structure but okay
        $reflection = new \ReflectionClass($this->layout);
        $structure = $reflection->getProperty('structure');
        $structure->setAccessible(true);

        /** @var \Magento\Framework\View\Layout\Data\Structure $structure */
        $structure = $structure->getValue($this->layout);

        $this->elements = $structure->exportElements();

        if (isset($this->elements['root'])) {
            $this->addChildren($this->elements['root']);
        }
    }

    public function addChildren($element)
    {
        $children = $element['children'] ?? [];

        foreach ($children as $name => $alias) {
            /** @var BlockInterface|AbstractBlock $block */
            $block = $this->layout->getBlock($alias);
            if ($block) {
                if ($block->getTemplateFile()) {
                    $data = $element;
                    unset($data['children']);
                    $this->templateCollector->addTemplate($name . ' - ' . $block->getTemplate(), $data, $element['type'], $block->getTemplateFile());
                }
            }

            if (isset($this->elements[$name])){
                $this->addChildren($this->elements[$name]);
            }
        }

    }
}
