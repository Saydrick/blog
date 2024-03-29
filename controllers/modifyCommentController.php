<?php

namespace blog\controllers;

use blog\repository\ModifyCommentRepository;
use blog\service\ValidateService;
use blog\Exceptions\Exception;

class ModifyCommentController
{
    protected ModifyCommentRepository $ModifyCommentRepository;
    protected ValidateService $ValidateService;

    public function __construct(ModifyCommentRepository $ModifyCommentRepository, ValidateService $ValidateService)
    {
        $this->ModifyCommentRepository = $ModifyCommentRepository;
        $this->ValidateService = $ValidateService;
    }

    public function update($id_comment, $id_post)
    {
        try {
            if (isset($_POST['envoyer'])) {
                // If token is not difined OR if post token is different from the session token
                if (!$_POST['token'] || $_POST['token'] !== $_SESSION['TOKEN']) {
                    throw new \RuntimeException('Error: Invalid form submission');
                }

                $formRules = [
                    'commentaire' => ['type' => 'required', 'message' => 'Veuillez renseigner le titre de l\'article']
                ];

                $this->ValidateService->formValidate($_POST, $formRules);

                $comment = strip_tags($_POST['commentaire']);

                $result = $this->ModifyCommentRepository->modifyComment($id_comment, $id_post, $comment);

                header("Location: /blog/public/post/" . $result);
            }
        } catch (Exception $e) {
            $result = 'Erreur : ' . $e->errorMessage();
        }
    }
}
