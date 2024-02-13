# BLOG - Créez votre premier blog en PHP

Dans le cadre du projet n°5 de la formation Développeur d'application - PHP/Symfony de OpenClassrooms,
ce site web est un blog sur lequel on retrouve une page de présentation du développeur ainsi que de nombreux articles.


## PRÉREQUIS

- PHP version 7.0 ou supérieur
- Apache server version 2.4 ou supérieur
- Composer
- Base de données MYSQL


## INSTALLATION

- Cloner le projet sur GitHub [Lien vers le projet GitHub](https://github.com/Saydrick/blog) et l’ajouter dans le dossier des projets de votre environnement de serveur apache local avec la commande :
```
git clone https://github.com/Saydrick/blog.git
```
- Dans le dossier `blog\config\` mettre à jour le fichier `ConnectDb.php` avec les identifiants de connexion à votre base de données.
- Créer une base de données en local nommée "blog" et importer le fichier "blog.sql" qui se trouve à la racine du projet.
- Exécuter `composer install` à la racine du projet pour installer les bibliothèques du projet.

## UTILISATION

### Connexion
Se connecter en visiteur ou administrateur sur le site :

Visiteur :
- identifiant : user@user.com
- mot de passe : 1234

Administrateur : 
- identifiant : admin@admin.com
- mot de passe : 1234

L'envoie de mails depuis le formulaire de contact de la page d'accueil est actuellement intercepté par la platforme MailTrap.
Pour tester l'envoie de mails, il faut modifier les informations de connexion dans `contactController.php` avec vos identifiants.

### Fonctionnalités
Les principales fonctionnalités du projet accessibles suivant le type d'utilisateur connecté sont :

Tous types d'utilisateurs (connectés ou non) :
- Inscription / connexion / déconnexion du site.
- Lecture des articles et des commentaires associés.

Utilisateur connecté :
- Rédaction d'un article.
- Ajout de commentaires sur un article.
- Modification et/ou suppression d'un article (si l'utilisateur est l'auteur de l'article).
- Modification et/ou suppression d'un commentaire (si l'utilisateur est l'auteur du commentaire).

Administrateur :
- Validation ou refus des commentaires des utilisateurs.


## BIBLIOTHÈQUES UTILISÉES

Twig
Altorouter
PHPMailer

## BADGE CODACY
[![Codacy Badge](https://app.codacy.com/project/badge/Grade/79308f038ec545a696711eb8374611af)](https://app.codacy.com/gh/Saydrick/blog/dashboard?utm_source=gh&utm_medium=referral&utm_content=&utm_campaign=Badge_grade)

## AUTEUR

BOUZANQUET Cédric
