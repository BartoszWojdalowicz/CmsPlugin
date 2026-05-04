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

namespace Sylius\CmsPlugin\Repository;

use Doctrine\ORM\QueryBuilder;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\CmsPlugin\Entity\PageInterface;

class PageRepository extends EntityRepository implements PageRepositoryInterface
{
    use TranslationBasedAwareTrait;

    public function findEnabled(bool $enabled): array
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.enabled = :enabled')
            ->setParameter('enabled', $enabled)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findOneEnabledByCode(string $code): ?PageInterface
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.code = :code')
            ->andWhere('o.enabled = true')
            ->setParameter('code', $code)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findOneEnabledBySlug(
        string $slug,
        ?string $localeCode,
    ): ?PageInterface {
        return $this->createQueryBuilder('o')
            ->leftJoin('o.translations', 'translation')
            ->where('translation.locale = :localeCode')
            ->andWhere('translation.slug = :slug')
            ->andWhere('o.enabled = true')
            ->setParameter('localeCode', $localeCode)
            ->setParameter('slug', $slug)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function createShopListQueryBuilder(string $collectionCode): QueryBuilder
    {
        return $this->createQueryBuilder('o')
            ->innerJoin('o.collections', 'collection')
            ->where('collection.code = :collectionCode')
            ->andWhere('o.enabled = true')
            ->setParameter('collectionCode', $collectionCode)
        ;
    }

    public function findByCollectionCode(string $collectionCode): array
    {
        return $this->createQueryBuilder('o')
            ->innerJoin('o.collections', 'collection')
            ->andWhere('collection.code = :collectionCode')
            ->andWhere('o.enabled = true')
            ->setParameter('collectionCode', $collectionCode)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByNamePart(string $phrase): array
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.name LIKE :name')
            ->setParameter('name', '%' . $phrase . '%')
            ->getQuery()
            ->getResult()
        ;
    }
}
