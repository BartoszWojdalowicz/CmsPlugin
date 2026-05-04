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

namespace Sylius\CmsPlugin\Entity;

use Sylius\Resource\Model\TimestampableTrait;
use Symfony\Component\Intl\Locales;

class Locale implements LocaleInterface, \Stringable
{
    use TimestampableTrait;

    /** @var mixed */
    protected $id;

    /** @var string|null */
    protected $code;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public function __toString(): string
    {
        return (string) $this->getName();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): void
    {
        $this->code = $code;
    }

    public function getName(?string $locale = null): ?string
    {
        if (null === $locale) {
            $locale = 'en_US';
        }

        if (null === $this->getCode()) {
            return Locales::getName('en_US', 'en_US');
        }

        return Locales::getName($this->getCode(), $locale);
    }
}
