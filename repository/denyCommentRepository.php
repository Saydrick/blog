<?php

namespace blog\repository;

use blog\config\ConnectDb;
use Exception;
use PDO;

class DenyCommentRepository
{
    public static function denyComment($id_comment)
    {

        $instance = ConnectDb::getInstance();
        $conn = $instance->getConnection();

        $query = $conn->prepare("DELETE FROM Commentaires 
                                WHERE ID_Commentaire = :id");

        // Liez les valeurs aux marqueurs de paramètres
        $query->bindValue(':id', $id_comment, PDO::PARAM_INT);

        // var_dump($query);

        if ($query->execute()) {
            return;
        } else {
            $erreur = "Une erreur est survenue \n";
            $erreur .= "Veuillez réessayer";

            throw new Exception($erreur);
        }
    }
}
