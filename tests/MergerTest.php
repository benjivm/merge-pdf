<?php

declare(strict_types=1);

namespace Tests;

use Benjivm\MergePdf\Driver\DriverInterface;
use Benjivm\MergePdf\Merger;
use Benjivm\MergePdf\PagesInterface;
use Benjivm\MergePdf\Source\FileSource;
use Benjivm\MergePdf\Source\RawSource;
use PHPUnit\Framework\MockObject\Exception;
use Prophecy\Prophet;

class MergerTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Prophet
     */
    private $prophet;

    protected function setUp(): void
    {
        $this->prophet = new Prophet();
    }

    /**
     * @throws Exception
     */
    public function test_add_raw()
    {
        $pages = $this->createMock(PagesInterface::class);

        $driver = $this->prophet->prophesize(DriverInterface::class);
        $driver->merge(new RawSource('foo', $pages))->willReturn('')->shouldBeCalled();

        $merger = new Merger($driver->reveal());
        $merger->addRaw('foo', $pages);
        $merger->merge();

        $this->expectNotToPerformAssertions();
    }

    /**
     * @throws Exception|\Benjivm\MergePdf\Exception
     */
    public function test_add_file()
    {
        $pages = $this->createMock(PagesInterface::class);

        $driver = $this->prophet->prophesize(DriverInterface::class);
        $driver->merge(new FileSource(__FILE__, $pages))->willReturn('')->shouldBeCalled();

        $merger = new Merger($driver->reveal());
        $merger->addFile(__FILE__, $pages);
        $merger->merge();

        $this->expectNotToPerformAssertions();
    }

    /**
     * @throws Exception|\Benjivm\MergePdf\Exception
     */
    public function test_add_iterator()
    {
        $pages = $this->createMock(PagesInterface::class);

        $driver = $this->prophet->prophesize(DriverInterface::class);
        $driver->merge(new FileSource(__FILE__, $pages))->willReturn('')->shouldBeCalled();

        $merger = new Merger($driver->reveal());
        $merger->addIterator([__FILE__], $pages);
        $merger->merge();

        $this->expectNotToPerformAssertions();
    }

    /**
     * @throws Exception
     */
    public function test_reset()
    {
        $pages = $this->createMock(PagesInterface::class);

        $driver = $this->prophet->prophesize(DriverInterface::class);
        $driver->merge()->willReturn('')->shouldBeCalled();

        $merger = new Merger($driver->reveal());
        $merger->addRaw('foo', $pages);
        $merger->reset();
        $merger->merge();

        $this->expectNotToPerformAssertions();
    }
}
