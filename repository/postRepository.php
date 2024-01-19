<?php

namespace blog\repository;

use blog\config\ConnectDb;
use blog\helper\helper;
use Michelf\Markdown;
use PDO;

class postRepository {
    public static function getPost($id_post) {

        $instance = ConnectDb::getInstance();
        $conn = $instance->getConnection();

        $query = $conn->prepare("SELECT posts.ID_post, posts.titre, posts.date_creation, posts.date_modification, posts.chapo, posts.contenu, posts.ID_utilisateur, utilisateurs.nom, utilisateurs.prenom
                                FROM posts
                                INNER JOIN utilisateurs ON (utilisateurs.ID_utilisateur = posts.ID_utilisateur)
                                WHERE posts.ID_post = :id_post");

        $query->bindValue(':id_post', $id_post, PDO::PARAM_INT);
        
        $query->execute();

        $row = $query->fetch(PDO::FETCH_ASSOC);

        $date_creation = helper::dateFormat($row['date_creation']);
        $date_modification = helper::dateFormat($row['date_modification']);

        $contenu = Markdown::defaultTransform($row['contenu']);

        $post = [
                'id' => $row['ID_post'],
                'titre' => $row['titre'],
                'date_creation' => $date_creation,
                'date_modification' => $date_modification,
                'chapo' => $row['chapo'],
                'contenu' => $contenu,
                'auteur' => $row['nom'] . " " . $row['prenom'],
                'id_auteur' => $row['ID_utilisateur'],
                'utilisateur' => !empty($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : NULL
                ];  

        $posts[] = $post;
           
        return $posts;
        
    }
}

