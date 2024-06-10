<?php

declare(strict_types=1);

namespace Tests\Source;

use Benjivm\MergePdf\PagesInterface;
use Benjivm\MergePdf\Source\RawSource;

class RawSourceTest extends \PHPUnit\Framework\TestCase
{
    public function test_get_name()
    {
        $this->assertSame(
            'raw-content',
            (new RawSource(''))->getName()
        );
    }

    public function testget_contents()
    {
        $this->assertSame(
            'foobar',
            (new RawSource('foobar'))->getContents()
        );
    }

    public function test_get_pages()
    {
        $pages = $this->createMock(PagesInterface::class);
        $this->assertSame(
            $pages,
            (new RawSource('', $pages))->getPages()
        );
    }
}
