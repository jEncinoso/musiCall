-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-04-2018 a las 16:39:08
-- Versión del servidor: 10.1.30-MariaDB
-- Versión de PHP: 7.0.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_music`
--
DROP DATABASE IF EXISTS db_music;
CREATE DATABASE db_music;
use db_music;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_songs`
--

CREATE TABLE `t_songs` (
  `name` varchar(150) COLLATE utf8mb4_spanish_ci NOT NULL,
  `artist` varchar(150) COLLATE utf8mb4_spanish_ci NOT NULL,
  `album` varchar(150) COLLATE utf8mb4_spanish_ci NOT NULL,
  `genre` varchar(150) COLLATE utf8mb4_spanish_ci NOT NULL,
  `length` varchar(5) COLLATE utf8mb4_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `t_songs`
--

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `t_songs`
--
ALTER TABLE `t_songs`
  ADD PRIMARY KEY (`name`,`artist`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
