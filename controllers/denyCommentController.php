<?php

namespace blog\controllers;

use blog\repository\DenyCommentRepository;
use blog\repository\UserRepository;
use PHPMailer\PHPMailer\PHPMailer;
use blog\service\ValidateService;
use blog\Exceptions\Exception;

class DenyCommentController
{
    protected DenyCommentRepository $DenyCommentRepository;
    protected UserRepository $UserRepository;
    protected PHPMailer $PHPMailer;
    protected ValidateService $ValidateService;

    public function __construct(
        DenyCommentRepository $DenyCommentRepository,
        UserRepository $UserRepository,
        PHPMailer $PHPMailer,
        ValidateService $ValidateService
    ) {
        $this->DenyCommentRepository = $DenyCommentRepository;
        $this->UserRepository = $UserRepository;
        $this->PHPMailer = $PHPMailer;
        $this->ValidateService = $ValidateService;
    }

    public function delete($id_comment, $id_user)
    {
        try {
            // Send mail to user to explain the deny
            $phpmailer = new PHPMailer(true);

            try {
                //Server settings
                $phpmailer->isSMTP();
                $phpmailer->Host = 'sandbox.smtp.mailtrap.io';
                $phpmailer->SMTPAuth = true;
                $phpmailer->Port = 2525;
                $phpmailer->Username = '191c523b7f1049';
                $phpmailer->Password = '0fa568225101b2';


                if (isset($_POST['envoyer'])) {
                    // If token is not difined OR if post token is different from the session token
                    if (!$_POST['token'] || $_POST['token'] !== $_SESSION['TOKEN']) {
                        throw new \RuntimeException('Error: Invalid form submission');
                    }

                    $formRules = [
                        'motif' => ['type' => 'required', 'message' => 'Veuillez renseigner votre motif']
                    ];

                    $this->ValidateService->formValidate($_POST, $formRules);

                    $message = strip_tags($_POST['motif']);

                    // Delete comment from DB
                    $result = $this->DenyCommentRepository->denyComment($id_comment);

                    // User and admin Recovery
                    $comment_user = $this->UserRepository->getUser($id_user);
                    $admin_user = $this->UserRepository->getUser($_SESSION['USER_ID']);

                    $comment_email = $comment_user['email'];
                    $comment_nom = $comment_user['nom'];
                    $comment_prenom = $comment_user['prenom'];

                    $admin_email = $admin_user['email'];
                    $admin_nom = $admin_user['nom'];
                    $admin_prenom = $admin_user['prenom'];

                    //Recipients
                    $phpmailer->setFrom($admin_email, $admin_nom . $admin_prenom);
                    $phpmailer->addAddress($comment_email, $comment_nom . $comment_prenom);     //Add a recipient

                    //Content
                    $phpmailer->isHTML(true);    //Set email format to HTML
                    $phpmailer->CharSet = 'UTF-8';
                    $phpmailer->Encoding = 'base64';
                    $phpmailer->Subject = 'Blog Bouzanquet Cédric : Votre commentaire a été refusé';
                    $phpmailer->Body    = $message;

                    $phpmailer->send();

                    $result = 'Votre message a bien été envoyé';
                }
            } catch (Exception $e) {
                $result = 'Erreur : ' . $e->getMessage();
            }



            header("Location: /blog/public/admin");
        } catch (Exception $e) {
            $result = 'Erreur : ' . $e->errorMessage();
        }

        return $result;
    }
}
