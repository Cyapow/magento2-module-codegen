<?php

/**
 * Copyright © 2023 Lingaro sp. z o.o. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace Lingaro\Magento2Codegen\Test\Unit\Service\PropertyFactory;

use Lingaro\Magento2Codegen\Model\BooleanProperty;
use Lingaro\Magento2Codegen\Service\PropertyBuilder;
use Lingaro\Magento2Codegen\Service\PropertyFactory\BooleanFactory;
use Lingaro\Magento2Codegen\Service\StringValidator;
use Lingaro\Magento2Codegen\Test\Unit\TestCase;

class BooleanFactoryTest extends TestCase
{
    private BooleanFactory $booleanFactory;

    public function setUp(): void
    {
        $this->booleanFactory = new BooleanFactory(new PropertyBuilder());
    }

    public function testCreateReturnsBooleanProperty(): void
    {
        $result = $this->booleanFactory->create('name', []);
        $this->assertInstanceOf(BooleanProperty::class, $result);
    }
}
