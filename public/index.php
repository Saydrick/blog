<?php

// use Router\Router;
use Exceptions\RouteNotFoundException;

require_once ('../config/autoload.php');

require_once('../config/ConnectDb.class.php');
// require_once('views/Accueil.twig');

// var_dump($_SERVER);
$loader = new \Twig\Loader\FilesystemLoader('../views');
$template = new \Twig\Environment($loader, ['cache' => false]);

$uri = $_SERVER['REQUEST_URI'];
$router = new AltoRouter();

// $router->map('GET', '/', 'accueil');
$router->map('GET', '/contact', 'contact');

$router->map(
    'GET',
    '/test',
    function () use ($template) {
        echo $template->render('accueil.twig', ['test' => 'test']);
    },
    'test'
);

$match = $router->match();
if(is_array($match)) {
    require '../views/Component/header.twig';
    // if(is_callable($match['target'])) {
    //     call_user_func_array($match['target'], $match['params']);
    // } else {
    //     $params = $match['params'];
    //     require "../views/{$match['target']}.twig";
    // }
    require '../views/Component/footer.twig';
} else '404';



// $user = new userController;
// $user->index();


?>