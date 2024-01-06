<?php

namespace blog\repository;

use blog\config\ConnectDb;
use blog\enum\Status;
use PDO;

class inscriptionRepository {
    public function newUser($nom, $prenom, $email, $password) {

        $instance = ConnectDb::getInstance();
        $conn = $instance->getConnection();

        $query = $conn->prepare("SELECT * FROM utilisateurs WHERE email = '$email'");
        $query->execute();
        $res = $query->fetch(PDO::FETCH_ASSOC);

        if($res)
        {
            $result = "Cette adresse mail est déjà utilisée par un autre utilisateur";
        }
        else
        {
            $query2 = $conn->prepare("INSERT INTO utilisateurs (nom, prenom, email, password, is_admin)
                                    VALUES ('".$nom."', '".$prenom."', '".$email."', '".$password."', ".Status::visiteur->value.")");
    
            if ($query2->execute())
            {
                $result = "Bienvenu $prenom $nom !\n";
                $result .= "Votre compte a bien été créé";
            }
            else
            {
                $result = "Une erreur est survenue\n";
                $result .= "Veuillez réessayer";
            }
        }


        // return 'coucou';
        return $result;
    }
}