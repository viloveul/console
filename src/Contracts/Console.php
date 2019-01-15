<?php

namespace Viloveul\Console\Contracts;

use Viloveul\Container\Contracts\Injector;

interface Console extends Injector
{
    public function boot(): void;
}
