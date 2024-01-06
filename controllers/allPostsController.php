<?php

namespace blog\controllers;

use blog\repository\allPostsRepository;

class allPostsController {

    protected allPostsRepository $_allPostsRepository;

    function __construct(allPostsRepository $allPostsRepository) {
        $this->_allPostsRepository = $allPostsRepository;
    }

    function index() {
        $posts = $this->_allPostsRepository->getAllPosts();
        return $posts;
    }
}
