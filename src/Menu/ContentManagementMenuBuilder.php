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

namespace Sylius\CmsPlugin\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Sylius\AdminUi\Knp\Menu\MenuBuilderInterface;

final readonly class ContentManagementMenuBuilder implements MenuBuilderInterface
{
    public function __construct(
        private MenuBuilderInterface $menuBuilder,
    ) {
    }

    public function createMenu(array $options): ItemInterface
    {
        $menu = $this->menuBuilder->createMenu($options);

        $cmsRootMenuItem = $menu
            ->addChild('sylius_cms')
            ->setLabel('sylius_cms.ui.cms')
            ->setLabelAttribute('icon', 'tabler:home-edit')
        ;

        $cmsRootMenuItem
            ->addChild('collections', [
                'route' => 'sylius_cms_admin_collection_index',
                'extras' => ['routes' => [
                    ['route' => 'sylius_cms_admin_collection_create'],
                    ['route' => 'sylius_cms_admin_collection_update'],
                ]],
            ])
            ->setLabel('sylius_cms.ui.collections')
        ;

        $cmsRootMenuItem
            ->addChild('templates', [
                'route' => 'sylius_cms_admin_template_index',
                'extras' => ['routes' => [
                    ['route' => 'sylius_cms_admin_template_create'],
                    ['route' => 'sylius_cms_admin_template_update'],
                ]],
            ])
            ->setLabel('sylius_cms.ui.content_templates')
        ;

        $cmsRootMenuItem
            ->addChild('pages', [
                'route' => 'sylius_cms_admin_page_index',
                'extras' => ['routes' => [
                    ['route' => 'sylius_cms_admin_page_create'],
                    ['route' => 'sylius_cms_admin_page_update'],
                ]],
            ])
            ->setLabel('sylius_cms.ui.pages')
        ;

        $cmsRootMenuItem
            ->addChild('blocks', [
                'route' => 'sylius_cms_admin_block_index',
                'extras' => ['routes' => [
                    ['route' => 'sylius_cms_admin_block_create'],
                    ['route' => 'sylius_cms_admin_block_update'],
                ]],
            ])
            ->setLabel('sylius_cms.ui.blocks')
        ;

        $cmsRootMenuItem
            ->addChild('media', [
                'route' => 'sylius_cms_admin_media_index',
                'extras' => ['routes' => [
                    ['route' => 'sylius_cms_admin_media_create'],
                    ['route' => 'sylius_cms_admin_media_update'],
                ]],
            ])
            ->setLabel('sylius_cms.ui.media')
        ;

        return $menu;
    }
}
