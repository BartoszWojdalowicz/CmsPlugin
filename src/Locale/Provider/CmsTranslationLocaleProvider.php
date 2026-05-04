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

use Sylius\Resource\Translation\Provider\TranslationLocaleProviderInterface;

final class CmsTranslationLocaleProvider implements TranslationLocaleProviderInterface
{
    public function __construct(private readonly LocaleProviderInterface $localeProvider)
    {
    }

    public function getDefinedLocalesCodes(): array
    {
        return $this->localeProvider->getAvailableLocalesCodes();
    }

    public function getDefaultLocaleCode(): string
    {
        return $this->localeProvider->getDefaultLocaleCode();
    }
}
