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

namespace Tests\Sylius\CmsPlugin\Unit\Form\Strategy\Wysiwyg;

use PHPUnit\Framework\TestCase;
use Sylius\CmsPlugin\Form\Strategy\Wysiwyg\JoditStrategy;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

final class JoditStrategyTest extends TestCase
{
    private JoditStrategy $joditStrategy;

    protected function setUp(): void
    {
        $this->joditStrategy = new JoditStrategy();
    }

    public function testReturnsTextareaAsParentType(): void
    {
        self::assertSame(TextareaType::class, $this->joditStrategy->getParent());
    }

    public function testReturnsJoditBlockPrefix(): void
    {
        self::assertSame('sylius_cms_plugin_jodit_strategy', $this->joditStrategy->getBlockPrefix());
    }

    public function testSetsJoditBlockPrefixOnFormView(): void
    {
        $view = new FormView();
        $form = $this->createMock(FormInterface::class);

        $this->joditStrategy->buildView($view, $form, []);

        self::assertSame('sylius_cms_plugin_jodit_strategy', $view->vars['block_prefix']);
    }
}
