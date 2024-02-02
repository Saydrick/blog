<?php

namespace blog\repository;

use blog\config\ConnectDb;
use blog\Helper\Helper;
use blog\Enum\IsChecked;
use PDO;

class CommentRepository
{
    public static function getAllComment($id_post)
    {

        $instance = ConnectDb::getInstance();
        $conn = $instance->getConnection();

        $query = $conn->prepare("SELECT commentaires.ID_commentaire,
                                        commentaires.date_creation,
                                        commentaires.date_modification,
                                        commentaires.message,
                                        commentaires.ID_utilisateur,
                                        utilisateurs.nom,
                                        utilisateurs.prenom
                    FROM commentaires
                    INNER JOIN posts_commentaires ON (posts_commentaires.ID_commentaire = commentaires.ID_commentaire)
                    INNER JOIN utilisateurs ON (utilisateurs.ID_utilisateur = commentaires.ID_utilisateur)
                    WHERE posts_commentaires.ID_post = :id_post
                    AND commentaires.is_checked = :IsChecked
                    ORDER BY commentaires.date_modification DESC");


        $query->bindValue(':id_post', $id_post, PDO::PARAM_INT);
        $query->bindValue(':IsChecked', IsChecked::checked->value);

        $query->execute();

        $comments = [];
        if ($query->rowCount() > 0) {
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $date_creation = Helper::dateFormat($row['date_creation']);
                $date_modification = Helper::dateFormat($row['date_modification']);

                $comment = [
                        'id_commentaire' => $row['ID_commentaire'],
                        'date_creation' => $date_creation,
                        'date_modification' => $date_modification,
                        'message' => $row['message'],
                        'auteur' => $row['nom'] . " " . $row['prenom'],
                        'id_auteur' => $row['ID_utilisateur']
                        ];

                $comments[] = $comment;
            }
        } else {
            $comments = 'Soyez le premier à commenter cet article';
        }

        return $comments;
    }


    public static function getComment($id_comment)
    {

        $instance = ConnectDb::getInstance();
        $conn = $instance->getConnection();

        $query = $conn->prepare("SELECT commentaires.ID_commentaire,
                                        commentaires.date_creation,
                                        commentaires.date_modification,
                                        commentaires.message,
                                        commentaires.ID_utilisateur,
                                        utilisateurs.nom,
                                        utilisateurs.prenom
                                FROM commentaires
                                INNER JOIN utilisateurs ON (utilisateurs.ID_utilisateur = commentaires.ID_utilisateur)
                                WHERE commentaires.ID_commentaire = :id_comment");


        $query->bindValue(':id_comment', $id_comment, PDO::PARAM_INT);

        $query->execute();

        $comments = [];
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $date_creation = Helper::dateFormat($row['date_creation']);
            $date_modification = Helper::dateFormat($row['date_modification']);

            $comment = [
                    'id_commentaire' => $row['ID_commentaire'],
                    'date_creation' => $date_creation,
                    'date_modification' => $date_modification,
                    'message' => $row['message'],
                    'auteur' => $row['nom'] . " " . $row['prenom'],
                    'id_auteur' => $row['ID_utilisateur']
                    ];

            $comments[] = $comment;
        }

        return $comments;
    }
}
