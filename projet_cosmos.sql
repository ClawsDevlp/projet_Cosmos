-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  lun. 20 mai 2019 à 12:19
-- Version du serveur :  5.7.26
-- Version de PHP :  7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `projet_cosmos`
--

-- --------------------------------------------------------

--
-- Structure de la table `avatar`
--

DROP TABLE IF EXISTS `avatar`;
CREATE TABLE IF NOT EXISTS `avatar` (
  `id_avatar` int(1) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_avatar`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `avatar`
--

INSERT INTO `avatar` (`id_avatar`, `link`) VALUES
(1, 'images/avatars/avatar_1.jpg'),
(2, 'images/avatars/avatar_2.jpg'),
(3, 'images/avatars/avatar_3.jpg'),
(4, 'images/avatars/avatar_4.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `badges`
--

DROP TABLE IF EXISTS `badges`;
CREATE TABLE IF NOT EXISTS `badges` (
  `id_badge` int(2) NOT NULL,
  `nom_badge` varchar(255) DEFAULT NULL,
  `description_badge` varchar(255) DEFAULT NULL,
  `id_texte` int(3) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_badge`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `badges`
--

INSERT INTO `badges` (`id_badge`, `nom_badge`, `description_badge`, `id_texte`, `link`) VALUES
(1, 'Petit ange parti trop tôt', 'Vous avez appuyé sur le bouton bleu. Il fallait manifestement appuyer sur l\'autre bouton.', 6, 'images/badges/badge_1.jpg'),
(2, 'Noir c\'est noir', 'Vous êtes mort d\'asphyxie dans la salle des machines ; seul, dans le noir, il n\'y avait plus d\'espoir.', 18, 'images/badges/badge_2.jpg'),
(3, 'La race avant tout', 'Vous avez vidé une bouteille de whisky à vous tout seul. Ça c\'est IMAC ! (L\'abus d\'alcool est dangereux pour la santé.)', 30, 'images/badges/badge_3.jpg'),
(4, '440 Hz', 'Vous préférez les aventures spaciales aux analyses spectrales.', 44, 'images/badges/badge_4.jpg'),
(5, 'Complètement marteau', 'Vous avez (volontairement ?) aggravé vos blessures avec un marteau.', 47, 'images/badges/badge_5.jpg'),
(6, 'Oh no.', 'Vous êtes mort dans d\'atroces souffrances des suites de vos blessures.', 49, 'images/badges/badge_6.jpg'),
(7, 'MacGyver', 'Vous êtes parvenu à vous soigner.', 92, 'images/badges/badge_7.jpg'),
(8, 'Tapez dans l\'dos !', 'En l\'absence de premiers secours, vous êtes mort d\'étouffement.', 102, 'images/badges/badge_8.jpg'),
(9, 'Bienvenue dans la grappe', 'Vous vous êtes intégré parmi les Raisseriens.', 111, 'images/badges/badge_9.jpg'),
(10, 'Les Raisins de la colère', 'Vous avez servi de repas aux Raisseriens. ', 115, 'images/badges/badge_10.jpg'),
(11, 'Caaapitaine Flam', 'Vous avez atteri sur Sonhat avec succès.', 87, 'images/badges/badge_11.jpg'),
(12, 'Poussières d’étoiles', 'A la suite d\'une explosion, vous avez été réduit à l\'état de miettes. De touuutes petites miettes.', 69, 'images/badges/badge_12.jpg'),
(13, 'Chorémanie', 'Votre superbe déhanché aura eu raison de vous.', 79, 'images/badges/badge_13.jpg'),
(14, 'Mon langage de requête structurée', 'Vous êtes allé aux limites de l\'univers et découvert que vous étiez en fait une requête SQL. ', 75, 'images/badges/badge_14.jpg'),
(15, 'Premier degré', 'La blague du chef des Raisseriens vous a laissé de marbre.', 112, 'images/badges/badge_15.jpg'),
(16, 'Fintastique !', 'Vous avez débloqué toutes les fins.', NULL, 'images/badges/badge_16.jpg'),
(17, 'C\'EST LE BOUTON ROUGE', 'Vous vous êtes obstiné à appuyer au moins 10 fois sur le bouton bleu. ', NULL, 'images/badges/badge_17.jpg'),
(18, 'Passion amnésie spatiale', 'Vous avez effectué au moins 30 parties. ', NULL, 'images/badges/badge_18.jpg'),
(19, 'J\'adore ce que vous faîtes', 'Vous avez collectionné tous les badges.', NULL, 'images/badges/badge_19.jpg'),
(20, 'Pasc\'elle le vaut bien', 'Vous avez «Pascale» dans votre pseudo.', NULL, 'images/badges/badge_20.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `badgesobtenus`
--

DROP TABLE IF EXISTS `badgesobtenus`;
CREATE TABLE IF NOT EXISTS `badgesobtenus` (
  `id_joueur` int(11) NOT NULL,
  `id_badge` int(2) NOT NULL,
  `id_partie` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_joueur`,`id_badge`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `badgesobtenus`
--

INSERT INTO `badgesobtenus` (`id_joueur`, `id_badge`, `id_partie`) VALUES
(1, 1, 57),
(1, 17, NULL),
(1, 18, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `joueur`
--

DROP TABLE IF EXISTS `joueur`;
CREATE TABLE IF NOT EXISTS `joueur` (
  `id_joueur` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(20) NOT NULL,
  `mdp` varchar(32) NOT NULL,
  `planete_origine` varchar(20) DEFAULT NULL,
  `id_avatar` int(11) NOT NULL,
  PRIMARY KEY (`id_joueur`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `joueur`
--

INSERT INTO `joueur` (`id_joueur`, `pseudo`, `mdp`, `planete_origine`, `id_avatar`) VALUES
(1, 'BaptisteO', 'c654fccb73b6aec4534cfaf165bdc26c', NULL, 3),
(2, 'pascale_patraque', 'abfdeb7faf918063f887720c9ebe0222', NULL, 2);

-- --------------------------------------------------------

--
-- Structure de la table `objets`
--

DROP TABLE IF EXISTS `objets`;
CREATE TABLE IF NOT EXISTS `objets` (
  `id_objet` int(3) NOT NULL,
  `nom_objet` varchar(25) DEFAULT NULL,
  `id_reponse` int(3) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_objet`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `objets`
--

INSERT INTO `objets` (`id_objet`, `nom_objet`, `id_reponse`, `link`) VALUES
(1, 'Clé à molette', 3, 'images/objets/objet1.jpg'),
(2, 'Tournevis', 4, 'images/objets/objet2.jpg'),
(3, 'Marteau', 5, 'images/objets/objet3.jpg'),
(4, 'Chapeau', 27, 'images/objets/objet4.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `objetsrecuperes`
--

DROP TABLE IF EXISTS `objetsrecuperes`;
CREATE TABLE IF NOT EXISTS `objetsrecuperes` (
  `id_partie` int(11) NOT NULL,
  `id_objet` int(3) NOT NULL,
  PRIMARY KEY (`id_partie`,`id_objet`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `objetsrecuperes`
--

INSERT INTO `objetsrecuperes` (`id_partie`, `id_objet`) VALUES
(12, 3),
(14, 3),
(15, 3),
(18, 3),
(19, 2),
(20, 2),
(21, 2),
(24, 2),
(26, 2),
(28, 3),
(29, 2),
(30, 2),
(30, 4),
(31, 2),
(32, 3),
(34, 1),
(35, 1),
(36, 3),
(38, 2),
(50, 2),
(52, 3),
(53, 3),
(54, 1),
(55, 3),
(56, 3),
(60, 2);

-- --------------------------------------------------------

--
-- Structure de la table `partie`
--

DROP TABLE IF EXISTS `partie`;
CREATE TABLE IF NOT EXISTS `partie` (
  `id_partie` int(11) NOT NULL AUTO_INCREMENT,
  `id_texte` int(3) NOT NULL,
  `id_joueur` int(11) NOT NULL,
  `date_texte` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_partie`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `partie`
--

INSERT INTO `partie` (`id_partie`, `id_texte`, `id_joueur`, `date_texte`) VALUES
(1, 6, 1, '2019-04-28 19:56:46'),
(2, 6, 1, '2019-04-28 19:56:50'),
(3, 6, 1, '2019-04-28 19:56:54'),
(4, 6, 1, '2019-04-28 19:56:57'),
(5, 6, 1, '2019-04-28 19:57:02'),
(6, 6, 1, '2019-04-28 19:57:05'),
(7, 6, 1, '2019-04-28 19:57:07'),
(8, 6, 1, '2019-04-28 19:57:10'),
(9, 6, 1, '2019-04-28 19:57:13'),
(10, 6, 1, '2019-04-28 19:57:23'),
(11, 6, 1, '2019-04-28 20:03:41'),
(12, 49, 1, '2019-04-28 20:03:49'),
(13, 6, 1, '2019-04-29 10:51:08'),
(14, 49, 1, '2019-04-29 10:51:13'),
(15, 48, 1, '2019-04-29 10:54:36'),
(16, 1, 1, '2019-04-29 11:09:50'),
(17, 6, 1, '2019-04-29 11:10:44'),
(18, 49, 1, '2019-04-29 11:10:48'),
(19, 89, 1, '2019-04-29 11:11:16'),
(20, 57, 1, '2019-04-29 11:11:28'),
(21, 115, 1, '2019-04-29 11:11:54'),
(22, 6, 1, '2019-04-29 11:18:57'),
(23, 6, 1, '2019-04-29 11:19:13'),
(24, 44, 1, '2019-04-29 11:19:17'),
(25, 6, 1, '2019-04-29 18:19:27'),
(26, 102, 1, '2019-04-29 18:23:05'),
(27, 6, 1, '2019-04-29 19:02:16'),
(28, 44, 1, '2019-04-29 19:02:19'),
(29, 115, 1, '2019-04-29 19:04:42'),
(30, 111, 1, '2019-04-29 19:12:20'),
(31, 69, 1, '2019-04-29 19:14:15'),
(32, 44, 1, '2019-04-29 19:16:29'),
(33, 6, 1, '2019-04-29 19:16:42'),
(34, 18, 1, '2019-04-29 19:16:45'),
(35, 18, 1, '2019-04-29 19:16:54'),
(36, 102, 1, '2019-04-29 19:17:02'),
(37, 6, 1, '2019-04-29 19:18:50'),
(38, 75, 1, '2019-04-29 19:18:53'),
(39, 1, 1, '2019-04-29 19:22:19'),
(40, 8, 2, '2019-05-09 20:46:40'),
(41, 1, 2, '2019-05-09 20:47:40'),
(42, 6, 2, '2019-05-09 20:48:01'),
(43, 6, 1, '2019-05-09 22:06:35'),
(44, 2, 1, '2019-05-09 22:08:28'),
(45, 1, 1, '2019-05-09 22:09:47'),
(46, 6, 1, '2019-05-09 22:10:04'),
(47, 6, 1, '2019-05-09 22:13:09'),
(48, 6, 1, '2019-05-09 22:14:26'),
(49, 6, 1, '2019-05-09 22:18:59'),
(50, 44, 1, '2019-05-09 22:19:06'),
(51, 2, 3, '2019-05-09 22:26:43'),
(52, 49, 4, '2019-05-09 22:27:49'),
(53, 44, 4, '2019-05-09 22:32:40'),
(54, 18, 4, '2019-05-09 22:37:04'),
(55, 49, 4, '2019-05-09 22:37:29'),
(56, 102, 4, '2019-05-09 22:40:07'),
(57, 6, 1, '2019-05-09 22:59:34'),
(58, 6, 1, '2019-05-09 22:59:41'),
(59, 6, 1, '2019-05-09 22:59:46'),
(60, 58, 1, '2019-05-09 23:18:38'),
(61, 6, 5, '2019-05-10 16:47:01');

-- --------------------------------------------------------

--
-- Structure de la table `reponses`
--

DROP TABLE IF EXISTS `reponses`;
CREATE TABLE IF NOT EXISTS `reponses` (
  `id_reponse` int(3) NOT NULL,
  `contenu_reponse` varchar(255) DEFAULT NULL,
  `id_texte_declencheur` int(3) NOT NULL,
  `id_objet_necessaire` int(3) DEFAULT NULL,
  `id_texte_destination` int(3) NOT NULL,
  PRIMARY KEY (`id_reponse`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `reponses`
--

INSERT INTO `reponses` (`id_reponse`, `contenu_reponse`, `id_texte_declencheur`, `id_objet_necessaire`, `id_texte_destination`) VALUES
(1, 'Bouton bleu', 4, NULL, 5),
(2, 'Bouton rouge', 4, NULL, 7),
(3, 'Clé à molette', 9, NULL, 10),
(4, 'Tournevis', 9, NULL, 10),
(5, 'Marteau', 9, NULL, 10),
(6, 'Démonter la poignée', 27, NULL, 28),
(7, 'Plier la porte', 27, NULL, 28),
(8, 'Se lever', 38, NULL, 39),
(9, 'Rester assis', 38, NULL, 45),
(10, 'L’arracher avec les mains', 46, NULL, 50),
(11, 'Utiliser votre tournevis', 46, 2, 48),
(12, 'Utiliser votre marteau', 46, 3, 47),
(13, 'Ne rien faire et rester sur vos gardes', 89, NULL, 97),
(14, 'Leur demander qui ils sont', 89, NULL, 103),
(15, 'Rester impassible', 107, NULL, 112),
(16, 'Esquisser un sourire nerveux', 107, NULL, 112),
(17, 'Faire un franc sourire', 107, 4, 108),
(18, 'Piquer un somme', 57, NULL, 34),
(19, 'Chercher des indices ailleurs', 57, NULL, 85),
(20, 'Chercher des indices dans le vaisseau', 57, NULL, 60),
(21, 'Lire le contenu', 63, NULL, 64),
(22, 'Détruire', 63, NULL, 70),
(23, 'Lancer', 70, NULL, 71),
(24, 'Écraser', 70, NULL, 116),
(25, 'Mettre de la musique', 116, NULL, 76),
(26, 'Tourner dans le fauteuil', 116, NULL, 80),
(27, 'Suivant', 83, NULL, 84);

-- --------------------------------------------------------

--
-- Structure de la table `textes`
--

DROP TABLE IF EXISTS `textes`;
CREATE TABLE IF NOT EXISTS `textes` (
  `id_texte` int(3) NOT NULL,
  `contenu_texte` varchar(300) DEFAULT NULL,
  `nb_end` int(2) DEFAULT NULL,
  PRIMARY KEY (`id_texte`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `textes`
--

INSERT INTO `textes` (`id_texte`, `contenu_texte`, `nb_end`) VALUES
(1, 'Vous ouvrez doucement les yeux...', NULL),
(2, 'Une lumière rougeâtre clignote dans la pièce.', NULL),
(3, 'Vous vous levez et reconnaissez le cockpit d\'un vaisseau spatial. Cependant, l\'appareil subit d\'importantes turbulences !', NULL),
(4, 'Paniqué.e, vous vous dirigez vers le tableau de bord. Deux gros boutons se présentent à vous. Sur lequel de ces boutons appuyez-vous ?', NULL),
(5, 'Le sas du cockpit s\'ouvre et vous êtes aspiré.e à l\'extérieur.', NULL),
(6, 'Le trou noir SX-7044, se trouvant à quelques milliers de kilomètres de là, engloutit votre cadavre à tout jamais.', 1),
(7, 'La lumière arrête de clignoter et le vaisseau commence à se stabiliser.', NULL),
(8, 'Un message d\'alerte apparaît alors sur l\'un des écrans : Niveau d\'oxygène en baisse : vanne n°22 non serrée.', NULL),
(9, 'Une boîte à outils se trouve à votre droite. Vous l’ouvrez et voyez quelques outils intéressants. Lequel choisissez-vous ?', NULL),
(10, 'Vous partez maintenant à la recherche de cette fameuse vanne n°22.', NULL),
(11, 'Le couloir est très sombre, vous avancez à tâtons.', NULL),
(12, 'Vous entrez dans ce qui vous semble être la salle des machines.', NULL),
(13, 'La clé à molette vous glisse des mains.', NULL),
(14, 'Elle s’écrase 20 mètres en dessous de vous, sous les nombreuses canalisations.', NULL),
(15, 'Vous commencez à avoir des vertige. Le niveau d’oxygène est maintenant dangereusement bas.', NULL),
(16, 'Vous arrivez devant la vanne n°22. Vous essayez de la tourner.', NULL),
(17, 'La vanne ne bouge pas d’un millimètre. Vous ré-essayez encore et encore, mais vos efforts sont vain.', NULL),
(18, 'Vous vous écroulez dans la salle des machines ... seul ... dans le noir...', 2),
(19, 'Vous arrivez devant la vanne n°22.', NULL),
(20, 'Malgré vos mains moites, vous arrivez à la resserrer.', NULL),
(21, 'Vous regagnez le cockpit et vous vous écroulez sur la banquette en cuir.', NULL),
(22, 'Le message d’alerte a disparu. Vous pouvez être fier de ce que vous venez d’accomplir !', NULL),
(23, '*blurp... blurp...*', NULL),
(24, 'Il semble que votre ventre crie famine.', NULL),
(25, 'Il faut dire que cette escapade dans la salle des machines vous a absorbé énormément d\'énergie.', NULL),
(26, 'Une gigantesque armoire en fer se trouve devant vous.', NULL),
(27, 'La poignée est bloquée. Vous sortez votre marteau.', NULL),
(28, 'A l’intérieur, peu de nourriture. Cependant, vous trouvez une flasque de whisky de très bonne facture !', NULL),
(29, 'Après tout, pourquoi pas ? Ça ne pourrait que vous requinquer !', NULL),
(30, '*Kof...kof…* Cette boisson est très forte...mais tellement bonne !', NULL),
(31, 'Vous allez vous asseoir sur le siège conducteur avec votre flasque. Vous admirez la magnifique vue de l’espace qui s’offre à vous.', NULL),
(32, 'Après un petit moment, l’éthanol commence à jouer sérieusement sur vos neurotransmetteurs.', NULL),
(33, 'Soudain, vous êtes pris d’un pique de fatigue et vous tombez à la renverse. Dans votre chute, vous déclenchez le levier de contrôle de l’appareil.', NULL),
(34, 'Sans même vous en apercevoir, vous déviez complètement de la trajectoire initiale et entrez dans l’atmosphère de la planète Sonhat..', NULL),
(35, 'Pendant que vous dormez paisiblement sur le sol de la cabine, votre vaisseau s’approche petit à petit de la surface de Sonhat.', NULL),
(36, 'Un signal d’alerte se déclenche dans le cockpit. Rien n’y fait, vous dormez.', NULL),
(37, 'Le vaisseau s’écrase dans un désert de sel.', NULL),
(38, 'Le choc vous réveille. Le vaisseau est en miettes autour de vous. Vous êtes au milieu de rien. Que faire ?', NULL),
(39, 'Vous essayez de vous lever, mais votre jambe a été transpercée par un énorme morceau de verre.', NULL),
(40, 'Vous hurlez de douleur et retombez par terre. Le sel s’infiltre dans la plaie.', NULL),
(41, 'Sous l’effet de la douleur, vous perdez connaissance…', NULL),
(42, 'Un sifflement retentit dans votre tête.', NULL),
(43, 'Il s’accentue, devient de plus en plus fort, de plus en plus intense..!', NULL),
(44, 'Vous ré-ouvrez les yeux. Vous êtes en cours de signal et le professeur est en train de siffler un 440Hz pour la classe.', 3),
(45, 'Vous restez assis et remarquez que votre cuisse a été transpercée par un énorme morceau de verre...Vous restez assis et remarquez que votre cuisse a été transpercée par un énorme morceau de verre...', NULL),
(46, 'Il vous faut impérativement retirer cette chose de votre jambe !', NULL),
(47, 'Il semblerait que le choc vous ait rendu.e complètement marteau.', NULL),
(48, 'Vous regrettez instantanément le choix que vous venez de faire.', NULL),
(49, 'Vous mourez dans d’atroces souffrances.', 4),
(50, 'Vous vous apprêtez à retirer ce corps étranger de votre cuisse mais vous apercevez la flasque de whishy. Elle est juste en face de vous, intacte.', NULL),
(51, 'Vous tendez le bras pour l’atteindre et parvenez finalement à l’attraper.', NULL),
(52, 'Une gorgée pour le courage et le reste sur la plaie pour la désinfecter', NULL),
(53, 'Le verrou est fermé. Vous sortez le tournevis afin de crocheter la serrure.', NULL),
(54, 'A l’intérieur il y a de la nourriture en abondance.', NULL),
(55, '*Scrunch…scrunch…* Vous regagnez des forces.', NULL),
(56, 'Vous allez vous asseoir sur le siège conducteur. Vous admirez la magnifique vue de l’espace qui s’offre à vous.', NULL),
(57, 'Mais vous ne savez toujours pas ce vous faites là : la mémoire ne vous est pas encore revenue. Que voulez-vous faire ?', NULL),
(58, 'Il fait extrêmement chaud. Vous commencez à transpirer abondamment.', NULL),
(60, 'Vous fouillez le vaisseau à la recherche d’indices.', NULL),
(61, 'En ouvrant un placard, une pile de dossiers s’écroule et une clé USB atterrit près de vos pieds.', NULL),
(62, 'Sur cette clé USB, il y a une étiquette avec la mention « CONFIDENTIEL ».', NULL),
(63, 'Vous retournez près du tableau de bord avec cette clé USB. Un grand moment d’hésitation s’installe.', NULL),
(64, 'Des centaines de pages répertorient tous types d’informations sur vous.', NULL),
(65, 'Les souvenirs vous reviennent. Mais c’est vrai ! Vous vous appelez en fait...', NULL),
(66, '« ALERTE INTRUSION SYSTÈME »', NULL),
(67, '« AUTO-DESTRUCTION ENCLENCHÉE »', NULL),
(68, 'Vous restez bloqué.e. Vous êtes complètement paralysé.e face à ce qui est en train de se produire.', NULL),
(69, 'Un peu plus tard, vous êtes beaucoup de petites miettes dans le vide spatial.', 5),
(70, 'Plus vous la regardez et plus vous trouvez que la couleur bleue de cette clé est affreuse. Comment voulez-vous la détruire ?', NULL),
(71, 'Vous lancez la clé USB devant vous. Elle rebondit sur la vitre du cockpit, puis s’écrase sur le tableau de bord.', NULL),
(72, 'Le vaisseau se met à accélérer d’un coup. Derrière la vitre du cockpit les étoiles sont de plus en plus longues, puis filées, puis comme des petits carrés noirs.', NULL),
(73, 'Votre tête tourne. Tout autour de vous se transforme en écritures sur fond blanc.', NULL),
(74, 'Vous aussi vous n’êtes plus qu’une écriture sur fond blanc : « SELECT * FROM personnage ».', NULL),
(75, 'Vous êtes une requête SQL.', 6),
(76, 'Vous trouvez sur le tableau de bord un écran qui affiche une sorte d’interface de lecteur audio.', NULL),
(77, 'Vous appuyé sur ce qui vous semble être le bouton «lecture».', NULL),
(78, 'Une musique se fait entendre dans le vaisseau. Vous dansez jusqu’au bout de la nuit.', NULL),
(79, 'Puis le jour suivant, puis la nuit d’après, puis un tout petit peu d’autres jours avec les nuits qui vont avec, puis vous mourrez.', 7),
(80, 'Vous faites plusieurs tours dans le fauteuil. Cela vous amuse beaucoup, mais au bout d’un moment vous vous sentez un peu mal.', NULL),
(81, 'Vous courrez alors dans le vaisseau à la recherche d’une «salle d’eau», mais finissez par vomir sur le pauvre sol d’un couloir du vaisseau.', NULL),
(82, 'Après plusieurs rejets actifs d’une partie de votre estomac, vous apercevez, près de votre flaque de contenu gastrique, une trappe. Vous l’ouvrez.', NULL),
(83, 'Surpris, vous tombez sur le chargement du vaisseau : des milliers de petits chapeaux violets. Vous décidez de vous coiffer d’un de ces petits chapeaux.', NULL),
(84, 'Puis, vous remontez dans le couloir et rejoignez le cockpit.', NULL),
(85, 'Vous en avez marre de rester planté là. Vous commencez à actionner des boutons et des leviers : c’est comme si vous aviez toujours sû conduire ce vaisseau  finalement !', NULL),
(86, 'Vous voyez sur un écran la présence d’une planète non loin. Elle est, apparemment, nommée «Sonhat». Vous décidez de la rejoindre, dans l’espoir de trouver des indices sur votre identité.', NULL),
(87, 'Vous atterrissez devant une sorte de village. Les maisons sont sphériques et toutes collées les unes aux autres.', NULL),
(88, 'Un groupe d’autochtones ressemblants à de gros grains de raisins s’approche.', NULL),
(89, 'Tout naturellement, vous avez un peu peur. Que faites-vous ?', NULL),
(90, '« Aaaaaaaaaaah !! ». Oui ça fait mal, vous vous attendiez à quoi ?', NULL),
(91, 'Vous arrachez prestement le bout de verre de votre jambe.', NULL),
(92, 'Vous enlevez votre t-shirt et l\'enroulez autour de votre cuisse afin d’en faire un garrot.', NULL),
(93, 'Toutes ces péripéties vous ont épuisé.e. Vous fermez les yeux et tombez dans un sommeil profond.', NULL),
(94, '12 heures passent...', NULL),
(95, 'Vous ressentez une violente claque sur la joue droite : cela vous réveille.', NULL),
(96, 'Une tribu d’autochtones ressemblant à de gros grains de raisins vous ont recueilli et transporté jusque chez eux.', NULL),
(97, 'Vous reculez. Ils reculent aussi.', NULL),
(98, 'Après plusieurs minutes de longs et embarrassants regards, l’un d’entre eux tente de s’approcher.', NULL),
(99, 'Il vous apporte ce qui vous semble être un fruit.', NULL),
(100, 'Vous le remerciez par un geste de tête et commencez à manger. Chaque gros grains de raisin vous regarde, fasciné.', NULL),
(101, 'Tout à coup, vous commencez à vous étouffer. *Mmg.. mggg*', NULL),
(102, 'Votre visage déformé effraie les autochtones : ils partent en courant. Plus personne n’est là pour appliquer les gestes de premiers secours. Vous mourez.', 8),
(103, 'Ce qui vous semble être leur chef se met à vous répondre : «Oh ?! Vous parlez la même langue que nous ?»', NULL),
(104, '« Nous sommes des Raisseriens, nous vivons sur la planète Sonhat depuis 4500 ans. »', NULL),
(105, '« L’engin avec lequel vous êtes arrivé ici est rudement sophistiqué, dites-nous ! »', NULL),
(106, 'Sous le choc, vous n’arrivez plus à prononcer un seul mot.', NULL),
(107, '« Ne soyez pas si terrorisé.e, on ne va pas vous manger ! Quoique… » Tous les grains de raisin se fendent la poire.', NULL),
(108, '« Étranger, ton petit chapeau et toi m’êtes sympathiques. Nous, Raisseriens, jurons de t’aider dans ta quête, et ce, quels que soient les problèmes que tu rencontres ! »', NULL),
(109, 'Les grains décident d’organiser une célébration en votre honneur.', NULL),
(110, 'Ils vous rebaptisent et vous font entrer dans leur « grappe ».', NULL),
(111, 'Il est l’heure pour vous de démarrer une nouvelle vie pleine de surprises et de rebondissements !', 9),
(112, 'Le chef des autochtones fait un signe de tête à l’un de ses collègues.', NULL),
(113, 'Ce dernier revient avec une hache pleine de jus de raisin.', NULL),
(114, 'Le chef vous regarde et sourit bêtement.', NULL),
(115, 'Vous êtes sur le point de devenir une nouvelle expérience culinaire pour toute la tribu.', 10),
(116, 'Vous placez la clé au sol. Puis, vous levez très haut votre pied puis le faites tomber lourdement sur cette dernière. La clé USB n’est plus. Que voulez-vous faire maintenant ?', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `textesuivant`
--

DROP TABLE IF EXISTS `textesuivant`;
CREATE TABLE IF NOT EXISTS `textesuivant` (
  `id_texte_origine` int(3) NOT NULL,
  `id_texte_suivant` int(3) NOT NULL,
  `id_objet_necessaire` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `textesuivant`
--

INSERT INTO `textesuivant` (`id_texte_origine`, `id_texte_suivant`, `id_objet_necessaire`) VALUES
(1, 2, NULL),
(2, 3, NULL),
(3, 4, NULL),
(5, 6, NULL),
(7, 8, NULL),
(8, 9, NULL),
(10, 11, NULL),
(11, 12, NULL),
(12, 58, NULL),
(58, 13, 1),
(13, 14, NULL),
(14, 15, NULL),
(15, 16, NULL),
(16, 17, NULL),
(17, 18, NULL),
(58, 19, 2),
(58, 19, 3),
(19, 20, NULL),
(20, 21, NULL),
(21, 22, NULL),
(22, 23, NULL),
(23, 24, NULL),
(24, 25, NULL),
(25, 26, NULL),
(26, 27, 3),
(28, 29, NULL),
(29, 30, NULL),
(30, 31, NULL),
(31, 32, NULL),
(32, 33, NULL),
(33, 34, NULL),
(34, 35, NULL),
(35, 36, NULL),
(36, 37, NULL),
(37, 38, NULL),
(39, 40, NULL),
(40, 41, NULL),
(41, 42, NULL),
(42, 43, NULL),
(43, 44, NULL),
(45, 46, NULL),
(47, 48, NULL),
(48, 49, NULL),
(50, 51, NULL),
(51, 52, NULL),
(52, 90, NULL),
(90, 91, NULL),
(91, 92, NULL),
(92, 93, NULL),
(93, 94, NULL),
(94, 95, NULL),
(95, 96, NULL),
(96, 89, NULL),
(97, 98, NULL),
(98, 99, NULL),
(99, 100, NULL),
(100, 101, NULL),
(101, 102, NULL),
(103, 104, NULL),
(104, 105, NULL),
(105, 106, NULL),
(106, 107, NULL),
(108, 109, NULL),
(109, 110, NULL),
(110, 111, NULL),
(112, 113, NULL),
(113, 114, NULL),
(114, 115, NULL),
(26, 53, 2),
(53, 54, NULL),
(54, 55, NULL),
(55, 56, NULL),
(56, 57, NULL),
(85, 86, NULL),
(86, 87, NULL),
(87, 88, NULL),
(88, 89, NULL),
(60, 61, NULL),
(61, 62, NULL),
(62, 63, NULL),
(64, 65, NULL),
(65, 66, NULL),
(66, 67, NULL),
(67, 68, NULL),
(68, 69, NULL),
(71, 72, NULL),
(72, 73, NULL),
(73, 74, NULL),
(74, 75, NULL),
(76, 77, NULL),
(77, 78, NULL),
(78, 79, NULL),
(80, 81, NULL),
(81, 82, NULL),
(82, 83, NULL),
(84, 85, NULL),
(4, 5, NULL),
(4, 7, NULL),
(9, 10, NULL),
(27, 28, NULL),
(38, 39, NULL),
(38, 45, NULL),
(46, 50, NULL),
(46, 48, NULL),
(46, 47, NULL),
(89, 97, NULL),
(89, 103, NULL),
(107, 112, NULL),
(107, 108, NULL),
(57, 34, NULL),
(57, 85, NULL),
(57, 60, NULL),
(63, 64, NULL),
(63, 70, NULL),
(70, 71, NULL),
(70, 116, NULL),
(116, 76, NULL),
(116, 80, NULL),
(83, 84, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
