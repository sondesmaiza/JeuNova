-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 03 mai 2026 à 15:33
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `jeunova`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE `admin` (
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`id_user`) VALUES
(1),
(8);

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `id_categorie` int(11) NOT NULL,
  `nom` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id_categorie`, `nom`) VALUES
(1, 'Informatique'),
(2, 'Business'),
(3, 'Design'),
(4, 'Informatique'),
(5, 'Design'),
(6, 'Business'),
(7, 'Développement personnel');

-- --------------------------------------------------------

--
-- Structure de la table `contact`
--

CREATE TABLE `contact` (
  `id_contact` int(11) NOT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `sujet` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `date_envoi` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `contact`
--

INSERT INTO `contact` (`id_contact`, `nom`, `email`, `sujet`, `message`, `date_envoi`) VALUES
(1, 'Ali', 'ali@mail.com', 'Question', 'Comment participer à un événement ?', '2026-04-05 20:40:44'),
(2, 'Sara', 'sara@mail.com', 'Problème', 'Je n’arrive pas à m’inscrire.', '2026-04-05 20:40:44'),
(3, 'Omar', 'omar@mail.com', 'Information', 'Pouvez-vous m’envoyer le programme ?', '2026-04-05 20:40:44'),
(4, 'Ali', 'ali@gmail.com', 'Information', 'Je veux plus de détails sur les événements', '2026-04-26 17:51:06'),
(5, 'Sana', 'sana@gmail.com', 'Inscription', 'Comment s’inscrire ?', '2026-04-26 17:51:06'),
(6, 'ahmed jbeli', 'ahmedjbeli@05.com', 'formation digital marketing', 'je m\'interesse a une formation sur le marketing digital', '2026-04-27 20:10:18'),
(7, 'hiba', 'hiba.souissi@esen.tn', 'question', '.......................', '2026-04-29 10:17:34');

-- --------------------------------------------------------

--
-- Structure de la table `evenement`
--

CREATE TABLE `evenement` (
  `id_event` int(11) NOT NULL,
  `titre` varchar(255) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `date_debut` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL,
  `capacite` int(11) DEFAULT NULL,
  `is_actualite` tinyint(1) DEFAULT 0,
  `id_categorie` int(11) DEFAULT NULL,
  `id_responsable` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `evenement`
--

INSERT INTO `evenement` (`id_event`, `titre`, `type`, `description`, `date_debut`, `date_fin`, `capacite`, `is_actualite`, `id_categorie`, `id_responsable`) VALUES
(3, 'Atelier HTML/CSS', 'Formation', 'Apprendre les bases du web', '2026-05-01', '2026-05-03', 30, 1, 4, 2),
(4, 'Workshop UI/UX', 'Atelier', 'Design moderne et UX', '2026-05-10', '2026-05-11', 25, 1, 3, 3),
(5, 'Entrepreneuriat', 'Conférence', 'Créer son projet', '2026-05-15', '2026-05-15', 50, 0, 2, 2),
(6, 'Formation UX avancé', 'formation', 'Apprenez l’expérience utilisateur', '2026-05-02', '2026-05-09', 20, 0, 3, NULL),
(7, 'Atelier Design Thinking', 'formation', 'Découvrez le design thinking', '2026-05-02', '2026-05-12', 20, 0, 3, NULL),
(8, 'Atelier informatique de base', 'formation', 'Apprenez les bases', '2026-05-02', '2026-05-12', 20, 0, NULL, NULL),
(9, 'Conférence développement personnel', 'conférence', 'Boostez votre carrière', '2026-05-02', '2026-05-12', 30, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `feedback`
--

CREATE TABLE `feedback` (
  `id_user` int(11) NOT NULL,
  `id_event` int(11) NOT NULL,
  `note` int(11) DEFAULT NULL,
  `commentaire` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `feedback`
--

INSERT INTO `feedback` (`id_user`, `id_event`, `note`, `commentaire`) VALUES
(4, 3, 5, 'Très bonne formation, claire et utile'),
(4, 4, 5, 'tres bien'),
(4, 5, 4, 'Bonne expérience entrepreneuriale'),
(5, 3, 4, 'Bon contenu mais un peu rapide'),
(5, 4, 5, 'Excellent workshop UI/UX'),
(6, 5, 5, 'Très motivant et inspirant');

-- --------------------------------------------------------

--
-- Structure de la table `inscription`
--

CREATE TABLE `inscription` (
  `id_user` int(11) NOT NULL,
  `id_event` int(11) NOT NULL,
  `date_inscription` date DEFAULT NULL,
  `statut` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `inscription`
--

INSERT INTO `inscription` (`id_user`, `id_event`, `date_inscription`, `statut`) VALUES
(4, 3, '2026-04-20', 'confirmé'),
(4, 4, '2026-05-02', 'confirmé'),
(4, 5, '2026-04-23', 'confirmé'),
(5, 3, '2026-04-21', 'confirmé'),
(5, 4, '2026-04-22', 'confirmé'),
(6, 4, '2026-04-22', 'en attente'),
(6, 5, '2026-04-23', 'confirmé'),
(11, 5, '2026-05-02', 'confirmé'),
(11, 6, '2026-05-02', 'confirmé'),
(12, 3, '2026-05-02', 'confirmé'),
(13, 4, '2026-05-02', 'confirmé'),
(14, 3, '2026-05-02', 'confirmé'),
(15, 3, '2026-05-02', 'confirmé'),
(16, 3, '2026-05-02', 'confirmé'),
(17, 7, '2026-05-02', 'confirmé'),
(18, 3, '2026-05-02', 'confirmé');

--
-- Déclencheurs `inscription`
--
DELIMITER $$
CREATE TRIGGER `after_inscription_update_interet` AFTER INSERT ON `inscription` FOR EACH ROW BEGIN
    DECLARE cat_nom VARCHAR(100);
    DECLARE current_interet TEXT;
    
    -- Récupérer le nom de la catégorie de l'événement
    SELECT c.nom INTO cat_nom
    FROM Evenement e
    LEFT JOIN Categorie c ON e.id_categorie = c.id_categorie
    WHERE e.id_event = NEW.id_event;
    
    IF cat_nom IS NOT NULL AND cat_nom != '' THEN
        SELECT centre_interet INTO current_interet
        FROM Participant
        WHERE id_user = NEW.id_user;
        
        IF current_interet IS NULL OR current_interet NOT LIKE CONCAT('%', cat_nom, '%') THEN
            UPDATE Participant
            SET centre_interet = CONCAT(
                IFNULL(current_interet, ''),
                IF(current_interet IS NOT NULL AND current_interet != '', ', ', ''),
                cat_nom
            )
            WHERE id_user = NEW.id_user;
        END IF;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `participant`
--

CREATE TABLE `participant` (
  `id_user` int(11) NOT NULL,
  `niveau` varchar(50) DEFAULT NULL,
  `centre_interet` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `participant`
--

INSERT INTO `participant` (`id_user`, `niveau`, `centre_interet`) VALUES
(4, 'Débutant', 'Business, Design, Informatique'),
(5, 'Intermédiaire', 'Design, Informatique'),
(6, 'Avancé', 'Business, Design'),
(9, '', ''),
(10, '', ''),
(11, '', 'Business, Design'),
(12, 'Débutant', '	\r\nBusiness, Design'),
(13, '', 'Design'),
(14, '', 'design'),
(15, '', 'Informatique'),
(16, '', 'Informatique'),
(17, '', 'Design'),
(18, '', 'Informatique');

-- --------------------------------------------------------

--
-- Structure de la table `responsable`
--

CREATE TABLE `responsable` (
  `id_user` int(11) NOT NULL,
  `specialite` varchar(100) DEFAULT NULL,
  `bio` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `responsable`
--

INSERT INTO `responsable` (`id_user`, `specialite`, `bio`) VALUES
(2, 'Développement Web', 'Expert en développement web moderne'),
(3, 'Design UI/UX', 'Spécialiste en expérience utilisateur');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id_user` int(11) NOT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `prenom` varchar(100) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `mot_de_passe` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id_user`, `nom`, `prenom`, `email`, `mot_de_passe`) VALUES
(1, 'Admin', 'System', 'admin@jeunova.com', '$2y$10$7VR8UWqPXXUCQE.2.kQlLex9Fmph14098UxVxqACT9eGUeuSE2ag.'),
(2, 'Ben Ali', 'Sami', 'sami@jeunova.com', '$2y$10$F5pnRgBafbgsK3oQwM/mwOh1dX4AfmXT5Z/0bc1rmfPrlEjqzX1Ea'),
(3, 'Trabelsi', 'Nour', 'nour@jeunova.com', '123456'),
(4, 'Haddaad', 'Amine', 'amine@gmail.com', '$2y$10$PBDoIg3bfMDSlH1T9oPbc.sXbaUMbR3EJOUa8sf/p5BEoW2TLfviW'),
(5, 'Mejri', 'Sarra', 'sarra@gmail.com', '123456'),
(6, 'Khalifa', 'Youssef', 'youssef@gmail.com', '123456'),
(8, 'souissi', 'hiba', 'hiba.souissi@esen.tn', '$2y$10$XlAwxNSvdefG65oBy9mUUe3W1EAURY8TWciuyYuTdeBsFbpJkiSN2'),
(9, 'hammemi', 'salim', 'salimhammemi@05.com', '$2y$10$YLLdjlKOfO5u6w/j3jMEROJq5l4Utg8Y0vw6wcZOp8M0k0fdVFkbW'),
(10, 'souissi', 'eya', 'eyasouissi@pdo.tn', '$2y$10$4kTyZiBEAaCNlJYi0fXO0ONzchQIDXA/oHvj.8xLjXLuMNU8gCZ5y'),
(11, 'maiza', 'yassine', 'yassinemaiza00@esen.com', '$2y$10$rcuNXYFoXoNeiypwTdVwPOu86gdwbzfrr8XnHeYwjCW7mU9dCJMYm'),
(12, 'Test', 'Auto', 'test.auto@jeunova.tn', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
(13, 'weslety', 'ahmed', 'ahmedweslety@esen.com', '$2y$10$qLByrEAhOZ5dnvS4yzPwh.b2tLf/r.XD8JDmZZqdoTVlKu/3w1NrW'),
(14, 'hammami', 'eya', 'eyahammami@esen.tn', '$2y$10$6y.eQRnxqF868dHDqXdhI.sD9opvOL5ySc/iBV.EDHfueQieeNxba'),
(15, 'mohamed', 'trabelsi', 'mohamedtrabelsi@esen.com', '$2y$10$oxlKf7/fF9gEw3K8gp7qU.WAyxv3288ZiwGNtwTgekmKrd8jIPQVC'),
(16, 'maiza', 'imed', 'imedmaiza@esen.com', '$2y$10$F7AMe5pW.60ttmKv3BxWu.hq6VtTFPYD5F9QJUn46kyvftN4r2CeK'),
(17, 'sagheir', 'abir', 'abirsagheir@esen.com', '$2y$10$bfvsc3./Y/VbiLs7GzH1wO4Nf6nuOHOiJOmjb6Hxzmn0yEZ3HGG1i'),
(18, 'chakroun', 'youssef', 'youssefchakroun@esen.tn', '$2y$10$SNb9HIoPuLMIgTMDeiydfe/Keby50cg6D7mUhy4QBXei8lSboioEC');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_user`);

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id_categorie`);

--
-- Index pour la table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id_contact`);

--
-- Index pour la table `evenement`
--
ALTER TABLE `evenement`
  ADD PRIMARY KEY (`id_event`),
  ADD KEY `id_categorie` (`id_categorie`),
  ADD KEY `id_responsable` (`id_responsable`);

--
-- Index pour la table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id_user`,`id_event`),
  ADD KEY `id_event` (`id_event`);

--
-- Index pour la table `inscription`
--
ALTER TABLE `inscription`
  ADD PRIMARY KEY (`id_user`,`id_event`),
  ADD KEY `id_event` (`id_event`);

--
-- Index pour la table `participant`
--
ALTER TABLE `participant`
  ADD PRIMARY KEY (`id_user`);

--
-- Index pour la table `responsable`
--
ALTER TABLE `responsable`
  ADD PRIMARY KEY (`id_user`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id_categorie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `contact`
--
ALTER TABLE `contact`
  MODIFY `id_contact` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `evenement`
--
ALTER TABLE `evenement`
  MODIFY `id_event` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `utilisateur` (`id_user`);

--
-- Contraintes pour la table `evenement`
--
ALTER TABLE `evenement`
  ADD CONSTRAINT `evenement_ibfk_1` FOREIGN KEY (`id_categorie`) REFERENCES `categorie` (`id_categorie`),
  ADD CONSTRAINT `evenement_ibfk_2` FOREIGN KEY (`id_responsable`) REFERENCES `responsable` (`id_user`);

--
-- Contraintes pour la table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `participant` (`id_user`),
  ADD CONSTRAINT `feedback_ibfk_2` FOREIGN KEY (`id_event`) REFERENCES `evenement` (`id_event`);

--
-- Contraintes pour la table `inscription`
--
ALTER TABLE `inscription`
  ADD CONSTRAINT `inscription_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `participant` (`id_user`),
  ADD CONSTRAINT `inscription_ibfk_2` FOREIGN KEY (`id_event`) REFERENCES `evenement` (`id_event`);

--
-- Contraintes pour la table `participant`
--
ALTER TABLE `participant`
  ADD CONSTRAINT `participant_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `utilisateur` (`id_user`);

--
-- Contraintes pour la table `responsable`
--
ALTER TABLE `responsable`
  ADD CONSTRAINT `responsable_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `utilisateur` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
