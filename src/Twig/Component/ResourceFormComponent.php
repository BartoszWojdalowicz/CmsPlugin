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

namespace Sylius\CmsPlugin\Twig\Component;

use Sylius\CmsPlugin\Twig\Component\Trait\LiveCollectionTrait;
use Sylius\CmsPlugin\Twig\Component\Trait\ResourceFormComponentTrait;
use Sylius\CmsPlugin\Twig\Component\Trait\TemplatePropTrait;
use Sylius\Resource\Model\ResourceInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;

#[AsLiveComponent]
class ResourceFormComponent
{
    use LiveCollectionTrait;
    use TemplatePropTrait;

    /** @use ResourceFormComponentTrait<ResourceInterface> */
    use ResourceFormComponentTrait {
        initialize as public __construct;
    }
}
