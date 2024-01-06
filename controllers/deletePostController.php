<?php

namespace blog\controllers;

use blog\repository\deletePostRepository;
use blog\service\validateService;
use blog\Exceptions\Exception;

class deletePostController {

    protected deletePostRepository $_deletePostRepository;
    protected validateService $_validateService;

    function __construct(deletePostRepository $deletePostRepository, validateService $validateService) {
        $this->_deletePostRepository = $deletePostRepository;
        $this->_validateService = $validateService;
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