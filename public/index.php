<?php

require_once('../vendor/autoload.php');
require_once('../vendor/twig/twig/src/Environment.php');
require_once('../config/ConnectDb.class.php');

$loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../views');
$twig  = new \Twig\Environment($loader, [
     'cache' => false,
     'debug' => true
 ]);

$router = new AltoRouter();         
$router->setBasePath('/blog/public');

try {
    $router->map('GET', '/', '/views/accueil.twig' /*CONTROLLER*/, 'accueil');
    $router->map('GET', '/contact', '/views/contact.twig', 'contact');
    // $router->map('GET', '/post/[i:id]', '/views/post.twig', 'post');
    
} catch (Exception $e) {
    die($e);
}

// var_dump($router);

// echo '-------------------------------------------------------------------------';

$match = $router->match();

// var_dump($match);

if(is_array($match)) {
    $page = $match['name'] . '.twig'/*'.php'*/;
    $layout = $twig->load('layout.twig');
    echo $twig->render($layout, ['page' => $page]);
} else {
    echo '404';
}

?>