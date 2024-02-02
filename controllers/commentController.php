<?php

namespace blog\controllers;

use blog\repository\CommentRepository;

class CommentController
{
    protected CommentRepository $CommentRepository;

    public function __construct(CommentRepository $CommentRepository)
    {
        $this->CommentRepository = $CommentRepository;
    }

    public function indexAll($id_post)
    {
        $comment = $this->CommentRepository->getAllComment($id_post);
        return $comment;
    }

    public function index($id_comment)
    {
        $comment = $this->CommentRepository->getComment($id_comment);
        return $comment;
    }
}
