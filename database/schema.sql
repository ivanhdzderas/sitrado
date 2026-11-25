/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `alternativas` (
  `id_alternativa` int NOT NULL AUTO_INCREMENT,
  `alternativa` text NOT NULL,
  `id_business` int NOT NULL,
  PRIMARY KEY (`id_alternativa`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `analisis_8d` (
  `id_8d` int NOT NULL AUTO_INCREMENT,
  `folio` int NOT NULL,
  `fecha` date NOT NULL,
  `fecha_cierre` date NOT NULL,
  `tipo` varchar(120) NOT NULL,
  `solicitante` varchar(150) NOT NULL,
  `problema_detectado` varchar(120) NOT NULL,
  `descripcion_problema` text NOT NULL,
  `creado` int NOT NULL,
  `notas` text NOT NULL,
  `estatus` varchar(10) NOT NULL,
  `efectivo_accion` varchar(2) DEFAULT NULL,
  `materia_prima` text NOT NULL,
  `metodos` text NOT NULL,
  `mano_de_obra` text NOT NULL,
  `maquinaria` text NOT NULL,
  `medio_ambiente` text NOT NULL,
  `causa_raiz` text NOT NULL,
  `lider` int NOT NULL,
  `objetivo` text NOT NULL,
  `presupuesto` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_8d`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `archivos_8d` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tipo_solucion` varchar(20) NOT NULL,
  `id_solucion` int NOT NULL,
  `archivo` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `archivos_juntas` (
  `id_archivo` int NOT NULL AUTO_INCREMENT,
  `id_tema` int NOT NULL,
  `archivo` text NOT NULL,
  PRIMARY KEY (`id_archivo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `archivos_proyectos` (
  `id_archivo` int NOT NULL AUTO_INCREMENT,
  `id_subproyecto` int NOT NULL,
  `archivo` varchar(150) NOT NULL,
  PRIMARY KEY (`id_archivo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `area` (
  `id` int NOT NULL,
  `area` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `avisos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `mensaje` text NOT NULL,
  `activo` varchar(2) NOT NULL DEFAULT 'SI',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `business` (
  `id_business` int NOT NULL AUTO_INCREMENT,
  `analisis` text NOT NULL,
  `ventaja` text NOT NULL,
  `fecha` date NOT NULL,
  `seleccion` int NOT NULL,
  `solicito` int NOT NULL,
  PRIMARY KEY (`id_business`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chat` (
  `chat_id` int NOT NULL AUTO_INCREMENT,
  `usuario` varchar(30) NOT NULL,
  `message` text NOT NULL,
  `sent_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `envia` int NOT NULL,
  `leido` varchar(2) NOT NULL DEFAULT 'NO',
  PRIMARY KEY (`chat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `checador` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario` int NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `movimiento` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `configuracion` (
  `8d` int NOT NULL,
  `encargada_proyectos` int NOT NULL,
  `f_c` varchar(150) NOT NULL,
  `f_n` varchar(150) NOT NULL,
  `f_m` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `consultores` (
  `id_consultor` int NOT NULL AUTO_INCREMENT,
  `folio_proyecto` int NOT NULL,
  `id_usuario` int NOT NULL,
  PRIMARY KEY (`id_consultor`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `documento` (
  `id` int NOT NULL,
  `folio` varchar(40) NOT NULL,
  `direccion` varchar(40) NOT NULL,
  `nombre` varchar(40) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `documentos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `menu` varchar(30) NOT NULL,
  `activo` varchar(2) NOT NULL,
  `descarga` varchar(2) NOT NULL,
  `submenu` int NOT NULL,
  `estatus` varchar(1) NOT NULL,
  `tipo` varchar(5) NOT NULL,
  `departamento` varchar(150) NOT NULL,
  `folio` varchar(30) NOT NULL,
  `fecha` int NOT NULL,
  `rev` int NOT NULL,
  `todos` varchar(2) NOT NULL DEFAULT 'NO',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `empresa` (
  `id` int NOT NULL,
  `nombre` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `empresas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) NOT NULL,
  `calle` varchar(120) NOT NULL,
  `numero_ext` varchar(10) NOT NULL,
  `numero_int` varchar(10) NOT NULL,
  `colonia` varchar(120) NOT NULL,
  `ciudad` varchar(120) NOT NULL,
  `estado` varchar(120) NOT NULL,
  `cp` varchar(5) NOT NULL,
  `rfc` varchar(13) NOT NULL,
  `apoderado` varchar(150) NOT NULL,
  `logo` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `equipo_de_trabajo` (
  `id_equipo` int NOT NULL,
  `folio_8d` int NOT NULL,
  `id_persona` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `eventos` (
  `id_evento` int NOT NULL AUTO_INCREMENT,
  `titulo` text NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `activo` varchar(2) NOT NULL,
  `tipo` varchar(120) NOT NULL,
  `descripcion` text NOT NULL,
  PRIMARY KEY (`id_evento`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `grupos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nomber` varchar(150) NOT NULL,
  `empresa` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `informados` (
  `id_informado` int NOT NULL AUTO_INCREMENT,
  `folio_proyecto` int NOT NULL,
  `id_usuario` int NOT NULL,
  PRIMARY KEY (`id_informado`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `integrantes` (
  `id_integrante` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `id_junta` int DEFAULT NULL,
  `asistencia` varchar(2) DEFAULT NULL,
  PRIMARY KEY (`id_integrante`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `juntas` (
  `id_junta` int NOT NULL AUTO_INCREMENT,
  `tema` varchar(150) NOT NULL,
  `fecha` datetime NOT NULL,
  `duracion` int NOT NULL,
  `lugar` text NOT NULL,
  `impartidor` int NOT NULL,
  `asignada` varchar(2) NOT NULL,
  `tipo` varchar(1) NOT NULL,
  `vueltas` int NOT NULL,
  `marcada` varchar(2) NOT NULL DEFAULT 'NO',
  `creador` int NOT NULL,
  `activo` varchar(2) NOT NULL DEFAULT 'SI',
  PRIMARY KEY (`id_junta`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mejora` (
  `id_mejora` int NOT NULL AUTO_INCREMENT,
  `descripcion` text NOT NULL,
  `beneficios` text NOT NULL,
  `fecha` date NOT NULL,
  `solicitante` int NOT NULL,
  `atendido` varchar(2) NOT NULL,
  `activo` varchar(2) NOT NULL,
  PRIMARY KEY (`id_mejora`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mensajes_doc` (
  `id_mensaje` int NOT NULL AUTO_INCREMENT,
  `id_documento` int NOT NULL,
  `mensaje` text NOT NULL,
  `fecha` date NOT NULL,
  PRIMARY KEY (`id_mensaje`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `menu` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) NOT NULL,
  `empresa` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `niveles` (
  `id_nivel` int NOT NULL AUTO_INCREMENT,
  `nivel` varchar(150) NOT NULL,
  PRIMARY KEY (`id_nivel`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notas` (
  `id_nota` int NOT NULL AUTO_INCREMENT,
  `id_tema_junta` int NOT NULL,
  `nota` text NOT NULL,
  `fecha` date NOT NULL,
  PRIMARY KEY (`id_nota`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notas_proyectos` (
  `id_nota` int NOT NULL AUTO_INCREMENT,
  `nota` text NOT NULL,
  `fecha` date NOT NULL,
  `id_subproyecto` int NOT NULL,
  PRIMARY KEY (`id_nota`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pedimentos` (
  `id_pedimento` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(120) NOT NULL,
  `fecha` date NOT NULL,
  `pidio` int NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `activo` varchar(2) NOT NULL,
  PRIMARY KEY (`id_pedimento`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pendientes` (
  `id_pendiente` int NOT NULL AUTO_INCREMENT,
  `usuario` int NOT NULL,
  `tema` text NOT NULL,
  `fecha` date NOT NULL,
  `activo` varchar(2) NOT NULL,
  `f_fin` date NOT NULL,
  `titulo` varchar(150) NOT NULL,
  PRIMARY KEY (`id_pendiente`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permiso_doc` (
  `id_permiso` int NOT NULL AUTO_INCREMENT,
  `id_documento` int NOT NULL,
  `id_subgrupo` int NOT NULL,
  PRIMARY KEY (`id_permiso`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permisos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario` int NOT NULL,
  `empresa` int NOT NULL,
  `grupo` int NOT NULL,
  `subgrupo` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permisos_documentos` (
  `id_permiso` int NOT NULL AUTO_INCREMENT,
  `id_documento` int NOT NULL,
  `id_usuario` int NOT NULL,
  PRIMARY KEY (`id_permiso`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `proyecto` (
  `id_proyecto` int NOT NULL AUTO_INCREMENT,
  `nombre_proyecto` varchar(150) NOT NULL,
  `capitan` int NOT NULL,
  `subcapitan` int NOT NULL,
  `f_inicio` date NOT NULL,
  `f_fin` date DEFAULT NULL,
  `patrocinador` int NOT NULL,
  `pendiente` varchar(2) NOT NULL,
  PRIMARY KEY (`id_proyecto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reactiva_subproyectos` (
  `id_reactiva` int NOT NULL AUTO_INCREMENT,
  `nota` text NOT NULL,
  `id_subproyecto` int NOT NULL,
  `fecha` date NOT NULL,
  `id_usuario` int NOT NULL,
  PRIMARY KEY (`id_reactiva`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reagendar` (
  `id_reagenda` int NOT NULL AUTO_INCREMENT,
  `proyecto` int NOT NULL,
  `subproyecto` int NOT NULL,
  `capitan` int NOT NULL,
  `respuesta` varchar(2) NOT NULL,
  `visto` varchar(2) NOT NULL DEFAULT 'NO',
  `notas` text NOT NULL,
  PRIMARY KEY (`id_reagenda`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reservaciones` (
  `id_reservacion` int NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `id_usuario` int NOT NULL,
  `sala` varchar(50) NOT NULL,
  `aprobado` varchar(2) NOT NULL,
  `id_junta` int NOT NULL,
  PRIMARY KEY (`id_reservacion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `responsables` (
  `id_departamento` int NOT NULL AUTO_INCREMENT,
  `departamento` varchar(150) NOT NULL,
  `usuario` int NOT NULL,
  `siglas` varchar(5) NOT NULL,
  PRIMARY KEY (`id_departamento`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sala_junta` (
  `id_sala` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) NOT NULL,
  `direccion` text NOT NULL,
  PRIMARY KEY (`id_sala`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `solicitud` (
  `id_solicitud` int NOT NULL AUTO_INCREMENT,
  `folio` int NOT NULL,
  `solicitante` int NOT NULL,
  `fecha` date NOT NULL,
  `tipo` varchar(5) NOT NULL,
  `codigo` varchar(15) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `especificar` text NOT NULL,
  `tiempo` int NOT NULL,
  `tipo_doc` varchar(30) NOT NULL,
  PRIMARY KEY (`id_solicitud`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `solucion_permanente` (
  `id_permanente` int NOT NULL AUTO_INCREMENT,
  `folio_8d` int NOT NULL,
  `solucion` text NOT NULL,
  `id_responsable` int NOT NULL,
  `fecha` date NOT NULL,
  `f_fin` date NOT NULL,
  `money` decimal(10,2) NOT NULL,
  `activo` varchar(2) NOT NULL DEFAULT 'SI',
  PRIMARY KEY (`id_permanente`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `solucion_preventivo` (
  `id_preventivo` int NOT NULL AUTO_INCREMENT,
  `folio_8d` int NOT NULL,
  `solucion` text NOT NULL,
  `id_responsable` int NOT NULL,
  `fecha` date NOT NULL,
  `f_fin` date NOT NULL,
  `money` decimal(10,2) NOT NULL,
  `activo` varchar(2) NOT NULL,
  PRIMARY KEY (`id_preventivo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `solucion_temporal` (
  `id_temporal` int NOT NULL AUTO_INCREMENT,
  `solucion` text NOT NULL,
  `id_responsable` int NOT NULL,
  `fecha` date NOT NULL,
  `f_fin` date NOT NULL,
  `folio_8d` int NOT NULL,
  `money` decimal(10,2) NOT NULL,
  `activo` varchar(2) NOT NULL,
  PRIMARY KEY (`id_temporal`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subgrupos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) NOT NULL,
  `gupo` int NOT NULL,
  `empresa` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `submenu` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(120) NOT NULL,
  `padre` varchar(120) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subproyecto` (
  `id_subproyecto` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) NOT NULL,
  `id_usuario` int NOT NULL,
  `f_inicio` date NOT NULL,
  `f_fin` date NOT NULL,
  `id_proyecto` int NOT NULL,
  `terminado` varchar(2) NOT NULL,
  `responsable` int NOT NULL,
  `reagenda` int NOT NULL,
  PRIMARY KEY (`id_subproyecto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `temas_juntas` (
  `id_tema` int NOT NULL AUTO_INCREMENT,
  `id_junta` int DEFAULT NULL,
  `tema` text NOT NULL,
  `fecha_compromiso` date DEFAULT NULL,
  `id_usuario_encargado` int DEFAULT NULL,
  `archivo` varchar(2) DEFAULT NULL,
  `terminado` varchar(2) DEFAULT NULL,
  `activo` varchar(2) NOT NULL DEFAULT 'SI',
  PRIMARY KEY (`id_tema`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(120) NOT NULL,
  `pass` varchar(250) NOT NULL,
  `usuario` varchar(120) NOT NULL,
  `tipo` varchar(5) NOT NULL,
  `juntas` varchar(2) NOT NULL,
  `img` varchar(150) NOT NULL,
  `plaza` int NOT NULL,
  `departamento` varchar(120) NOT NULL,
  `puesto` varchar(120) NOT NULL,
  `nivel` varchar(150) NOT NULL,
  `reportes` varchar(2) NOT NULL DEFAULT 'NO',
  `correo` varchar(150) NOT NULL,
  `asistente` int NOT NULL,
  `ingreso` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `verificacion` (
  `id_verificacion` int NOT NULL AUTO_INCREMENT,
  `id_documento` int NOT NULL,
  `id_usuario` int NOT NULL,
  `estatus` varchar(1) NOT NULL,
  PRIMARY KEY (`id_verificacion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `visto` (
  `id` int NOT NULL AUTO_INCREMENT,
  `documento` int NOT NULL,
  `usuario` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `visto_avisos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `aviso` int NOT NULL,
  `usuario` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
