<?php

namespace blog\controllers;

use blog\repository\modifyCommentaireRepository;
use blog\service\validateService;
use blog\Exceptions\Exception;

class modifyCommentaireController {

    protected modifyCommentaireRepository $_modifyCommentaireRepository;
    protected validateService $_validateService;

    function __construct(modifyCommentaireRepository $modifyCommentaireRepository, validateService $validateService) {
        $this->_modifyCommentaireRepository = $modifyCommentaireRepository;
        $this->_validateService = $validateService;
    }

    function update($id_commentaire, $id_post) {
        try {
            if(isset($_POST['envoyer'])) {

                $formRules = [
                    'commentaire' => ['type' => 'required', 'message' => 'Veuillez renseigner le titre de l\'article']
                ];
            
                $this->_validateService->formValidate($_POST, $formRules);

                $commentaire = $_POST['commentaire']; 

                $result = $this->_modifyCommentaireRepository->modifyCommentaire($id_commentaire, $id_post, $commentaire);      

                header("Location: /blog/public/post/" . $result);
                exit;                       
            }
                        
        } catch (Exception $e) {
            $result = 'Erreur : ' . $e->errorMessage();
        }

        // return $result;
    }

}