<?php

namespace Validators;

class NamespaceLoader
{
    private $unload = [];

    public function __construct(
        private string $namespace,
        private bool $recursive = false
    ) {
    }

    public function namespaceToDir()
    {
        return str_replace("\\", "/", $this->namespace());
    }

    public function namespace()
    {
        return $this->namespace;
    }

    public function appRoot()
    {
        $appRoot =  __DIR__ . "/../";
        if (!endsWith($appRoot, "/")) {
            $appRoot .= "/";
        }

        return $appRoot;
    }

    public function load()
    {
        if (!is_dir($path = $this->getNamespaceClass())) {
            throw new \Exception("Diretorio para o namespace informado invalido!");
        }
        $mappedClasses = [];
        foreach (scandir($path) as $item) {
            if (!in_array($item, [".", ".."])) {
                if (is_dir($path . "/" . $item) && $this->recursive()) {
                    if ($this->permitedToLoad($this->namespace() . "\\" . $item)) {
                        $loaded = self::createRecursive($this->namespace() . "\\" . $item);
                        if ($loaded && count($loaded) > 0) {
                            array_push($mappedClasses, ...$loaded);
                        }
                    }
                }

                if (file_exists($path . "/" . $item)) {
                    $possibleClass =  $this->namespace() . "\\" . str_replace(".php", "", $item);
                    if ($this->permitedToLoad($possibleClass) && class_exists($possibleClass)) {
                        $mappedClasses[] = $possibleClass;
                    }
                }
            }
        }

        return $mappedClasses;
    }

    public function psr4LoadedClasses()
    {
        $composerJsonPath =  $this->appRoot() . 'composer.json';
        $composerConfig = json_decode(file_get_contents($composerJsonPath));
        return (array) $composerConfig->autoload->{'psr-4'};
    }

    public function getNamespaceClass()
    {
        $psr4 = $this->psr4LoadedClasses();
        $realPath = explode("\\", $this->namespace());
        $root = array_shift($realPath);
        return $realPath = $this->appRoot() . $psr4[$root . "\\"]  . implode("/", $realPath);
    }

    public function recursive()
    {
        return $this->recursive;
    }

    public static function createRecursive(string $namespace)
    {
        return (new self($namespace, true))->load();
    }

    public function unload(array $classes = [])
    {
        $this->unload = $classes;
    }

    public function permitedToLoad(string $class)
    {
        return !isset(array_flip($this->unload)[$class]);
    }
}
