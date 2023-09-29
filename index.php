<?php

// use Router\Router;
// use Exceptions\RouteNotFoundException;

require_once ('config/autoload.php');
require_once('config/ConnectDb.class.php');
require_once('views/Accueil.twig');

// $loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/views');
// $template = new \Twig\Environment($loader, ['cache' => false]);

// $user = new userController;
// $user->index();

// $router = new Router();

// $router->register('/', function() {
//     return 'Accueil';
// });

// $router->register('/posts', function() {
//     return 'Posts';
// });

// try {
//     echo $router->resolve($_SERVER['REQUEST_URI']);
// } catch (RouteNotFoundException $e) {
//     echo $e->getMessage();
// }

?>