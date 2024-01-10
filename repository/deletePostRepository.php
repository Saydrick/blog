<?php

namespace blog\repository;

use blog\config\ConnectDb;
use Exception;

class deletePostRepository {
    public static function deletePost($id) {

        $instance = ConnectDb::getInstance();
        $conn = $instance->getConnection();

        $query = $conn->prepare("DELETE FROM posts
                                WHERE ID_post = :id");

        $query->bindValue(':id', $id);

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