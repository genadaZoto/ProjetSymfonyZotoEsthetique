-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 22 avr. 2020 à 16:44
-- Version du serveur :  10.4.11-MariaDB
-- Version de PHP : 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `esthetique`
--

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_card` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `commentaires` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id`, `nom`, `prenom`, `adresse`, `contact`, `email`, `id_card`, `commentaires`) VALUES
(3, 'DriDri', 'Tani', 'Rue Gaucheret 88', '0231456', 'Tani@hotmail.com', 'BE213154', 'il est gentil'),
(4, 'Zoto', 'Gena', 'rue max roos, 56', '0231456', 'genadazoto@hotmail.com', 'BE213154', 'Codeuse'),
(5, 'Bellissima', 'Noemie', 'Rue De l\'été', '04876 90 525', 'memi@hotmail.com', 'BE635241', 'Elle est gentille.'),
(6, 'Zoto', 'Olimpia', 'rue max roos', '123 56', 'olol@hotmail.com', 'BE635241', 'non'),
(7, 'Maggie', 'DeBlock', 'Rue de la Loi 30', '04876 90 525', 'm@gmail.com', 'BE321654', 'Elle a pas bien géré la crise de Covid-19'),
(11, 'Williems', 'Sophie', 'rue max roos', '04876 90 525', 'genadazoto@hotmail.com', 'BE635241', 'Bien');

-- --------------------------------------------------------

--
-- Structure de la table `migration_versions`
--

CREATE TABLE `migration_versions` (
  `version` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migration_versions`
--

INSERT INTO `migration_versions` (`version`, `executed_at`) VALUES
('20200402133443', '2020-04-02 13:35:16'),
('20200403074159', '2020-04-03 07:50:50'),
('20200406134248', '2020-04-06 13:43:23'),
('20200406134642', '2020-04-06 13:47:31'),
('20200410073951', '2020-04-10 07:40:13');

-- --------------------------------------------------------

--
-- Structure de la table `photo`
--

CREATE TABLE `photo` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `date_photo` datetime NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lien_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `photo`
--

INSERT INTO `photo` (`id`, `client_id`, `date_photo`, `label`, `lien_image`) VALUES
(20, 7, '2020-03-02 00:00:00', '1 jour', 'a7e25d6a611132f246b42c475eafeef8.jpeg'),
(21, 7, '2020-05-02 00:00:00', '2 jour', 'e57eae355f4374192ee3788ed4c199e1.jpeg'),
(22, 5, '2020-02-01 00:00:00', '1 jour', '72b44714622906ae4e8385d2d05a4f53.jpeg'),
(23, 6, '2020-02-02 00:00:00', '2 jour', 'd717945e970335fe643600197ef55ba2.jpeg');

-- --------------------------------------------------------

--
-- Structure de la table `prestation`
--

CREATE TABLE `prestation` (
  `id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `date_prestation` datetime NOT NULL,
  `carte_bancaire` tinyint(1) NOT NULL,
  `prix_service` decimal(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `prestation`
--

INSERT INTO `prestation` (`id`, `service_id`, `client_id`, `date_prestation`, `carte_bancaire`, `prix_service`) VALUES
(1, 6, 4, '2019-09-02 00:00:00', 1, '22.50'),
(2, 5, 4, '2019-02-02 00:00:00', 1, '23.00'),
(4, 2, 3, '2020-03-12 00:00:00', 1, '23.00'),
(5, 2, 3, '2020-02-02 00:00:00', 1, '23.00'),
(7, 2, 3, '2015-01-01 00:00:00', 1, '23.00'),
(10, 2, 3, '2020-01-01 00:00:00', 0, '23.00'),
(13, 6, 4, '2020-03-12 00:00:00', 1, '23.00'),
(14, 2, 4, '2019-02-02 00:00:00', 0, '24.00'),
(15, 5, 3, '2020-04-01 00:00:00', 0, '32.50'),
(16, 7, 4, '2020-04-03 00:00:00', 1, '32.50'),
(17, 6, 7, '2018-05-01 00:00:00', 0, '12.50'),
(18, 7, 11, '2020-05-03 00:00:00', 0, '32.50'),
(19, 14, 3, '2019-06-03 00:00:00', 1, '45.00'),
(20, 13, 6, '2020-05-05 00:00:00', 1, '54.00'),
(21, 14, 3, '2020-04-17 00:00:00', 0, '36.00'),
(22, 6, 7, '2018-06-03 00:00:00', 1, '32.25');

-- --------------------------------------------------------

--
-- Structure de la table `service`
--

CREATE TABLE `service` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prix` decimal(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `service`
--

INSERT INTO `service` (`id`, `user_id`, `nom`, `prix`) VALUES
(2, 1, 'manicure', '25.50'),
(5, 1, 'Coifffure', '22.50'),
(6, 1, 'épilation', '30.00'),
(7, 2, 'soin cheveux', '20.00'),
(13, 1, 'Soin corps', '42.00'),
(14, 1, 'Epiliation Homme', '54.00');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `nom`, `prenom`) VALUES
(1, 'genadazoto@hotmail.com', '[\"ROLE_ADMIN\"]', '$argon2id$v=19$m=65536,t=4,p=1$MUhEeVBFVENrLmJMeHhkQw$TnNNZ+YRJfHdDSojWepcSZiIHJbrSX6ONpy/Nmz5Gfk', 'Genada', 'Zoto'),
(2, 'olimpia@gmail.com', '[]', '$argon2id$v=19$m=65536,t=4,p=1$NUdmbFBrVHRHTHNUamt0Tw$JfFv95y6axeEnKcLAs7MbTiktp/DJxqVQnqp3sCIIpY', 'Zoto', 'Olimpia');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `migration_versions`
--
ALTER TABLE `migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `photo`
--
ALTER TABLE `photo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_14B7841819EB6921` (`client_id`);

--
-- Index pour la table `prestation`
--
ALTER TABLE `prestation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_51C88FADED5CA9E6` (`service_id`),
  ADD KEY `IDX_51C88FAD19EB6921` (`client_id`);

--
-- Index pour la table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_E19D9AD2A76ED395` (`user_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `client`
--
ALTER TABLE `client`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `photo`
--
ALTER TABLE `photo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT pour la table `prestation`
--
ALTER TABLE `prestation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `service`
--
ALTER TABLE `service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `photo`
--
ALTER TABLE `photo`
  ADD CONSTRAINT `FK_14B7841819EB6921` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`);

--
-- Contraintes pour la table `prestation`
--
ALTER TABLE `prestation`
  ADD CONSTRAINT `FK_51C88FAD19EB6921` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`),
  ADD CONSTRAINT `FK_51C88FADED5CA9E6` FOREIGN KEY (`service_id`) REFERENCES `service` (`id`);

--
-- Contraintes pour la table `service`
--
ALTER TABLE `service`
  ADD CONSTRAINT `FK_E19D9AD2A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
