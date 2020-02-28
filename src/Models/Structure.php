<?php

namespace Maestriam\Samurai\Models;

use Maestriam\Samurai\Foundation\FileNominator;
use Maestriam\Samurai\Foundation\SyntaxValidator;
use Maestriam\Samurai\Foundation\FileSystem;
use Maestriam\Samurai\Foundation\StructureDirectory;

class Structure
{
    /**
     * Undocumented variable
     *
     * @var [type]
     */
    private $dir;

    /**
     * Undocumented variable
     *
     * @var [type]
     */
    private $file;

    /**
     * Undocumented variable
     *
     * @var [type]
     */
    private $valid;

    /**
     * Undocumented variable
     *
     * @var [type]
     */
    private $nominator;

    /**
     * Retorna uma instância de RN
     * sobre estrutura de pasta do tema
     *
     * @return StructureDirectory
     */
    protected function dir() : StructureDirectory
    {
        if ($this->dir == null) {
            $this->dir = new StructureDirectory();
        }

        return $this->dir;
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    protected function file() : FileSystem
    {
        if ($this->file == null) {
            $this->file = new FileSystem();
        }

        return $this->file;
    }

    /**
     * Undocumented function
     *
     * @return SyntaxValidator
     */
    protected function valid() : SyntaxValidator
    {
        if ($this->valid == null) {
            $this->valid = new SyntaxValidator();
        }

        return $this->valid;
    }

    /**
     * Undocumented function
     *
     * @return FileNominator
     */
    protected function nominator() : FileNominator
    {
        if ($this->nominator == null) {
            $this->nominator = new FileNominator();
        }

        return $this->nominator;
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function all()
    {
        return [];
    }

    private function readBase()
    {
        $base = $this->dir()->base();

        if (! $this->baseExists($base)) {
            return [];
        }

        $themes = scandir($base);
        $themes = array_splice($themes, 2);

        return empty($themes) ?  [] : $themes;
    }
}
