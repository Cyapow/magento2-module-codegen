<?php

/**
 * @copyright Copyright © 2021 Orba. All rights reserved.
 * @author    info@orba.co
 */

declare(strict_types=1);

namespace Orba\Magento2Codegen\Service\StringFilter;

use ICanBoogie\Inflector;

/**
 * Transforms words from singular to plural
 */
class PluralizeFilter implements FilterInterface
{
    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function filter(string $text): string
    {
        $inflector = Inflector::get(Inflector::DEFAULT_LOCALE);
        return $inflector->pluralize($text);
    }
}
