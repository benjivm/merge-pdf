<?php

namespace Benjivm\MergePdf\Driver;

use Benjivm\MergePdf\Source\SourceInterface;

interface DriverInterface
{
    /**
     * Merge multiple sources
     */
    public function merge(SourceInterface ...$sources): string;
}
