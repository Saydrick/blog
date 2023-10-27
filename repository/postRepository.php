<?php

namespace blog\repository;

use blog\config\ConnectDb;
use PDO;

class postRepository {
    public static function getAllPosts(){
        
        $instance = ConnectDb::getInstance();
        $conn = $instance->getConnection();

        $sql = "SELECT posts.ID_post, posts.titre, posts.date_creation, posts.date_modification, posts.chapo, posts.contenu, utilisateurs.nom, utilisateurs.prenom
                FROM posts
                INNER JOIN utilisateurs ON (utilisateurs.ID_utilisateur = posts.ID_utilisateur)";

        $query = $conn->prepare($sql);
        $query->execute();

        $posts = [];
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {  
                $post = [
                        'id' => $row['ID_post'],
                        'titre' => $row['titre'],
                        'date_creation' => $row['date_creation'],
                        'date_modification' => $row['date_modification'],
                        'chapo' => $row['chapo'],
                        'contenu' => $row['contenu'],
                        'nom' => $row['nom'],
                        'prenom' => $row['prenom']
                        ];  

                $posts[] = $post;
        } 
           
        return $posts;
        
    }
}

