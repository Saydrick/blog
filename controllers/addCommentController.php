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

                $formRules = [
                    'commentaire' => ['type' => 'required', 'message' => 'Veuillez écrire un commentaire avant de valider']
                ];
            
                $this->_validateService->formValidate($_POST, $formRules);

                $comment = $_POST['commentaire'];

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