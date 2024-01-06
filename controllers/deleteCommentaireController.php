<?php

namespace blog\controllers;

use blog\repository\deleteCommentaireRepository;
use blog\service\validateService;
use blog\Exceptions\Exception;

class deleteCommentaireController {

    protected deleteCommentaireRepository $_deleteCommentaireRepository;
    protected validateService $_validateService;

    function __construct(deleteCommentaireRepository $deleteCommentaireRepository, validateService $validateService) {
        $this->_deleteCommentaireRepository = $deleteCommentaireRepository;
        $this->_validateService = $validateService;
    }

    function delete($id_post, $id_commentaire) {
        try {
            if(isset($_POST['envoyer'])) {

                $result = $this->_deleteCommentaireRepository->deleteCommentaire($id_post, $id_commentaire);      

                header("Location: /blog/public/post/" . $result);
                exit;                       
            }
                        
        } catch (Exception $e) {
            $result = 'Erreur : ' . $e->errorMessage();
        }

        // return $result;
    }

}