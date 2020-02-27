<?php

namespace Maestriam\Samurai\Models;

use Maestriam\Samurai\Foundation\FileNominator;
use Maestriam\Samurai\Foundation\Validator;
use Maestriam\Samurai\Foundation\FileSystem;
use Maestriam\Samurai\Foundation\StructureDirectory;

class Structure
{
    /**
     * Undocumented variable
     *
     * @var [type]
     */
    protected $dir;

    /**
     * Undocumented variable
     *
     * @var [type]
     */
    protected $file;

    /**
     * Undocumented function
     */
    public function __construct()
    {
        $this->dir = new StructureDirectory();

        $this->file = new FileSystem();

        $this->valid = new Validator();

        $this->nominator = new FileNominator();

    }

    public function readBase()
    {
        return [];
    }
}
