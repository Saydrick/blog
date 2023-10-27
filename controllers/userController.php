<?php

namespace blog\controller;

use blog\repository\userRepository;

class userController {

    protected userRepository $_userRepository;

    function __construct(userRepository $userRepository) {
        $this->_userRepository = $userRepository;
    }

    function index() {
        $this->_userRepository->getUser();
    }
}
