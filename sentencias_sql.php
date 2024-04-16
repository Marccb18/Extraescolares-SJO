<?php

$uri = "mysql://avnadmin:AVNS_SV3vxOevkckSb-vKih-@extraescolar-msolizrueda-948a.b.aivencloud.com:18078/defaultdb?ssl-mode=REQUIRED";

$fields = parse_url($uri);

// build the DSN including SSL settings
$conn = "mysql:";
$conn .= "host=" . $fields["host"];
$conn .= ";port=" . $fields["port"];;
$conn .= ";dbname=defaultdb";
$conn .= ";sslmode=verify-ca;sslrootcert=ca.pem";

try {
    $db = new PDO($conn, $fields["user"], $fields["pass"]);

    $stmt = $db->query("-- phpMyAdmin SQL Dump
    -- version 5.2.1
    -- https://www.phpmyadmin.net/
    --
    -- Servidor: 127.0.0.1
    -- Tiempo de generación: 11-04-2024 a las 21:29:55
    -- Versión del servidor: 10.4.28-MariaDB
    -- Versión de PHP: 8.2.4
    
    SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';
    START TRANSACTION;
    SET time_zone = '+00:00';
    
    
    /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
    /*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
    /*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
    /*!40101 SET NAMES utf8mb4 */;
    
    --
    -- Base de datos: `extraescolares_sjo`
    --
    
    -- --------------------------------------------------------
    
    --
    -- Estructura de tabla para la tabla `alumno`
    --
    
    CREATE TABLE `alumno` (
        `ID` int(12) NOT NULL,
        `Nombre` varchar(50) NOT NULL,
        `Apellidos` varchar(50) NOT NULL,
        `ID_Materia` int(10) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
    
    --
    -- Volcado de datos para la tabla `alumno`
    --
    
    INSERT INTO `alumno` (`ID`, `Nombre`, `Apellidos`, `ID_Materia`) VALUES
    (1, 'Ana', 'Garcia Lopez', 1),
    (2, 'Pedro', 'Ruiz Sanchez', 2),
    (3, 'Maria', 'Gonzalez Lopez', 3),
    (4, 'Juan', 'Perez Garcia', 4),
    (5, 'Sofia', 'Diaz Hernandez', 5),
    (6, 'David', 'Garcia Alonso', 6),
    (7, 'Laura', 'Lopez Jimenez', 7),
    (8, 'Alejandro', 'Martinez Rodriguez', 8),
    (9, 'Marta', 'Sanchez Gonzalez', 1),
    (10, 'Luis', 'Blanco Torres', 2);
    
    -- --------------------------------------------------------
    
    --
    -- Estructura de tabla para la tabla `faltas`
    --
    
    CREATE TABLE `faltas` (
        `ID_Alumno` int(12) NOT NULL,
        `ID_Materia` int(10) NOT NULL,
        `Fecha` date NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
    
    --
    -- Volcado de datos para la tabla `faltas`
    --
    
    INSERT INTO `faltas` (`ID_Alumno`, `ID_Materia`, `Fecha`) VALUES
    (4, 4, '2024-04-17'),
    (7, 7, '2024-04-01'),
    (8, 8, '2024-02-14'),
    (10, 2, '2034-06-19');
    
    -- --------------------------------------------------------
    
    --
    -- Estructura de tabla para la tabla `materia`
    --
    
    CREATE TABLE `materia` (
        `ID` int(10) NOT NULL,
        `Nombre` varchar(30) NOT NULL,
        `Dia` enum('LUN','MAR','MIE','JUE','VIE','SAB','DOM') NOT NULL,
        `Hora` time NOT NULL,
        `ID_Profesor` varchar(10) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
    
    --
    -- Volcado de datos para la tabla `materia`
    --
    
    INSERT INTO `materia` (`ID`, `Nombre`, `Dia`, `Hora`, `ID_Profesor`) VALUES
    (1, 'Matematicas', 'LUN', '09:00:00', '12345678A'),
    (2, 'Fisica', 'MAR', '10:00:00', '22110033J'),
    (3, 'Quimica', 'MIE', '11:00:00', '33221100G'),
    (4, 'Lenguaje', 'JUE', '12:00:00', '98765432D'),
    (5, 'Literatura', 'VIE', '13:00:00', '12345678A'),
    (6, 'Historia', 'SAB', '14:00:00', '22110033J'),
    (7, 'Geografia', 'DOM', '15:00:00', '33221100G'),
    (8, 'Filosofia', 'LUN', '16:00:00', '98765432D');
    
    -- --------------------------------------------------------
    
    --
    -- Estructura de tabla para la tabla `matriculas`
    --
    
    CREATE TABLE `matriculas` (
        `ID_Alumno` int(12) NOT NULL,
        `ID_Materia` int(10) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
    
    --
    -- Volcado de datos para la tabla `matriculas`
    --
    
    INSERT INTO `matriculas` (`ID_Alumno`, `ID_Materia`) VALUES
    (1, 1),
    (9, 1),
    (2, 2),
    (10, 2),
    (3, 3),
    (4, 4),
    (5, 5),
    (6, 6),
    (7, 7),
    (8, 8);
    
    -- --------------------------------------------------------
    
    --
    -- Estructura de tabla para la tabla `personal`
    --
    
    CREATE TABLE `personal` (
            `DNI` varchar(10) NOT NULL,
        `Nombre` varchar(50) NOT NULL,
        `Apellidos` varchar(50) NOT NULL,
        `Email` varchar(50) NOT NULL,
        `ROL` enum('PRO','ADM','COO') NOT NULL,
        `Password` varchar(300) NOT NULL,
        `Telefono` int(9) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
    
    --
    -- Volcado de datos para la tabla `personal`
    --
    
    INSERT INTO `personal` (`DNI`, `Nombre`, `Apellidos`, `Email`, `ROL`, `Password`, `Telefono`) VALUES
    ('00123456C', 'Pedro', 'Ruiz Sanchez', 'pedro.ruiz@company.com', 'COO', 'hashed_password789', 234567890),
    ('11223344E', 'Luis', 'Blanco Torres', 'luis.blanco@company.com', 'ADM', 'hashed_password345', 456789012),
    ('12345678A', 'Juan', 'Perez Garcia', 'juan.perez@company.com', 'PRO', 'hashed_password123', 123456789),
    ('22110033J', 'Marta', 'Sanchez Gonzalez', 'marta.sanchez@company.com', 'PRO', 'hashed_password890', 901234567),
    ('33221100G', 'David', 'Garcia Alonso', 'david.garcia@company.com', 'PRO', 'hashed_password901', 678901234),
    ('44112233H', 'Laura', 'Lopez Jimenez', 'laura.lopez@company.com', 'ADM', 'hashed_password234', 789012345),
    ('55443322F', 'Sofia', 'Diaz Hernandez', 'sofia.diaz@company.com', 'COO', 'hashed_password678', 567890123),
    ('66554433I', 'Alejandro', 'Martinez Rodriguez', 'alejandro.martinez@company.com', 'COO', 'hashed_password567', 890123456),
    ('87654321B', 'Maria', 'Gonzalez Lopez', 'maria.gonzalez@company.com', 'ADM', 'hashed_password456', 987654321),
    ('98765432D', 'Ana', 'Fernandez Martinez', 'ana.fernandez@company.com', 'PRO', 'hashed_password012', 345678901);
    
    --
    -- Índices para tablas volcadas
    --
    
    --
    -- Indices de la tabla `alumno`
    --
    ALTER TABLE `alumno`
        ADD PRIMARY KEY (`ID`),
        ADD KEY `ID_Materia` (`ID_Materia`);
    
    --
    -- Indices de la tabla `faltas`
    --
    ALTER TABLE `faltas`
        ADD PRIMARY KEY (`ID_Alumno`,`ID_Materia`,`Fecha`),
        ADD KEY `ID_Alumno` (`ID_Alumno`),
        ADD KEY `ID_Materia` (`ID_Materia`);
    
    --
    -- Indices de la tabla `materia`
    --
    ALTER TABLE `materia`
        ADD PRIMARY KEY (`ID`),
        ADD KEY `ID_Profesor` (`ID_Profesor`);
    
    --
    -- Indices de la tabla `matriculas`
    --
    ALTER TABLE `matriculas`
        ADD PRIMARY KEY (`ID_Alumno`),
        ADD KEY `ID_Alumno` (`ID_Alumno`),
        ADD KEY `ID_Materia` (`ID_Materia`);
    
    --
    -- Indices de la tabla `personal`
    --
    ALTER TABLE `personal`
        ADD PRIMARY KEY (`DNI`);
    
    --
    -- AUTO_INCREMENT de las tablas volcadas
    --
    
    --
    -- AUTO_INCREMENT de la tabla `alumno`
    --
    ALTER TABLE `alumno`
        MODIFY `ID` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123456800;
    
    --
    -- AUTO_INCREMENT de la tabla `materia`
    --
    ALTER TABLE `materia`
        MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
    
    --
    -- Restricciones para tablas volcadas
    --
    
    --
    -- Filtros para la tabla `alumno`
    --
    ALTER TABLE `alumno`
        ADD CONSTRAINT `alumno_ibfk_1` FOREIGN KEY (`ID_Materia`) REFERENCES `materia` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
    
    --
    -- Filtros para la tabla `faltas`
    --
    ALTER TABLE `faltas`
        ADD CONSTRAINT `faltas_ibfk_1` FOREIGN KEY (`ID_Alumno`) REFERENCES `alumno` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
        ADD CONSTRAINT `faltas_ibfk_2` FOREIGN KEY (`ID_Materia`) REFERENCES `materia` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
    
    --
    -- Filtros para la tabla `materia`
    --
    ALTER TABLE `materia`
        ADD CONSTRAINT `materia_ibfk_1` FOREIGN KEY (`ID_Profesor`) REFERENCES `personal` (`DNI`) ON DELETE CASCADE ON UPDATE CASCADE;
    
    --
    -- Filtros para la tabla `matriculas`
    --
    ALTER TABLE `matriculas`
        ADD CONSTRAINT `matriculas_ibfk_1` FOREIGN KEY (`ID_Alumno`) REFERENCES `alumno` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
        ADD CONSTRAINT `matriculas_ibfk_2` FOREIGN KEY (`ID_Materia`) REFERENCES `materia` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
    COMMIT;");
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}