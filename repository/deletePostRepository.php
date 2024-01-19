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

        $query->bindValue(':id', $id, PDO::PARAM_INT);

        if ($query->execute())
        {
            return $id;
        }
        else
        {
            $error = "Une erreur est survenue \n";
            $error .= "Veuillez réessayer";

            throw new Exception($error);
        }

    }
}