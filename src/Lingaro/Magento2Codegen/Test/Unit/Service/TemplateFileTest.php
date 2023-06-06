<?php

/**
 * Copyright © 2023 Lingaro sp. z o.o. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace Lingaro\Magento2Codegen\Test\Unit\Service;

use InvalidArgumentException;
use Lingaro\Magento2Codegen\Service\Config;
use Lingaro\Magento2Codegen\Service\DirectoryIteratorFactory;
use Lingaro\Magento2Codegen\Service\FinderFactory;
use Lingaro\Magento2Codegen\Service\TemplateDir;
use Lingaro\Magento2Codegen\Service\TemplateFile;
use Lingaro\Magento2Codegen\Test\Unit\TestCase;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Yaml\Parser;

/**
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class TemplateFileTest extends TestCase
{
    private TemplateFile $templateFile;

    public function setUp(): void
    {
        $this->templateFile = new TemplateFile(
            new TemplateDir(
                new Config(new Processor(), new Parser()),
                new DirectoryIteratorFactory(),
                new Filesystem()
            ),
            new FinderFactory(),
            new Parser()
        );
    }

    public function testExistsReturnsFalseIfTemplateDoesNotExist(): void
    {
        $result = $this->templateFile->exists('nonexistent');
        $this->assertFalse($result);
    }

    public function testExistsReturnsTrueIfTemplateExists(): void
    {
        $result = $this->templateFile->exists('example');
        $this->assertTrue($result);
    }

    public function testGetDescriptionThrowsExceptionIfTemplateDoesNotExist(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->templateFile->getDescription('nonexistent');
    }

    public function testGetDescriptionReturnsEmptyStringIfConfigDirDoesNotExist(): void
    {
        $result = $this->templateFile->getDescription('noconfig');
        $this->assertSame('', $result);
    }

    public function testGetDescriptionReturnsEmptyStringIfDescriptionFileDoesNotExist(): void
    {
        $result = $this->templateFile->getDescription('emptyconfig');
        $this->assertSame('', $result);
    }

    public function testGetDescriptionReturnsDescriptionFileContentIfDescriptionFileExists(): void
    {
        $result = $this->templateFile->getDescription('example');
        $this->assertSame('Exemplary description', $result);
    }

    public function testGetDependenciesThrowsExceptionIfTemplateDoesNotExist(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->templateFile->getDependencies('nonexistent');
    }

    public function testGetDependenciesReturnsEmptyArrayIfConfigDirDoesNotExist(): void
    {
        $result = $this->templateFile->getDependencies('noconfig');
        $this->assertSame([], $result);
    }

    public function testGetDependenciesThrowsExceptionIfConfigYmlIsInvalid(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->templateFile->getDependencies('stringinconfigyml');
    }

    public function testGetDependenciesThrowsExceptionIfDependenciesArrayIsNested(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->templateFile->getDependencies('nestedarrayofdependencies');
    }

    public function testGetDependenciesThrowsExceptionIfDependencyDoesNotExist(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->templateFile->getDependencies('nonexistentdependency');
    }

    public function testGetDependenciesReturnsEmptyArrayIfDependenciesDoesNotExistInConfigYml(): void
    {
        $result = $this->templateFile->getDependencies('nodependenciesinconfigyml');
        $this->assertSame([], $result);
    }

    public function testGetDependenciesReturnsArrayOfAllLevelsDependencies(): void
    {
        $result = $this->templateFile->getDependencies('example');
        $this->assertSame(['example2', 'emptyconfig'], $result);
    }

    public function testGetTemplateFilesReturnsEmptyArrayIfTemplatesArrayIsEmpty(): void
    {
        $result = $this->templateFile->getTemplateFiles([]);
        $this->assertSame([], $result);
    }

    public function testGetTemplateFilesThrowsExceptionIfOneOfTheTemplatesDoesNotExist(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->templateFile->getTemplateFiles(['example', 'nonexistent']);
    }

    public function testGetTemplateFilesReturnsNonConfigFilesIfTemplatesArrayIsNotEmptyAndAllTemplatesExist(): void
    {
        $result = $this->templateFile->getTemplateFiles(['example', 'example2']);
        $this->assertContainsOnlyInstancesOf(SplFileInfo::class, $result);
        $this->assertCount(2, $result);
    }
}
