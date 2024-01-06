<?php

namespace blog\config;


use \Twig\Environment;
use \Twig\Loader\FilesystemLoader;

class TwigRenderer {
    private $twig;

    public function __construct($viewsPath) {
        $loader = new FilesystemLoader($viewsPath);
        $this->twig = new Environment($loader, [
            'cache' => false,
            'debug' => true,
        ]);
    }

    public function render($template, $params) {
        return $this->twig->render($template, $params);
    }
}