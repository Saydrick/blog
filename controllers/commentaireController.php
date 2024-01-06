<?php

namespace blog\controllers;

use blog\repository\commentaireRepository;

class commentaireController {

    protected commentaireRepository $_commentaireRepository;

    function __construct(commentaireRepository $commentaireRepository) {
        $this->_commentaireRepository = $commentaireRepository;
    }

    function index_all($id_post) {
        $commentaire = $this->_commentaireRepository->getAllCommentaire($id_post);
        return $commentaire;
    }

    function index($id_commentaire) {
        $commentaire = $this->_commentaireRepository->getCommentaire($id_commentaire);
        return $commentaire;
    }
}
