<?php

declare(strict_types=1);

namespace Tests\Driver;

use Benjivm\MergePdf\Driver\DefaultDriver;
use Benjivm\MergePdf\Driver\DriverInterface;
use Benjivm\MergePdf\Source\SourceInterface;
use PHPUnit\Framework\MockObject\Exception;
use Prophecy\Prophet;

class DefaultDriverTest extends \PHPUnit\Framework\TestCase
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
    public function test_merge(): void
    {
        $wrapped = $this->prophet->prophesize(DriverInterface::class);

        $source1 = $this->createMock(SourceInterface::class);
        $source2 = $this->createMock(SourceInterface::class);

        $wrapped->merge($source1, $source2)->willReturn('foo')->shouldBeCalled();

        $driver = new DefaultDriver($wrapped->reveal());

        $this->assertEquals(
            'foo',
            $driver->merge($source1, $source2)
        );
    }
}
