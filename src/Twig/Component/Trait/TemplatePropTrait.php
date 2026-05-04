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

namespace Sylius\CmsPlugin\Twig\Component\Trait;

use Symfony\UX\LiveComponent\Attribute\LiveProp;

trait TemplatePropTrait
{
    #[LiveProp]
    public ?string $template = null;
}
