<?php

namespace Presentation;


use Smarty;

class TemplateEngine extends Smarty
{
    private $path;

    public function __construct(string $fileName)
    {
        parent::__construct();

        $this->path = __DIR__ . "/../PresentationHTML/" . $fileName;
    }

    public function Compile()
    {
        return $this->fetch($this->path);
    }
}
