<?php

namespace blog\controllers;

use PHPMailer\PHPMailer\PHPMailer;
use blog\service\validateService;
use blog\Exceptions\Exception;

require_once('../config/requireLoader.php');

class contactController {

    protected PHPMailer $PHPMailer;
    protected validateService $_validateService;

    function __construct(PHPMailer $PHPMailer, validateService $validateService) {
        $this->PHPMailer = $PHPMailer; 
        $this->_validateService = $validateService;
    }

    function index() {


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
                    'nom' => ['type' => 'required', 'message' => 'Veuillez renseigner votre nom'],
                    'prenom' => ['type' => 'required', 'message' => 'Veuillez renseigner votre prénom'],
                    'mail' => ['type' => 'email', 'message' => 'L\'adresse mail entrée est incorrecte'],
                    'sujet' => ['type' => 'required', 'message' => 'Veuillez renseigner le sujet de votre message'],
                    'message' => ['type' => 'required', 'message' => 'Veuillez renseigner votre message']
                ];
            
                $this->_validateService->formValidate($_POST, $formRules);

                $nom = strip_tags($_POST['nom']);
                $prenom = strip_tags($_POST['prenom']);
                $mail = strip_tags($_POST['mail']);
                $sujet = strip_tags($_POST['sujet']);
                $message = strip_tags($_POST['message']);

                //Recipients
                $phpmailer->setFrom($mail, $nom . $prenom);
                $phpmailer->addAddress('cedric.bouzanquet@gmail.com', 'BOUZANQUET Cédric');     //Add a recipient
                // $phpmailer->addReplyTo('info@example.com', 'Information');
                // $phpmailer->addCC('cc@example.com');
                // $phpmailer->addBCC('bcc@example.com');

                //Content
                $phpmailer->isHTML(true);                                  //Set email format to HTML
                $phpmailer->Subject = $sujet;
                $phpmailer->Body    = $message;
                // $phpmailer->AltBody = 'This is the body in plain text for non-HTML mail clients';

                $phpmailer->send();

                $result = 'Votre message a bien été envoyé';
            }            

        } catch (Exception $e) {
            $result = 'Erreur : ' . $e->getMessage();
        }

        return $result;
    }
}