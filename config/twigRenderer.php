<?php

namespace blog\config;

use Exception;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TwigRenderer
{
    private $twig;

    public function __construct($viewsPath)
    {
        try {
            $loader = new FilesystemLoader($viewsPath);
            $this->twig = new Environment($loader, [
                'cache' => false,
                'debug' => true,
            ]);
        } catch (\Exception $e) {
            throw new Exception('Erreur lors de la création de TwigRenderer: ' . $e->getMessage());
        }
    }

    public function render($template, $params)
    {
        return $this->twig->render($template, $params);
    }
}
