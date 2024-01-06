<?php

namespace blog\controllers;

use blog\repository\inscriptionRepository;
use blog\service\validateService;
use blog\Exceptions\Exception;

class inscriptionController {

    protected inscriptionRepository $_inscriptionRepository;

    function __construct(inscriptionRepository $inscriptionRepository) {
        $this->_inscriptionRepository = $inscriptionRepository;
    }

    function create() {

        try {
            if(isset($_POST['envoyer'])) {

                $formRules = [
                    // 'envoyer' => ['type' => 'required', 'message' => 'Veuillez cliquer sur "Envoyer"'],
                    'nom' => ['type' => 'required', 'message' => 'Veuillez renseigner votre nom'],
                    'prenom' => ['type' => 'required', 'message' => 'Veuillez renseigner votre prénom'],
                    'mail' => ['type' => 'email', 'message' => 'L\'adresse mail entrée est incorrecte'],
                    'password' => ['type' => 'required', 'message' => 'Veuillez renseigner votre mot de passe'],
                    'confirm_password' => ['type' => 'confirm_password', 'fieldToConfirm' => 'password', 'message' => 'Les mots de passe ne correspondent pas']
                ];
            
                validateService::formValidate($_POST, $formRules);

                $nom = $_POST['nom']; 
                $prenom = $_POST['prenom'];
                $email = $_POST['mail'];
                $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

                $result = $this->_inscriptionRepository->newUser($nom, $prenom, $email, $password);

                
                             
            }
                        
        } catch (Exception $e) {
            $result = 'Erreur : ' . $e->errorMessage();
        }

        return $result;
    }
}