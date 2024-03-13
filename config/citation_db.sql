-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Tempo de geração: 13/03/2024 às 10:28
-- Versão do servidor: 5.7.39
-- Versão do PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `test_db`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `auteur`
--

CREATE TABLE `auteur` (
  `nom` text NOT NULL,
  `prenom` text NOT NULL,
  `anneeNaissance` int(11) NOT NULL,
  `auteur_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `citation`
--

CREATE TABLE `citation` (
  `citation_texte` text NOT NULL,
  `citation_date` date NOT NULL,
  `creationDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `auteur_id` int(11) NOT NULL,
  `citation_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `auteur`
--
ALTER TABLE `auteur`
  ADD PRIMARY KEY (`auteur_id`);

--
-- Índices de tabela `citation`
--
ALTER TABLE `citation`
  ADD UNIQUE KEY `citation_id` (`citation_id`),
  ADD KEY `auteur_id` (`auteur_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `auteur`
--
ALTER TABLE `auteur`
  MODIFY `auteur_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `citation`
--
ALTER TABLE `citation`
  MODIFY `citation_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `citation`
--
ALTER TABLE `citation`
  ADD CONSTRAINT `citation_ibfk_1` FOREIGN KEY (`auteur_id`) REFERENCES `auteur` (`auteur_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
