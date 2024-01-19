<?php

namespace blog\controllers;

use blog\repository\registerRepository;
use blog\repository\userRepository;
use blog\service\validateService;
use blog\Exceptions\Exception;

class registerController {

    protected registerRepository $_registerRepository;
    protected userRepository $_userRepository;
    protected validateService $_validateService;

    function __construct(registerRepository $registerRepository, userRepository $userRepository, validateService $validateService) {
        $this->_registerRepository = $registerRepository;
        $this->_userRepository = $userRepository;
        $this->_validateService = $validateService;
    }

    function create() {

        try {
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
                    'nom' => ['type' => 'required', 'message' => 'Veuillez renseigner votre nom'],
                    'prenom' => ['type' => 'required', 'message' => 'Veuillez renseigner votre prénom'],
                    'mail' => ['type' => 'email', 'message' => 'L\'adresse mail entrée est incorrecte'],
                    'password' => ['type' => 'required', 'message' => 'Veuillez renseigner votre mot de passe'],
                    'confirm_password' => ['type' => 'confirm_password', 'fieldToConfirm' => 'password', 'message' => 'Les mots de passe ne correspondent pas']
                ];
            
                $this->_validateService->formValidate($_POST, $formRules);

                $nom = strip_tags($_POST['nom']); 
                $prenom = strip_tags($_POST['prenom']);
                $email = strip_tags($_POST['mail']);
                $password = password_hash(strip_tags($_POST['password']), PASSWORD_BCRYPT);

                $newUser = $this->_registerRepository->newUser($nom, $prenom, $email, $password);

                if(is_numeric($newUser))
                {
                    $user = $this->_userRepository->getUser($newUser);

                    $_SESSION['USER_ID'] = $user['id'];
                    $_SESSION['USER_MAIL'] = $user['email'];
                    $_SESSION['USER_NOM'] = $user['nom'];
                    $_SESSION['USER_PRENOM'] = $user['prenom'];
                    $_SESSION['USER_ADMIN'] = $user['is_admin'];

                    header("Location: /blog/public/");
                }
                else
                {
                    throw new Exception($newUser);
                }

                
                             
            }
                        
        } catch (Exception $e) {
            $result = 'Erreur : ' . $e->errorMessage();
        }

        return $result;
    }
}