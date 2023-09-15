<?php

namespace 'blog/repository';

class userRepository {
    function getUser() {
        
        $instance = ConnectDb::getInstance();
        $conn = $instance->getConnection();

        $sql = 'SELECT ID_utilisateur, nom, prenom, is_admin FROM utilisateurs';
        $query = $conn->prepare($sql);
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
            return $users[];
    }
}