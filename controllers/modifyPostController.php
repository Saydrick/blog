<?php

namespace blog\controllers;

use blog\repository\ModifyPostRepository;
use blog\service\ValidateService;
use blog\Exceptions\Exception;

class ModifyPostController
{
    protected ModifyPostRepository $ModifyPostRepository;
    protected ValidateService $ValidateService;

    public function __construct(ModifyPostRepository $ModifyPostRepository, ValidateService $ValidateService)
    {
        $this->ModifyPostRepository = $ModifyPostRepository;
        $this->ValidateService = $ValidateService;
    }

    public function update($id)
    {
        try {
            if (isset($_POST['envoyer'])) {
                // If token is not difined OR if post token is different from the session token
                if (!$_POST['token'] || $_POST['token'] !== $_SESSION['TOKEN']) {
                    throw new \RuntimeException('Error: Invalid form submission');
                }

                $formRules = [
                    'titre' => ['type' => 'required', 'message' => 'Veuillez renseigner le titre de l\'article'],
                    'contenu' => ['type' => 'required', 'message' => 'Veuillez renseigner le contenu de l\'article']
                ];

                $this->ValidateService->formValidate($_POST, $formRules);

                if ($_POST['chapo'] == '') {
                    $content = strip_tags($_POST['contenu']);
                    $chapo = substr($content, 0, 100);
                } else {
                    $chapo = strip_tags($_POST['chapo']);
                }

                $titre = strip_tags($_POST['titre']);
                $contenu = nl2br(strip_tags($_POST['contenu']));

                $result = $this->ModifyPostRepository->modifyPost($id, $titre, $chapo, $contenu);

                header("Location: /blog/public/post/" . $result);
            }
        } catch (Exception $e) {
            $result = 'Erreur : ' . $e->errorMessage();
        }

        // return $result;
    }
}
