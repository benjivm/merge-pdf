<?php

declare(strict_types=1);

namespace Tests;

use Benjivm\MergePdf\Exception;
use Benjivm\MergePdf\Pages;

class PagesTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider pageNumbersProvider
     */
    public function test_page_numbers($expressionString, array $expected): void
    {
        $this->assertSame(
            $expected,
            (new Pages($expressionString))->getPageNumbers()
        );
    }

    public static function pageNumbersProvider(): array
    {
        return [
            ['', []],
            ['1', [1]],
            ['1,2', [1, 2]],
            ['5-7', [5, 6, 7]],
            ['7-5', [7, 6, 5]],
            ['1,2-5,4,7-5', [1, 2, 3, 4, 5, 4, 7, 6, 5]],
            [' 1, 2- 5,, 4 ,7 -5,,', [1, 2, 3, 4, 5, 4, 7, 6, 5]],
        ];
    }

    public function test_invalid_string(): void
    {
        $this->expectException(Exception::class);
        new Pages('12,*');
    }
}
