-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 16-02-2019 a las 19:38:55
-- Versión del servidor: 5.7.17-log
-- Versión de PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `guia_del_turista`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comuna`
--

CREATE TABLE `comuna` (
  `ID_COMUNA` int(11) NOT NULL,
  `ID_PROVINCIA` int(11) DEFAULT NULL,
  `NOMBRE_COMUNA` char(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `comuna`
--

INSERT INTO `comuna` (`ID_COMUNA`, `ID_PROVINCIA`, `NOMBRE_COMUNA`) VALUES
(1, 1, 'Arica'),
(2, 1, 'Camarones'),
(3, 2, 'General La'),
(4, 2, 'Putre'),
(5, 3, 'Alto Hospi'),
(6, 3, 'Iquique'),
(7, 4, 'Camiña'),
(8, 4, 'Colchane'),
(9, 4, 'Huara'),
(10, 4, 'Pica'),
(11, 4, 'Pozo Almon'),
(12, 5, 'Antofagast'),
(13, 5, 'Mejillones'),
(14, 5, 'Sierra Gor'),
(15, 5, 'Taltal'),
(16, 6, 'Calama'),
(17, 6, 'Ollague'),
(18, 6, 'San Pedro'),
(19, 7, 'María Elen'),
(20, 7, 'Tocopilla'),
(21, 8, 'Chañaral'),
(22, 8, 'Diego de A'),
(23, 9, 'Caldera'),
(24, 9, 'Copiapó'),
(25, 9, 'Tierra Ama'),
(26, 10, 'Alto del C'),
(27, 10, 'Freirina'),
(28, 10, 'Huasco'),
(29, 10, 'Vallenar'),
(30, 11, 'Canela'),
(31, 11, 'Illapel'),
(32, 11, 'Los Vilos'),
(33, 11, 'Salamanca'),
(34, 12, 'Andacollo'),
(35, 12, 'Coquimbo'),
(36, 12, 'La Higuera'),
(37, 12, 'La Serena'),
(38, 12, 'Paihuaco'),
(39, 12, 'Vicuña'),
(40, 13, 'Combarbalá'),
(41, 13, 'Monte Patr'),
(42, 13, 'Ovalle'),
(43, 13, 'Punitaqui'),
(44, 13, 'Río Hurtad'),
(45, 14, 'Isla de Pa'),
(46, 15, 'Calle Larg'),
(47, 15, 'Los Andes'),
(48, 15, 'Rinconada'),
(49, 15, 'San Esteba'),
(50, 16, 'La Ligua'),
(51, 16, 'Papudo'),
(52, 16, 'Petorca'),
(53, 16, 'Zapallar'),
(54, 17, 'Hijuelas'),
(55, 17, 'La Calera'),
(56, 17, 'La Cruz'),
(57, 17, 'Limache'),
(58, 17, 'Nogales'),
(59, 17, 'Olmué'),
(60, 17, 'Quillota'),
(61, 18, 'Algarrobo'),
(62, 18, 'Cartagena'),
(63, 18, 'El Quisco'),
(64, 18, 'El Tabo'),
(65, 18, 'San Antoni'),
(66, 18, 'Santo Domi'),
(67, 19, 'Catemu'),
(68, 19, 'Llaillay'),
(69, 19, 'Panquehue'),
(70, 19, 'Putaendo'),
(71, 19, 'San Felipe'),
(72, 19, 'Santa Marí'),
(73, 20, 'Casablanca'),
(74, 20, 'Concón'),
(75, 20, 'Juan Ferná'),
(76, 20, 'Puchuncaví'),
(77, 20, 'Quilpué'),
(78, 20, 'Quintero'),
(79, 20, 'Valparaíso'),
(80, 20, 'Villa Alem'),
(81, 20, 'Viña del M'),
(82, 21, 'Colina'),
(83, 21, 'Lampa'),
(84, 21, 'Tiltil'),
(85, 22, 'Pirque'),
(86, 22, 'Puente Alt'),
(87, 22, 'San José d'),
(88, 23, 'Buin'),
(89, 23, 'Calera de'),
(90, 23, 'Paine'),
(91, 23, 'San Bernar'),
(92, 24, 'Alhué'),
(93, 24, 'Curacaví'),
(94, 24, 'María Pint'),
(95, 24, 'Melipilla'),
(96, 24, 'San Pedro'),
(97, 25, 'Cerrillos'),
(98, 25, 'Cerro Navi'),
(99, 25, 'Conchalí'),
(100, 25, 'El Bosque'),
(101, 25, 'Estación C'),
(102, 25, 'Huechuraba'),
(103, 25, 'Independen'),
(104, 25, 'La Cistern'),
(105, 25, 'La Granja'),
(106, 25, 'La Florida'),
(107, 25, 'La Pintana'),
(108, 25, 'La Reina'),
(109, 25, 'Las Condes'),
(110, 25, 'Lo Barnech'),
(111, 25, 'Lo Espejo'),
(112, 25, 'Lo Prado'),
(113, 25, 'Macul'),
(114, 25, 'Maipú'),
(115, 25, 'Ñuñoa'),
(116, 25, 'Pedro Agui'),
(117, 25, 'Peñalolén'),
(118, 25, 'Providenci'),
(119, 25, 'Pudahuel'),
(120, 25, 'Quilicura'),
(121, 25, 'Quinta Nor'),
(122, 25, 'Recoleta'),
(123, 25, 'Renca'),
(124, 25, 'San Miguel'),
(125, 25, 'San Joaquí'),
(126, 25, 'San Ramón'),
(127, 25, 'Santiago'),
(128, 25, 'Vitacura'),
(129, 26, 'El Monte'),
(130, 26, 'Isla de Ma'),
(131, 26, 'Padre Hurt'),
(132, 26, 'Peñaflor'),
(133, 26, 'Talagante'),
(134, 27, 'Codegua'),
(135, 27, 'Coínco'),
(136, 27, 'Coltauco'),
(137, 27, 'Doñihue'),
(138, 27, 'Graneros'),
(139, 27, 'Las Cabras'),
(140, 27, 'Machalí'),
(141, 27, 'Malloa'),
(142, 27, 'Mostazal'),
(143, 27, 'Olivar'),
(144, 27, 'Peumo'),
(145, 27, 'Pichidegua'),
(146, 27, 'Quinta de'),
(147, 27, 'Rancagua'),
(148, 27, 'Rengo'),
(149, 27, 'Requínoa'),
(150, 27, 'San Vicent'),
(151, 28, 'La Estrell'),
(152, 28, 'Litueche'),
(153, 28, 'Marchihue'),
(154, 28, 'Navidad'),
(155, 28, 'Peredones'),
(156, 28, 'Pichilemu'),
(157, 29, 'Chépica'),
(158, 29, 'Chimbarong'),
(159, 29, 'Lolol'),
(160, 29, 'Nancagua'),
(161, 29, 'Palmilla'),
(162, 29, 'Peralillo'),
(163, 29, 'Placilla'),
(164, 29, 'Pumanque'),
(165, 29, 'San Fernan'),
(166, 29, 'Santa Cruz'),
(167, 30, 'Cauquenes'),
(168, 30, 'Chanco'),
(169, 30, 'Pelluhue'),
(170, 31, 'Curicó'),
(171, 31, 'Hualañé'),
(172, 31, 'Licantén'),
(173, 31, 'Molina'),
(174, 31, 'Rauco'),
(175, 31, 'Romeral'),
(176, 31, 'Sagrada Fa'),
(177, 31, 'Teno'),
(178, 31, 'Vichuquén'),
(179, 32, 'Colbún'),
(180, 32, 'Linares'),
(181, 32, 'Longaví'),
(182, 32, 'Parral'),
(183, 32, 'Retiro'),
(184, 32, 'San Javier'),
(185, 32, 'Villa Aleg'),
(186, 32, 'Yerbas Bue'),
(187, 33, 'Constituci'),
(188, 33, 'Curepto'),
(189, 33, 'Empedrado'),
(190, 33, 'Maule'),
(191, 33, 'Pelarco'),
(192, 33, 'Pencahue'),
(193, 33, 'Río Claro'),
(194, 33, 'San Clemen'),
(195, 33, 'San Rafael'),
(196, 33, 'Talca'),
(197, 34, 'Arauco'),
(198, 34, 'Cañete'),
(199, 34, 'Contulmo'),
(200, 34, 'Curanilahu'),
(201, 34, 'Lebu'),
(202, 34, 'Los Álamos'),
(203, 34, 'Tirúa'),
(204, 35, 'Alto Biobí'),
(205, 35, 'Antuco'),
(206, 35, 'Cabrero'),
(207, 35, 'Laja'),
(208, 35, 'Los Ángele'),
(209, 35, 'Mulchén'),
(210, 35, 'Nacimiento'),
(211, 35, 'Negrete'),
(212, 35, 'Quilaco'),
(213, 35, 'Quilleco'),
(214, 35, 'San Rosend'),
(215, 35, 'Santa Bárb'),
(216, 35, 'Tucapel'),
(217, 35, 'Yumbel'),
(218, 36, 'Chiguayant'),
(219, 36, 'Concepción'),
(220, 36, 'Coronel'),
(221, 36, 'Florida'),
(222, 36, 'Hualpén'),
(223, 36, 'Hualqui'),
(224, 36, 'Lota'),
(225, 36, 'Penco'),
(226, 36, 'San Pedro'),
(227, 36, 'Santa Juan'),
(228, 36, 'Talcahuano'),
(229, 36, 'Tomé'),
(230, 37, 'Bulnes'),
(231, 37, 'Chillán'),
(232, 37, 'Chillán Vi'),
(233, 37, 'Cobquecura'),
(234, 37, 'Coelemu'),
(235, 37, 'Coihueco'),
(236, 37, 'El Carmen'),
(237, 37, 'Ninhue'),
(238, 37, 'Ñiquen'),
(239, 37, 'Pemuco'),
(240, 37, 'Pinto'),
(241, 37, 'Portezuelo'),
(242, 37, 'Quillón'),
(243, 37, 'Quirihue'),
(244, 37, 'Ránquil'),
(245, 37, 'San Carlos'),
(246, 37, 'San Fabián'),
(247, 37, 'San Ignaci'),
(248, 37, 'San Nicolá'),
(249, 37, 'Treguaco'),
(250, 37, 'Yungay'),
(251, 38, 'Carahue'),
(252, 38, 'Cholchol'),
(253, 38, 'Cunco'),
(254, 38, 'Curarrehue'),
(255, 38, 'Freire'),
(256, 38, 'Galvarino'),
(257, 38, 'Gorbea'),
(258, 38, 'Lautaro'),
(259, 38, 'Loncoche'),
(260, 38, 'Melipeuco'),
(261, 38, 'Nueva Impe'),
(262, 38, 'Padre Las'),
(263, 38, 'Perquenco'),
(264, 38, 'Pitrufquén'),
(265, 38, 'Pucón'),
(266, 38, 'Saavedra'),
(267, 38, 'Temuco'),
(268, 38, 'Teodoro Sc'),
(269, 38, 'Toltén'),
(270, 38, 'Vilcún'),
(271, 38, 'Villarrica'),
(272, 39, 'Angol'),
(273, 39, 'Collipulli'),
(274, 39, 'Curacautín'),
(275, 39, 'Ercilla'),
(276, 39, 'Lonquimay'),
(277, 39, 'Los Sauces'),
(278, 39, 'Lumaco'),
(279, 39, 'Purén'),
(280, 39, 'Renaico'),
(281, 39, 'Traiguén'),
(282, 39, 'Victoria'),
(283, 40, 'Corral'),
(284, 40, 'Lanco'),
(285, 40, 'Los Lagos'),
(286, 40, 'Máfil'),
(287, 40, 'Mariquina'),
(288, 40, 'Paillaco'),
(289, 40, 'Panguipull'),
(290, 40, 'Valdivia'),
(291, 41, 'Futrono'),
(292, 41, 'La Unión'),
(293, 41, 'Lago Ranco'),
(294, 41, 'Río Bueno'),
(295, 42, 'Ancud'),
(296, 42, 'Castro'),
(297, 42, 'Chonchi'),
(298, 42, 'Curaco de'),
(299, 42, 'Dalcahue'),
(300, 42, 'Puqueldón'),
(301, 42, 'Queilén'),
(302, 42, 'Quemchi'),
(303, 42, 'Quellón'),
(304, 42, 'Quinchao'),
(305, 43, 'Calbuco'),
(306, 43, 'Cochamó'),
(307, 43, 'Fresia'),
(308, 43, 'Frutillar'),
(309, 43, 'Llanquihue'),
(310, 43, 'Los Muermo'),
(311, 43, 'Maullín'),
(312, 43, 'Puerto Mon'),
(313, 43, 'Puerto Var'),
(314, 44, 'Osorno'),
(315, 44, 'Puero Octa'),
(316, 44, 'Purranque'),
(317, 44, 'Puyehue'),
(318, 44, 'Río Negro'),
(319, 44, 'San Juan d'),
(320, 44, 'San Pablo'),
(321, 45, 'Chaitén'),
(322, 45, 'Futaleufú'),
(323, 45, 'Hualaihué'),
(324, 45, 'Palena'),
(325, 46, 'Aisén'),
(326, 46, 'Cisnes'),
(327, 46, 'Guaitecas'),
(328, 47, 'Cochrane'),
(329, 47, 'O\'higgins'),
(330, 47, 'Tortel'),
(331, 48, 'Coihaique'),
(332, 48, 'Lago Verde'),
(333, 49, 'Chile Chic'),
(334, 49, 'Río Ibáñez'),
(335, 50, 'Antártica'),
(336, 50, 'Cabo de Ho'),
(337, 51, 'Laguna Bla'),
(338, 51, 'Punta Aren'),
(339, 51, 'Río Verde'),
(340, 51, 'San Gregor'),
(341, 52, 'Porvenir'),
(342, 52, 'Primavera'),
(343, 52, 'Timaukel'),
(344, 53, 'Natales'),
(345, 53, 'Torres del'),
(346, 43, 'Todo Chile'),
(347, 42, 'Todo Chile'),
(348, 41, 'Todo Chile'),
(349, 40, 'Todo Chile'),
(350, 39, 'Todo Chile'),
(351, 38, 'Todo Chile'),
(352, 37, 'Todo Chile'),
(353, 36, 'Todo Chile'),
(354, 35, 'Todo Chile'),
(355, 34, 'Todo Chile'),
(356, 33, 'Todo Chile'),
(357, 32, 'Todo Chile'),
(358, 31, 'Todo Chile'),
(359, 30, 'Todo Chile'),
(360, 29, 'Todo Chile'),
(361, 28, 'Todo Chile'),
(362, 27, 'Todo Chile'),
(363, 26, 'Todo Chile'),
(364, 25, 'Todo Chile'),
(365, 24, 'Todo Chile'),
(366, 23, 'Todo Chile'),
(367, 22, 'Todo Chile'),
(368, 21, 'Todo Chile'),
(369, 20, 'Todo Chile'),
(370, 19, 'Todo Chile'),
(371, 18, 'Todo Chile'),
(372, 17, 'Todo Chile'),
(373, 16, 'Todo Chile'),
(374, 15, 'Todo Chile'),
(375, 14, 'Todo Chile'),
(376, 13, 'Todo Chile'),
(377, 12, 'Todo Chile'),
(378, 11, 'Todo Chile'),
(379, 10, 'Todo Chile'),
(380, 9, 'Todo Chile'),
(381, 8, 'Todo Chile'),
(382, 7, 'Todo Chile'),
(383, 6, 'Todo Chile'),
(384, 5, 'Todo Chile'),
(385, 4, 'Todo Chile'),
(386, 3, 'Todo Chile'),
(387, 2, 'Todo Chile'),
(388, 1, 'Todo Chile'),
(389, 44, 'Todo Chile'),
(390, 45, 'Todo Chile'),
(391, 46, 'Todo Chile'),
(392, 47, 'Todo Chile'),
(393, 48, 'Todo Chile'),
(394, 49, 'Todo Chile'),
(395, 50, 'Todo Chile'),
(396, 51, 'Todo Chile'),
(397, 52, 'Todo Chile'),
(398, 53, 'Todo Chile');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `foto`
--

CREATE TABLE `foto` (
  `ID_FOTO` int(11) NOT NULL,
  `ID_NEGOCIO` int(11) DEFAULT NULL,
  `NOMBRE_FOTO` varchar(200) DEFAULT NULL,
  `UBICACION_FOTO` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `foto`
--

INSERT INTO `foto` (`ID_FOTO`, `ID_NEGOCIO`, `NOMBRE_FOTO`, `UBICACION_FOTO`) VALUES
(1, 6, 'cuatro', 'imagen-3-id-usuario-3.jpg'),
(2, 6, 'uno', 'imagen-1-id-usuario-3.jpg'),
(3, 6, 'dos', 'imagen-2-id-usuario-3.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `negocio`
--

CREATE TABLE `negocio` (
  `ID_NEGOCIO` int(11) NOT NULL,
  `ID_PERSONA` int(11) DEFAULT NULL,
  `ID_COMUNA` int(11) DEFAULT NULL,
  `NOMBRE_DE_FANTASIA_NEGOCIO` varchar(200) DEFAULT NULL,
  `DESCRIPCION_NEGOCIO` longtext,
  `DIRECCION_NEGOCIO` varchar(200) DEFAULT NULL,
  `REFERENCIA_DIRECCION_NEGOCIO` varchar(200) DEFAULT NULL,
  `LATITUD_NEGOCIO` varchar(300) DEFAULT NULL,
  `LONGITUD_NEGOCIO` varchar(300) DEFAULT NULL,
  `CELULAR_NEGOCIO` varchar(200) DEFAULT NULL,
  `WHATSAPP_NEGOCIO` varchar(200) DEFAULT NULL,
  `FACEBOOK_NEGOCIO` varchar(300) DEFAULT NULL,
  `PAGINA_WEB_NEGOCIO` varchar(300) DEFAULT NULL,
  `NOMBRE_USUARIO_FACEBOOK_NEGOCIO` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `negocio`
--

INSERT INTO `negocio` (`ID_NEGOCIO`, `ID_PERSONA`, `ID_COMUNA`, `NOMBRE_DE_FANTASIA_NEGOCIO`, `DESCRIPCION_NEGOCIO`, `DIRECCION_NEGOCIO`, `REFERENCIA_DIRECCION_NEGOCIO`, `LATITUD_NEGOCIO`, `LONGITUD_NEGOCIO`, `CELULAR_NEGOCIO`, `WHATSAPP_NEGOCIO`, `FACEBOOK_NEGOCIO`, `PAGINA_WEB_NEGOCIO`, `NOMBRE_USUARIO_FACEBOOK_NEGOCIO`) VALUES
(1, 1, NULL, 'ejemplo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 3, 35, 'Aguas termales', 'asdasd asd sad as', '', '', '-29.902669099999997', '-71.2519374', '967052104', '967052104', '', '', ''),
(8, 3, NULL, 'kajjak', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `ID_PERSONA` int(11) NOT NULL,
  `ID_TIPO_USUARIO` int(11) DEFAULT NULL,
  `RUT_PERSONA` varchar(20) DEFAULT NULL,
  `NOMBRE_COMPLETO_PERSONA` varchar(200) DEFAULT NULL,
  `USUARIO_PERSONA` varchar(200) DEFAULT NULL,
  `CONTRASENA_PERSONA` varchar(200) DEFAULT NULL,
  `EMAIL_PERSONA` varchar(200) DEFAULT NULL,
  `FONO_PERSONA` varchar(200) DEFAULT NULL,
  `ESTADO_PERSONA` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`ID_PERSONA`, `ID_TIPO_USUARIO`, `RUT_PERSONA`, `NOMBRE_COMPLETO_PERSONA`, `USUARIO_PERSONA`, `CONTRASENA_PERSONA`, `EMAIL_PERSONA`, `FONO_PERSONA`, `ESTADO_PERSONA`) VALUES
(1, 2, '16.428.927-3', 'Roy Alex Standen Barraza', 'roystandenb', 'roy164289273yor', 'roystandenb@gmail.com', NULL, 1),
(2, 2, '123456', 'Amanda Standen', 'amandita', '123456', 'amanda@gmail.com', '123456', 1),
(3, 1, '8.370.986-3', 'otro nombre', '456', '456', 'nose@gmail.com', '+56 3 4534 5345', 1),
(4, 1, '789', '789', '789', '789', '789', '+56 7 7777 7777', 0),
(5, 1, '16.428.927-3', 'Sol', 'sol', '567', 'sol@gmail.com', '+56 9 9292 6213', 0),
(6, 1, '16.428.927-3', 'clarita', 'clara', 'clara', 'clara@perrita.com', '+56 9 9292 6213', 0),
(7, 1, '16.428.927-3', '777', '7777', '77', '77777@ghj.xom', '+56 7 7777 7777', 1),
(8, 1, '16.428.927-3', '8888', '78888', '8888', '888@88.8', '+56 8 8888 8888', 1),
(9, 1, '16.428.927-3', '9999', '9999', '9999', '9@9.9', '+56 9 9999 9999', 1),
(10, 1, '6.667.038-4', 'Hkkhj', 'Hjjhkk', 'Hujh', 'D@gmail.com', '+56 9 8989 8788', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `provincia`
--

CREATE TABLE `provincia` (
  `ID_PROVINCIA` int(11) NOT NULL,
  `ID_REGION` int(11) DEFAULT NULL,
  `NOMBRE_PROVINCIA` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `provincia`
--

INSERT INTO `provincia` (`ID_PROVINCIA`, `ID_REGION`, `NOMBRE_PROVINCIA`) VALUES
(1, 1, 'Arica'),
(2, 1, 'Parinacota'),
(3, 2, 'Iquique'),
(4, 2, 'El Tamarugal'),
(5, 3, 'Antofagasta'),
(6, 3, 'El Loa'),
(7, 3, 'Tocopilla'),
(8, 4, 'Chañaral'),
(9, 4, 'Copiapó'),
(10, 4, 'Huasco'),
(11, 5, 'Choapa'),
(12, 5, 'Elqui'),
(13, 5, 'Limarí'),
(14, 6, 'Isla de Pascua'),
(15, 6, 'Los Andes'),
(16, 6, 'Petorca'),
(17, 6, 'Quillota'),
(18, 6, 'San Antonio'),
(19, 6, 'San Felipe de Aconcagua'),
(20, 6, 'Valparaiso'),
(21, 7, 'Chacabuco'),
(22, 7, 'Cordillera'),
(23, 7, 'Maipo'),
(24, 7, 'Melipilla'),
(25, 7, 'Santiago'),
(26, 7, 'Talagante'),
(27, 8, 'Cachapoal'),
(28, 8, 'Cardenal Caro'),
(29, 8, 'Colchagua'),
(30, 9, 'Cauquenes'),
(31, 9, 'Curicó'),
(32, 9, 'Linares'),
(33, 9, 'Talca'),
(34, 10, 'Arauco'),
(35, 10, 'Bio Bío'),
(36, 10, 'Concepción'),
(37, 10, 'Ñuble'),
(38, 11, 'Cautín'),
(39, 11, 'Malleco'),
(40, 12, 'Valdivia'),
(41, 12, 'Ranco'),
(42, 13, 'Chiloé'),
(43, 13, 'Llanquihue'),
(44, 13, 'Osorno'),
(45, 13, 'Palena'),
(46, 14, 'Aisén'),
(47, 14, 'Capitán Prat'),
(48, 14, 'Coihaique'),
(49, 14, 'General Carrera'),
(50, 15, 'Antártica Chilena'),
(51, 15, 'Magallanes'),
(52, 15, 'Tierra del Fuego'),
(53, 15, 'Última Esperanza');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `region`
--

CREATE TABLE `region` (
  `ID_REGION` int(11) NOT NULL,
  `NOMBRE_REGION` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `region`
--

INSERT INTO `region` (`ID_REGION`, `NOMBRE_REGION`) VALUES
(1, 'Arica y Parinacota'),
(2, 'Tarapacá'),
(3, 'Antofagasta'),
(4, 'Atacama'),
(5, 'Coquimbo'),
(6, 'Valparaiso'),
(7, 'Metropolitana de Santiago'),
(8, 'Libertador General Bernardo O\'Higgins'),
(9, 'Maule'),
(10, 'Biobío'),
(11, 'La Araucanía'),
(12, 'Los Ríos'),
(13, 'Los Lagos'),
(14, 'Aisén del General Carlos Ibáñez del Campo'),
(15, 'Magallanes y de la Antártica Chilena');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicio`
--

CREATE TABLE `servicio` (
  `ID_SERVICIO` int(11) NOT NULL,
  `NOMBRE_SERVICIO` varchar(200) DEFAULT NULL,
  `ICONO_SERVICIO` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `servicio`
--

INSERT INTO `servicio` (`ID_SERVICIO`, `NOMBRE_SERVICIO`, `ICONO_SERVICIO`) VALUES
(11, 'Hotel', '11.png'),
(12, 'Comida rápida', '12.png'),
(13, 'Iglesia', '13.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios_del_negocio`
--

CREATE TABLE `servicios_del_negocio` (
  `ID_SERVICIOS_DEL_NEGOCIO` int(11) NOT NULL,
  `ID_NEGOCIO` int(11) DEFAULT NULL,
  `ID_SERVICIO` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `servicios_del_negocio`
--

INSERT INTO `servicios_del_negocio` (`ID_SERVICIOS_DEL_NEGOCIO`, `ID_NEGOCIO`, `ID_SERVICIO`) VALUES
(20, 6, 11);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_usuario`
--

CREATE TABLE `tipo_usuario` (
  `ID_TIPO_USUARIO` int(11) NOT NULL,
  `NOMBRE_TIPO_USUARIO` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipo_usuario`
--

INSERT INTO `tipo_usuario` (`ID_TIPO_USUARIO`, `NOMBRE_TIPO_USUARIO`) VALUES
(1, 'EMPRESA'),
(2, 'ADMINISTRADOR');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comuna`
--
ALTER TABLE `comuna`
  ADD PRIMARY KEY (`ID_COMUNA`),
  ADD KEY `FK_RELATIONSHIP_6` (`ID_PROVINCIA`);

--
-- Indices de la tabla `foto`
--
ALTER TABLE `foto`
  ADD PRIMARY KEY (`ID_FOTO`),
  ADD KEY `FK_RELATIONSHIP_2` (`ID_NEGOCIO`);

--
-- Indices de la tabla `negocio`
--
ALTER TABLE `negocio`
  ADD PRIMARY KEY (`ID_NEGOCIO`),
  ADD KEY `FK_RELATIONSHIP_1` (`ID_PERSONA`),
  ADD KEY `FK_RELATIONSHIP_7` (`ID_COMUNA`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`ID_PERSONA`),
  ADD KEY `FK_RELATIONSHIP_8` (`ID_TIPO_USUARIO`);

--
-- Indices de la tabla `provincia`
--
ALTER TABLE `provincia`
  ADD PRIMARY KEY (`ID_PROVINCIA`),
  ADD KEY `FK_RELATIONSHIP_5` (`ID_REGION`);

--
-- Indices de la tabla `region`
--
ALTER TABLE `region`
  ADD PRIMARY KEY (`ID_REGION`);

--
-- Indices de la tabla `servicio`
--
ALTER TABLE `servicio`
  ADD PRIMARY KEY (`ID_SERVICIO`);

--
-- Indices de la tabla `servicios_del_negocio`
--
ALTER TABLE `servicios_del_negocio`
  ADD PRIMARY KEY (`ID_SERVICIOS_DEL_NEGOCIO`),
  ADD KEY `FK_RELATIONSHIP_3` (`ID_NEGOCIO`),
  ADD KEY `FK_RELATIONSHIP_4` (`ID_SERVICIO`);

--
-- Indices de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  ADD PRIMARY KEY (`ID_TIPO_USUARIO`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comuna`
--
ALTER TABLE `comuna`
  MODIFY `ID_COMUNA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=399;
--
-- AUTO_INCREMENT de la tabla `foto`
--
ALTER TABLE `foto`
  MODIFY `ID_FOTO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `negocio`
--
ALTER TABLE `negocio`
  MODIFY `ID_NEGOCIO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `ID_PERSONA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `provincia`
--
ALTER TABLE `provincia`
  MODIFY `ID_PROVINCIA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;
--
-- AUTO_INCREMENT de la tabla `region`
--
ALTER TABLE `region`
  MODIFY `ID_REGION` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT de la tabla `servicio`
--
ALTER TABLE `servicio`
  MODIFY `ID_SERVICIO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT de la tabla `servicios_del_negocio`
--
ALTER TABLE `servicios_del_negocio`
  MODIFY `ID_SERVICIOS_DEL_NEGOCIO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  MODIFY `ID_TIPO_USUARIO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comuna`
--
ALTER TABLE `comuna`
  ADD CONSTRAINT `FK_RELATIONSHIP_6` FOREIGN KEY (`ID_PROVINCIA`) REFERENCES `provincia` (`ID_PROVINCIA`);

--
-- Filtros para la tabla `foto`
--
ALTER TABLE `foto`
  ADD CONSTRAINT `FK_RELATIONSHIP_2` FOREIGN KEY (`ID_NEGOCIO`) REFERENCES `negocio` (`ID_NEGOCIO`);

--
-- Filtros para la tabla `negocio`
--
ALTER TABLE `negocio`
  ADD CONSTRAINT `FK_RELATIONSHIP_1` FOREIGN KEY (`ID_PERSONA`) REFERENCES `persona` (`ID_PERSONA`),
  ADD CONSTRAINT `FK_RELATIONSHIP_7` FOREIGN KEY (`ID_COMUNA`) REFERENCES `comuna` (`ID_COMUNA`);

--
-- Filtros para la tabla `persona`
--
ALTER TABLE `persona`
  ADD CONSTRAINT `FK_RELATIONSHIP_8` FOREIGN KEY (`ID_TIPO_USUARIO`) REFERENCES `tipo_usuario` (`ID_TIPO_USUARIO`);

--
-- Filtros para la tabla `provincia`
--
ALTER TABLE `provincia`
  ADD CONSTRAINT `FK_RELATIONSHIP_5` FOREIGN KEY (`ID_REGION`) REFERENCES `region` (`ID_REGION`);

--
-- Filtros para la tabla `servicios_del_negocio`
--
ALTER TABLE `servicios_del_negocio`
  ADD CONSTRAINT `FK_RELATIONSHIP_3` FOREIGN KEY (`ID_NEGOCIO`) REFERENCES `negocio` (`ID_NEGOCIO`),
  ADD CONSTRAINT `FK_RELATIONSHIP_4` FOREIGN KEY (`ID_SERVICIO`) REFERENCES `servicio` (`ID_SERVICIO`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
