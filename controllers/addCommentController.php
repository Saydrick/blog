<?php

namespace blog\controllers;

use blog\repository\addCommentRepository;
use blog\service\validateService;
use blog\Exceptions\Exception;

class addCommentController {

    protected addCommentRepository $_addCommentRepository;
    protected validateService $_validateService;

    function __construct(addCommentRepository $addCommentRepository, validateService $validateService) {
        $this->_addCommentRepository = $addCommentRepository;
        $this->_validateService = $validateService;
    }

    function create($id_post) {
        try {
            if(isset($_POST['envoyer'])) {

                // If token is not difined OR if post token is different from the session token
                if (!$_POST['token'] || $_POST['token'] !== $_SESSION['TOKEN']) {
                    // show an error message
                    echo '<p class="error">Error: invalid form submission</p>';
                    // return 405 http status code
                    header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
                    exit;
                }
                
                $formRules = [
                    'commentaire' => ['type' => 'required', 'message' => 'Veuillez écrire un commentaire avant de valider']
                ];
            
                $this->_validateService->formValidate($_POST, $formRules);

                $comment = strip_tags($_POST['commentaire']);

                $result = $this->_addCommentRepository->addComment($comment, $id_post);      

                header("Location: /blog/public/post/" . $result);
                exit;                       
            }
                        
        } catch (Exception $e) {
            $result = 'Erreur : ' . $e->errorMessage();
        }

        // return $result;
    }

}