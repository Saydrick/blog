<?php

namespace blog\controllers;

use blog\repository\AdministratorRepository;

class AdministratorController
{
    protected AdministratorRepository $AdministratorRepository;

    public function __construct(AdministratorRepository $AdministratorRepository)
    {
        $this->AdministratorRepository = $AdministratorRepository;
    }

    /* recovery of all posts */
    public function postsIndex()
    {
        $posts = $this->AdministratorRepository->getPosts();
        return $posts;
    }

    /* recovery of all comments */
    public function commentsIndex()
    {
        $comments = $this->AdministratorRepository->getComments();
        return $comments;
    }
}
