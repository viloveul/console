<?php

namespace Viloveul\Console\Contracts;

use Viloveul\Container\Contracts\ContainerAware;

interface Console extends ContainerAware
{
    public function boot(): void;
}
