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

namespace Sylius\CmsPlugin\Locale\Twig;

use Sylius\CmsPlugin\Locale\Context\LocaleContextInterface;
use Sylius\CmsPlugin\Locale\Context\LocaleNotFoundException;
use Symfony\Component\Intl\Exception\MissingResourceException;
use Symfony\Component\Intl\Locales;
use Twig\Extension\RuntimeExtensionInterface;

final class LocaleRuntime implements RuntimeExtensionInterface
{
    public function __construct(private LocaleContextInterface $localeContext)
    {
    }

    public function convertCodeToName(string $code, ?string $localeCode = null): string
    {
        try {
            return Locales::getName($code, $this->getLocaleCode($localeCode) ?? 'en');
        } catch (\InvalidArgumentException|MissingResourceException) {
            return $code;
        }
    }

    public function getLocaleCode(?string $localeCode): ?string
    {
        if (null !== $localeCode) {
            return $localeCode;
        }

        try {
            return $this->localeContext->getLocaleCode();
        } catch (LocaleNotFoundException) {
            return null;
        }
    }

    public function getCountryCode(string $locale): ?string
    {
        return \Locale::getRegion($locale);
    }
}
