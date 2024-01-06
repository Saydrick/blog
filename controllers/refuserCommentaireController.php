<?php

namespace blog\controllers;

use blog\repository\validerCommentaireRepository;
use blog\service\validateService;
use blog\Exceptions\Exception;

class validerCommentaireController {

    protected validerCommentaireRepository $_validerCommentaireRepository;

    function __construct(validerCommentaireRepository $validerCommentaireRepository) {
        $this->_validerCommentaireRepository = $validerCommentaireRepository;
    }

    function delete($id_commentaire) {
        try {
            $result = $this->_validerCommentaireRepository->validerCommentaire($id_commentaire);      

            header("Location: /blog/public/admin");
            exit;                       
                        
        } catch (Exception $e) {
            $result = 'Erreur : ' . $e->errorMessage();
        }

        // return $result;
    }

}