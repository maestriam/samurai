<?php

namespace Maestriam\Samurai\Traits\Shared;

/**
 *
 */
trait Composer
{
    private function getComposer() : string
    {
        $vendor = $this->getVendor();
        $author = $this->getAuthor();
        $desc   = $this->getDescription();

        $content = $this->file()->stub('composer');

        $content = str_replace('{{theme}}', $vendor, $content);
        $content = str_replace('{{description}}', $desc, $content);
        $content = str_replace('{{name}}', $author->name, $content);
        $content = str_replace('{{email}}', $author->email, $content);
        $content = str_replace('\r\n', PHP_EOL, $content);

        return $content;
    }

    private function mkComposer()
    {
        $filename = 'composer.json';
        $content  = $this->getComposer();
        $filepath = $this->path . DS . $filename;

        $this->file()->mkFile($filepath, $content);
    }

}
