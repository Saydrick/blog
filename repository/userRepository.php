<?php

namespace blog\repository;

use blog\config\ConnectDb;
use PDO;

class userRepository {
    public static function getAllUsers() {

        $instance = ConnectDb::getInstance();
        $conn = $instance->getConnection();

        $query = $conn->prepare("SELECT ID_utilisateur, nom, prenom, is_admin 
                                FROM utilisateurs");
        $query->execute();

        $users = [];
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {  
                $user = [
                        'id' => $row['ID_utilisateur'],
                        'nom' => $row['nom'],
                        'prenom' => $row['prenom'],
                        'is_admin' => $row['is_admin']
                        ];  





                $users[] = $user;
        } 
            return $users;
    }


    public static function getUserID($user_mail) {

        $instance = ConnectDb::getInstance();
        $conn = $instance->getConnection();

        $query = $conn->prepare("SELECT ID_utilisateur, nom, prenom, is_admin 
                                FROM utilisateurs 
                                WHERE email = '$user_mail'");
        $query->execute();

        $row = $query->fetch(PDO::FETCH_ASSOC);
        
        $user = [
                'id' => $row['ID_utilisateur'],
                'nom' => $row['nom'],
                'prenom' => $row['prenom'],
                'is_admin' => $row['is_admin']
                ];  

            return $user;
    }


    public static function getUser($user_id) {

        $instance = ConnectDb::getInstance();
        $conn = $instance->getConnection();

        $query = $conn->prepare("SELECT ID_utilisateur, nom, prenom, email, is_admin 
                                FROM utilisateurs 
                                WHERE ID_utilisateur = '$user_id'");
        $query->execute();

        $row = $query->fetch(PDO::FETCH_ASSOC);
        
        $user = [
                'id' => $row['ID_utilisateur'],
                'nom' => $row['nom'],
                'prenom' => $row['prenom'],
                'is_admin' => $row['is_admin']
                ];  

            return $user;
    }
}
