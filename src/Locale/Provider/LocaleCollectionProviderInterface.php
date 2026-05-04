<?php

/*
 * This file is part of the Sylius CMS Plugin package.
 *
 * (c) Sylius Sp. z o.o.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Sylius\CmsPlugin\Locale\Provider;

use Sylius\Component\Locale\Model\LocaleInterface;

interface LocaleCollectionProviderInterface
{
    /**
     * @return array<array-key, LocaleInterface>
     */
    public function getAll(): array;
}
