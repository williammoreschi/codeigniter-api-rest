-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 06/11/2018 às 16:45
-- Versão do servidor: 10.1.34-MariaDB
-- Versão do PHP: 7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `pizzaria`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedido`
--

CREATE TABLE `pedido` (
  `id` int(12) NOT NULL,
  `tamanho` varchar(100) NOT NULL,
  `sabor` varchar(100) NOT NULL,
  `personalizacao` text NOT NULL,
  `preparo` int(12) NOT NULL,
  `total` decimal(15,2) NOT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `pedido`
--

INSERT INTO `pedido` (`id`, `tamanho`, `sabor`, `personalizacao`, `preparo`, `total`, `data_criacao`) VALUES
(1, 'Pequena', 'Calabresa', '', 15, '20.00', '2018-11-06 15:39:50'),
(2, 'Pequena', 'Marguerita', '', 15, '20.00', '2018-11-06 15:40:26'),
(3, 'Pequena', 'Portuguesa', '', 20, '20.00', '2018-11-06 15:40:35'),
(4, 'Média', 'Calabresa', '', 20, '30.00', '2018-11-06 15:40:40'),
(5, 'Média', 'Marguerita', '', 20, '30.00', '2018-11-06 15:40:44'),
(6, 'Média', 'Portuguesa', '', 25, '30.00', '2018-11-06 15:40:49'),
(7, 'Grande', 'Calabresa', '', 25, '40.00', '2018-11-06 15:40:57'),
(8, 'Grande', 'Marguerita', '', 25, '40.00', '2018-11-06 15:41:05'),
(9, 'Grande', 'Portuguesa', '', 30, '40.00', '2018-11-06 15:41:09'),
(10, 'Pequena', 'Portuguesa', 'Extra Bacon - R$3.00\nSem Cebola - R$0.00\nBorda Recheada - R$5.00\n', 25, '28.00', '2018-11-06 15:41:13'),
(11, 'Pequena', 'Portuguesa', 'Extra Bacon - R$3.00\nSem Cebola - R$0.00\n', 20, '23.00', '2018-11-06 15:41:37'),
(12, 'Pequena', 'Portuguesa', 'Extra Bacon - R$3.00\n', 20, '23.00', '2018-11-06 15:41:43');

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `pedido`
--
ALTER TABLE `pedido`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
