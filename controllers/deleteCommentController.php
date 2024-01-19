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

                // If token is not difined OR if post token is different from the session token
                if (!$_POST['token'] || $_POST['token'] !== $_SESSION['TOKEN']) {
                    // show an error message
                    echo '<p class="error">Error: invalid form submission</p>';
                    // return 405 http status code
                    header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
                    exit;
                }

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