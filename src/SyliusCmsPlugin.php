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

namespace Sylius\CmsPlugin;

use Sylius\CmsPlugin\DependencyInjection\Compiler\CompositeLocaleContextPass;
use Sylius\CmsPlugin\DependencyInjection\Compiler\ContentElementPass;
use Sylius\CmsPlugin\DependencyInjection\Compiler\MediaProviderPass;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class SyliusCmsPlugin extends Bundle
{
    private $containerExtension;

    public function getContainerExtension(): ?ExtensionInterface
    {
        if (null === $this->containerExtension) {
            $extension = $this->createContainerExtension();

            if (null !== $extension) {
                if (!$extension instanceof ExtensionInterface) {
                    throw new \LogicException(sprintf('Extension %s must implement %s.', $extension::class, ExtensionInterface::class));
                }

                // check naming convention for Sylius Plugins
                $basename = preg_replace('/Plugin$/', '', $this->getName());
                $expectedAlias = Container::underscore($basename);

                if ($expectedAlias !== $extension->getAlias()) {
                    throw new \LogicException(sprintf(
                        'Users will expect the alias of the default extension of a plugin to be the underscored version of the plugin name ("%s"). You can override "Bundle::getContainerExtension()" if you want to use "%s" or another alias.',
                        $expectedAlias,
                        $extension->getAlias(),
                    ));
                }

                $this->containerExtension = $extension;
            } else {
                $this->containerExtension = false;
            }
        }

        return $this->containerExtension ?: null;
    }

    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new MediaProviderPass());
        $container->addCompilerPass(new ContentElementPass());
        $container->addCompilerPass(new CompositeLocaleContextPass());
    }

    public function getPath(): string
    {
        return \dirname(__DIR__);
    }

    public function getContainerExtensionClass(): string
    {
        $basename = preg_replace('/Plugin$/', '', $this->getName());

        return $this->getNamespace() . '\\DependencyInjection\\' . $basename . 'Extension';
    }
}
