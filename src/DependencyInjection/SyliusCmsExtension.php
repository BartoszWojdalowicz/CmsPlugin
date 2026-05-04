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

namespace Sylius\CmsPlugin\DependencyInjection;

use Sylius\Bundle\ResourceBundle\DependencyInjection\Extension\AbstractResourceExtension;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;

final class SyliusCmsExtension extends AbstractResourceExtension implements PrependExtensionInterface
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('sylius_cms.templates.pages', $config['templates']['pages']);
        $container->setParameter('sylius_cms.templates.blocks', $config['templates']['blocks']);
        $container->setParameter('sylius_cms.wysiwyg_editor', $config['wysiwyg_editor']);
    }

    public function prepend(ContainerBuilder $container): void
    {
        $config = $this->getCurrentConfiguration($container);
        $container->setParameter('sylius_cms.fixtures_dir', __DIR__ . '/../../config/fixtures');

        $this->registerResources('sylius_cms', 'doctrine/orm', $config['resources'], $container);

        $localeConfiguration = new LocaleConfiguration();
        $localeConfig = $this->processConfiguration($localeConfiguration, []);

        $this->registerResources('sylius', 'doctrine/orm', $localeConfig['resources'], $container);
        $container->setParameter('sylius_locale.locale', $localeConfig['locale']);

        $this->prependDoctrineMigrations($container);
    }

    protected function getMigrationsNamespace(): string
    {
        return 'Sylius\CmsPlugin\Migrations';
    }

    protected function getMigrationsDirectory(): string
    {
        return '@SyliusCmsPlugin/src/Migrations';
    }

    /** @return string[] */
    protected function getNamespacesOfMigrationsExecutedBefore(): array
    {
        return ['Sylius\Bundle\CoreBundle\Migrations'];
    }

    /** @return array<array-key, mixed> */
    private function getCurrentConfiguration(ContainerBuilder $container): array
    {
        /** @var ConfigurationInterface $configuration */
        $configuration = $this->getConfiguration([], $container);
        $configs = $container->getExtensionConfig($this->getAlias());

        return $this->processConfiguration($configuration, $configs);
    }

    private function prependDoctrineMigrations(ContainerBuilder $container): void
    {
        if (
            !$container->hasExtension('doctrine_migrations') ||
            !$container->hasExtension('sylius_labs_doctrine_migrations_extra')
        ) {
            return;
        }

        if (
            $container->hasParameter('sylius_core.prepend_doctrine_migrations') &&
            !$container->getParameter('sylius_core.prepend_doctrine_migrations')
        ) {
            return;
        }

        $doctrineConfig = $container->getExtensionConfig('doctrine_migrations');
        $container->prependExtensionConfig('doctrine_migrations', [
            'migrations_paths' => \array_merge(\array_pop($doctrineConfig)['migrations_paths'] ?? [], [
                $this->getMigrationsNamespace() => $this->getMigrationsDirectory(),
            ]),
        ]);

        $container->prependExtensionConfig('sylius_labs_doctrine_migrations_extra', [
            'migrations' => [
                $this->getMigrationsNamespace() => $this->getNamespacesOfMigrationsExecutedBefore(),
            ],
        ]);
    }
}
