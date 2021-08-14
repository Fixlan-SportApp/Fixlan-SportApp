-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 12, 2021 at 08:31 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sportapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_cliente`
--

CREATE TABLE `tb_cliente` (
  `id` int(11) NOT NULL,
  `c_email` varchar(100) DEFAULT NULL,
  `c_password` varchar(100) DEFAULT NULL,
  `c_socio` int(11) DEFAULT NULL,
  `c_club` int(11) DEFAULT NULL,
  `c_db` varchar(50) DEFAULT NULL,
  `c_token` varchar(120) DEFAULT NULL,
  `c_estado` varchar(80) DEFAULT NULL,
  `c_alta` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_cliente`
--

INSERT INTO `tb_cliente` (`id`, `c_email`, `c_password`, `c_socio`, `c_club`, `c_db`, `c_token`, `c_estado`, `c_alta`) VALUES
(1, 'juani.bosco93@gmail.com', '5272b8803338e3aa82e4162c490cc11f', 1, 1, 'sa_club', 'af604275463bbab9df0587d37b7190c2b137d847b99d77e748581056ebc8e34998e9a6542e9a1af368b10ea489a7e399c3a7', 'HABILITADO', '2021-04-22 17:39:32');

-- --------------------------------------------------------

--
-- Table structure for table `tb_club`
--

CREATE TABLE `tb_club` (
  `id` int(11) NOT NULL,
  `c_nombre` varchar(80) DEFAULT NULL,
  `c_modulos` text DEFAULT NULL,
  `c_feed` decimal(18,2) DEFAULT NULL,
  `c_db` varchar(80) DEFAULT NULL,
  `c_estado` varchar(80) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_club`
--

INSERT INTO `tb_club` (`id`, `c_nombre`, `c_modulos`, `c_feed`, `c_db`, `c_estado`) VALUES
(1, 'Club Ejemplo', '[\"SOCIOS\", \"GESTION\", \"CLASES\", \"MARKETING\", \"BOLETERIA\", \"TESORERIA\", \"CONTABLE\", \"RRHH\", \"ACCESOS\", \"INFRAESTRUCTURA\"]', '0.00', 'sa_club', 'HABILITADO');

-- --------------------------------------------------------

--
-- Table structure for table `tb_error`
--

CREATE TABLE `tb_error` (
  `id` int(11) NOT NULL,
  `e_titulo` varchar(80) DEFAULT NULL,
  `e_descripcion` text DEFAULT NULL,
  `e_color` varchar(80) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tb_usuario`
--

CREATE TABLE `tb_usuario` (
  `id` int(11) NOT NULL,
  `u_usuario` varchar(80) DEFAULT NULL,
  `u_password` varchar(200) DEFAULT NULL,
  `u_nombre` varchar(200) DEFAULT NULL,
  `u_club` int(11) DEFAULT NULL,
  `u_token` varchar(200) DEFAULT NULL,
  `u_estado` varchar(80) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_usuario`
--

INSERT INTO `tb_usuario` (`id`, `u_usuario`, `u_password`, `u_nombre`, `u_club`, `u_token`, `u_estado`) VALUES
(1, 'administrador', '01357bba4f2cc991f9ba455975ad375f', 'Usuario Administrador', 1, '4e6de35567ab070d3755957fef0270ebeeeb6bf8bf1479afd24dfcac5f154d2143a0549c170e88adfb00cceb59ea289adcba', 'HABILITADO');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_cliente`
--
ALTER TABLE `tb_cliente`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_club`
--
ALTER TABLE `tb_club`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_error`
--
ALTER TABLE `tb_error`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_usuario`
--
ALTER TABLE `tb_usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_cliente`
--
ALTER TABLE `tb_cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_club`
--
ALTER TABLE `tb_club`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_error`
--
ALTER TABLE `tb_error`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_usuario`
--
ALTER TABLE `tb_usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
