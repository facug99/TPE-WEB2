<?php

class Model {
    protected $db; // La base de datos que heredarán los otros modelos

    public function __construct() {
        // Se establece la conexión con la base de datos
        $this->db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET, DB_USER, DB_PASS);
        $this->deploy();
    }

    /**
     * Crea las tablas en la base de datos en caso que esté vacía
     */
    public function deploy() {
        // Se verifica si hay tablas en la DB
        $query = $this->db->query('SHOW TABLES');

        // Se obtienen todas las tablas de la DB
        $tables = $query->fetchAll();

        // Si no hay, se crean
        if (count($tables) == 0) {
            $sql = 
            <<<END
                -- phpMyAdmin SQL Dump
                -- version 5.2.1
                -- https://www.phpmyadmin.net/
                --
                -- Servidor: 127.0.0.1
                -- Tiempo de generación: 17-10-2023 a las 18:20:49
                -- Versión del servidor: 10.4.28-MariaDB
                -- Versión de PHP: 8.2.4

                SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
                START TRANSACTION;
                SET time_zone = "+00:00";


                /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
                /*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
                /*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
                /*!40101 SET NAMES utf8mb4 */;

                --
                -- Base de datos: `web2_tpe`
                --

                -- --------------------------------------------------------

                --
                -- Estructura de tabla para la tabla `albums`
                --

                CREATE TABLE `albums` (
                `id` int(11) NOT NULL,
                `title` varchar(100) NOT NULL,
                `year` int(11) NOT NULL,
                `band_id` int(11) NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

                --
                -- Volcado de datos para la tabla `albums`
                --

                INSERT INTO `albums` (`id`, `title`, `year`, `band_id`) VALUES
                (4, 'Rock a Medianoche', 2000, 2),
                (5, 'Rock Eterno', 1999, 2),
                (6, 'Raíces sureñas', 1988, 3),
                (7, 'Folklore de la Pampa', 1999, 3),
                (8, 'Salsa y Pasión', 2005, 4),
                (9, 'Tropical Heat', 2012, 4),
                (10, 'Cachengue Bristol', 2016, 6),
                (11, 'Yo Quiero Rock', 2001, 7),
                (12, 'Con vos', 2004, 8),
                (13, 'Baila', 2010, 8),
                (14, '20 Grandes Éxitos', 2020, 9),
                (15, 'Tanto Tango', 1998, 10);

                -- --------------------------------------------------------

                --
                -- Estructura de tabla para la tabla `bands`
                --

                CREATE TABLE `bands` (
                `id` int(11) NOT NULL,
                `name` varchar(100) NOT NULL,
                `genre` varchar(100) NOT NULL,
                `formed_location` varchar(100) NOT NULL,
                `formed_year` int(11) NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

                --
                -- Volcado de datos para la tabla `bands`
                --

                INSERT INTO `bands` (`id`, `name`, `genre`, `formed_location`, `formed_year`) VALUES
                (2, 'Rockeros de la Noche', 'Rock', 'Mar del Plata', 1998),
                (3, 'Sonidos del Sur', 'Folklore', 'Bahía Blanca', 2003),
                (4, 'Hot Salsa Quilmes', 'Salsa', 'Quilmes', 2010),
                (5, 'Lomas de Milonga', 'Tango', 'Lomas de Zamora', 2008),
                (6, 'Cuartetazo Bristol', 'Cuarteto', 'Mar del Plata', 2015),
                (7, 'Esto es Rock', 'Rock', 'Tandil', 2000),
                (8, 'MDQumbia ', 'Cumbia', 'Mar del Plata', 2002),
                (9, 'Aires Sureños', 'Folklore', 'Bahía Blanca', 2012),
                (10, 'Dor por Cuatro', 'Tango', 'La Plata', 1995);

                -- --------------------------------------------------------

                --
                -- Estructura de tabla para la tabla `users`
                --

                CREATE TABLE `users` (
                `id` int(11) NOT NULL,
                `username` varchar(100) NOT NULL,
                `password` varchar(100) NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

                --
                -- Volcado de datos para la tabla `users`
                --

                INSERT INTO `users` (`id`, `username`, `password`) VALUES
                (1, 'webadmin', '$2y$10\$sG.FqhVNVlwjWZkSmgE6O.YT7Dxm94JtfoRjRxZsjaXqpWhw/GDwS');

                --
                -- Índices para tablas volcadas
                --

                --
                -- Indices de la tabla `albums`
                --
                ALTER TABLE `albums`
                ADD PRIMARY KEY (`id`),
                ADD KEY `FK_band_id` (`band_id`);

                --
                -- Indices de la tabla `bands`
                --
                ALTER TABLE `bands`
                ADD PRIMARY KEY (`id`);

                --
                -- Indices de la tabla `users`
                --
                ALTER TABLE `users`
                ADD PRIMARY KEY (`id`),
                ADD UNIQUE KEY `UNIQUE_email` (`username`) USING BTREE;

                --
                -- AUTO_INCREMENT de las tablas volcadas
                --

                --
                -- AUTO_INCREMENT de la tabla `albums`
                --
                ALTER TABLE `albums`
                MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

                --
                -- AUTO_INCREMENT de la tabla `bands`
                --
                ALTER TABLE `bands`
                MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

                --
                -- AUTO_INCREMENT de la tabla `users`
                --
                ALTER TABLE `users`
                MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

                --
                -- Restricciones para tablas volcadas
                --

                --
                -- Filtros para la tabla `albums`
                --
                ALTER TABLE `albums`
                ADD CONSTRAINT `FK_band_id` FOREIGN KEY (`band_id`) REFERENCES `bands` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
                COMMIT;

                /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
                /*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
                /*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
            END;

            $this->db->query($sql);
        }
    }
}
