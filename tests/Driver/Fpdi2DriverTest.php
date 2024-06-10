<?php

declare(strict_types=1);

namespace Tests\Driver;

use Benjivm\MergePdf\Driver\Fpdi2Driver;
use Benjivm\MergePdf\Exception;
use Benjivm\MergePdf\Pages;
use Benjivm\MergePdf\Source\SourceInterface;
use InvalidArgumentException;
use Prophecy\Argument;
use Prophecy\Prophet;
use setasign\Fpdi\Tcpdf\Fpdi;

class Fpdi2DriverTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Prophet
     */
    private $prophet;

    protected function setUp(): void
    {
        $this->prophet = new Prophet();
    }

    public function test_exception_on_invalid_fpdi(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Fpdi2Driver('string-this-is-not-fpdi');
    }

    public function test_exception_on_failure(): void
    {
        // Tcpdf generates warnings due to argument ordering with php 8
        // suppressing errors is a dirty hack until tcpdf is patched
        $fpdi = @$this->prophet->prophesize(Fpdi::class);

        $fpdi->setSourceFile(Argument::any())->willThrow(new \Exception('message'));

        $source = $this->prophet->prophesize(SourceInterface::class);
        $source->getName()->willReturn('file');
        $source->getContents()->willReturn('');

        $this->expectException(Exception::class);
        $this->expectExceptionMessage("'message' in 'file'");

        (new Fpdi2Driver($fpdi->reveal()))->merge($source->reveal());
    }

    public function test_merge(): void
    {
        $fpdi = $this->prophet->prophesize(Fpdi::class);

        $fpdi->setSourceFile(Argument::any())->willReturn(2);

        $fpdi->setPrintHeader(false)->shouldBeCalled();
        $fpdi->setPrintFooter(false)->shouldBeCalled();

        $fpdi->importPage(1)->willReturn('page_1');
        $fpdi->getTemplateSize('page_1')->willReturn(['width' => 1, 'height' => 2]);
        $fpdi->AddPage('P', [1, 2])->shouldBeCalled();
        $fpdi->useTemplate('page_1')->shouldBeCalled();

        $fpdi->importPage(2)->willReturn('page_2');
        $fpdi->getTemplateSize('page_2')->willReturn(['width' => 2, 'height' => 1]);
        $fpdi->AddPage('L', [2, 1])->shouldBeCalled();
        $fpdi->useTemplate('page_2')->shouldBeCalled();

        $fpdi->Output('', 'S')->willReturn('created-pdf');

        $source = $this->prophet->prophesize(SourceInterface::class);
        $source->getName()->willReturn('');
        $source->getContents()->willReturn('');
        $source->getPages()->willReturn(new Pages('1, 2'));

        $this->assertSame(
            'created-pdf',
            (new Fpdi2Driver($fpdi->reveal()))->merge($source->reveal())
        );
    }
}
