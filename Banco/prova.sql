-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 23-Jun-2017 às 00:43
-- Versão do servidor: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `prova`
--
CREATE DATABASE IF NOT EXISTS `prova` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `prova`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ferramentas`
--

CREATE TABLE `ferramentas` (
  `id` int(45) NOT NULL,
  `descricao` mediumtext NOT NULL,
  `qtd` int(45) NOT NULL,
  `especificacao` mediumtext NOT NULL,
  `data_entrada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `data_saida` date DEFAULT NULL,
  `status` int(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `ferramentas`
--

INSERT INTO `ferramentas` (`id`, `descricao`, `qtd`, `especificacao`, `data_entrada`, `data_saida`, `status`) VALUES
(2, 'Chave de fenda', 5, 'Chave de fenda philips', '2017-06-22 23:44:20', NULL, 2),
(3, 'Chave de fenda', 5, 'Chave de fenda philips', '2017-06-22 23:48:25', NULL, 2),
(4, 'Chave de fenda', 5, 'Chave de fenda philips', '2017-06-22 23:48:56', NULL, 1),
(5, 'Chave de fenda', 5, 'Chave de fenda philips', '2017-06-22 23:49:09', NULL, 1),
(6, 'Chave de fenda 2312312', 5, 'Chave de fenda philips', '2017-06-22 23:50:00', NULL, 1),
(7, 'Chave de fenda2', 5, 'Chave de fenda philips', '2017-06-23 00:10:59', NULL, 1),
(8, 'Chave de fenda22222', 5, 'Chave de fenda philips', '2017-06-23 00:16:06', NULL, 1),
(9, 'asdasd', 2, 'qweqweqwe131231231', '2017-06-23 00:20:39', NULL, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ferramentas`
--
ALTER TABLE `ferramentas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ferramentas`
--
ALTER TABLE `ferramentas`
  MODIFY `id` int(45) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
