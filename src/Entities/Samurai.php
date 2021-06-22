<?php

namespace Maestriam\Samurai\Entities;

use Maestriam\Samurai\Contracts\Entities\SamuraiContract;

class Samurai implements SamuraiContract
{
    /**
     * {@inheritDoc}
     */
    public function base() : Base
    {
        return new Base();
    }

    /**
     * {@inheritDoc}
     */
    public function theme(string $package) : Theme
    {
        return new Theme($package);
    }

    /**
     * {@inheritDoc}
     */
    public function wizard() : Wizard
    {
        return new Wizard();
    }
}