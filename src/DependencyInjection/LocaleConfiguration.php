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

use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;
use Sylius\CmsPlugin\Entity\Locale;
use Sylius\CmsPlugin\Entity\LocaleInterface;
use Sylius\CmsPlugin\Locale\Form\Type\LocaleType;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class LocaleConfiguration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $localeTreeBuilder = new TreeBuilder('sylius_locale');
        /** @var ArrayNodeDefinition $rootNode */
        $localeRootNode = $localeTreeBuilder->getRootNode();

        $localeRootNode
            ->children()
            ->scalarNode('driver')->defaultValue(SyliusResourceBundle::DRIVER_DOCTRINE_ORM)->end()
            ->scalarNode('locale')->defaultValue('en_US')->cannotBeEmpty()->end()
            ->end()
        ;

        $this->addLocaleResourcesSection($localeRootNode);

        return $localeTreeBuilder;
    }

    private function addLocaleResourcesSection(ArrayNodeDefinition $node): void
    {
        $node
            ->children()
            ->arrayNode('resources')
            ->addDefaultsIfNotSet()
            ->children()
            ->arrayNode('locale')
            ->addDefaultsIfNotSet()
            ->children()
            ->arrayNode('classes')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('model')->defaultValue(Locale::class)->cannotBeEmpty()->end()
            ->scalarNode('interface')->defaultValue(LocaleInterface::class)->cannotBeEmpty()->end()
            ->scalarNode('controller')->defaultValue(ResourceController::class)->cannotBeEmpty()->end()
            ->scalarNode('repository')->cannotBeEmpty()->end()
            ->scalarNode('factory')->defaultValue(\Sylius\Resource\Factory\Factory::class)->end()
            ->scalarNode('form')->defaultValue(LocaleType::class)->cannotBeEmpty()->end()
            ->end()
            ->end()
            ->end()
            ->end()
            ->end()
            ->end()
            ->end()
        ;
    }
}
