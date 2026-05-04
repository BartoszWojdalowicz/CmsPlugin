<?php

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
