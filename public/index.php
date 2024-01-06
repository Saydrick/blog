<?php

session_start();

use PHPMailer\PHPMailer\PHPMailer;

require_once('../config/requireLoader.php');

// $session = array('id' => $_SESSION['USER_ID']);

$twigRenderer = new \blog\config\TwigRenderer(__DIR__.'/../views');

$router = new AltoRouter();         
$router->setBasePath('/blog/public');


$router->map('GET', '/', function() use ($twigRenderer) {
    require_once('../config/requireLoader.php');

    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : NULL;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : NULL;

    $page = 'accueil.twig';

    // Charger la page avec les paramètres du controller
    $layout = 'layout.twig';
    echo $twigRenderer->render($layout, ['page' => $page, 'session_id' => $session_id, 'session_admin' => $session_admin]);
},'accueil');


                                /* ADMINISTRATEUR */
$router->map('GET', '/admin', function() use ($twigRenderer) {
    require_once('../config/requireLoader.php');

    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : NULL;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : NULL;

    $articles = new \blog\controllers\administrateurController(new \blog\repository\administrateurRepository); 
    $commentaires = new \blog\controllers\administrateurController(new \blog\repository\administrateurRepository); 

    // Appeler une méthode du contrôleur
    $articles = $articles->postsIndex();
    $commentaires = $commentaires->CommentairesIndex();
    $page = 'administrateur.twig';

    // Charger la page sans controller
    $layout = 'layout.twig';
    echo $twigRenderer->render($layout, ['page' => $page, 'articles' => $articles, 'commentaires' => $commentaires, 'session_id' => $session_id, 'session_admin' => $session_admin]);
}, 'administrateur');

$router->map('GET', '/admin/validerCommentaire/[i:id]', function($id) use ($twigRenderer) {
    require_once('../config/requireLoader.php');

    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : NULL;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : NULL;

    $controller = new \blog\controllers\validerCommentaireController(new \blog\repository\validerCommentaireRepository); 

    // Appeler une méthode du contrôleur
    $controller = $controller->update($id);
    $page = 'administrateur.twig';

    $layout = 'layout.twig';
    echo $twigRenderer->render($layout, ['page' => $page, 'articles' => $articles, 'session_id' => $session_id, 'session_admin' => $session_admin]);
}, 'validerCommentaire');

$router->map('GET', '/admin/refuserCommentaire/[i:id_commentaire]', function($id_commentaire) use ($twigRenderer) {
    require_once('../config/requireLoader.php');

    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : NULL;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : NULL;

    $article = new \blog\controllers\commentaireController(new \blog\repository\commentaireRepository); 

    // Appeler une méthode du contrôleur
    $article = $article->index($id_commentaire);

    // var_dump($commentaire);

    $page = 'refuserCommentaire.twig';

    $layout = 'layout.twig';
    echo $twigRenderer->render($layout, ['page' => $page, 'article' => $article, 'session_id' => $session_id, 'session_admin' => $session_admin]);
}, 'refuserCommentaire');

// $router->map('GET', '/admin/refuserCommentaire-confirme/[i:id]', function($id) use ($twigRenderer) {
//     require_once('../config/requireLoader.php');

//     $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : NULL;
//     $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : NULL;

//     $controller = new \blog\controllers\refuserCommentaireController(new \blog\repository\refuserCommentaireRepository); 

//     // Appeler une méthode du contrôleur
//     $controller = $controller->delete($id);
//     $page = 'refuserCommentaire.twig';

//     // Charger la page sans controller
//     $layout = 'layout.twig';
//     echo $twigRenderer->render($layout, ['page' => $page, 'articles' => $articles, 'session_id' => $session_id, 'session_admin' => $session_admin]);
// }, 'refuserCommentaire-confirme');


                                /* CONNEXION */
$router->map('GET', '/inscription', function() use ($twigRenderer) {
    require_once('../config/requireLoader.php');
    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : NULL;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : NULL;


    $page = 'inscription.twig';

    // Charger la page sans controller
    $layout = 'layout.twig';
    echo $twigRenderer->render($layout, ['page' => $page, 'session_id' => $session_id, 'session_admin' => $session_admin]);
}, 'inscription');



$router->map('POST', '/inscription-confirme', function() use ($twigRenderer) {
    require_once('../config/requireLoader.php');
    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : NULL;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : NULL;
    
    $controller = new \blog\controllers\inscriptionController(new \blog\repository\inscriptionRepository);

    // Appeler une méthode du contrôleur
    $result = $controller->create();
    $page = 'accueil.twig';

    // Charger la page avec les paramètres du controller
    $layout = 'layout.twig';
    echo $twigRenderer->render($layout, ['result' => $result, 'page' => $page, 'session_id' => $session_id, 'session_admin' => $session_admin]);
}, 'inscription-confirme');



$router->map('GET', '/connexion', function() use ($twigRenderer) {
    require_once('../config/requireLoader.php');
    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : NULL;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : NULL;
    $page = 'connexion.twig';

    // Charger la page sans controller
    $layout = 'layout.twig';
    echo $twigRenderer->render($layout, ['page' => $page, 'session_id' => $session_id, 'session_admin' => $session_admin]);
}, 'connexion');



$router->map('POST', '/connexion-confirme', function() use ($twigRenderer) {
    require_once('../config/requireLoader.php');
    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : NULL;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : NULL;
    
    $controller = new \blog\controllers\connexionController(new \blog\repository\connexionRepository, new \blog\service\validateService);

    // Appeler une méthode du contrôleur
    $result = $controller->index();
    $page = 'accueil.twig';

    // Charger la page avec les paramètres du controller
    $layout = 'layout.twig';
    echo $twigRenderer->render($layout, ['result' => $result, 'page' => $page, 'session_id' => $session_id, 'session_admin' => $session_admin]);
}, 'connexion-confirme');



$router->map('GET', '/deconnexion', function() use ($twigRenderer) {
    require_once('../config/requireLoader.php');
    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : NULL;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : NULL;
    $page = 'deconnexion.twig';

    // Charger la page sans controller
    $layout = 'layout.twig';
    echo $twigRenderer->render($layout, ['page' => $page, 'session_id' => $session_id, 'session_admin' => $session_admin]);
}, 'deconnexion');



$router->map('POST', '/deconnexion-confirme', function() use ($twigRenderer) {
    require_once('../config/requireLoader.php');

    session_destroy();

    header("Location: /blog/public/");
}, 'deconnexion-confirme');


                                /* CONTACT */
$router->map('POST', '/contact', function() use ($twigRenderer) {
    require_once('../config/requireLoader.php');
    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : NULL;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : NULL;
    
    $controller = new \blog\controllers\contactController(new PHPMailer);

    // Appeler une méthode du contrôleur
    $result = $controller->index();
    $page = 'accueil.twig';

    // Charger la page avec les paramètres du controller
    $layout = 'layout.twig';
    echo $twigRenderer->render($layout, ['result' => $result, 'page' => $page, 'session_id' => $session_id, 'session_admin' => $session_admin]);
}, 'contact');


                                /* POSTS */
$router->map('GET', '/all-posts', function() use ($twigRenderer) {
    require_once('../config/requireLoader.php');
    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : NULL;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : NULL;

    $controller = new \blog\controllers\allPostsController(new \blog\repository\allPostsRepository); 

    // Appeler une méthode du contrôleur
    $params = $controller->index();
    $page = 'allPosts.twig';

    // Charger la page avec les paramètres du controller
    $layout = 'layout.twig';
    echo $twigRenderer->render($layout, ['params' => $params, 'page' => $page, 'session_id' => $session_id, 'session_admin' => $session_admin]);
}, 'allPosts');



$router->map('GET', '/post/[i:id]', function($id) use ($twigRenderer) {
    require_once('../config/requireLoader.php');
    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : NULL;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : NULL;

    $articles = new \blog\controllers\postController(new \blog\repository\postRepository); 
    $commentaires = new \blog\controllers\commentaireController(new \blog\repository\commentaireRepository); 

    // Appeler une méthode du contrôleur
    $articles = $articles->index($id);
    $commentaires = $commentaires->index_all($id);



    $page = 'post.twig';


    // Charger la page avec les paramètres du controller
    $layout = 'layout.twig';
    echo $twigRenderer->render($layout, ['articles' => $articles, 'commentaires' => $commentaires, 'page' => $page, 'session_id' => $session_id, 'session_admin' => $session_admin]);
}, 'post');


$router->map('GET', '/add-post', function() use ($twigRenderer) {
    require_once('../config/requireLoader.php');
    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : NULL;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : NULL;

    $page = 'addPost.twig';

    // Charger la page avec les paramètres du controller
    $layout = 'layout.twig';
    echo $twigRenderer->render($layout, ['page' => $page, 'session_id' => $session_id, 'session_admin' => $session_admin]);
}, 'addPost');



$router->map('POST', '/add-post-confirme', function() use ($twigRenderer) {
    require_once('../config/requireLoader.php');
    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : NULL;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : NULL;
    
    $controller = new \blog\controllers\addPostController(new \blog\repository\addPostRepository, new \blog\service\validateService);

    // Appeler une méthode du contrôleur
    $result = $controller->create();
    $page = 'addPost.twig';

    // var_dump($params); 

    // Charger la page avec les paramètres du controller
    $layout = 'layout.twig';
    echo $twigRenderer->render($layout, ['result' => $result, 'page' => $page, 'session_id' => $session_id, 'session_admin' => $session_admin]);
}, 'addPost-confirme');



$router->map('GET', '/modify-post/[i:id]', function($id) use ($twigRenderer) {
    require_once('../config/requireLoader.php');
    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : NULL;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : NULL;

    $controller = new \blog\controllers\postController(new \blog\repository\postRepository); 

    // Appeler une méthode du contrôleur
    $params = $controller->index($id);
    $page = 'modifyPost.twig';

    // Charger la page avec les paramètres du controller
    $layout = 'layout.twig';
    echo $twigRenderer->render($layout, ['params' => $params, 'page' => $page, 'session_id' => $session_id, 'session_admin' => $session_admin]);
}, 'modifyPost');



$router->map('POST', '/modify-post-confirme/[i:id]', function($id) use ($twigRenderer) {
    require_once('../config/requireLoader.php');
    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : NULL;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : NULL;
    
    $controller = new \blog\controllers\modifyPostController(new \blog\repository\modifyPostRepository, new \blog\service\validateService);

    // Appeler une méthode du contrôleur
    $result = $controller->update($id);
    $page = 'modifyPost.twig';

    // var_dump($params); 

    // Charger la page avec les paramètres du controller
    $layout = 'layout.twig';
    echo $twigRenderer->render($layout, ['result' => $result, 'page' => $page, 'session_id' => $session_id, 'session_admin' => $session_admin]);
}, 'modifyPost-confirme');



$router->map('GET', '/delete-post/[i:id]', function($id) use ($twigRenderer) {
    require_once('../config/requireLoader.php');
    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : NULL;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : NULL;

    $controller = new \blog\controllers\postController(new \blog\repository\postRepository); 

    // Appeler une méthode du contrôleur
    $params = $controller->index($id);
    $page = 'deletePost.twig';

    // Charger la page avec les paramètres du controller
    $layout = 'layout.twig';
    echo $twigRenderer->render($layout, ['params' => $params, 'page' => $page, 'session_id' => $session_id, 'session_admin' => $session_admin]);
}, 'deletePost');



$router->map('POST', '/delete-post-confirme/[i:id]', function($id) use ($twigRenderer) {
    require_once('../config/requireLoader.php');
    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : NULL;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : NULL;
    
    $controller = new \blog\controllers\deletePostController(new \blog\repository\deletePostRepository, new \blog\service\validateService);

    // Appeler une méthode du contrôleur
    $result = $controller->delete($id);
    $page = 'deletePost.twig';

    // var_dump($params); 

    // Charger la page avec les paramètres du controller
    $layout = 'layout.twig';
    echo $twigRenderer->render($layout, ['result' => $result, 'page' => $page, 'session_id' => $session_id, 'session_admin' => $session_admin]);
}, 'deletePost-confirme');


                                    /* COMMENTAIRE */
$router->map('POST', '/add-commentaire/[i:id]', function($id) use ($twigRenderer) {
    require_once('../config/requireLoader.php');
    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : NULL;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : NULL;
    
    $controller = new \blog\controllers\addCommentaireController(new \blog\repository\addCommentaireRepository, new \blog\service\validateService);

    // Appeler une méthode du contrôleur
    $result = $controller->create($id);
    $page = 'addCommentaire.twig';

    // var_dump($params); 

    // Charger la page avec les paramètres du controller
    $layout = 'layout.twig';
    echo $twigRenderer->render($layout, ['result' => $result, 'page' => $page, 'session_id' => $session_id, 'session_admin' => $session_admin]);
}, 'addCommentaire');



$router->map('GET', '/modify-commentaire/[i:id_post]-[i:id_commentaire]', function($id_post, $id_commentaire) use ($twigRenderer) {
    require_once('../config/requireLoader.php');
    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : NULL;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : NULL;

    $articles = new \blog\controllers\postController(new \blog\repository\postRepository); 
    $allCommentaires = new \blog\controllers\commentaireController(new \blog\repository\commentaireRepository); 
    $commentaire = new \blog\controllers\commentaireController(new \blog\repository\commentaireRepository); 

    // Appeler une méthode du contrôleur
    $articles = $articles->index($id_post);
    $commentaires = $allCommentaires->index_all($id_post);
    $modify_commentaire = $commentaire->index($id_commentaire);

    // var_dump($modify_commentaire);

    $page = 'modifyCommentaire.twig';

    // Charger la page avec les paramètres du controller
    $layout = 'layout.twig';
    echo $twigRenderer->render($layout, ['articles' => $articles, 'commentaires' => $commentaires, 'modify_commentaire' => $modify_commentaire, 'page' => $page, 'session_id' => $session_id, 'session_admin' => $session_admin]);
}, 'modifyCommentaire');



$router->map('POST', '/modify-commentaire-confirme/[i:id_post]-[i:id_commentaire]', function($id_post, $id_commentaire) use ($twigRenderer) {
    require_once('../config/requireLoader.php');
    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : NULL;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : NULL;
    
    $controller = new \blog\controllers\modifyCommentaireController(new \blog\repository\modifyCommentaireRepository, new \blog\service\validateService);

    // Appeler une méthode du contrôleur
    $result = $controller->update($id_commentaire, $id_post);
    $page = 'modifyCommentaire.twig';

    // var_dump($params); 

    // Charger la page avec les paramètres du controller
    $layout = 'layout.twig';
    echo $twigRenderer->render($layout, ['result' => $result, 'page' => $page, 'session_id' => $session_id, 'session_admin' => $session_admin]);
}, 'modifyCommentaire-confirme');



$router->map('GET', '/delete-commentaire/[i:id_post]-[i:id_commentaire]', function($id_post, $id_commentaire) use ($twigRenderer) {
    require_once('../config/requireLoader.php');
    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : NULL;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : NULL;

    $article = new \blog\controllers\postController(new \blog\repository\postRepository); 
    $commentaire = new \blog\controllers\CommentaireController(new \blog\repository\CommentaireRepository); 

    // Appeler une méthode du contrôleur
    $article = $article->index($id_post);
    $commentaire = $commentaire->index($id_commentaire);
    $page = 'deleteCommentaire.twig';

    // Charger la page avec les paramètres du controller
    $layout = 'layout.twig';
    echo $twigRenderer->render($layout, ['article' => $article, 'commentaire' => $commentaire, 'page' => $page, 'session_id' => $session_id, 'session_admin' => $session_admin]);
}, 'deleteCommentaire');



$router->map('POST', '/delete-commentaire-confirme/[i:id_post]-[i:id_commentaire]', function($id_post, $id_commentaire) use ($twigRenderer) {
    require_once('../config/requireLoader.php');
    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : NULL;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : NULL;
    
    $controller = new \blog\controllers\deleteCommentaireController(new \blog\repository\deleteCommentaireRepository, new \blog\service\validateService);

    // Appeler une méthode du contrôleur
    $result = $controller->delete($id_post, $id_commentaire);
    $page = 'deleteCommentaire.twig';

    // var_dump($params); 

    // Charger la page avec les paramètres du controller
    $layout = 'layout.twig';
    echo $twigRenderer->render($layout, ['result' => $result, 'page' => $page, 'session_id' => $session_id, 'session_admin' => $session_admin]);
}, 'deleteCommentaire-confirme');




$match = $router->match();

// var_dump($match);

if(is_array($match)) {
    
    if(is_array($match) && is_callable( $match['target'])) {
        call_user_func_array($match['target'], $match['params']);
    }
    else {
        $session = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : NULL;
        $page = $match['name'] . '.twig';
        $layout = 'layout.twig';
        echo $twigRenderer->render($layout, ['page' => $page, 'session' => $session]);
    }

} 
?>