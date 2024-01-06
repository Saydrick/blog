<?php

namespace blog\controllers;

use blog\repository\addPostRepository;
use blog\service\validateService;
use blog\Exceptions\Exception;

class addPostController {

    protected addPostRepository $_addPostRepository;
    protected validateService $_validateService;

    function __construct(addPostRepository $addPostRepository, validateService $validateService) {
        $this->_addPostRepository = $addPostRepository;
        $this->_validateService = $validateService;
    }

    function create() {
        try {
            if(isset($_POST['envoyer'])) {

                $formRules = [
                    'titre' => ['type' => 'required', 'message' => 'Veuillez renseigner le titre de l\'article'],
                    'contenu' => ['type' => 'required', 'message' => 'Veuillez renseigner le contenu de l\'article']
                ];
            
                $this->_validateService->formValidate($_POST, $formRules);

                if ($_POST['chapo'] == '')
                {
                    $chapo = substr($_POST['contenu'], 0, 30);
                }
                else
                {
                    $chapo = $_POST['chapo']; 
                }

                $titre = $_POST['titre']; 
                $contenu = $_POST['contenu']; 

                $result = $this->_addPostRepository->addPost($titre, $chapo, $contenu);      

                header("Location: /blog/public/post/" . $result);
                exit;                       
            }
                        
        } catch (Exception $e) {
            $result = 'Erreur : ' . $e->errorMessage();
        }

        // return $result;
    }

}