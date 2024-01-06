<?php

namespace blog\repository;

use blog\config\ConnectDb;
use blog\helper\helper;
use blog\enum\Is_checked;
use PDO;

class commentaireRepository {
    public static function getAllCommentaire($id_post) {

        $instance = ConnectDb::getInstance();
        $conn = $instance->getConnection();

        $query = $conn->prepare("SELECT commentaires.ID_commentaire, commentaires.date_creation, commentaires.date_modification, commentaires.message, commentaires.ID_utilisateur, utilisateurs.nom, utilisateurs.prenom
                                FROM commentaires
                                INNER JOIN posts_commentaires ON (posts_commentaires.ID_commentaire = commentaires.ID_commentaire)
                                INNER JOIN utilisateurs ON (utilisateurs.ID_utilisateur = commentaires.ID_utilisateur)
                                WHERE posts_commentaires.ID_post = :id_post
                                AND commentaires.is_checked = :is_checked
                                ORDER BY commentaires.date_modification DESC");

        
        $query->bindValue(':id_post', $id_post);
        $query->bindValue(':is_checked', Is_checked::checked->value);

        $query->execute();

        if($query->rowCount() > 0)
        {
            while($row = $query->fetch(PDO::FETCH_ASSOC))
            {
                $date_creation = helper::dateFormat($row['date_creation']);
                $date_modification = helper::dateFormat($row['date_modification']);
        
                $commentaire = [
                        'id_commentaire' => $row['ID_commentaire'],
                        'date_creation' => $date_creation,
                        'date_modification' => $date_modification,
                        'message' => $row['message'],
                        'auteur' => $row['nom'] . " " . $row['prenom'],
                        'id_auteur' => $row['ID_utilisateur']
                        ];  
    
                $commentaires[] = $commentaire;
            }
        }
        else 
        {
            $commentaires = 'Soyez le premier à commenter cet article';
        }

        return $commentaires;
    }


    public static function getCommentaire($id_commentaire) {

        $instance = ConnectDb::getInstance();
        $conn = $instance->getConnection();

        $query = $conn->prepare("SELECT commentaires.ID_commentaire, commentaires.date_creation, commentaires.date_modification, commentaires.message, commentaires.ID_utilisateur, utilisateurs.nom, utilisateurs.prenom
                                FROM commentaires
                                INNER JOIN utilisateurs ON (utilisateurs.ID_utilisateur = commentaires.ID_utilisateur)
                                WHERE commentaires.ID_commentaire = :id_commentaire");

        
        $query->bindValue(':id_commentaire', $id_commentaire);

        $query->execute();

        while($row = $query->fetch(PDO::FETCH_ASSOC))
        {
            $date_creation = helper::dateFormat($row['date_creation']);
            $date_modification = helper::dateFormat($row['date_modification']);
    
            $commentaire = [
                    'id_commentaire' => $row['ID_commentaire'],
                    'date_creation' => $date_creation,
                    'date_modification' => $date_modification,
                    'message' => $row['message'],
                    'auteur' => $row['nom'] . " " . $row['prenom'],
                    'id_auteur' => $row['ID_utilisateur']
                    ];  

            $commentaires[] = $commentaire;
        }

        return $commentaires;
    }
}

