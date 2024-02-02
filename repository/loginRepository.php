<?php

namespace blog\repository;

use blog\config\ConnectDb;
use Exception;
use PDO;

class LoginRepository
{
    public function checkUser($email, $password)
    {

        try {
            $instance = ConnectDb::getInstance();
            $conn = $instance->getConnection();

            $query = $conn->prepare("SELECT ID_utilisateur, nom, prenom, is_admin, password
                                    FROM utilisateurs
                                    WHERE email = :email");

            $query->bindValue(':email', $email, PDO::PARAM_STR);

            $query->execute();

            $res = $query->fetch(PDO::FETCH_ASSOC);

            if ($res) {
                $passwordHash = $res['password'];
                if (password_verify($password, $passwordHash)) {
                    $user = [
                        'user_ID' => $res['ID_utilisateur'],
                        'email' => $email,
                        'nom' => $res['nom'],
                        'prenom' => $res['prenom'],
                        'is_admin' => $res['is_admin']
                        ];

                    return $user;
                } else {
                    throw new Exception("L'adresse mail ou le mot de passe est incorrect");
                }
            } else {
                throw new Exception("L'adresse mail ou le mot de passe est incorrect");
            }
        } catch (Exception $e) {
            $result = 'Erreur : ' . $e->getMessage();
            return $result;
        }
    }
}
