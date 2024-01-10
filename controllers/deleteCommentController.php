<?php

namespace blog\controllers;

use blog\repository\deleteCommentRepository;
use blog\Exceptions\Exception;

class deleteCommentController {

    protected deleteCommentRepository $_deleteCommentRepository;

    function __construct(deleteCommentRepository $deleteCommentRepository) {
        $this->_deleteCommentRepository = $deleteCommentRepository;
    }

    function delete($id_post, $id_comment) {
        try {
            if(isset($_POST['envoyer'])) {

                $result = $this->_deleteCommentRepository->deleteComment($id_post, $id_comment);      

                header("Location: /blog/public/post/" . $result);
                exit;                       
            }
                        
        } catch (Exception $e) {
            $result = 'Erreur : ' . $e->errorMessage();
        }

        // return $result;
    }

}