<?php

namespace blog\repository;

use blog\config\ConnectDb;
use blog\enum\Is_checked;
use blog\helper\helper;
use PDO;

class administratorRepository {
    public static function getPosts() {

        $instance = ConnectDb::getInstance();
        $conn = $instance->getConnection();

        $query = $conn->prepare("SELECT posts.ID_post, posts.titre, posts.date_creation, posts.date_modification, utilisateurs.nom, utilisateurs.prenom
                                FROM posts
                                JOIN posts_commentaires ON (posts_commentaires.ID_post = posts.ID_post)
                                JOIN commentaires ON (commentaires.ID_commentaire = posts_commentaires.ID_commentaire)
                                JOIN utilisateurs ON (utilisateurs.ID_utilisateur = posts.ID_utilisateur)
                                WHERE commentaires.is_checked = :is_checked
                                GROUP BY posts.ID_post");
                                
        $query->bindValue(':is_checked', Is_checked::unverified->value);

        $query->execute();

        $posts = [];
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) 
        {  
            $date_creation = helper::dateFormat($row['date_creation']);
            $date_modification = helper::dateFormat($row['date_modification']);

            $post = [
                    'id' => $row['ID_post'],
                    'titre' => $row['titre'],
                    'date_creation' => $date_creation,
                    'date_modification' => $date_modification,
                    'auteur' => $row['nom'] . " " . $row['prenom']
                    ];  

            $posts[] = $post;
        } 
           
        return $posts;
        
    }


    public static function getComments() {

        $instance = ConnectDb::getInstance();
        $conn = $instance->getConnection();

        $query = $conn->prepare("SELECT posts_commentaires.ID_post, commentaires.ID_commentaire, commentaires.date_modification, commentaires.message, utilisateurs.nom, utilisateurs.prenom
                                FROM commentaires
                                JOIN posts_commentaires ON (posts_commentaires.ID_commentaire = commentaires.ID_commentaire)
                                JOIN utilisateurs ON (utilisateurs.ID_utilisateur = commentaires.ID_utilisateur)
                                WHERE commentaires.is_checked = :is_checked");
                                
        $query->bindValue(':is_checked', Is_checked::unverified->value);

        $query->execute();

        $comments = [];
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) 
        {  
            $date_modification = helper::dateFormat($row['date_modification']);

            $comment = [
                    'id_post' => $row['ID_post'],
                    'id_commentaire' => $row['ID_commentaire'],
                    'date_modification' => $date_modification,
                    'message' => $row['message'],
                    'auteur' => $row['nom'] . " " . $row['prenom']
                    ];  

            $comments[] = $comment;
        } 
           
        return $comments;
        
    }
}

