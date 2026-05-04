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

namespace Sylius\CmsPlugin\DependencyInjection\Compiler;

use Sylius\Bundle\ResourceBundle\DependencyInjection\Compiler\PrioritizedCompositeServicePass;
use Sylius\CmsPlugin\Locale\Context\CompositeLocaleContext;
use Sylius\CmsPlugin\Locale\Context\ImmutableLocaleContext;
use Sylius\CmsPlugin\Locale\Provider\CmsTranslationLocaleProvider;
use Sylius\Resource\Translation\Provider\TranslationLocaleProviderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

final class CompositeLocaleContextPass extends PrioritizedCompositeServicePass
{
    public function __construct()
    {
        parent::__construct(
            'sylius.context.locale',
            'sylius.context.locale.composite',
            'sylius.context.locale',
            'addContext',
        );
    }

    public function process(ContainerBuilder $container): void
    {
        if (!$container->has('sylius.context.locale.composite')) {
            $fallback = (new Definition(ImmutableLocaleContext::class))
                ->addArgument('%sylius_locale.locale%');

            $composite = (new Definition(CompositeLocaleContext::class))
                ->setPublic(true)
                ->addMethodCall('addContext', [$fallback, -255]);

            $container->setDefinition('sylius.context.locale.composite', $composite);
            $container->setAlias('sylius.context.locale', 'sylius.context.locale.composite')->setPublic(true);
        }

        parent::process($container);
    }
}
