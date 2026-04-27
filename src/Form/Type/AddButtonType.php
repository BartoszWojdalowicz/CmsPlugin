<?php

namespace Sylius\CmsPlugin\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class AddButtonType extends AbstractType
{
    public const OPTION_TYPES = 'types';

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $view->vars[self::OPTION_TYPES] = $options[self::OPTION_TYPES];
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefault(self::OPTION_TYPES, [])
            ->setAllowedTypes(self::OPTION_TYPES, 'array')
        ;
    }

    public function getParent(): string
    {
        return ButtonType::class;
    }
}
