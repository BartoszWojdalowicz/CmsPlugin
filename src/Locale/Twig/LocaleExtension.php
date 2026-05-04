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
use Sylius\CmsPlugin\Locale\Converter\LocaleConverterInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

final class LocaleExtension extends AbstractExtension
{
    public function __construct(
        private LocaleConverterInterface $localeConverter,
        private LocaleContextInterface $localeContext,
    ) {
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('sylius_locale_name', [$this, 'convertCodeToName']),
            new TwigFilter('sylius_locale_country', [$this, 'getCountryCode']),
        ];
    }

    public function convertCodeToName(string $code, ?string $localeCode = null): string
    {
        try {
            return $this->localeConverter->convertCodeToName($code, $this->getLocaleCode($localeCode));
        } catch (\InvalidArgumentException) {
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
