<?php

namespace Sylius\CmsPlugin\Twig\Component\Trait;

use Symfony\UX\LiveComponent\Attribute\LiveProp;

trait TemplatePropTrait
{
    #[LiveProp]
    public ?string $template = null;
}
