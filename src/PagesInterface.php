<?php

namespace Benjivm\MergePdf;

interface PagesInterface
{
    /**
     * @return int[]
     */
    public function getPageNumbers(): array;
}
