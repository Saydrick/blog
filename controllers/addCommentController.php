<?php

namespace blog\controllers;

use blog\repository\addCommentRepository;
use blog\service\ValidateService;
use blog\Exceptions\Exception;

class AddCommentController
{
    protected addCommentRepository $addCommentRepository;
    protected ValidateService $ValidateService;

    public function __construct(addCommentRepository $addCommentRepository, ValidateService $ValidateService)
    {
        $this->addCommentRepository = $addCommentRepository;
        $this->ValidateService = $ValidateService;
    }

    public function create($id_post)
    {
        try {
            if (isset($_POST['envoyer'])) {
                // If token is not difined OR if post token is different from the session token
                if (!$_POST['token'] || $_POST['token'] !== $_SESSION['TOKEN']) {
                    throw new \RuntimeException('Error: Invalid form submission');
                }

                $formRules = [
                    'commentaire' => [
                        'type' => 'required',
                        'message' => 'Veuillez écrire un commentaire avant de valider'
                        ]
                ];

                $this->ValidateService->formValidate($_POST, $formRules);

                $comment = strip_tags($_POST['commentaire']);

                $result = $this->addCommentRepository->addComment($comment, $id_post);

                header("Location: /blog/public/post/" . $result);
            }
        } catch (Exception $e) {
            $result = 'Erreur : ' . $e->errorMessage();
        }

        // return $result;
    }
}
