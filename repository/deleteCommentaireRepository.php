<?php

namespace blog\repository;

use blog\config\ConnectDb;
use Exception;
use PDO;

class deletecommentaireRepository {
    public static function deletecommentaire($id_post, $id_commentaire) {

        $instance = ConnectDb::getInstance();
        $conn = $instance->getConnection();

        $query = $conn->prepare("DELETE FROM commentaires
                                WHERE ID_commentaire = :id");

        // Liez les valeurs aux marqueurs de paramètres
        $query->bindValue(':id', $id_commentaire);

        var_dump($query);

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