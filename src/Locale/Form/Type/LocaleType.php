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

namespace Sylius\CmsPlugin\Locale\Form\Type;

use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;

final class LocaleType extends AbstractResourceType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code', \Symfony\Component\Form\Extension\Core\Type\LocaleType::class, [
                'label' => 'sylius.form.locale.name',
            ])
            ->add('enabled', CheckboxType::class, [
                'label' => 'sylius.form.locale.enabled',
                'required' => false,
            ])
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'sylius_locale';
    }
}
