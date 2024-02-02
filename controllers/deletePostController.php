<?php

namespace blog\controllers;

use blog\repository\DeletePostRepository;
use blog\service\ValidateService;
use blog\Exceptions\Exception;

class DeletePostController
{
    protected DeletePostRepository $DeletePostRepository;

    public function __construct(DeletePostRepository $DeletePostRepository)
    {
        $this->DeletePostRepository = $DeletePostRepository;
    }

    public function delete($id)
    {
        try {
            if (isset($_POST['envoyer'])) {
                // If token is not difined OR if post token is different from the session token
                if (!$_POST['token'] || $_POST['token'] !== $_SESSION['TOKEN']) {
                    throw new \RuntimeException('Error: Invalid form submission');
                }

                $result = $this->DeletePostRepository->deletePost($id);

                header("Location: /blog/public/all-posts");
            }
        } catch (Exception $e) {
            $result = 'Erreur : ' . $e->errorMessage();
        }

        // return $result;
    }
}
