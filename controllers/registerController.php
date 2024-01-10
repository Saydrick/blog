<?php

namespace blog\controllers;

use blog\repository\registerRepository;
use blog\service\validateService;
use blog\Exceptions\Exception;

class registerController {

    protected registerRepository $_registerRepository;
    protected validateService $_validateService;

    function __construct(registerRepository $registerRepository, validateService $validateService) {
        $this->_registerRepository = $registerRepository;
        $this->_validateService = $validateService;
    }

    function create() {

        try {
            if(isset($_POST['envoyer'])) {

                $formRules = [
                    'nom' => ['type' => 'required', 'message' => 'Veuillez renseigner votre nom'],
                    'prenom' => ['type' => 'required', 'message' => 'Veuillez renseigner votre prénom'],
                    'mail' => ['type' => 'email', 'message' => 'L\'adresse mail entrée est incorrecte'],
                    'password' => ['type' => 'required', 'message' => 'Veuillez renseigner votre mot de passe'],
                    'confirm_password' => ['type' => 'confirm_password', 'fieldToConfirm' => 'password', 'message' => 'Les mots de passe ne correspondent pas']
                ];
            
                $this->_validateService->formValidate($_POST, $formRules);

                $nom = $_POST['nom']; 
                $prenom = $_POST['prenom'];
                $email = $_POST['mail'];
                $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

                $result = $this->_registerRepository->newUser($nom, $prenom, $email, $password);

                
                             
            }
                        
        } catch (Exception $e) {
            $result = 'Erreur : ' . $e->errorMessage();
        }

        return $result;
    }
}