<?php

namespace blog\repository;

use blog\config\ConnectDb;
use Exception;
use PDO;

class DeleteCommentRepository
{
    public static function deleteComment($id_post, $id_comment)
    {

        $instance = ConnectDb::getInstance();
        $conn = $instance->getConnection();

        $query = $conn->prepare("DELETE FROM commentaires
                                WHERE ID_commentaire = :id");

        // Liez les valeurs aux marqueurs de paramètres
        $query->bindValue(':id', $id_comment, PDO::PARAM_INT);

        if ($query->execute()) {
            return $id_post;
        } else {
            $error = "Une erreur est survenue \n";
            $error .= "Veuillez réessayer";

            throw new Exception($error);
        }
    }
}
