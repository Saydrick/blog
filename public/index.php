<?php

use blog\controller\allPostsController;
use blog\repository\postRepository;

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
    
    $router->map('GET', '/all-posts', function() {
        // Inclure le fichier du contrôleur si nécessaire
        require_once('../vendor/twig/twig/src/Environment.php');
        require_once('../controllers/allPostsController.php');
        require_once('../repository/postRepository.php');
        $loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../views');
        $twig  = new \Twig\Environment($loader, ['cache' => false, 'debug' => true]);
        
        $controller = new allPostsController(new postRepository);

        // Appeler une méthode du contrôleur
        $params = $controller->index();
        $page = 'allPosts.twig';

        $layout = $twig->load('layout.twig');
        // $layout = $twig->load('allPosts.twig');
        echo $twig->render($layout, ['params' => $params, 'page' => $page]);
    }, 'allPosts');
    
} catch (Exception $e) {
    echo '404';
    die($e);
}

// var_dump($router);


$match = $router->match();

// var_dump($match['target']);

if(is_array($match)) {


    /* GRAFIKART */
    // $page = $match['name'] . '.twig';
    // $layout = $twig->load('allPosts.twig');
    // echo $twig->render($layout, ['params' => $params]);

    /* MVC */
    // list($controller, $action) = explode('#', $match['target']); // Sépare la classe de sa fonction
    // // require_once('../controllers/' . $controller . '.php');
    
    // // $controller = 'blog\controller\\' . $controller;
    // // var_dump($controller);
    // $controller = new $controller(new postRepository);

    // $test = $controller->$action;
    // var_dump($test);

    //---------------------------
    // require_once('../views/Component/header.twig');

    if(is_array($match) && is_callable( $match['target'])) {
        call_user_func_array($match['target'], $match['params']);
    }

    // require_once('../views/Component/footer.twig');
    //---------------------------
    // $page = $match['name'] . '.twig';
    // $layout = $twig->load($page);
    // echo $twig->render($layout);
    


} else {
    echo '404';
    die;
}
?>