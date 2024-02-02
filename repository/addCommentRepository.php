<?php

namespace blog\repository;

use blog\config\ConnectDb;
use blog\Enumeration\IsChecked;
use Exception;
use PDO;

class AddCommentRepository
{
    public static function addComment($comment, $id_post)
    {

        $instance = ConnectDb::getInstance();
        $conn = $instance->getConnection();

        // Add comment to the database
        $query = $conn->prepare("INSERT INTO commentaires (date_creation,
                                                            date_modification,
                                                            message,
                                                            IsChecked,
                                                            ID_utilisateur)
                                VALUES (:date_creation, :date_modification, :message, :IsChecked, :user_id)");

        // Binding values to parameter markers
        $query->bindValue(':date_creation', date('Y-m-d'));
        $query->bindValue(':date_modification', date('Y-m-d'));
        $query->bindValue(':message', $comment, PDO::PARAM_STR);
        $query->bindValue(':IsChecked', IsChecked::unverified->value);
        $query->bindValue(':user_id', $_SESSION['USER_ID'], PDO::PARAM_INT);

        if ($query->execute()) {
            $id_comment = $conn->lastInsertId();

            // Linking comment to the article
            $query2 = $conn->prepare("INSERT INTO posts_commentaires (id_post, id_commentaire)
                                    VALUES (:id_post, :id_comment)");

            // Binding values to parameter markers
            $query2->bindValue(':id_post', $id_post, PDO::PARAM_INT);
            $query2->bindValue(':id_comment', $id_comment, PDO::PARAM_INT);

            if ($query2->execute()) {
                return $id_post;
            } else {
                $error = "Une erreur est survenue \n";
                $error .= "Veuillez réessayer";

                throw new Exception($error);
            }
        } else {
            $error = "Une erreur est survenue \n";
            $error .= "Veuillez réessayer";

            throw new Exception($error);
        }
    }
}
