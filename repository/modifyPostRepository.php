<?php

namespace blog\repository;

use blog\config\ConnectDb;
use Exception;
use PDO;

class ModifyPostRepository
{
    public static function modifyPost($id, $titre, $chapo, $contenu)
    {

        $instance = ConnectDb::getInstance();
        $conn = $instance->getConnection();

        $query = $conn->prepare("UPDATE posts 
                                SET titre = :titre,
                                    date_modification = :date_modification,
                                    chapo = :chapo,
                                    contenu = :contenu
                                WHERE ID_post = :id");

        // Liez les valeurs aux marqueurs de paramètres
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->bindValue(':titre', $titre, PDO::PARAM_STR);
        $query->bindValue(':date_modification', date('Y-m-d'));
        $query->bindValue(':chapo', $chapo, PDO::PARAM_STR);
        $query->bindValue(':contenu', $contenu, PDO::PARAM_STR);

        if ($query->execute()) {
            return $id;
        } else {
            $erreur = "Une erreur est survenue \n";
            $erreur .= "Veuillez réessayer";

            throw new Exception($erreur);
        }
    }
}
