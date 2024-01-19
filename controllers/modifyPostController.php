<?php

namespace blog\controllers;

use blog\repository\modifyPostRepository;
use blog\service\validateService;
use blog\Exceptions\Exception;

class modifyPostController {

    protected modifyPostRepository $_modifyPostRepository;
    protected validateService $_validateService;

    function __construct(modifyPostRepository $modifyPostRepository, validateService $validateService) {
        $this->_modifyPostRepository = $modifyPostRepository;
        $this->_validateService = $validateService;
    }

    function update($id) {
        try {
            if(isset($_POST['envoyer'])) {

                // If token is not difined OR if post token is different from the session token
                if (!$_POST['token'] || $_POST['token'] !== $_SESSION['TOKEN']) {
                    // show an error message
                    echo '<p class="error">Error: invalid form submission</p>';
                    // return 405 http status code
                    header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
                    exit;
                }

                $formRules = [
                    'titre' => ['type' => 'required', 'message' => 'Veuillez renseigner le titre de l\'article'],
                    'contenu' => ['type' => 'required', 'message' => 'Veuillez renseigner le contenu de l\'article']
                ];
            
                $this->_validateService->formValidate($_POST, $formRules);

                if ($_POST['chapo'] == '')
                {
                    $content = strip_tags($_POST['contenu']);
                    $chapo = substr($content, 0, 100);
                }
                else
                {
                    $chapo = strip_tags($_POST['chapo']); 
                }

                $titre = strip_tags($_POST['titre']); 
                $contenu = nl2br(strip_tags($_POST['contenu'])); 

                $result = $this->_modifyPostRepository->modifyPost($id, $titre, $chapo, $contenu);      

                header("Location: /blog/public/post/" . $result);
                exit;                       
            }
                        
        } catch (Exception $e) {
            $result = 'Erreur : ' . $e->errorMessage();
        }

        // return $result;
    }

}