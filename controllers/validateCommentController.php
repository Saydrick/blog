<?php

namespace blog\controllers;

use blog\repository\ValidateCommentRepository;
use blog\Exceptions\Exception;

class ValidateCommentController
{
    protected ValidateCommentRepository $ValidateCommentRepository;

    public function __construct(ValidateCommentRepository $ValidateCommentRepository)
    {
        $this->ValidateCommentRepository = $ValidateCommentRepository;
    }

    public function update($id_comment)
    {
        try {
            $result = $this->ValidateCommentRepository->validateComment($id_comment);

            header("Location: /blog/public/admin");
        } catch (Exception $e) {
            $result = 'Erreur : ' . $e->errorMessage();
        }

        // return $result;
    }
}
