-- phpMyAdmin SQL Dump
-- version 4.6.6deb4+deb9u2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 16-03-2021 a las 12:25:46
-- Versión del servidor: 10.1.47-MariaDB-0+deb9u1
-- Versión de PHP: 7.4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tgistau_jobOff`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `candidat`
--

CREATE TABLE `candidat` (
  `id` int(11) NOT NULL,
  `usuari_id` int(11) DEFAULT NULL,
  `nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cognom1` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cognom2` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefon` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `candidat`
--

INSERT INTO `candidat` (`id`, `usuari_id`, `nom`, `cognom1`, `cognom2`, `telefon`) VALUES
(1, NULL, 'lola', 'Garcia', 'Garcia', 999999999),
(2, NULL, 'Joan', 'Perez', 'Perez', 999999999),
(3, NULL, 'Aina', 'Roviro', 'Roviro', 999999999);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id` int(11) NOT NULL,
  `descripcio` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id`, `descripcio`) VALUES
(1, 'DAW'),
(2, 'DAM'),
(3, 'SMX'),
(4, 'ASIX');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20210315200210', '2021-03-15 21:02:22', 235);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `id` int(11) NOT NULL,
  `usuari_id` int(11) DEFAULT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipus` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `correu` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`id`, `usuari_id`, `nom`, `tipus`, `logo`, `correu`) VALUES
(1, NULL, 'UNO Empresa', 'Tecnología de la información', NULL, 'tgistau@inspedralbes.cat'),
(2, NULL, 'DOS empresa', 'Restauración', NULL, 'tgistau@inspedralbes.cat'),
(3, NULL, 'TRES Empresa', 'Productiva', NULL, 'tgistau@inspedralbes.cat');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oferta`
--

CREATE TABLE `oferta` (
  `id` int(11) NOT NULL,
  `empresa_id` int(11) NOT NULL,
  `titol` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcio` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_publicacio` date NOT NULL,
  `ubicacio` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estat` smallint(6) NOT NULL,
  `categoria_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `oferta`
--

INSERT INTO `oferta` (`id`, `empresa_id`, `titol`, `descripcio`, `data_publicacio`, `ubicacio`, `estat`, `categoria_id`) VALUES
(1, 2, 'Desenvolupador WEB', 'descripcio Desenvolupador WEB', '2021-05-01', 'Barcelona', 0, 0),
(2, 2, 'Full stack', 'descripció Full stack', '2021-05-01', 'Girona', 0, 0),
(3, 3, 'DEsenvolupardor Vue', 'Descripció DEsenvolupardor Vue', '2021-05-01', 'Lleida', 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oferta_candidat`
--

CREATE TABLE `oferta_candidat` (
  `oferta_id` int(11) NOT NULL,
  `candidat_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `candidat`
--
ALTER TABLE `candidat`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_6AB5B4715F263030` (`usuari_id`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_B8D75A505F263030` (`usuari_id`);

--
-- Indices de la tabla `oferta`
--
ALTER TABLE `oferta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_7479C8F2521E1991` (`empresa_id`);

--
-- Indices de la tabla `oferta_candidat`
--
ALTER TABLE `oferta_candidat`
  ADD PRIMARY KEY (`oferta_id`,`candidat_id`),
  ADD KEY `IDX_BC759CA0FAFBF624` (`oferta_id`),
  ADD KEY `IDX_BC759CA08D0EB82` (`candidat_id`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `candidat`
--
ALTER TABLE `candidat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `empresa`
--
ALTER TABLE `empresa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `oferta`
--
ALTER TABLE `oferta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `candidat`
--
ALTER TABLE `candidat`
  ADD CONSTRAINT `FK_6AB5B4715F263030` FOREIGN KEY (`usuari_id`) REFERENCES `user` (`id`);

--
-- Filtros para la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD CONSTRAINT `FK_B8D75A505F263030` FOREIGN KEY (`usuari_id`) REFERENCES `user` (`id`);

--
-- Filtros para la tabla `oferta`
--
ALTER TABLE `oferta`
  ADD CONSTRAINT `FK_7479C8F2521E1991` FOREIGN KEY (`empresa_id`) REFERENCES `empresa` (`id`);

--
-- Filtros para la tabla `oferta_candidat`
--
ALTER TABLE `oferta_candidat`
  ADD CONSTRAINT `FK_BC759CA08D0EB82` FOREIGN KEY (`candidat_id`) REFERENCES `candidat` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_BC759CA0FAFBF624` FOREIGN KEY (`oferta_id`) REFERENCES `oferta` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
