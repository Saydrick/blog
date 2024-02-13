<?php

namespace blog\repository;

use blog\config\ConnectDb;
use blog\Enumeration\Status;
use PDO;

class RegisterRepository
{
    public function newUser($nom, $prenom, $email, $password)
    {

        $instance = ConnectDb::getInstance();
        $conn = $instance->getConnection();

        $query = $conn->prepare("SELECT * FROM utilisateurs WHERE email = :email");

        $query->bindValue(':email', $email, PDO::PARAM_STR);

        $query->execute();

        $res = $query->fetch(PDO::FETCH_ASSOC);

        if ($res) {
            $result = "Cette adresse mail est déjà utilisée par un autre utilisateur";
        } else {
            $query2 = $conn->prepare("INSERT INTO utilisateurs (nom, prenom, email, password, is_admin)
                                    VALUES (:nom, :prenom, :email, :password, :is_admin)");


            $query2->bindValue(':nom', $nom, PDO::PARAM_STR);
            $query2->bindValue(':prenom', $prenom, PDO::PARAM_STR);
            $query2->bindValue(':email', $email, PDO::PARAM_STR);
            $query2->bindValue(':password', $password, PDO::PARAM_STR);
            $query2->bindValue(':is_admin', Status::visiteur->value, PDO::PARAM_INT);

            if ($query2->execute()) {
                $id_user = $conn->lastInsertId();

                return $id_user;
            } else {
                $result = "Une erreur est survenue\n";
                $result .= "Veuillez réessayer";
            }
        }

        return $result;
    }
}
