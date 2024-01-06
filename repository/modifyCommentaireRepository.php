<?php

namespace blog\repository;

use blog\config\ConnectDb;
use blog\enum\Is_checked;
use Exception;
use PDO;

class modifyCommentaireRepository {
    public static function modifyCommentaire($id_commentaire, $id_post, $commentaire) {

        $instance = ConnectDb::getInstance();
        $conn = $instance->getConnection();

        $query = $conn->prepare("UPDATE Commentaires 
                                SET message = :commentaire, date_modification = :date_modification, is_checked = :is_checked
                                WHERE ID_Commentaire = :id");

        // Liez les valeurs aux marqueurs de paramètres
        $query->bindValue(':id', $id_commentaire);
        $query->bindValue(':commentaire', $commentaire);
        $query->bindValue(':date_modification', date('Y-m-d'));
        $query->bindValue(':is_checked', Is_checked::unverified->value);

        // var_dump($query);

        if ($query->execute())
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
}