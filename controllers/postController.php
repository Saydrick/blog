<?php

namespace blog\controllers;

use blog\repository\postRepository;

class postController {

    protected postRepository $_postRepository;

    function __construct(postRepository $postRepository) {
        $this->_postRepository = $postRepository;
    }

    function index($id) {
        $post = $this->_postRepository->getPost($id);
        return $post;
    }
}
