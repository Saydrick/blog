<?php

namespace blog\repository;

use blog\config\ConnectDb;
use blog\enum\Is_checked;
use Exception;
use PDO;

class validerCommentaireRepository {
    public static function validerCommentaire($id_commentaire) {

        $instance = ConnectDb::getInstance();
        $conn = $instance->getConnection();

        $query = $conn->prepare("UPDATE Commentaires 
                                SET is_checked = :is_checked
                                WHERE ID_Commentaire = :id");

        // Liez les valeurs aux marqueurs de paramètres
        $query->bindValue(':id', $id_commentaire);
        $query->bindValue(':is_checked', Is_checked::checked->value);

        // var_dump($query);

        if ($query->execute())
        {
            return;
        }
        else
        {
            $erreur = "Une erreur est survenue \n";
            $erreur .= "Veuillez réessayer";

            throw new Exception($erreur);
        }

    }
}