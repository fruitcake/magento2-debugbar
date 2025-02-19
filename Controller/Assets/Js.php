<?php

namespace Fruitcake\MagentoDebugbar\Controller\Assets;

class Js extends Base
{
    public function execute()
    {
        return $this->createResponse('text/javascript', function(){
            $this->debugbar->getJavascriptRenderer()->dumpJsAssets();
        });
    }
}