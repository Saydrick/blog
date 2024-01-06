<?php

namespace blog\controllers;

use blog\repository\connexionRepository;
use blog\service\validateService;
use blog\Exceptions\Exception;

class connexionController {

    protected connexionRepository $_connexionRepository;
    protected validateService $_validateService;

    function __construct(connexionRepository $connexionRepository, validateService $validateService) {
        $this->_connexionRepository = $connexionRepository;
        $this->_validateService = $validateService;
    }

    function index() {

        if(isset($_POST['envoyer'])) {

            $formRules = [
                'mail' => ['type' => 'email', 'message' => 'Le format de votre adresse mail est incorrecte'],
                'password' => ['type' => 'required', 'message' => 'Veuillez renseigner votre mot de passe']
            ];
        
            try {
                $this->_validateService->formValidate($_POST, $formRules);

                $email = $_POST['mail'];
                $password = $_POST['password'];
                
                $user = $this->_connexionRepository->checkUser($email, $password);

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

        return $result; // Renvoyer la vues

    }
}

