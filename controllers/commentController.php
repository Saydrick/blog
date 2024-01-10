<?php

namespace blog\controllers;

use blog\repository\commentRepository;

class commentController {

    protected commentRepository $_commentRepository;

    function __construct(commentRepository $commentRepository) {
        $this->_commentRepository = $commentRepository;
    }

    function index_all($id_post) {
        $comment = $this->_commentRepository->getAllComment($id_post);
        return $comment;
    }

    function index($id_comment) {
        $comment = $this->_commentRepository->getComment($id_comment);
        return $comment;
    }
}
