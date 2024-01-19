<?php

/* TODO */
namespace blog\controllers;

use blog\repository\denyCommentRepository;
use blog\repository\userRepository;
use PHPMailer\PHPMailer\PHPMailer;
use blog\service\validateService;
use blog\Exceptions\Exception;

class denyCommentController {

    protected denyCommentRepository $_denyCommentRepository;
    protected userRepository $_userRepository;
    protected PHPMailer $PHPMailer;
    protected validateService $_validateService;

    function __construct(denyCommentRepository $denyCommentRepository, userRepository $userRepository, PHPMailer $PHPMailer, validateService $validateService) {
        $this->_denyCommentRepository = $denyCommentRepository;
        $this->_userRepository = $userRepository;
        $this->PHPMailer = $PHPMailer; 
        $this->_validateService = $validateService;
    }

    function delete($id_comment, $id_user) {
        try {
            // Send mail to user to explain the deny
            $phpmailer = new PHPMailer(true);

            try {
                //Server settings
                // $phpmailer->SMTPDebug = SMTP::DEBUG_SERVER;  
                $phpmailer->isSMTP();
                $phpmailer->Host = 'sandbox.smtp.mailtrap.io';
                $phpmailer->SMTPAuth = true;
                $phpmailer->Port = 2525;
                $phpmailer->Username = '191c523b7f1049';
                $phpmailer->Password = '0fa568225101b2';


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
                        'motif' => ['type' => 'required', 'message' => 'Veuillez renseigner votre motif']
                    ];
                
                    $this->_validateService->formValidate($_POST, $formRules);

                    $message = strip_tags($_POST['motif']);

                    // Delete comment from DB
                    $result = $this->_denyCommentRepository->denyComment($id_comment);    

                    // User and admin Recovery
                    $comment_user = $this->_userRepository->getUser($id_user);
                    $admin_user = $this->_userRepository->getUser($_SESSION['USER_ID']);
                    
                    $comment_email = $comment_user['email'];
                    $comment_nom = $comment_user['nom'];
                    $comment_prenom = $comment_user['prenom'];

                    $admin_email = $admin_user['email'];
                    $admin_nom = $admin_user['nom'];
                    $admin_prenom = $admin_user['prenom'];

                    /* TODO vérifier que tout à l'air OK et tester */

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
            exit;                       
                        
        } catch (Exception $e) {
            $result = 'Erreur : ' . $e->errorMessage();
        }

        return $result;
    }

}