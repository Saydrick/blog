<?php

namespace blog\repository;

use blog\config\ConnectDb;
use Exception;
use PDO;

class deletePostRepository {
    public static function deletePost($id) {

        $instance = ConnectDb::getInstance();
        $conn = $instance->getConnection();

        $query = $conn->prepare("DELETE FROM posts
                                WHERE ID_post = :id");

        // Liez les valeurs aux marqueurs de paramètres
        $query->bindValue(':id', $id);

        var_dump($query);

        if ($query->execute())
        {
            return $id;
        }
        else
        {
            $erreur = "Une erreur est survenue \n";
            $erreur .= "Veuillez réessayer";

            throw new Exception($erreur);
        }

    }
}