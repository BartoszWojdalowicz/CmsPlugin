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

/*
 * This file is part of the Sylius package.
 *
 * (c) Sylius Sp. z o.o.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\CmsPlugin\Filesystem\Adapter;

interface FlysystemFilesystemAdapterInterface
{
    public function has(string $location): bool;

    public function write(string $location, string $content): void;

    public function delete(string $location): void;
}
