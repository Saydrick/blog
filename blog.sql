-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mar. 13 fév. 2024 à 16:39
-- Version du serveur : 5.7.36
-- Version de PHP : 8.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `blog`
--

-- --------------------------------------------------------

--
-- Structure de la table `commentaires`
--

CREATE TABLE `commentaires` (
  `ID_commentaire` int(8) NOT NULL,
  `date_creation` date NOT NULL,
  `date_modification` date NOT NULL,
  `message` text NOT NULL,
  `is_checked` tinyint(1) NOT NULL DEFAULT '0',
  `ID_utilisateur` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `commentaires`
--

INSERT INTO `commentaires` (`ID_commentaire`, `date_creation`, `date_modification`, `message`, `is_checked`, `ID_utilisateur`) VALUES
(6, '2023-12-15', '2023-12-15', 'Bonjour, j\'ai vraiment aimé votre article ! Merci beaucoup\r\n', 1, 2),
(8, '2023-12-15', '2023-12-15', 'j\'ai appris plein de truc.', 1, 2),
(9, '2023-12-15', '2023-12-15', 'coucou', 1, 2),
(12, '2024-01-10', '2024-01-10', 'je confirme que ça fonctionne. Bravo !', 1, 2),
(13, '2024-01-10', '2024-01-10', 'Ce commentaire peut être supprimé', 1, 2),
(14, '2024-01-11', '2024-02-12', 'Inspirant ! Cet article m\'a rappelé l\'importance de la curiosité et de l\'ouverture d\'esprit dans notre quête créative. Les conseils pratiques sur le brainstorming vont certainement enrichir ma démarche créative au quotidien. ', 1, 2),
(17, '2024-02-12', '2024-02-12', 'Bonjour', 0, 2);

-- --------------------------------------------------------

--
-- Structure de la table `posts`
--

CREATE TABLE `posts` (
  `ID_post` int(8) NOT NULL,
  `titre` varchar(100) NOT NULL,
  `date_creation` date NOT NULL,
  `date_modification` date NOT NULL,
  `chapo` varchar(250) NOT NULL,
  `contenu` text NOT NULL,
  `ID_utilisateur` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `posts`
--

INSERT INTO `posts` (`ID_post`, `titre`, `date_creation`, `date_modification`, `chapo`, `contenu`, `ID_utilisateur`) VALUES
(1, 'Test 1', '2023-10-19', '2023-12-01', 'Test de post #1.5', 'Ceci est le 1er post de ce blog.\r\nIl est utilisé pour tester la création d\'un controller. \r\n\r\nTout s\'est bien passé !', 1),
(2, 'Test 2', '2023-12-01', '2023-12-01', 'Test de l\'ajout d\'un nouvel article', 'Cet article sert à tester l\'ajout d\'un nouvel article dans la base de données ainsi que la redirection vers la page de l\'article s\'il a bien été créé.', 2),
(3, 'Test 3', '2023-12-01', '2023-12-01', 'Vérification supplémentaire', 'On vérifie si ça fonctionne toujours !', 2),
(4, 'L\'Art de la Créativité : Cultiver l\'Inspiration au Quotidien !', '2024-01-11', '2024-02-12', 'Explorez les méandres de la créativité, comprenez les facteurs qui la nourrissent, et découvrez des méthodes pratiques pour libérer votre potentiel créatif dans tous les aspects de votre vie.', 'La créativité est souvent considérée comme une aptitude innée, mais elle peut être cultivée. Pour stimuler votre créativité, il est crucial de comprendre l\'importance de la curiosité, de l\'ouverture d\'esprit et du changement de perspective. En plongeant dans des activités variées, en explorant de nouvelles idées et en embrassant l\'échec comme un catalyseur d\'apprentissage, vous pouvez libérer votre esprit créatif. Des exemples concrets de techniques de brainstorming et d\'approches pour surmonter le blocage créatif sont également discutés pour vous aider à intégrer la créativité dans votre vie quotidienne. OK<br />\r\n', 2),
(5, 'L\'Écologie au Quotidien : Comment Adopter des Habitudes Respectueuses de l\'Environnement', '2024-01-11', '2024-01-11', 'Explorez les gestes simples qui peuvent avoir un impact positif sur l\'environnement. Découvrez comment intégrer des habitudes respectueuses de la planète dans votre vie quotidienne pour contribuer à la préservation de notre planète.', 'Cet article examine les petites actions quotidiennes qui, mises ensemble, peuvent avoir un impact significatif sur l\'environnement. De la réduction des déchets à la consommation responsable, en passant par les alternatives éco-friendly, découvrez comment chaque individu peut jouer un rôle crucial dans la préservation de la planète. Des ressources et des conseils pour un mode de vie plus durable sont également partagés.\r\n\r\n', 2),
(6, 'Les Mystères de la Méditation : Explorez la Sérénité Intérieure', '2024-01-11', '2024-01-11', 'Plongez dans le monde fascinant de la méditation. Explorez ses origines millénaires, comprenez les bienfaits pour le bien-être mental et découvrez des techniques pratiques pour intégrer la méditation dans votre vie quotidienne', 'La méditation, souvent associée à la spiritualité orientale, trouve ses racines dans des traditions séculaires. En explorant ces origines, on peut mieux comprendre les différentes approches de la méditation, allant de la pleine conscience à la méditation transcendantale.\n\nLes bienfaits de la méditation sur le bien-être mental sont soutenus par des études scientifiques. La réduction du stress, l\'amélioration de la concentration et la gestion des émotions sont quelques-uns des avantages documentés de la pratique méditative régulière.\n\nPour intégrer la méditation dans votre vie quotidienne, commencez par trouver un endroit calme et confortable. Adoptez une posture relaxée et concentrez-vous sur votre respiration. Des techniques spécifiques, telles que la méditation guidée ou la visualisation, peuvent être explorées pour trouver celle qui correspond le mieux à vos besoins.\n\nLa méditation ne nécessite pas nécessairement un engagement religieux. Elle peut être une pratique laïque, accessible à tous, quel que soit leur contexte spirituel. En faisant de la méditation une routine quotidienne, vous pouvez cultiver la paix intérieure et la clarté mentale.\n\n', 2),
(7, 'L\'Art de la Créativité : Nourrir l\'Inspiration pour une Vie Épanouissante', '2024-01-11', '2024-01-11', 'Découvrez comment libérer le potentiel créatif qui sommeille en vous. Plongez dans l\'univers infini de la créativité, explorez ses racines profondes et apprenez à cultiver une mentalité propice à l\'innovation dans tous les aspects de votre vie.', 'La créativité n\'est pas simplement un don réservé à quelques-uns, mais une qualité innée que chacun peut développer. Pour éveiller votre créativité, commencez par cultiver la curiosité. Ouvrez votre esprit à de nouvelles expériences, explorez des domaines qui vous sont étrangers et embrassez le mystère de l\'inconnu. La créativité naît souvent de la capacité à voir le monde sous des angles différents.<br />\r\n<br />\r\nEn embrassant l\'échec comme un compagnon naturel du processus créatif, vous libérez la peur de l\'imperfection qui peut entraver votre pensée innovante. C\'est dans les erreurs que se cachent parfois les idées les plus lumineuses et les solutions les plus novatrices.<br />\r\n<br />\r\nLes activités variées sont le carburant de la créativité. Ne limitez pas votre exploration à un seul domaine. Que ce soit la peinture, la musique, l\'écriture ou l\'ingénierie, chaque discipline offre une perspective unique qui peut enrichir votre répertoire créatif. Même des activités simples comme la marche dans la nature ou la contemplation silencieuse peuvent déclencher des étincelles d\'inspiration.<br />\r\n<br />\r\nLes techniques de brainstorming sont des outils puissants pour stimuler la créativité. Organisez des sessions de réflexion où aucune idée n\'est jugée. Encouragez la pensée divergente et explorez des solutions audacieuses. Vous pourriez être surpris par la profondeur de votre inventivité lorsque les barrières de la pensée conventionnelle sont levées.<br />\r\n<br />\r\nLa créativité peut être une force motrice non seulement pour le développement personnel, mais aussi pour le progrès social et économique. Les grandes innovations de l\'histoire ont souvent émergé de l\'esprit créatif de personnes audacieuses qui ont osé défier le statu quo.<br />\r\n<br />\r\nEn fin de compte, la créativité n\'est pas simplement un trait de personnalité, mais une habitude à cultiver. En intégrant des pratiques créatives dans votre routine quotidienne, vous nourrissez cette flamme intérieure. Transformez chaque défi en opportunité d\'innover. Vous pourriez découvrir que la créativité n\'est pas seulement une compétence, mais un mode de vie.', 2);

-- --------------------------------------------------------

--
-- Structure de la table `posts_commentaires`
--

CREATE TABLE `posts_commentaires` (
  `ID_post_commentaire` int(8) NOT NULL,
  `ID_post` int(8) NOT NULL,
  `ID_commentaire` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `posts_commentaires`
--

INSERT INTO `posts_commentaires` (`ID_post_commentaire`, `ID_post`, `ID_commentaire`) VALUES
(1, 1, 6),
(3, 1, 8),
(4, 2, 9),
(7, 3, 12),
(8, 3, 13),
(9, 4, 14),
(12, 4, 17);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `ID_utilisateur` int(8) NOT NULL,
  `nom` varchar(40) NOT NULL,
  `prenom` varchar(40) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`ID_utilisateur`, `nom`, `prenom`, `email`, `password`, `is_admin`) VALUES
(1, 'Doe', 'John', 'john.doe@gmail.com', 'Passw0rd', 1),
(2, 'Bouzanquet', 'Cédric', 'cedric.bouzanquet@gmail.com', '$2y$10$QaQ4cmMk6jSHOAB/Dqps8uMJst0pTG0owIHczRrYT9UZ4VsBuGgT6', 1),
(3, 'Dupond', 'Jean', 'jean.dupond@mail.com', '$2y$10$WRoveOQa6zZZVmpYOPNrTu55sRzd1aSzosltAkYrtw9PpBr47312S', 0),
(6, 'Martin', 'Marie', 'm.martin@mail.com', '$2y$10$XWQokJPUKfs7IZIdIyYfxuFvfoRCSIqS.7xASC7ZkgAyKQBvT28NC', 0),
(7, 'User', 'test', 'user@user.com', '$2y$10$kehBJt2q0qb8x3SC7D3U5.edkVIBA21ldn9UkQGVXNNmFVleh/ufS', 0),
(8, 'Admin', 'test', 'admin@admin.com', '$2y$10$.8xQ57JRRCTCqxO71VQrE.GJuJ0KSao9Wrskfmfcy/rqTAJLZGWga', 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `commentaires`
--
ALTER TABLE `commentaires`
  ADD PRIMARY KEY (`ID_commentaire`),
  ADD KEY `commentaires_id_utilisateur_foreign` (`ID_utilisateur`);

--
-- Index pour la table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`ID_post`),
  ADD KEY `posts_id_utilisateur_foreign` (`ID_utilisateur`);

--
-- Index pour la table `posts_commentaires`
--
ALTER TABLE `posts_commentaires`
  ADD PRIMARY KEY (`ID_post_commentaire`),
  ADD KEY `posts_commentaire_ID_commentaire_foreign` (`ID_commentaire`),
  ADD KEY `posts_commentaire_ID_post_foreign` (`ID_post`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`ID_utilisateur`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `commentaires`
--
ALTER TABLE `commentaires`
  MODIFY `ID_commentaire` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `posts`
--
ALTER TABLE `posts`
  MODIFY `ID_post` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `posts_commentaires`
--
ALTER TABLE `posts_commentaires`
  MODIFY `ID_post_commentaire` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `ID_utilisateur` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commentaires`
--
ALTER TABLE `commentaires`
  ADD CONSTRAINT `commentaires_id_utilisateur_foreign` FOREIGN KEY (`ID_utilisateur`) REFERENCES `utilisateurs` (`ID_utilisateur`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_id_utilisateur_foreign` FOREIGN KEY (`ID_utilisateur`) REFERENCES `utilisateurs` (`ID_utilisateur`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `posts_commentaires`
--
ALTER TABLE `posts_commentaires`
  ADD CONSTRAINT `posts_commentaire_ID_commentaire_foreign` FOREIGN KEY (`ID_commentaire`) REFERENCES `commentaires` (`ID_commentaire`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `posts_commentaire_ID_post_foreign` FOREIGN KEY (`ID_post`) REFERENCES `posts` (`ID_post`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
