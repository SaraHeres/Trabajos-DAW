-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-11-2022 a las 20:42:19
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `consultas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE TABLE `citas` (
  `idCita` int(11) NOT NULL,
  `citFecha` date NOT NULL,
  `citHora` time NOT NULL,
  `citPaciente` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `citMedico` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `citConsultorio` int(11) NOT NULL,
  `citEstado` enum('Asignado','Atendido') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Asignado',
  `CitObservaciones` text COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `citas`
--

INSERT INTO `citas` (`idCita`, `citFecha`, `citHora`, `citPaciente`, `citMedico`, `citConsultorio`, `citEstado`, `CitObservaciones`) VALUES
(1, '2022-02-24', '10:30:00', '22333444A', '12345678A', 6, 'Atendido', 'Sintomas leves de psicosis paranoide, quiere un calipo'),
(2, '2022-02-17', '11:25:00', '22444555A', '11222333B', 4, 'Atendido', 'Ataque de ansiedad por ser un capullo'),
(3, '2022-03-15', '14:20:00', '22555666A', '11222333B', 5, 'Atendido', 'EPILEPSIA'),
(4, '2022-03-16', '07:30:00', '44111222A', '12345678A', 1, 'Atendido', 'se hace caca a proposito'),
(5, '2022-03-08', '08:10:00', '22333444A', '11222333B', 1, 'Atendido', 'Sintomas leves de psicosis paranoide, quiere un calipo'),
(6, '2022-03-14', '09:10:00', '22444555A', '11222333B', 1, 'Asignado', ''),
(7, '2022-03-14', '09:09:00', '88777666T', '11222333B', 1, 'Atendido', 'Positivo Covid'),
(8, '2022-03-16', '09:09:00', '88777666T', '11222333B', 1, 'Atendido', 'Positivo Covid'),
(9, '2022-10-13', '09:10:00', '22444555A', '11222666A', 1, 'Asignado', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consultorios`
--

CREATE TABLE `consultorios` (
  `idConsultorio` int(11) NOT NULL,
  `conNombre` char(50) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `consultorios`
--

INSERT INTO `consultorios` (`idConsultorio`, `conNombre`) VALUES
(1, 'Centro de Salud Oviedo'),
(2, 'Centro de Salud Corvera'),
(3, 'Centro de Salud Aviles'),
(4, 'Centro de Salud Gijon'),
(5, 'Centro de Salud Luarca'),
(6, 'Hospital Universitario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medicos`
--

CREATE TABLE `medicos` (
  `dniMed` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `medNombres` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `medApellidos` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `medEspecialidad` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `medTelefono` char(15) COLLATE utf8_spanish_ci NOT NULL,
  `medCorreo` varchar(50) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `medicos`
--

INSERT INTO `medicos` (`dniMed`, `medNombres`, `medApellidos`, `medEspecialidad`, `medTelefono`, `medCorreo`) VALUES
('11222333B', 'Begoña', 'Menenedez', 'Psicologia', '666333444', 'bego@gmail.com'),
('11222666A', 'MAria', 'Magdalena', 'Resurreccion', '999888777', 'm@gmail.com'),
('12345678A', 'Sara', 'Heres', 'Ginecologia', '666111222', 'sara@gmail.com'),
('33999888T', 'Sandra', 'Hernandez', 'Hernandez', '777888666', 'sandra@gmail.com'),
('55666888T', 'Carlos', 'Heres', 'Pediatría', '777888999', 'c@gmail.com'),
('77888999D', 'Soni', 'Gomez', 'cirujia', '444555666', 's@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pacientes`
--

CREATE TABLE `pacientes` (
  `dniPac` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `pacNombres` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `pacApellidos` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `pacFechaNacimiento` date NOT NULL,
  `pacSexo` enum('Masculino','Femenino') COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `pacientes`
--

INSERT INTO `pacientes` (`dniPac`, `pacNombres`, `pacApellidos`, `pacFechaNacimiento`, `pacSexo`) VALUES
('22333444A', 'Jorge', 'Rubin', '1998-11-10', 'Masculino'),
('22444555A', 'Victor', 'Martinez', '1988-04-20', 'Masculino'),
('22555666A', 'Laura', 'Nosti', '1991-07-06', 'Femenino'),
('33222111T', 'David', 'David', '2022-03-01', 'Masculino'),
('44111222A', 'Pablo', 'Fernandez', '2022-03-03', 'Masculino'),
('44333222W', 'Sara', 'Fernandez', '2022-03-02', 'Femenino'),
('44333555T', 'pac', 'pac', '2022-02-28', 'Femenino'),
('44555666P', 'Sakura', 'Kinomoto', '2020-03-03', 'Femenino'),
('55444333W', 'Soraya', 'Povedano', '2020-03-23', 'Femenino'),
('77788999R', 'Pepe', 'Caleya', '2022-03-01', 'Femenino'),
('88777666T', 'Yolanda', 'Iglesias', '2022-03-12', 'Femenino');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `dniUsu` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `usuLogin` char(15) COLLATE utf8_spanish_ci NOT NULL,
  `usuPassword` varchar(157) COLLATE utf8_spanish_ci NOT NULL,
  `usuEstado` enum('Activo','Inactivo') COLLATE utf8_spanish_ci NOT NULL,
  `usutipo` enum('Administrador','Asistente','Medico','Paciente') COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`dniUsu`, `usuLogin`, `usuPassword`, `usuEstado`, `usutipo`) VALUES
('11222333B', 'bego', 'bego11', 'Activo', 'Medico'),
('12345678A', 'sara', 'sara1', 'Activo', 'Medico'),
('22444555A', 'victor', 'victor1', 'Activo', 'Paciente'),
('33222333A', 'admin', 'admin1', 'Activo', 'Administrador'),
('33222333A', 'asistente', 'asistente1', 'Activo', 'Asistente'),
('88777666T', 'yolanda', 'yolanda1', 'Activo', 'Paciente');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`idCita`),
  ADD KEY `citPaciente` (`citPaciente`,`citMedico`,`citConsultorio`),
  ADD KEY `citMedico` (`citMedico`),
  ADD KEY `citConsultorio` (`citConsultorio`);

--
-- Indices de la tabla `consultorios`
--
ALTER TABLE `consultorios`
  ADD PRIMARY KEY (`idConsultorio`);

--
-- Indices de la tabla `medicos`
--
ALTER TABLE `medicos`
  ADD PRIMARY KEY (`dniMed`);

--
-- Indices de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  ADD PRIMARY KEY (`dniPac`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`dniUsu`,`usuLogin`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `citas`
--
ALTER TABLE `citas`
  MODIFY `idCita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
