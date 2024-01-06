<?php

namespace blog\repository;

use blog\config\ConnectDb;
use blog\enum\Is_checked;
use Exception;
use PDO;

class addCommentaireRepository {
    public static function addCommentaire($commentaire, $id_post) {

        $instance = ConnectDb::getInstance();
        $conn = $instance->getConnection();

        // Ajout du commentaire dans la base de données
        $query = $conn->prepare("INSERT INTO commentaires (date_creation, date_modification, message, is_checked, ID_utilisateur)
                                VALUES (:date_creation, :date_modification, :message, :is_checked, :user_id)");

        // Liaison des valeurs aux marqueurs de paramètres
        $query->bindValue(':date_creation', date('Y-m-d'));
        $query->bindValue(':date_modification', date('Y-m-d'));
        $query->bindValue(':message', $commentaire);
        $query->bindValue(':is_checked', Is_checked::unverified->value);
        $query->bindValue(':user_id', $_SESSION['USER_ID']);

        // var_dump(Is_checked::unverified->value);

        if ($query->execute())
        {
            $id_commentaire = $conn->lastInsertId();

            // Liaison du commentaire avec l'article
            $query2 = $conn->prepare("INSERT INTO posts_commentaires (id_post, id_commentaire)
                                    VALUES (:id_post, :id_commentaire)");

            // Liaison des valeurs aux marqueurs de paramètres
            $query2->bindValue(':id_post', $id_post);
            $query2->bindValue(':id_commentaire', $id_commentaire);

            if ($query2->execute())
            {
                return $id_post;
            }
            else
            {
                $erreur = "Une erreur est survenue \n";
                $erreur .= "Veuillez réessayer";
    
                throw new Exception($erreur);
            }
        }
        else
        {
            $erreur = "Une erreur est survenue \n";
            $erreur .= "Veuillez réessayer";

            throw new Exception($erreur);
        }

    }
}