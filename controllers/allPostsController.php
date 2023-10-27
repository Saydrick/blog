<?php

namespace blog\controller;

use blog\repository\postRepository;

class allPostsController {

    protected postRepository $_postRepository;

    function __construct(postRepository $postRepository) {
        $this->_postRepository = $postRepository;
    }

    function index() {
        $posts = $this->_postRepository->getAllPosts();
        return $posts;
    }
}
