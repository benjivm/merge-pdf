<?php

declare(strict_types=1);

namespace Benjivm\MergePdf\Source;

use Benjivm\MergePdf\Pages;
use Benjivm\MergePdf\PagesInterface;

/**
 * Pdf source from raw string
 */
final class RawSource implements SourceInterface
{
    /**
     * @var string
     */
    private $contents;

    /**
     * @var PagesInterface
     */
    private $pages;

    public function __construct(string $contents, ?PagesInterface $pages = null)
    {
        $this->contents = $contents;
        $this->pages = $pages ?: new Pages();
    }

    public function getName(): string
    {
        return 'raw-content';
    }

    public function getContents(): string
    {
        return $this->contents;
    }

    public function getPages(): PagesInterface
    {
        return $this->pages;
    }
}
