<?php

namespace Fruitcake\MagentoDebugbar\Controller\Assets;

class Css extends Base
{
    public function execute()
    {
        return $this->createResponse('text/css', function(){
            $this->debugbar->getJavascriptRenderer()->dumpCssAssets();
        });
    }
}