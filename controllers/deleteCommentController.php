<?php

namespace blog\controllers;

use blog\repository\DeleteCommentRepository;
use blog\Exceptions\Exception;

class DeleteCommentController
{
    protected DeleteCommentRepository $DeleteCommentRepository;

    public function __construct(DeleteCommentRepository $DeleteCommentRepository)
    {
        $this->DeleteCommentRepository = $DeleteCommentRepository;
    }

    public function delete($id_post, $id_comment)
    {
        try {
            if (isset($_POST['envoyer'])) {
                // If token is not difined OR if post token is different from the session token
                if (!$_POST['token'] || $_POST['token'] !== $_SESSION['TOKEN']) {
                    throw new \RuntimeException('Error: Invalid form submission');
                }

                $result = $this->DeleteCommentRepository->deleteComment($id_post, $id_comment);

                header("Location: /blog/public/post/" . $result);
            }
        } catch (Exception $e) {
            $result = 'Erreur : ' . $e->errorMessage();
        }
    }
}
