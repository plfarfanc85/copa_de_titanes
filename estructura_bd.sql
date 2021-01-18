SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Base de datos: `deity`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `city`
--

CREATE TABLE `city` (
  `id` bigint(20) NOT NULL,
  `dane` varchar(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `state` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `console`
--

CREATE TABLE `console` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `state` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `credit`
--

CREATE TABLE `credit` (
  `id` int(11) NOT NULL,
  `amount` int(11) DEFAULT NULL,
  `comments` varchar(150) NOT NULL,
  `player_id` bigint(20) NOT NULL,
  `date_import` datetime NOT NULL COMMENT 'Fecha en que se crea el registro.',
  `path` varchar(250) DEFAULT NULL COMMENT 'Soporte pago',
  `rrhh_id` bigint(20) DEFAULT NULL,
  `state` int(11) NOT NULL COMMENT '0:Anulado, 1:Aprobado, 2:Pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------------------

--
-- Estructura de tabla para la tabla `game`
--

CREATE TABLE `game` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `game_type_id` bigint(20) NOT NULL,
  `state` tinyint(11) NOT NULL COMMENT '1:activo; 0:inactivo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `game_type`
--

CREATE TABLE `game_type` (
  `id` bigint(20) NOT NULL,
  `name` varchar(250) NOT NULL,
  `state` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historical`
--

CREATE TABLE `historical` (
  `id` bigint(20) NOT NULL,
  `action` varchar(50) DEFAULT NULL,
  `comments` varchar(250) DEFAULT NULL,
  `table_name` varchar(50) DEFAULT NULL,
  `table_id` bigint(20) DEFAULT NULL,
  `rrhh_id` bigint(20) DEFAULT NULL,
  `action_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historical_session`
--

CREATE TABLE `historical_session` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `action` varchar(10) NOT NULL,
  `date` date NOT NULL,
  `hour` time NOT NULL,
  `ip` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historico_visitante`
--

CREATE TABLE `historico_visitante` (
  `id` bigint(20) NOT NULL,
  `date` date NOT NULL,
  `hour` time NOT NULL,
  `page` int(11) NOT NULL COMMENT '1:home, 2:fifa, 3:pes, 4:halo, 5:callofduty',
  `state` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `player`
--

CREATE TABLE `player` (
  `id` bigint(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `dni` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(10) NOT NULL,
  `city_id` bigint(20) NOT NULL,
  `path` varchar(255) DEFAULT NULL,
  `profile` varchar(100) NOT NULL,
  `login` tinyint(4) NOT NULL DEFAULT '0',
  `state` tinyint(4) NOT NULL COMMENT '1:activo; 0:inactivo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rrhh`
--

CREATE TABLE `rrhh` (
  `id` bigint(11) NOT NULL,
  `username` varchar(10) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `dni` varchar(15) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `surname` varchar(100) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `mobile` varchar(10) DEFAULT NULL,
  `profile` varchar(20) DEFAULT NULL,
  `path` varchar(255) NOT NULL,
  `state` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `social_network`
--

CREATE TABLE `social_network` (
  `id` bigint(20) NOT NULL,
  `entity` varchar(45) NOT NULL,
  `entity_id` int(11) NOT NULL,
  `comments` varchar(250) NOT NULL,
  `published` datetime NOT NULL,
  `player_id` bigint(20) NOT NULL,
  `father` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tournament`
--

CREATE TABLE `tournament` (
  `id` bigint(20) NOT NULL,
  `name` varchar(200) NOT NULL,
  `game_id` int(11) NOT NULL,
  `tournament_type_id` int(11) NOT NULL COMMENT 'Tipo de torneo',
  `tournament_detail_id` int(11) NOT NULL,
  `tournament_class_id` int(11) NOT NULL,
  `consoles` varchar(10) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `inscription` int(11) NOT NULL DEFAULT '0',
  `description` varchar(255) DEFAULT NULL,
  `city_id` int(11) NOT NULL,
  `profit` int(11) NOT NULL DEFAULT '30',
  `winner_id` bigint(20) NOT NULL,
  `test` tinyint(4) NOT NULL,
  `state` tinyint(11) NOT NULL COMMENT '1:activo; 0:inactivo; 2: terminado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tournament_class`
--

CREATE TABLE `tournament_class` (
  `id` int(11) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `state` int(11) NOT NULL COMMENT '0:Inactivo, 1:Activo	'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tournament_console`
--

CREATE TABLE `tournament_console` (
  `id` bigint(20) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `console_id` int(11) DEFAULT NULL,
  `state` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tournament_detail`
--

CREATE TABLE `tournament_detail` (
  `id` bigint(20) NOT NULL,
  `amount` int(11) NOT NULL COMMENT 'Cuantas veces el tipo (N grupos o liga de todo el torneo)',
  `players` int(11) NOT NULL COMMENT 'Jugadores x grupo o liga',
  `classified` int(11) NOT NULL,
  `sessions` int(11) NOT NULL COMMENT 'Cantidad de Sesiones',
  `group_roundtrip` tinyint(4) NOT NULL COMMENT 'Partido ida y vuelta en grupo',
  `playoff_roundtrip` tinyint(4) NOT NULL COMMENT '	Ida y vuelta en Playoff'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tournament_group`
--

CREATE TABLE `tournament_group` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `tournament_phase_id` bigint(20) DEFAULT NULL,
  `tournament_coordinator_id` bigint(20) DEFAULT NULL,
  `tconsole_id` int(11) NOT NULL COMMENT 'Consola Asignada al grupo',
  `state` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tournament_group_detail`
--

CREATE TABLE `tournament_group_detail` (
  `id` int(11) NOT NULL,
  `player_id` bigint(20) DEFAULT NULL,
  `tournament_group_id` bigint(20) DEFAULT NULL,
  `point` int(11) DEFAULT NULL COMMENT 'Puntos de la tabla de posiciones, como la tabla credits',
  `state` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tournament_group_position`
--

CREATE TABLE `tournament_group_position` (
  `id` bigint(20) NOT NULL,
  `tournament_group_id` bigint(20) DEFAULT NULL,
  `player_id` bigint(20) DEFAULT NULL,
  `point` bigint(20) DEFAULT NULL,
  `position` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tournament_group_position_soccer`
--

CREATE TABLE `tournament_group_position_soccer` (
  `id` bigint(20) NOT NULL,
  `tournament_group_position_id` bigint(20) DEFAULT NULL,
  `gf` int(11) DEFAULT NULL COMMENT 'Goles a favor',
  `gc` int(11) DEFAULT NULL COMMENT 'Goles en contra',
  `dg` int(11) DEFAULT NULL COMMENT 'Diferencia de Goles',
  `pj` int(11) DEFAULT NULL COMMENT 'Partidos Jugados',
  `pg` int(11) DEFAULT NULL COMMENT 'Partidos Ganados',
  `pe` int(11) DEFAULT NULL COMMENT 'Partidos empatados',
  `pp` int(11) DEFAULT NULL COMMENT 'Partidos perdidos',
  `state` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tournament_match`
--

CREATE TABLE `tournament_match` (
  `id` bigint(20) NOT NULL,
  `name` varchar(250) DEFAULT NULL,
  `tournament_group_id` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `tconsole_id` bigint(20) DEFAULT NULL,
  `state` int(4) DEFAULT NULL COMMENT '0:Inactivo; 1:Activo; 2:·En Juego; 3:Terminado; 4:Cancelado; 5:En Edicion'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tournament_match_detail`
--

CREATE TABLE `tournament_match_detail` (
  `id` bigint(20) NOT NULL,
  `tournament_match_id` bigint(20) DEFAULT NULL,
  `player_id` bigint(20) DEFAULT NULL,
  `point` int(11) DEFAULT NULL COMMENT 'Marcador (Goles) o Posicion, dependiendo de la configuracion',
  `tournament_match_type_id` bigint(20) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  `state` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tournament_match_schedule`
--

CREATE TABLE `tournament_match_schedule` (
  `id` bigint(20) NOT NULL,
  `tournament_match_id` bigint(20) NOT NULL,
  `player_id` bigint(20) NOT NULL,
  `date_schedule` datetime NOT NULL,
  `state` int(11) NOT NULL COMMENT '0: Opcional, 1: Confirmado, 2:cancelado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tournament_match_type`
--

CREATE TABLE `tournament_match_type` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `state` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tournament_phase`
--

CREATE TABLE `tournament_phase` (
  `id` bigint(20) NOT NULL,
  `tournament_session_id` bigint(20) DEFAULT NULL,
  `console_id` int(11) DEFAULT NULL,
  `name` varchar(250) DEFAULT NULL,
  `number` int(11) DEFAULT NULL COMMENT 'Orden de ejecucion en el torneo',
  `state` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tournament_player`
--

CREATE TABLE `tournament_player` (
  `id` bigint(20) NOT NULL,
  `tournament_id` bigint(20) NOT NULL,
  `player_id` bigint(20) NOT NULL,
  `console_id` int(11) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  `state` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tournament_session`
--

CREATE TABLE `tournament_session` (
  `id` bigint(20) NOT NULL,
  `name` varchar(250) DEFAULT NULL,
  `tournament_id` bigint(20) DEFAULT NULL,
  `state` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tournament_structure`
--

CREATE TABLE `tournament_structure` (
  `id` bigint(20) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `state` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tournament_type`
--

CREATE TABLE `tournament_type` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `state` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tournament_winners`
--

CREATE TABLE `tournament_winners` (
  `id` bigint(20) NOT NULL,
  `tournament_id` bigint(20) NOT NULL,
  `percent` int(11) NOT NULL,
  `player_id` bigint(20) DEFAULT NULL,
  `position` int(11) NOT NULL,
  `state` tinyint(4) NOT NULL COMMENT '0:No pagado; 1:Pagado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `console`
--
ALTER TABLE `console`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `credit`
--
ALTER TABLE `credit`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `game`
--
ALTER TABLE `game`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `game_type`
--
ALTER TABLE `game_type`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `historical`
--
ALTER TABLE `historical`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `historical_session`
--
ALTER TABLE `historical_session`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `historico_visitante`
--
ALTER TABLE `historico_visitante`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `player`
--
ALTER TABLE `player`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `rrhh`
--
ALTER TABLE `rrhh`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `social_network`
--
ALTER TABLE `social_network`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tournament`
--
ALTER TABLE `tournament`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tournament_class`
--
ALTER TABLE `tournament_class`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tournament_console`
--
ALTER TABLE `tournament_console`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tournament_detail`
--
ALTER TABLE `tournament_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tournament_group`
--
ALTER TABLE `tournament_group`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tournament_group_detail`
--
ALTER TABLE `tournament_group_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tournament_group_position`
--
ALTER TABLE `tournament_group_position`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tournament_group_position_soccer`
--
ALTER TABLE `tournament_group_position_soccer`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tournament_match`
--
ALTER TABLE `tournament_match`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tournament_match_detail`
--
ALTER TABLE `tournament_match_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tournament_match_schedule`
--
ALTER TABLE `tournament_match_schedule`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tournament_match_type`
--
ALTER TABLE `tournament_match_type`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tournament_phase`
--
ALTER TABLE `tournament_phase`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tournament_player`
--
ALTER TABLE `tournament_player`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tournament_session`
--
ALTER TABLE `tournament_session`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tournament_structure`
--
ALTER TABLE `tournament_structure`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tournament_type`
--
ALTER TABLE `tournament_type`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tournament_winners`
--
ALTER TABLE `tournament_winners`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `city`
--
ALTER TABLE `city`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `console`
--
ALTER TABLE `console`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `credit`
--
ALTER TABLE `credit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `game`
--
ALTER TABLE `game`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `game_type`
--
ALTER TABLE `game_type`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `historical`
--
ALTER TABLE `historical`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `historical_session`
--
ALTER TABLE `historical_session`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de la tabla `historico_visitante`
--
ALTER TABLE `historico_visitante`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5573;

--
-- AUTO_INCREMENT de la tabla `player`
--
ALTER TABLE `player`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=721;

--
-- AUTO_INCREMENT de la tabla `rrhh`
--
ALTER TABLE `rrhh`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `social_network`
--
ALTER TABLE `social_network`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tournament`
--
ALTER TABLE `tournament`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `tournament_class`
--
ALTER TABLE `tournament_class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tournament_console`
--
ALTER TABLE `tournament_console`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tournament_detail`
--
ALTER TABLE `tournament_detail`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `tournament_group`
--
ALTER TABLE `tournament_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT de la tabla `tournament_group_detail`
--
ALTER TABLE `tournament_group_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=363;

--
-- AUTO_INCREMENT de la tabla `tournament_group_position`
--
ALTER TABLE `tournament_group_position`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=421;

--
-- AUTO_INCREMENT de la tabla `tournament_group_position_soccer`
--
ALTER TABLE `tournament_group_position_soccer`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=421;

--
-- AUTO_INCREMENT de la tabla `tournament_match`
--
ALTER TABLE `tournament_match`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=311;

--
-- AUTO_INCREMENT de la tabla `tournament_match_detail`
--
ALTER TABLE `tournament_match_detail`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=621;

--
-- AUTO_INCREMENT de la tabla `tournament_match_schedule`
--
ALTER TABLE `tournament_match_schedule`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tournament_match_type`
--
ALTER TABLE `tournament_match_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tournament_phase`
--
ALTER TABLE `tournament_phase`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT de la tabla `tournament_player`
--
ALTER TABLE `tournament_player`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=188;

--
-- AUTO_INCREMENT de la tabla `tournament_session`
--
ALTER TABLE `tournament_session`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `tournament_structure`
--
ALTER TABLE `tournament_structure`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tournament_type`
--
ALTER TABLE `tournament_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tournament_winners`
--
ALTER TABLE `tournament_winners`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


