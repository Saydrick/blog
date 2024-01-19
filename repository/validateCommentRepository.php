<?php

namespace blog\repository;

use blog\config\ConnectDb;
use blog\enum\Is_checked;
use Exception;
use PDO;

class validateCommentRepository {
    public static function validateComment($id_comment) {

        $instance = ConnectDb::getInstance();
        $conn = $instance->getConnection();

        $query = $conn->prepare("UPDATE Commentaires 
                                SET is_checked = :is_checked
                                WHERE ID_Commentaire = :id");

        // Liez les valeurs aux marqueurs de paramètres
        $query->bindValue(':id', $id_comment, PDO::PARAM_INT);
        $query->bindValue(':is_checked', Is_checked::checked->value);

        // var_dump($query);

        if ($query->execute())
        {
            return;
        }
        else
        {
            $error = "Une erreur est survenue \n";
            $error .= "Veuillez réessayer";

            throw new Exception($error);
        }

    }
}