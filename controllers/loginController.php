<?php

namespace blog\controllers;

use blog\repository\loginRepository;
use blog\service\validateService;
use blog\Exceptions\Exception;

class loginController {

    protected loginRepository $_loginRepository;
    protected validateService $_validateService;

    function __construct(loginRepository $loginRepository, validateService $validateService) {
        $this->_loginRepository = $loginRepository;
        $this->_validateService = $validateService;
    }

    function index() {

        if(isset($_POST['envoyer'])) {

            // If token is not difined OR if post token is different from the session token
            if (!$_POST['token'] || $_POST['token'] !== $_SESSION['TOKEN']) {
                // show an error message
                echo '<p class="error">Error: invalid form submission</p>';
                // return 405 http status code
                header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
                exit;
            }

            $formRules = [
                'mail' => ['type' => 'email', 'message' => 'Le format de votre adresse mail est incorrecte'],
                'password' => ['type' => 'required', 'message' => 'Veuillez renseigner votre mot de passe']
            ];
        
            try {
                $this->_validateService->formValidate($_POST, $formRules);

                $email = strip_tags($_POST['mail']);
                $password = strip_tags($_POST['password']);
                
                $user = $this->_loginRepository->checkUser($email, $password);

                if(is_array($user))
                {
                    $_SESSION['USER_ID'] = $user['user_ID'];
                    $_SESSION['USER_MAIL'] = $email;
                    $_SESSION['USER_NOM'] = $user['nom'];
                    $_SESSION['USER_PRENOM'] = $user['prenom'];
                    $_SESSION['USER_ADMIN'] = $user['is_admin'];
                }
                else
                {
                    throw new Exception($user);
                }

                header("Location: /blog/public/");
            }
            catch (Exception $e) {
                $result = 'Erreur : ' . $e->getMessage();
            }
        }

        return $result;

    }
}

