<?php

namespace Validators\Foundation;

class ConfigBag
{
    private array $defaultConfig = [];

    public function __construct(private array $config = [])
    {
        $this->setupDefaultConfig(__DIR__ . "/../../resources/config.php");
    }

    private function setupDefaultConfig(string $path)
    {
        $this->defaultConfig = require $path;
    }

    public function set(string $config, mixed $value)
    {
        $this->config[$config] = $value;
    }

    public function get(?string $config = null) : mixed
    {
        if (!$config) {
            return $this->config;
        }
        
        return dot($config, $this->config) ?? null;
    }

    public function getFromDefault(?string $config = null) : mixed
    {
        if (!$config) {
            return $this->defaultConfig;
        }
        
        return dot($config, $this->defaultConfig) ?? null;
    }
}
