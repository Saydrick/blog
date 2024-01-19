<?php

namespace blog\repository;

use blog\config\ConnectDb;
use blog\helper\helper;
use PDO;

class allPostsRepository {
    public static function getAllPosts() {

        $instance = ConnectDb::getInstance();
        $conn = $instance->getConnection();

        $query = $conn->prepare("SELECT posts.ID_post, posts.titre, posts.date_creation, posts.date_modification, posts.chapo, posts.contenu, utilisateurs.nom, utilisateurs.prenom
                                FROM posts
                                INNER JOIN utilisateurs ON (utilisateurs.ID_utilisateur = posts.ID_utilisateur)
                                ORDER BY posts.date_modification DESC");
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
                    'chapo' => $row['chapo'],
                    'contenu' => $row['contenu'],
                    'auteur' => $row['nom'] . " " . $row['prenom']
                    ];  

            $posts[] = $post;
        } 
           
        return $posts;
        
    }
}

