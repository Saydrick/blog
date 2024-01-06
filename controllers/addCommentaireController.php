<?php

namespace blog\controllers;

use blog\repository\addCommentaireRepository;
use blog\service\validateService;
use blog\Exceptions\Exception;

class addCommentaireController {

    protected addCommentaireRepository $_addCommentaireRepository;
    protected validateService $_validateService;

    function __construct(addCommentaireRepository $addCommentaireRepository, validateService $validateService) {
        $this->_addCommentaireRepository = $addCommentaireRepository;
        $this->_validateService = $validateService;
    }

    function create($id_post) {
        try {
            if(isset($_POST['envoyer'])) {

                $formRules = [
                    'commentaire' => ['type' => 'required', 'message' => 'Veuillez écrire un commentaire avant de valider']
                ];
            
                $this->_validateService->formValidate($_POST, $formRules);

                $commentaire = $_POST['commentaire'];

                $result = $this->_addCommentaireRepository->addCommentaire($commentaire, $id_post);      

                header("Location: /blog/public/post/" . $result);
                exit;                       
            }
                        
        } catch (Exception $e) {
            $result = 'Erreur : ' . $e->errorMessage();
        }

        // return $result;
    }

}