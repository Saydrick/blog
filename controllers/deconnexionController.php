<?php

namespace blog\controllers;

use blog\repository\ConnexionRepository;
use blog\service\ValidateService;
use blog\Exceptions\Exception;

class ConnexionController
{
    protected ConnexionRepository $ConnexionRepository;
    protected ValidateService $ValidateService;

    public function __construct(ConnexionRepository $ConnexionRepository, ValidateService $ValidateService)
    {
        $this->ConnexionRepository = $ConnexionRepository;
        $this->ValidateService = $ValidateService;
    }

    public function index()
    {

        if (isset($_POST['envoyer'])) {
            // If token is not difined OR if post token is different from the session token
            if (!$_POST['token'] || $_POST['token'] !== $_SESSION['TOKEN']) {
                throw new \RuntimeException('Error: Invalid form submission');
            }

            $formRules = [
                'mail' => ['type' => 'email', 'message' => 'Le format de votre adresse mail est incorrecte'],
                'password' => ['type' => 'required', 'message' => 'Veuillez renseigner votre mot de passe']
            ];

            try {
                $this->ValidateService->formValidate($_POST, $formRules);

                $email = strip_tags($_POST['mail']);
                $password = strip_tags($_POST['password']);

                $user = $this->ConnexionRepository->checkUser($email, $password);

                if (is_array($user)) {
                    $_SESSION['USER_ID'] = $user['user_ID'];
                    $_SESSION['USER_MAIL'] = $email;
                    $_SESSION['USER_NOM'] = $user['nom'];
                    $_SESSION['USER_PRENOM'] = $user['prenom'];
                    $_SESSION['USER_ADMIN'] = $user['is_admin'];
                } else {
                    throw new Exception($user);
                }

                $result = "Bienvenu " . $_SESSION['USER_PRENOM'] . " " . $_SESSION['USER_NOM'] . " !";
            } catch (Exception $e) {
                $result = 'Erreur : ' . $e->getMessage();
            }
        }

        return $result; // Renvoyer la vues
    }
}
