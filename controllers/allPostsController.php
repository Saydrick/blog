<?php

namespace blog\controllers;

use blog\repository\AllPostsRepository;

class AllPostsController
{
    protected AllPostsRepository $AllPostsRepository;

    public function __construct(AllPostsRepository $AllPostsRepository)
    {
        $this->AllPostsRepository = $AllPostsRepository;
    }

    public function index()
    {
        $posts = $this->AllPostsRepository->getAllPosts();
        return $posts;
    }
}
