<?php

namespace blog\controllers;

use blog\repository\RegisterRepository;
use blog\repository\UserRepository;
use blog\service\ValidateService;
use blog\Exceptions\Exception;

class RegisterController
{
    protected RegisterRepository $RegisterRepository;
    protected UserRepository $UserRepository;
    protected ValidateService $ValidateService;

    public function __construct(
        RegisterRepository $RegisterRepository,
        UserRepository $UserRepository,
        ValidateService $ValidateService
    ) {
        $this->RegisterRepository = $RegisterRepository;
        $this->UserRepository = $UserRepository;
        $this->ValidateService = $ValidateService;
    }

    public function create()
    {

        try {
            if (isset($_POST['envoyer'])) {
                // If token is not difined OR if post token is different from the session token
                if (!$_POST['token'] || $_POST['token'] !== $_SESSION['TOKEN']) {
                    throw new \RuntimeException('Error: Invalid form submission');
                }

                $formRules = [
                    'nom' => [
                        'type' => 'required',
                        'message' => 'Veuillez renseigner votre nom'
                    ],
                    'prenom' => [
                        'type' => 'required',
                        'message' => 'Veuillez renseigner votre prénom'
                    ],
                    'mail' => [
                        'type' => 'email',
                        'message' => 'L\'adresse mail entrée est incorrecte'
                    ],
                    'password' => [
                        'type' => 'required',
                        'message' => 'Veuillez renseigner votre mot de passe'
                    ],
                    'confirm_password' => [
                        'type' => 'confirm_password',
                        'fieldToConfirm' => 'password',
                        'message' => 'Les mots de passe ne correspondent pas'
                    ]
                ];

                $this->ValidateService->formValidate($_POST, $formRules);

                $nom = strip_tags($_POST['nom']);
                $prenom = strip_tags($_POST['prenom']);
                $email = strip_tags($_POST['mail']);
                $password = password_hash(strip_tags($_POST['password']), PASSWORD_BCRYPT);

                $newUser = $this->RegisterRepository->newUser($nom, $prenom, $email, $password);

                if (is_numeric($newUser)) {
                    $user = $this->UserRepository->getUser($newUser);

                    $_SESSION['USER_ID'] = $user['id'];
                    $_SESSION['USER_MAIL'] = $user['email'];
                    $_SESSION['USER_NOM'] = $user['nom'];
                    $_SESSION['USER_PRENOM'] = $user['prenom'];
                    $_SESSION['USER_ADMIN'] = $user['is_admin'];

                    header("Location: /blog/public/");
                } else {
                    throw new Exception($newUser);
                }
            }
        } catch (Exception $e) {
            $result = 'Erreur : ' . $e->errorMessage();
        }

        return $result;
    }
}
