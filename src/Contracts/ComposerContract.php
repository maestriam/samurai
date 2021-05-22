<?php

namespace Maestriam\Samurai\Contracts;

use Maestriam\Samurai\Entities\Composer;
use Maestriam\Samurai\Entities\Vendor;

interface ComposerContract
{
    public function __construct(Vendor $vendor, string $desc = null);

    public function description(string $desc = null) : string|Composer;
}