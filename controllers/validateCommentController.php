<?php

namespace blog\controllers;

use blog\repository\validateCommentRepository;
use blog\Exceptions\Exception;

class validateCommentController {

    protected validateCommentRepository $_validateCommentRepository;

    function __construct(validateCommentRepository $validateCommentRepository) {
        $this->_validateCommentRepository = $validateCommentRepository;
    }

    function update($id_comment) {
        try {
            $result = $this->_validateCommentRepository->validateComment($id_comment);      

            header("Location: /blog/public/admin");
            exit;                       
                        
        } catch (Exception $e) {
            $result = 'Erreur : ' . $e->errorMessage();
        }

        // return $result;
    }

}