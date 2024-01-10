<?php

namespace blog\controllers;

use blog\repository\modifyCommentRepository;
use blog\service\validateService;
use blog\Exceptions\Exception;

class modifyCommentController {

    protected modifyCommentRepository $_modifyCommentRepository;
    protected validateService $_validateService;

    function __construct(modifyCommentRepository $modifyCommentRepository, validateService $validateService) {
        $this->_modifyCommentRepository = $modifyCommentRepository;
        $this->_validateService = $validateService;
    }

    function update($id_comment, $id_post) {
        try {
            if(isset($_POST['envoyer'])) {

                $formRules = [
                    'commentaire' => ['type' => 'required', 'message' => 'Veuillez renseigner le titre de l\'article']
                ];
            
                $this->_validateService->formValidate($_POST, $formRules);

                $comment = $_POST['commentaire']; 

                $result = $this->_modifyCommentRepository->modifyComment($id_comment, $id_post, $comment);      

                header("Location: /blog/public/post/" . $result);
                exit;                       
            }
                        
        } catch (Exception $e) {
            $result = 'Erreur : ' . $e->errorMessage();
        }

        // return $result;
    }

}