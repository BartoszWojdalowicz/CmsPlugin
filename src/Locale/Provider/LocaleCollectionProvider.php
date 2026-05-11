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

use Sylius\CmsPlugin\Entity\LocaleInterface;
use Sylius\Resource\Doctrine\Persistence\RepositoryInterface;

final class LocaleCollectionProvider implements LocaleCollectionProviderInterface
{
    /** @param RepositoryInterface<LocaleInterface> $localeRepository */
    public function __construct(private RepositoryInterface $localeRepository)
    {
    }

    public function getAll(): array
    {
        $locales = [];

        foreach ($this->localeRepository->findBy(['enabled' => true]) as $locale) {
            $locales[$locale->getCode()] = $locale;
        }

        return $locales;
    }
}
