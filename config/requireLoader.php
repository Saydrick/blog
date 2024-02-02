<?php

namespace blog\config;

class RequireLoader
{
    public static function register()
    {
        spl_autoload_register(function ($className) {
            // Convertir le nom de la classe en chemin de fichier
            $classFile = str_replace('\\', '/', $className) . '.php';

            // Vérifier si le fichier de classe existe et le charger s'il existe
            if (file_exists($classFile)) {
                include_once $classFile;
            }
        });
    }
}

// Enregistrer l'autoloader
RequireLoader::register();

// Inclure l'autoloader Composer
require '../vendor/autoload.php';
