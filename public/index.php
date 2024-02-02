<?php

session_start();

use AltoRouter;
use PHPMailer\PHPMailer\PHPMailer;
use blog\controllers\AdministratorController;

require_once('../config/RequireLoader.php');

if (!isset($_SESSION['TOKEN'])) {
    $_SESSION['TOKEN'] = bin2hex(openssl_random_pseudo_bytes(6));
}

$twigRenderer = new \blog\config\TwigRenderer(__DIR__ . '/../views');

$router = new AltoRouter();
$router->setBasePath('/blog/public');


                                /* HOMEPAGE */
$router->map('GET', '/', function () use ($twigRenderer) {
    require_once('../config/RequireLoader.php');

    $session_token = $_SESSION['TOKEN'];
    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : null;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : null;

    $page = 'homepage.twig';

    // Load page without controller settings
    $layout = 'layout.twig';
    echo $twigRenderer->render(
        $layout,
        ['page' => $page,
        'session_token' => $session_token,
        'session_id' => $session_id,
        'session_admin' => $session_admin
        ]
    );
}, 'homepage');


                                /* ADMINISTRATOR */
$router->map('GET', '/admin', function () use ($twigRenderer) {
    require_once('../config/RequireLoader.php');

    // Retrieving the SESSION superglobal variable
    $session_token = $_SESSION['TOKEN'];
    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : null;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : null;

    // Class instantiation
    $posts = new AdministratorController(new \blog\repository\AdministratorRepository());
    $comments = new \blog\controllers\AdministratorController(new \blog\repository\AdministratorRepository());

    // Call a controller method
    $posts = $posts->postsIndex();
    $comments = $comments->CommentsIndex();
    $page = 'administrator.twig';

    // Load page with controller settings
    $layout = 'layout.twig';
    echo $twigRenderer->render(
        $layout,
        ['page' => $page,
        'posts' => $posts,
        'comments' => $comments,
        'session_token' => $session_token,
        'session_id' => $session_id,
        'session_admin' => $session_admin
        ]
    );
}, 'administrator');

$router->map('GET', '/admin/validateComment/[i:id]', function ($id) use ($twigRenderer) {
    require_once('../config/RequireLoader.php');

    // Retrieving the SESSION superglobal variable
    $session_token = $_SESSION['TOKEN'];
    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : null;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : null;

    // Class instantiation
    $controller = new \blog\controllers\ValidateCommentController(new \blog\repository\ValidateCommentRepository());

    // Call a controller method
    $controller = $controller->update($id);
    $page = 'administrator.twig';

    // Load page with controller settings
    $layout = 'layout.twig';
    echo $twigRenderer->render(
        $layout,
        ['page' => $page,
        'session_token' => $session_token,
        'session_id' => $session_id,
        'session_admin' => $session_admin
        ]
    );
}, 'validerComment');

$router->map('GET', '/admin/denyComment/[i:id_comment]', function ($id_comment) use ($twigRenderer) {
    require_once('../config/RequireLoader.php');

    // Retrieving the SESSION superglobal variable
    $session_token = $_SESSION['TOKEN'];
    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : null;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : null;

    // Class instantiation
    $controller = new \blog\controllers\CommentController(new \blog\repository\CommentRepository());

    // Call a controller method
    $comments = $controller->index($id_comment);

    // var_dump($comment);

    $page = 'denyComment.twig';

    //Load page with controller settings
    $layout = 'layout.twig';
    echo $twigRenderer->render(
        $layout,
        ['page' => $page,
        'comments' => $comments,
        'session_token' => $session_token,
        'session_id' => $session_id,
        'session_admin' => $session_admin
        ]
    );
}, 'denyComment');


$router->map(
    'POST',
    '/admin/denyComment-confirm/[i:id_comment]-[i:id_user]',
    function ($id_comment, $id_user) use ($twigRenderer) {
        require_once('../config/RequireLoader.php');

        // Retrieving the SESSION superglobal variable
        $session_token = $_SESSION['TOKEN'];
        $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : null;
        $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : null;

        // Class instantiation
        $controller = new \blog\controllers\DenyCommentController(
            new \blog\repository\DenyCommentRepository(),
            new \blog\repository\UserRepository(),
            new PHPMailer(),
            new \blog\service\ValidateService()
        );

        // Call a controller method
        $controller = $controller->delete($id_comment, $id_user);
        $page = 'denyComment.twig';

        //Load page without controller settings
        $layout = 'layout.twig';
        echo $twigRenderer->render(
            $layout,
            ['page' => $page,
            'session_token' => $session_token,
            'session_id' => $session_id,
            'session_admin' => $session_admin
            ]
        );
    },
    'denyComment-confirm'
);


                                /* LOGIN */
$router->map('GET', '/register', function () use ($twigRenderer) {
    require_once('../config/RequireLoader.php');

    // Retrieving the SESSION superglobal variable
    $session_token = $_SESSION['TOKEN'];
    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : null;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : null;


    $page = 'register.twig';

    //Load page without controller settings
    $layout = 'layout.twig';
    echo $twigRenderer->render(
        $layout,
        ['page' => $page,
        'session_token' => $session_token,
        'session_id' => $session_id,
        'session_admin' => $session_admin
        ]
    );
}, 'register');



$router->map('POST', '/register-confirm', function () use ($twigRenderer) {
    require_once('../config/RequireLoader.php');

    // Retrieving the SESSION superglobal variable
    $session_token = $_SESSION['TOKEN'];
    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : null;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : null;

    // Class instantiation
    $controller = new \blog\controllers\RegisterController(
        new \blog\repository\RegisterRepository(),
        new \blog\repository\UserRepository(),
        new \blog\service\ValidateService()
    );

    // Call a controller method
    $result = $controller->create();
    $page = 'homepage.twig';

    //Load page with controller settings
    $layout = 'layout.twig';
    echo $twigRenderer->render(
        $layout,
        ['page' => $page,
        'result' => $result,
        'session_token' => $session_token,
        'session_id' => $session_id,
        'session_admin' => $session_admin
        ]
    );
}, 'register-confirm');



$router->map('GET', '/login', function () use ($twigRenderer) {
    require_once('../config/RequireLoader.php');

    // Retrieving the SESSION superglobal variable
    $session_token = $_SESSION['TOKEN'];
    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : null;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : null;

    $page = 'login.twig';

    //Load page without controller settings
    $layout = 'layout.twig';
    echo $twigRenderer->render(
        $layout,
        ['page' => $page,
        'session_token' => $session_token,
        'session_id' => $session_id,
        'session_admin' => $session_admin
        ]
    );
}, 'login');



$router->map('POST', '/login-confirm', function () use ($twigRenderer) {
    require_once('../config/RequireLoader.php');

    // Retrieving the SESSION superglobal variable
    $session_token = $_SESSION['TOKEN'];
    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : null;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : null;

    // Class instantiation
    $controller = new \blog\controllers\LoginController(
        new \blog\repository\LoginRepository(),
        new \blog\service\ValidateService()
    );

    // Call a controller method
    $result = $controller->index();
    $page = 'homepage.twig';

    //Load page with controller settings
    $layout = 'layout.twig';
    echo $twigRenderer->render(
        $layout,
        ['page' => $page,
        'result' => $result,
        'session_token' => $session_token,
        'session_id' => $session_id,
        'session_admin' => $session_admin
        ]
    );
}, 'login-confirm');



$router->map('GET', '/signOut', function () use ($twigRenderer) {
    require_once('../config/RequireLoader.php');

    // Retrieving the SESSION superglobal variable
    $session_token = $_SESSION['TOKEN'];
    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : null;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : null;

    $page = 'signOut.twig';

    //Load page without controller settings
    $layout = 'layout.twig';
    echo $twigRenderer->render(
        $layout,
        ['page' => $page,
        'session_token' => $session_token,
        'session_id' => $session_id,
        'session_admin' => $session_admin
        ]
    );
}, 'signOut');



$router->map('POST', '/signOut-confirm', function () use ($twigRenderer) {
    require_once('../config/RequireLoader.php');

    session_destroy();

    header("Location: /blog/public/");
}, 'signOut-confirm');


                                /* CONTACT */
$router->map('POST', '/contact', function () use ($twigRenderer) {
    require_once('../config/RequireLoader.php');

    // Retrieving the SESSION superglobal variable
    $session_token = $_SESSION['TOKEN'];
    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : null;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : null;

    // Class instantiation
    $controller = new \blog\controllers\ContactController(new PHPMailer(), new \blog\service\ValidateService());

    // Call a controller method
    $result = $controller->index();
    $page = 'homepage.twig';

    //Load page with controller settings
    $layout = 'layout.twig';
    echo $twigRenderer->render(
        $layout,
        ['page' => $page,
        'result' => $result,
        'session_token' => $session_token,
        'session_id' => $session_id,
        'session_admin' => $session_admin
        ]
    );
}, 'contact');


                                /* POSTS */
$router->map('GET', '/all-posts', function () use ($twigRenderer) {
    require_once('../config/RequireLoader.php');

    // Retrieving the SESSION superglobal variable
    $session_token = $_SESSION['TOKEN'];
    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : null;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : null;

    // Class instantiation
    $controller = new \blog\controllers\AllPostsController(new \blog\repository\AllPostsRepository());

    // Call a controller method
    $posts = $controller->index();
    $page = 'allPosts.twig';

    //Load page with controller settings
    $layout = 'layout.twig';
    echo $twigRenderer->render(
        $layout,
        ['page' => $page,
        'posts' => $posts,
        'session_token' => $session_token,
        'session_id' => $session_id,
        'session_admin' => $session_admin
        ]
    );
}, 'allPosts');



$router->map('GET', '/post/[i:id]', function ($id) use ($twigRenderer) {
    require_once('../config/RequireLoader.php');

    // Retrieving the SESSION superglobal variable
    $session_token = $_SESSION['TOKEN'];
    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : null;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : null;

    // Class instantiation
    $posts = new \blog\controllers\PostController(new \blog\repository\PostRepository());
    $comments = new \blog\controllers\CommentController(new \blog\repository\CommentRepository());

    // Call a controller method
    $posts = $posts->index($id);
    $comments = $comments->indexAll($id);

    $page = 'post.twig';

    //Load page with controller settings
    $layout = 'layout.twig';
    echo $twigRenderer->render(
        $layout,
        ['page' => $page,
        'posts' => $posts,
        'comments' => $comments,
        'session_token' => $session_token,
        'session_id' => $session_id,
        'session_admin' => $session_admin
        ]
    );
}, 'post');


$router->map('GET', '/add-post', function () use ($twigRenderer) {
    require_once('../config/RequireLoader.php');

    // Retrieving the SESSION superglobal variable
    $session_token = $_SESSION['TOKEN'];
    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : null;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : null;

    $page = 'addPost.twig';

    //Load page without controller settings
    $layout = 'layout.twig';
    echo $twigRenderer->render(
        $layout,
        ['page' => $page,
        'session_token' => $session_token,
        'session_id' => $session_id,
        'session_admin' => $session_admin
        ]
    );
}, 'addPost');



$router->map('POST', '/add-post-confirm', function () use ($twigRenderer) {
    require_once('../config/RequireLoader.php');

    // Retrieving the SESSION superglobal variable
    $session_token = $_SESSION['TOKEN'];
    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : null;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : null;

    // Class instantiation
    $controller = new \blog\controllers\AddPostController(
        new \blog\repository\AddPostRepository(),
        new \blog\service\ValidateService()
    );

    // Call a controller method
    $result = $controller->create();
    $page = 'addPost.twig';

    //Load page with controller settings
    $layout = 'layout.twig';
    echo $twigRenderer->render(
        $layout,
        ['page' => $page,
        'result' => $result,
        'session_token' => $session_token,
        'session_id' => $session_id,
        'session_admin' => $session_admin
        ]
    );
}, 'addPost-confirm');



$router->map('GET', '/modify-post/[i:id]', function ($id) use ($twigRenderer) {
    require_once('../config/RequireLoader.php');

    // Retrieving the SESSION superglobal variable
    $session_token = $_SESSION['TOKEN'];
    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : null;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : null;

    // Class instantiation
    $controller = new \blog\controllers\PostController(new \blog\repository\PostRepository());

    // Call a controller method
    $posts = $controller->index($id);
    $page = 'modifyPost.twig';

    //Load page with controller settings
    $layout = 'layout.twig';
    echo $twigRenderer->render(
        $layout,
        ['page' => $page,
        'posts' => $posts,
        'session_token' => $session_token,
        'session_id' => $session_id,
        'session_admin' => $session_admin
        ]
    );
}, 'modifyPost');



$router->map('POST', '/modify-post-confirm/[i:id]', function ($id) use ($twigRenderer) {
    require_once('../config/RequireLoader.php');

    // Retrieving the SESSION superglobal variable
    $session_token = $_SESSION['TOKEN'];
    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : null;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : null;

    // Class instantiation
    $controller = new \blog\controllers\ModifyPostController(
        new \blog\repository\ModifyPostRepository(),
        new \blog\service\ValidateService()
    );

    // Call a controller method
    $result = $controller->update($id);
    $page = 'modifyPost.twig';

    //Load page with controller settings
    $layout = 'layout.twig';
    echo $twigRenderer->render(
        $layout,
        ['page' => $page,
        'result' => $result,
        'session_token' => $session_token,
        'session_id' => $session_id,
        'session_admin' => $session_admin
        ]
    );
}, 'modifyPost-confirm');



$router->map('GET', '/delete-post/[i:id]', function ($id) use ($twigRenderer) {
    require_once('../config/RequireLoader.php');

    // Retrieving the SESSION superglobal variable
    $session_token = $_SESSION['TOKEN'];
    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : null;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : null;

    // Class instantiation
    $controller = new \blog\controllers\PostController(new \blog\repository\PostRepository());

    // Call a controller method
    $posts = $controller->index($id);
    $page = 'deletePost.twig';

    //Load page with controller settings
    $layout = 'layout.twig';
    echo $twigRenderer->render(
        $layout,
        ['page' => $page,
        'posts' => $posts,
        'session_token' => $session_token,
        'session_id' => $session_id,
        'session_admin' => $session_admin
        ]
    );
}, 'deletePost');



$router->map('POST', '/delete-post-confirm/[i:id]', function ($id) use ($twigRenderer) {
    require_once('../config/RequireLoader.php');

    // Retrieving the SESSION superglobal variable
    $session_token = $_SESSION['TOKEN'];
    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : null;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : null;

    // Class instantiation
    $controller = new \blog\controllers\DeletePostController(new \blog\repository\DeletePostRepository());

    // Call a controller method
    $result = $controller->delete($id);
    $page = 'deletePost.twig';

    //Load page with controller settings
    $layout = 'layout.twig';
    echo $twigRenderer->render(
        $layout,
        ['page' => $page,
        'result' => $result,
        'session_token' => $session_token,
        'session_id' => $session_id,
        'session_admin' => $session_admin
        ]
    );
}, 'deletePost-confirm');


                                    /* COMMENT */
$router->map('POST', '/add-comment/[i:id]', function ($id) use ($twigRenderer) {
    require_once('../config/RequireLoader.php');

    // Retrieving the SESSION superglobal variable
    $session_token = $_SESSION['TOKEN'];
    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : null;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : null;

    // Class instantiation
    $controller = new \blog\controllers\AddCommentController(
        new \blog\repository\AddCommentRepository(),
        new \blog\service\ValidateService()
    );

    // Call a controller method
    $result = $controller->create($id);
    $page = 'addComment.twig';

    //Load page with controller settings
    $layout = 'layout.twig';
    echo $twigRenderer->render(
        $layout,
        ['page' => $page,
        'result' => $result,
        'session_token' => $session_token,
        'session_id' => $session_id,
        'session_admin' => $session_admin
        ]
    );
}, 'addComment');



$router->map('GET', '/modify-comment/[i:id_post]-[i:id_comment]', function ($id_post, $id_comment) use ($twigRenderer) {
    require_once('../config/RequireLoader.php');

    // Retrieving the SESSION superglobal variable
    $session_token = $_SESSION['TOKEN'];
    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : null;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : null;

    // Class instantiation
    $post = new \blog\controllers\PostController(new \blog\repository\PostRepository());
    $allComments = new \blog\controllers\CommentController(new \blog\repository\CommentRepository());
    $comment = new \blog\controllers\CommentController(new \blog\repository\CommentRepository());

    // Call a controller method
    $post = $post->index($id_post);
    $comments = $allComments->indexAll($id_post);
    $modify_comment = $comment->index($id_comment);

    $page = 'modifyComment.twig';

    //Load page with controller settings
    $layout = 'layout.twig';
    echo $twigRenderer->render(
        $layout,
        ['page' => $page,
        'post' => $post,
        'comments' => $comments,
        'modify_comment' => $modify_comment,
        'session_token' => $session_token,
        'session_id' => $session_id,
        'session_admin' => $session_admin
        ]
    );
}, 'modifyComment');



$router->map(
    'POST',
    '/modify-comment-confirm/[i:id_post]-[i:id_comment]',
    function ($id_post, $id_comment) use ($twigRenderer) {
        require_once('../config/RequireLoader.php');

    // Retrieving the SESSION superglobal variable
        $session_token = $_SESSION['TOKEN'];
        $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : null;
        $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : null;

    // Class instantiation
        $controller = new \blog\controllers\ModifyCommentController(
            new \blog\repository\ModifyCommentRepository(),
            new \blog\service\ValidateService()
        );

    // Call a controller method
        $result = $controller->update($id_comment, $id_post);
        $page = 'modifyComment.twig';

    //Load page with controller settings
        $layout = 'layout.twig';
        echo $twigRenderer->render(
            $layout,
            ['page' => $page,
            'result' => $result,
            'session_token' => $session_token,
            'session_id' => $session_id,
            'session_admin' => $session_admin
            ]
        );
    },
    'modifyComment-confirm'
);



$router->map('GET', '/delete-comment/[i:id_post]-[i:id_comment]', function ($id_post, $id_comment) use ($twigRenderer) {
    require_once('../config/RequireLoader.php');

    // Retrieving the SESSION superglobal variable
    $session_token = $_SESSION['TOKEN'];
    $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : null;
    $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : null;

    // Class instantiation
    $post = new \blog\controllers\PostController(new \blog\repository\PostRepository());
    $comment = new \blog\controllers\CommentController(new \blog\repository\CommentRepository());

    // Call a controller method
    $post = $post->index($id_post);
    $comment = $comment->index($id_comment);

    $page = 'deleteComment.twig';

    //Load page with controller settings
    $layout = 'layout.twig';
    echo $twigRenderer->render(
        $layout,
        ['page' => $page,
        'post' => $post,
        'comment' => $comment,
        'session_token' => $session_token,
        'session_id' => $session_id,
        'session_admin' => $session_admin
        ]
    );
}, 'deleteComment');



$router->map(
    'POST',
    '/delete-comment-confirm/[i:id_post]-[i:id_comment]',
    function ($id_post, $id_comment) use ($twigRenderer) {
        require_once('../config/RequireLoader.php');

    // Retrieving the SESSION superglobal variable
        $session_token = $_SESSION['TOKEN'];
        $session_id = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : null;
        $session_admin = !empty($_SESSION['USER_ADMIN']) ? $_SESSION['USER_ADMIN'] : null;

    // Class instantiation
        $controller = new \blog\controllers\DeleteCommentController(
            new \blog\repository\DeleteCommentRepository(),
            new \blog\service\ValidateService()
        );

    // Call a controller method
        $result = $controller->delete($id_post, $id_comment);
        $page = 'deleteComment.twig';

    //Load page with controller settings
        $layout = 'layout.twig';
        echo $twigRenderer->render(
            $layout,
            ['page' => $page,
            'result' => $result,
            'session_token' => $session_token,
            'session_id' => $session_id,
            'session_admin' => $session_admin
            ]
        );
    },
    'deleteComment-confirm'
);


$match = $router->match();

// var_dump($match);

if (is_array($match)) {
    if (is_array($match) && is_callable($match['target'])) {
        call_user_func_array($match['target'], $match['params']);
    } else {
        $session = !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : null;
        $page = $match['name'] . '.twig';
        $layout = 'layout.twig';
        echo $twigRenderer->render($layout, ['page' => $page, 'session' => $session]);
    }
}
