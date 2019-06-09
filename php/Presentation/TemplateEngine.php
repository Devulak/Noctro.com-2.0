<?php


namespace Presentation;


class TemplateEngine
{
    public $Prefix = "{";
    public $Suffix = "}";
    public $Compiled;

    public function __construct(string $path)
    {
        $path = __DIR__ . "/" . $path;

        $this->Compiled = file_get_contents($path);
    }

    public function Assign(string $variable, string $value)
    {
        $this->Compiled = str_replace($this->Prefix . $variable . $this->Suffix, htmlspecialchars($value), $this->Compiled);
    }
}