<?php

/**
 * Copyright © 2023 Lingaro sp. z o.o. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace Orba\Magento2Codegen\Test\Unit\Service\StringFilter;

use Orba\Magento2Codegen\Service\StringFilter\LowerOnlyCaseFilter;
use Orba\Magento2Codegen\Test\Unit\TestCase;

class LowerOnlyCaseFilterTest extends TestCase
{
    private LowerOnlyCaseFilter $lowerOnlyCaseFilter;

    public function setUp(): void
    {
        $this->lowerOnlyCaseFilter = new LowerOnlyCaseFilter();
    }

    /**
     * @dataProvider filterProvider
     */
    public function testFilterReturnsCorrectlyFilteredString(string $text, string $expected): void
    {
        $result = $this->lowerOnlyCaseFilter->filter($text);
        $this->assertSame($expected, $result);
    }

    public function filterProvider(): array
    {
        return [
            ['one', 'one'],
            ['ONE', 'one'],
            ['one_two', 'onetwo'],
            ['one-two', 'onetwo'],
            ['one TWO', 'onetwo'],
            ['oneTwo', 'onetwo'],
            ['one1two2', 'one1two2'],
            ['one1Two2', 'one1two2'],
            ['_one_', 'one'],
            ['one__two', 'onetwo'],
            [' one  two ', 'onetwo']
        ];
    }
}
