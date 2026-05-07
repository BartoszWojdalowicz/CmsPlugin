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

namespace Sylius\CmsPlugin\Locale\Listener;

use Sylius\CmsPlugin\Locale\Context\LocaleContextInterface;
use Sylius\CmsPlugin\Locale\Context\LocaleNotFoundException;
use Sylius\CmsPlugin\Locale\Provider\LocaleProviderInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;

final class RequestLocaleSetter
{
    public function __construct(private LocaleContextInterface $localeContext, private LocaleProviderInterface $localeProvider)
    {
    }

    /**
     * @throws LocaleNotFoundException
     */
    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        $request->setLocale($this->localeContext->getLocaleCode());
        $request->setDefaultLocale($this->localeProvider->getDefaultLocaleCode());
    }
}
