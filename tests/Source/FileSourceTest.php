<?php

declare(strict_types=1);

namespace Tests\Source;

use Benjivm\MergePdf\Exception;
use Benjivm\MergePdf\PagesInterface;
use Benjivm\MergePdf\Source\FileSource;

class FileSourceTest extends \PHPUnit\Framework\TestCase
{
    public function test_exception_on_invalid_name()
    {
        $this->expectException(Exception::class);
        new FileSource('this-file-does-not-exist');
    }

    public function test_get_name()
    {
        $this->assertSame(
            __FILE__,
            (new FileSource(__FILE__))->getName()
        );
    }

    public function testget_contents()
    {
        $this->assertSame(
            file_get_contents(__FILE__),
            (new FileSource(__FILE__))->getContents()
        );
    }

    public function test_get_pages()
    {
        $pages = $this->createMock(PagesInterface::class);
        $this->assertSame(
            $pages,
            (new FileSource(__FILE__, $pages))->getPages()
        );
    }
}
