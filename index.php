<?php

require_once 'vendor/autoload.php';
require_once('config/ConnectDb.class.php');

$loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/views');
$template = new \Twig\Environment($loader, ['cache' => false]);

$user = new userController;
$user->index();

?>