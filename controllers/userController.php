<?php

/* Not yet used */

namespace blog\controller;

use blog\repository\userRepository;

class userController {

    protected userRepository $_userRepository;

    function __construct(userRepository $userRepository) {
        $this->_userRepository = $userRepository;
    }

    function index($id_user) {
        $this->_userRepository->getUser($id_user);
    }
}
