<?php

/*
- Traduction des champs dans les tables SQL ?
- Traduction des champs dans le code ? ('date_modification' => 'modification_date')
- Traduction des classes CSS ?


*/

session_start();

use PHPMailer\PHPMailer\PHPMailer;

require_once('../config/requireLoader.php');

$twigRenderer = new \blog\config\TwigRenderer(__DIR__.'/../views');

$router = new AltoRouter();         
$router->setBasePath('/blog/public');


                                /* HOMEPAGE */
$router->map('GET', '/', function() use ($twigRenderer) {
    require_once('../config/requireLoader.php');

    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : NULL;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : NULL;

    $page = 'homepage.twig';

    // Load page without controller settings
    $layout = 'layout.twig';
    echo $twigRenderer->render($layout, ['page' => $page, 'session_id' => $session_id, 'session_admin' => $session_admin]);
},'homepage');


                                /* ADMINISTRATOR */
$router->map('GET', '/admin', function() use ($twigRenderer) {
    require_once('../config/requireLoader.php');

    // Retrieving the SESSION superglobal variable
    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : NULL;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : NULL;

    // Class instantiation
    $posts = new \blog\controllers\administratorController(new \blog\repository\administratorRepository); 
    $comments = new \blog\controllers\administratorController(new \blog\repository\administratorRepository); 

    // Call a controller method
    $posts = $posts->postsIndex();
    $comments = $comments->CommentsIndex();
    $page = 'administrator.twig';

    // Load page with controller settings
    $layout = 'layout.twig';
    echo $twigRenderer->render($layout, ['page' => $page, 'posts' => $posts, 'comments' => $comments, 'session_id' => $session_id, 'session_admin' => $session_admin]);
}, 'administrator');

$router->map('GET', '/admin/validateComment/[i:id]', function($id) use ($twigRenderer) {
    require_once('../config/requireLoader.php');

    // Retrieving the SESSION superglobal variable
    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : NULL;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : NULL;

    // Class instantiation
    $controller = new \blog\controllers\validateCommentController(new \blog\repository\validateCommentRepository); 

    // Call a controller method
    $controller = $controller->update($id);
    $page = 'administrator.twig';

    // Load page with controller settings
    $layout = 'layout.twig';
    echo $twigRenderer->render($layout, ['page' => $page, 'session_id' => $session_id, 'session_admin' => $session_admin]);
}, 'validerComment');

$router->map('GET', '/admin/denyComment/[i:id_comment]', function($id_comment) use ($twigRenderer) {
    require_once('../config/requireLoader.php');

    // Retrieving the SESSION superglobal variable
    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : NULL;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : NULL;

    // Class instantiation
    $comment = new \blog\controllers\commentController(new \blog\repository\commentRepository); 

    // Call a controller method
    $comment = $comment->index($id_comment);

    // var_dump($comment);

    $page = 'denyComment.twig';

    //Load page with controller settings
    $layout = 'layout.twig';
    echo $twigRenderer->render($layout, ['page' => $page, 'comment' => $comment, 'session_id' => $session_id, 'session_admin' => $session_admin]);
}, 'denyComment');

$router->map('GET', '/admin/denyComment-confirm/[i:id]', function($id) use ($twigRenderer) {
    require_once('../config/requireLoader.php');

    // Retrieving the SESSION superglobal variable
    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : NULL;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : NULL;

    // Class instantiation
    $controller = new \blog\controllers\denyCommentController(new \blog\repository\denyCommentRepository); 

    // Call a controller method
    $controller = $controller->delete($id);
    $page = 'denyComment.twig';

    //Load page without controller settings
    $layout = 'layout.twig';
    echo $twigRenderer->render($layout, ['page' => $page, 'session_id' => $session_id, 'session_admin' => $session_admin]);
}, 'denyComment-confirm');


                                /* LOGIN */
$router->map('GET', '/register', function() use ($twigRenderer) {
    require_once('../config/requireLoader.php');

    // Retrieving the SESSION superglobal variable
    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : NULL;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : NULL;


    $page = 'register.twig';

    //Load page without controller settings
    $layout = 'layout.twig';
    echo $twigRenderer->render($layout, ['page' => $page, 'session_id' => $session_id, 'session_admin' => $session_admin]);
}, 'register');



$router->map('POST', '/register-confirm', function() use ($twigRenderer) {
    require_once('../config/requireLoader.php');

    // Retrieving the SESSION superglobal variable
    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : NULL;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : NULL;
    
    // Class instantiation
    $controller = new \blog\controllers\registerController(new \blog\repository\registerRepository, new \blog\service\validateService);

    // Call a controller method
    $result = $controller->create();
    $page = 'homepage.twig';

    //Load page with controller settings
    $layout = 'layout.twig';
    echo $twigRenderer->render($layout, ['page' => $page, 'result' => $result, 'session_id' => $session_id, 'session_admin' => $session_admin]);
}, 'register-confirm');



$router->map('GET', '/login', function() use ($twigRenderer) {
    require_once('../config/requireLoader.php');
    
    // Retrieving the SESSION superglobal variable
    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : NULL;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : NULL;
    
    $page = 'login.twig';

    //Load page without controller settings
    $layout = 'layout.twig';
    echo $twigRenderer->render($layout, ['page' => $page, 'session_id' => $session_id, 'session_admin' => $session_admin]);
}, 'login');



$router->map('POST', '/login-confirm', function() use ($twigRenderer) {
    require_once('../config/requireLoader.php');
    
    // Retrieving the SESSION superglobal variable
    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : NULL;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : NULL;
    
    // Class instantiation
    $controller = new \blog\controllers\loginController(new \blog\repository\loginRepository, new \blog\service\validateService);

    // Call a controller method
    $result = $controller->index();
    $page = 'homepage.twig';

    //Load page with controller settings
    $layout = 'layout.twig';
    echo $twigRenderer->render($layout, ['page' => $page, 'result' => $result, 'session_id' => $session_id, 'session_admin' => $session_admin]);
}, 'login-confirm');



$router->map('GET', '/signOut', function() use ($twigRenderer) {
    require_once('../config/requireLoader.php');
    
    // Retrieving the SESSION superglobal variable
    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : NULL;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : NULL;
    
    $page = 'signOut.twig';

    //Load page without controller settings
    $layout = 'layout.twig';
    echo $twigRenderer->render($layout, ['page' => $page, 'session_id' => $session_id, 'session_admin' => $session_admin]);
}, 'signOut');



$router->map('POST', '/signOut-confirm', function() use ($twigRenderer) {
    require_once('../config/requireLoader.php');

    session_destroy();

    header("Location: /blog/public/");
}, 'signOut-confirm');


                                /* CONTACT */
$router->map('POST', '/contact', function() use ($twigRenderer) {
    require_once('../config/requireLoader.php');
    
    // Retrieving the SESSION superglobal variable
    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : NULL;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : NULL;
    
    // Class instantiation
    $controller = new \blog\controllers\contactController(new PHPMailer, new \blog\service\validateService);

    // Call a controller method
    $result = $controller->index();
    $page = 'homepage.twig';

    //Load page with controller settings
    $layout = 'layout.twig';
    echo $twigRenderer->render($layout, ['page' => $page, 'result' => $result, 'session_id' => $session_id, 'session_admin' => $session_admin]);
}, 'contact');


                                /* POSTS */
$router->map('GET', '/all-posts', function() use ($twigRenderer) {
    require_once('../config/requireLoader.php');
    
    // Retrieving the SESSION superglobal variable
    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : NULL;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : NULL;

    // Class instantiation
    $controller = new \blog\controllers\allPostsController(new \blog\repository\allPostsRepository); 

    // Call a controller method
    $posts = $controller->index();
    $page = 'allPosts.twig';

    //Load page with controller settings
    $layout = 'layout.twig';
    echo $twigRenderer->render($layout, ['page' => $page, 'posts' => $posts, 'session_id' => $session_id, 'session_admin' => $session_admin]);
}, 'allPosts');



$router->map('GET', '/post/[i:id]', function($id) use ($twigRenderer) {
    require_once('../config/requireLoader.php');
    
    // Retrieving the SESSION superglobal variable
    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : NULL;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : NULL;

    // Class instantiation
    $posts = new \blog\controllers\postController(new \blog\repository\postRepository); 
    $comments = new \blog\controllers\commentController(new \blog\repository\commentRepository); 

    // Call a controller method
    $posts = $posts->index($id);
    $comments = $comments->index_all($id);

    $page = 'post.twig';

    //Load page with controller settings
    $layout = 'layout.twig';
    echo $twigRenderer->render($layout, ['page' => $page, 'posts' => $posts, 'comments' => $comments, 'session_id' => $session_id, 'session_admin' => $session_admin]);
}, 'post');


$router->map('GET', '/add-post', function() use ($twigRenderer) {
    require_once('../config/requireLoader.php');
    
    // Retrieving the SESSION superglobal variable
    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : NULL;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : NULL;

    $page = 'addPost.twig';

    //Load page without controller settings
    $layout = 'layout.twig';
    echo $twigRenderer->render($layout, ['page' => $page, 'session_id' => $session_id, 'session_admin' => $session_admin]);
}, 'addPost');



$router->map('POST', '/add-post-confirm', function() use ($twigRenderer) {
    require_once('../config/requireLoader.php');
    
    // Retrieving the SESSION superglobal variable
    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : NULL;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : NULL;
    
    // Class instantiation
    $controller = new \blog\controllers\addPostController(new \blog\repository\addPostRepository, new \blog\service\validateService);

    // Call a controller method
    $result = $controller->create();
    $page = 'addPost.twig';

    //Load page with controller settings
    $layout = 'layout.twig';
    echo $twigRenderer->render($layout, ['page' => $page, 'result' => $result, 'session_id' => $session_id, 'session_admin' => $session_admin]);
}, 'addPost-confirm');



$router->map('GET', '/modify-post/[i:id]', function($id) use ($twigRenderer) {
    require_once('../config/requireLoader.php');
    
    // Retrieving the SESSION superglobal variable
    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : NULL;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : NULL;

    // Class instantiation
    $controller = new \blog\controllers\postController(new \blog\repository\postRepository); 

    // Call a controller method
    $posts = $controller->index($id);
    $page = 'modifyPost.twig';

    //Load page with controller settings
    $layout = 'layout.twig';
    echo $twigRenderer->render($layout, ['page' => $page, 'posts' => $posts, 'session_id' => $session_id, 'session_admin' => $session_admin]);
}, 'modifyPost');



$router->map('POST', '/modify-post-confirm/[i:id]', function($id) use ($twigRenderer) {
    require_once('../config/requireLoader.php');
    
    // Retrieving the SESSION superglobal variable
    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : NULL;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : NULL;
    
    // Class instantiation
    $controller = new \blog\controllers\modifyPostController(new \blog\repository\modifyPostRepository, new \blog\service\validateService);

    // Call a controller method
    $result = $controller->update($id);
    $page = 'modifyPost.twig';

    //Load page with controller settings
    $layout = 'layout.twig';
    echo $twigRenderer->render($layout, ['page' => $page, 'result' => $result, 'session_id' => $session_id, 'session_admin' => $session_admin]);
}, 'modifyPost-confirm');



$router->map('GET', '/delete-post/[i:id]', function($id) use ($twigRenderer) {
    require_once('../config/requireLoader.php');
    
    // Retrieving the SESSION superglobal variable
    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : NULL;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : NULL;

    // Class instantiation
    $controller = new \blog\controllers\postController(new \blog\repository\postRepository); 

    // Call a controller method
    $posts = $controller->index($id);
    $page = 'deletePost.twig';

    //Load page with controller settings
    $layout = 'layout.twig';
    echo $twigRenderer->render($layout, ['page' => $page, 'posts' => $posts, 'session_id' => $session_id, 'session_admin' => $session_admin]);
}, 'deletePost');



$router->map('POST', '/delete-post-confirm/[i:id]', function($id) use ($twigRenderer) {
    require_once('../config/requireLoader.php');
    
    // Retrieving the SESSION superglobal variable
    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : NULL;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : NULL;
    
    // Class instantiation
    $controller = new \blog\controllers\deletePostController(new \blog\repository\deletePostRepository);

    // Call a controller method
    $result = $controller->delete($id);
    $page = 'deletePost.twig';

    //Load page with controller settings
    $layout = 'layout.twig';
    echo $twigRenderer->render($layout, ['page' => $page, 'result' => $result, 'session_id' => $session_id, 'session_admin' => $session_admin]);
}, 'deletePost-confirm');


                                    /* COMMENT */
$router->map('POST', '/add-comment/[i:id]', function($id) use ($twigRenderer) {
    require_once('../config/requireLoader.php');
    
    // Retrieving the SESSION superglobal variable
    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : NULL;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : NULL;
    
    // Class instantiation
    $controller = new \blog\controllers\addCommentController(new \blog\repository\addCommentRepository, new \blog\service\validateService);

    // Call a controller method
    $result = $controller->create($id);
    $page = 'addComment.twig'; /* TODO Pourquoi ? */

    //Load page with controller settings
    $layout = 'layout.twig';
    echo $twigRenderer->render($layout, ['page' => $page, 'result' => $result, 'session_id' => $session_id, 'session_admin' => $session_admin]);
}, 'addComment');



$router->map('GET', '/modify-comment/[i:id_post]-[i:id_comment]', function($id_post, $id_comment) use ($twigRenderer) {
    require_once('../config/requireLoader.php');
    
    // Retrieving the SESSION superglobal variable
    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : NULL;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : NULL;

    // Class instantiation
    $post = new \blog\controllers\postController(new \blog\repository\postRepository); 
    $allComments = new \blog\controllers\commentController(new \blog\repository\commentRepository); 
    $comment = new \blog\controllers\commentController(new \blog\repository\commentRepository); 

    // Call a controller method
    $post = $post->index($id_post);
    $comments = $allComments->index_all($id_post);
    $modify_comment = $comment->index($id_comment);

    $page = 'modifyComment.twig';

    //Load page with controller settings
    $layout = 'layout.twig';
    echo $twigRenderer->render($layout, ['page' => $page, 'post' => $post, 'comments' => $comments, 'modify_comment' => $modify_comment, 'session_id' => $session_id, 'session_admin' => $session_admin]);
}, 'modifyComment');



$router->map('POST', '/modify-comment-confirm/[i:id_post]-[i:id_comment]', function($id_post, $id_comment) use ($twigRenderer) {
    require_once('../config/requireLoader.php');
    
    // Retrieving the SESSION superglobal variable
    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : NULL;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : NULL;
    
    // Class instantiation
    $controller = new \blog\controllers\modifyCommentController(new \blog\repository\modifyCommentRepository, new \blog\service\validateService);

    // Call a controller method
    $result = $controller->update($id_comment, $id_post);
    $page = 'modifyComment.twig';

    //Load page with controller settings
    $layout = 'layout.twig';
    echo $twigRenderer->render($layout, ['page' => $page, 'result' => $result, 'session_id' => $session_id, 'session_admin' => $session_admin]);
}, 'modifyComment-confirm');



$router->map('GET', '/delete-comment/[i:id_post]-[i:id_comment]', function($id_post, $id_comment) use ($twigRenderer) {
    require_once('../config/requireLoader.php');
    
    // Retrieving the SESSION superglobal variable
    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : NULL;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : NULL;

    // Class instantiation
    $post = new \blog\controllers\postController(new \blog\repository\postRepository); 
    $comment = new \blog\controllers\CommentController(new \blog\repository\CommentRepository); 

    // Call a controller method
    $post = $post->index($id_post);
    $comment = $comment->index($id_comment);
    $page = 'deleteComment.twig';

    //Load page with controller settings
    $layout = 'layout.twig';
    echo $twigRenderer->render($layout, ['page' => $page, 'post' => $post, 'comment' => $comment, 'session_id' => $session_id, 'session_admin' => $session_admin]);
}, 'deleteComment');



$router->map('POST', '/delete-comment-confirm/[i:id_post]-[i:id_comment]', function($id_post, $id_comment) use ($twigRenderer) {
    require_once('../config/requireLoader.php');
    
    // Retrieving the SESSION superglobal variable
    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : NULL;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : NULL;
    
    // Class instantiation
    $controller = new \blog\controllers\deleteCommentController(new \blog\repository\deleteCommentRepository, new \blog\service\validateService);

    // Call a controller method
    $result = $controller->delete($id_post, $id_comment);
    $page = 'deleteComment.twig';

    //Load page with controller settings
    $layout = 'layout.twig';
    echo $twigRenderer->render($layout, ['page' => $page, 'result' => $result, 'session_id' => $session_id, 'session_admin' => $session_admin]);
}, 'deleteComment-confirm');




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