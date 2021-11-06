<?php

namespace SpinyMan\LumenRouteParamToObject\Tests\Entities;

class Namer
{
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function run(): string
    {
        return ucfirst(
            strtolower($this->name)
        );
    }
}
