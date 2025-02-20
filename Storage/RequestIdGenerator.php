<?php

namespace Fruitcake\MagentoDebugbar\Storage;

use DebugBar\RequestIdGeneratorInterface;

class RequestIdGenerator implements RequestIdGeneratorInterface
{
    /**
     * Generates a unique id for the current request.  If called repeatedly, a new unique id must
     * always be returned on each call to generate() - even across different object instances.
     *
     * To avoid any potential confusion in ID --> value maps, the returned value must be
     * guaranteed to not be all-numeric.
     *
     * @return string
     */
    function generate()
    {
        return 'X' . time(). bin2hex(random_bytes(16));
    }
}
