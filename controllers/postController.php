<?php

namespace blog\controllers;

use blog\repository\PostRepository;

class PostController
{
    protected PostRepository $PostRepository;

    public function __construct(PostRepository $PostRepository)
    {
        $this->PostRepository = $PostRepository;
    }

    public function index($id)
    {
        $post = $this->PostRepository->getPost($id);
        return $post;
    }
}
