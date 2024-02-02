<?php

namespace blog\repository;

use blog\config\ConnectDb;
use blog\enum\IsChecked;
use Exception;
use PDO;

class ModifyCommentRepository
{
    public static function modifyComment($id_comment, $id_post, $comment)
    {

        $instance = ConnectDb::getInstance();
        $conn = $instance->getConnection();

        // Modify comment in database
        $query = $conn->prepare("UPDATE Commentaires 
                                SET message = :comment, date_modification = :modification_date, IsChecked = :IsChecked
                                WHERE ID_Commentaire = :id");

        // Binding values to parameter markers
        $query->bindValue(':id', $id_comment, PDO::PARAM_INT);
        $query->bindValue(':comment', $comment, PDO::PARAM_STR);
        $query->bindValue(':modification_date', date('Y-m-d'));
        $query->bindValue(':IsChecked', IsChecked::unverified->value);

        if ($query->execute()) {
            return $id_post;
        } else {
            $error = "Une erreur est survenue \n";
            $error .= "Veuillez réessayer";

            throw new Exception($error);
        }
    }
}
