<?php

namespace blog\repository;

use blog\config\ConnectDb;
use Exception;
use PDO;

class AddPostRepository
{
    public static function addPost($titre, $chapo, $contenu)
    {

        $instance = ConnectDb::getInstance();
        $conn = $instance->getConnection();

        $query = $conn->prepare("INSERT INTO posts (titre,
                                                    date_creation,
                                                    date_modification,
                                                    chapo,
                                                    contenu,
                                                    ID_utilisateur)
                                VALUES (:titre,
                                        :date_creation,
                                        :date_modification,
                                        :chapo,
                                        :contenu,
                                        :user_id)");

        // Liez les valeurs aux marqueurs de paramètres
        $query->bindValue(':titre', $titre, PDO::PARAM_STR);
        $query->bindValue(':date_creation', date('Y-m-d'));
        $query->bindValue(':date_modification', date('Y-m-d'));
        $query->bindValue(':chapo', $chapo, PDO::PARAM_STR);
        $query->bindValue(':contenu', $contenu, PDO::PARAM_STR);
        $query->bindValue(':user_id', $_SESSION['USER_ID'], PDO::PARAM_INT);

        if ($query->execute()) {
            $id_post = $conn->lastInsertId();

            return $id_post;
        } else {
            $error = "Une erreur est survenue \n";
            $error .= "Veuillez réessayer";

            throw new Exception($error);
        }
    }
}
