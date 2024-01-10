<?php

namespace blog\controllers;

use blog\repository\administratorRepository;

class administratorController {

    protected administratorRepository $_administratorRepository;

    function __construct(administratorRepository $administratorRepository) {
        $this->_administratorRepository = $administratorRepository;
    }

    /* recovery of all posts */
    function postsIndex() {
        $posts = $this->_administratorRepository->getPosts();
        return $posts;
    }

    /* recovery of all comments */
    function commentsIndex() {
        $comments = $this->_administratorRepository->getComments();
        return $comments;
    }
}
