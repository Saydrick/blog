<?php

namespace blog\controllers;

use blog\repository\deletePostRepository;
use blog\service\validateService;
use blog\Exceptions\Exception;

class deletePostController {

    protected deletePostRepository $_deletePostRepository;

    function __construct(deletePostRepository $deletePostRepository) {
        $this->_deletePostRepository = $deletePostRepository;
    }

    function delete($id) {
        try {
            if(isset($_POST['envoyer'])) {

                $result = $this->_deletePostRepository->deletePost($id);      

                header("Location: /blog/public/all-posts");
                exit;                       
            }
                        
        } catch (Exception $e) {
            $result = 'Erreur : ' . $e->errorMessage();
        }

        // return $result;
    }

}