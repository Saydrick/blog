<?php

namespace blog\repository;

use blog\config\ConnectDb;
use blog\enum\IsChecked;
use Exception;
use PDO;

class ValidateCommentRepository
{
    public static function validateComment($id_comment)
    {

        $instance = ConnectDb::getInstance();
        $conn = $instance->getConnection();

        $query = $conn->prepare("UPDATE Commentaires 
                                SET IsChecked = :IsChecked
                                WHERE ID_Commentaire = :id");

        // Liez les valeurs aux marqueurs de paramètres
        $query->bindValue(':id', $id_comment, PDO::PARAM_INT);
        $query->bindValue(':IsChecked', IsChecked::checked->value);

        // var_dump($query);

        if ($query->execute()) {
            return;
        } else {
            $error = "Une erreur est survenue \n";
            $error .= "Veuillez réessayer";

            throw new Exception($error);
        }
    }
}
