<?php

namespace blog\controllers;

use blog\repository\administrateurRepository;

class administrateurController {

    protected administrateurRepository $_administrateurRepository;

    function __construct(administrateurRepository $administrateurRepository) {
        $this->_administrateurRepository = $administrateurRepository;
    }

    function postsIndex() {
        $posts = $this->_administrateurRepository->getPosts();
        return $posts;
    }

    function commentairesIndex() {
        $commentaires = $this->_administrateurRepository->getCommentaires();
        return $commentaires;
    }
}
