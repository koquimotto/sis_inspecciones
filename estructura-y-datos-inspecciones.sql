-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         12.2.2-MariaDB - MariaDB Server
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.14.0.7165
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para inspecciones
CREATE DATABASE IF NOT EXISTS `inspecciones` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_uca1400_ai_ci */;
USE `inspecciones`;

-- Volcando estructura para tabla inspecciones.cargos
CREATE TABLE IF NOT EXISTS `cargos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(255) DEFAULT NULL,
  `cargo` varchar(255) DEFAULT NULL,
  `estado` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cargos_codigo_index` (`codigo`),
  KEY `cargos_cargo_index` (`cargo`),
  KEY `cargos_estado_index` (`estado`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla inspecciones.cargos: ~47 rows (aproximadamente)
DELETE FROM `cargos`;
INSERT INTO `cargos` (`id`, `codigo`, `cargo`, `estado`, `created_at`, `updated_at`) VALUES
	(1, 'ADM', 'Administrador', 1, '2026-03-05 10:00:26', '2026-03-05 10:00:26'),
	(2, 'DIR', 'Director', 1, '2026-03-05 10:00:26', '2026-03-05 10:00:26'),
	(3, 'GER', 'Gerente General', 1, '2026-03-05 10:00:26', '2026-03-05 10:00:26'),
	(4, 'SUB', 'Subgerente', 1, '2026-03-05 10:00:26', '2026-03-05 10:00:26'),
	(5, 'JEF', 'Jefe de Área', 1, '2026-03-05 10:00:26', '2026-03-05 10:00:26'),
	(6, 'SUP', 'Supervisor', 1, '2026-03-05 10:00:26', '2026-03-05 10:00:26'),
	(7, 'COO', 'Coordinador', 1, '2026-03-05 10:00:26', '2026-03-05 10:00:26'),
	(8, 'ASI', 'Asistente', 1, '2026-03-05 10:00:26', '2026-03-05 10:00:26'),
	(9, 'ANA', 'Analista', 1, '2026-03-05 10:00:26', '2026-03-05 10:00:26'),
	(10, 'OPE', 'Operador', 1, '2026-03-05 10:00:26', '2026-03-05 10:00:26'),
	(11, 'OPE-MAQ', 'Operador de Maquinaria', 1, '2026-03-05 10:00:26', '2026-03-05 10:00:26'),
	(12, 'CHO', 'Chofer / Conductor', 1, '2026-03-05 10:00:26', '2026-03-05 10:00:26'),
	(13, 'TEC', 'Técnico', 1, '2026-03-05 10:00:26', '2026-03-05 10:00:26'),
	(14, 'TEC-MEC', 'Técnico Mecánico', 1, '2026-03-05 10:00:26', '2026-03-05 10:00:26'),
	(15, 'TEC-ELC', 'Técnico Electricista', 1, '2026-03-05 10:00:26', '2026-03-05 10:00:26'),
	(16, 'TEC-ELE', 'Técnico Electrónico', 1, '2026-03-05 10:00:26', '2026-03-05 10:00:26'),
	(17, 'TEC-SST', 'Técnico de Seguridad y Salud en el Trabajo', 1, '2026-03-05 10:00:26', '2026-03-05 10:00:26'),
	(18, 'MEC', 'Mecánico', 1, '2026-03-05 10:00:26', '2026-03-05 10:00:26'),
	(19, 'ELC', 'Electricista', 1, '2026-03-05 10:00:26', '2026-03-05 10:00:26'),
	(20, 'SOL', 'Soldador', 1, '2026-03-05 10:00:26', '2026-03-05 10:00:26'),
	(21, 'ALM', 'Almacenero', 1, '2026-03-05 10:00:26', '2026-03-05 10:00:26'),
	(22, 'LOG', 'Logística', 1, '2026-03-05 10:00:26', '2026-03-05 10:00:26'),
	(23, 'COM', 'Compras', 1, '2026-03-05 10:00:26', '2026-03-05 10:00:26'),
	(24, 'ING-CIV', 'Ingeniero Civil', 1, '2026-03-05 10:00:26', '2026-03-05 10:00:26'),
	(25, 'ING-IND', 'Ingeniero Industrial', 1, '2026-03-05 10:00:26', '2026-03-05 10:00:26'),
	(26, 'ING-MEC', 'Ingeniero Mecánico', 1, '2026-03-05 10:00:26', '2026-03-05 10:00:26'),
	(27, 'ING-ELC', 'Ingeniero Electricista', 1, '2026-03-05 10:00:26', '2026-03-05 10:00:26'),
	(28, 'ING-SIS', 'Ingeniero de Sistemas', 1, '2026-03-05 10:00:26', '2026-03-05 10:00:26'),
	(29, 'ING-AMB', 'Ingeniero Ambiental', 1, '2026-03-05 10:00:26', '2026-03-05 10:00:26'),
	(30, 'ING-GEO', 'Ingeniero Geólogo', 1, '2026-03-05 10:00:26', '2026-03-05 10:00:26'),
	(31, 'ARQ', 'Arquitecto', 1, '2026-03-05 10:00:26', '2026-03-05 10:00:26'),
	(32, 'TOP', 'Topógrafo', 1, '2026-03-05 10:00:26', '2026-03-05 10:00:26'),
	(33, 'CON', 'Contador', 1, '2026-03-05 10:00:26', '2026-03-05 10:00:26'),
	(34, 'TES', 'Tesorero', 1, '2026-03-05 10:00:26', '2026-03-05 10:00:26'),
	(35, 'RRHH', 'Recursos Humanos', 1, '2026-03-05 10:00:26', '2026-03-05 10:00:26'),
	(36, 'LEG', 'Asesor Legal', 1, '2026-03-05 10:00:26', '2026-03-05 10:00:26'),
	(37, 'ADM-OF', 'Administración (Oficina)', 1, '2026-03-05 10:00:26', '2026-03-05 10:00:26'),
	(38, 'VEN', 'Vendedor', 1, '2026-03-05 10:00:26', '2026-03-05 10:00:26'),
	(39, 'ASE-COM', 'Asesor Comercial', 1, '2026-03-05 10:00:26', '2026-03-05 10:00:26'),
	(40, 'ATE', 'Atención al Cliente', 1, '2026-03-05 10:00:26', '2026-03-05 10:00:26'),
	(41, 'MKT', 'Marketing', 1, '2026-03-05 10:00:26', '2026-03-05 10:00:26'),
	(42, 'DEV', 'Desarrollador', 1, '2026-03-05 10:00:26', '2026-03-05 10:00:26'),
	(43, 'SOP', 'Soporte Técnico', 1, '2026-03-05 10:00:26', '2026-03-05 10:00:26'),
	(44, 'INF', 'Infraestructura / Redes', 1, '2026-03-05 10:00:26', '2026-03-05 10:00:26'),
	(45, 'CAL', 'Calidad', 1, '2026-03-05 10:00:26', '2026-03-05 10:00:26'),
	(46, 'DOC', 'Documentación', 1, '2026-03-05 10:00:26', '2026-03-05 10:00:26'),
	(47, 'PRA', 'Practicante', 1, '2026-03-05 10:00:26', '2026-03-05 10:00:26');

-- Volcando estructura para tabla inspecciones.categorias
CREATE TABLE IF NOT EXISTS `categorias` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(255) DEFAULT NULL,
  `categoria` varchar(255) NOT NULL,
  `estado` bit(1) DEFAULT b'1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `updated_by` bigint(20) unsigned DEFAULT NULL,
  `deleted_by` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `categorias_codigo_index` (`codigo`) USING BTREE,
  KEY `categorias_categoria_index` (`categoria`) USING BTREE,
  KEY `categorias_estado_index` (`estado`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Volcando datos para la tabla inspecciones.categorias: ~54 rows (aproximadamente)
DELETE FROM `categorias`;
INSERT INTO `categorias` (`id`, `codigo`, `categoria`, `estado`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
	(1, 'VEH-PIC', 'Vehículo - Pickup', b'1', '2026-03-05 09:59:54', '2026-03-05 09:59:54', NULL, NULL, NULL, NULL),
	(2, 'VEH-SUV', 'Vehículo - SUV', b'1', '2026-03-05 09:59:54', '2026-03-05 09:59:54', NULL, NULL, NULL, NULL),
	(3, 'VEH-SED', 'Vehículo - Sedán', b'1', '2026-03-05 09:59:54', '2026-03-05 09:59:54', NULL, NULL, NULL, NULL),
	(4, 'VEH-HBK', 'Vehículo - Hatchback', b'1', '2026-03-05 09:59:54', '2026-03-05 09:59:54', NULL, NULL, NULL, NULL),
	(5, 'VEH-VAN', 'Vehículo - Van', b'1', '2026-03-05 09:59:54', '2026-03-05 09:59:54', NULL, NULL, NULL, NULL),
	(6, 'VEH-MIN', 'Vehículo - Minibús', b'1', '2026-03-05 09:59:54', '2026-03-05 09:59:54', NULL, NULL, NULL, NULL),
	(7, 'VEH-BUS', 'Vehículo - Bus', b'1', '2026-03-05 09:59:54', '2026-03-05 09:59:54', NULL, NULL, NULL, NULL),
	(8, 'CAM-LIG', 'Camión - Liviano', b'1', '2026-03-05 09:59:54', '2026-03-05 09:59:54', NULL, NULL, NULL, NULL),
	(9, 'CAM-MED', 'Camión - Mediano', b'1', '2026-03-05 09:59:54', '2026-03-05 09:59:54', NULL, NULL, NULL, NULL),
	(10, 'CAM-PES', 'Camión - Pesado', b'1', '2026-03-05 09:59:54', '2026-03-05 09:59:54', NULL, NULL, NULL, NULL),
	(11, 'CAM-TRC', 'Tractocamión', b'1', '2026-03-05 09:59:54', '2026-03-05 09:59:54', NULL, NULL, NULL, NULL),
	(12, 'CAM-VOL', 'Volquete', b'1', '2026-03-05 09:59:54', '2026-03-05 09:59:54', NULL, NULL, NULL, NULL),
	(13, 'CAM-CIS', 'Cisterna', b'1', '2026-03-05 09:59:54', '2026-03-05 09:59:54', NULL, NULL, NULL, NULL),
	(14, 'CAM-FRG', 'Furgón', b'1', '2026-03-05 09:59:54', '2026-03-05 09:59:54', NULL, NULL, NULL, NULL),
	(15, 'CAM-PLT', 'Plataforma', b'1', '2026-03-05 09:59:54', '2026-03-05 09:59:54', NULL, NULL, NULL, NULL),
	(16, 'CAM-BAR', 'Baranda', b'1', '2026-03-05 09:59:54', '2026-03-05 09:59:54', NULL, NULL, NULL, NULL),
	(17, 'MAQ-EXC', 'Excavadora', b'1', '2026-03-05 09:59:54', '2026-03-05 09:59:54', NULL, NULL, NULL, NULL),
	(18, 'MAQ-RET', 'Retroexcavadora', b'1', '2026-03-05 09:59:54', '2026-03-05 09:59:54', NULL, NULL, NULL, NULL),
	(19, 'MAQ-CAR', 'Cargador frontal', b'1', '2026-03-05 09:59:54', '2026-03-05 09:59:54', NULL, NULL, NULL, NULL),
	(20, 'MAQ-MIN', 'Minicargador', b'1', '2026-03-05 09:59:54', '2026-03-05 09:59:54', NULL, NULL, NULL, NULL),
	(21, 'MAQ-DOZ', 'Bulldozer / Tractor oruga', b'1', '2026-03-05 09:59:54', '2026-03-05 09:59:54', NULL, NULL, NULL, NULL),
	(22, 'MAQ-MOT', 'Motoniveladora', b'1', '2026-03-05 09:59:54', '2026-03-05 09:59:54', NULL, NULL, NULL, NULL),
	(23, 'MAQ-ROD', 'Rodillo compactador', b'1', '2026-03-05 09:59:54', '2026-03-05 09:59:54', NULL, NULL, NULL, NULL),
	(24, 'MAQ-COM', 'Compactadora', b'1', '2026-03-05 09:59:54', '2026-03-05 09:59:54', NULL, NULL, NULL, NULL),
	(25, 'MAQ-GRU', 'Grúa', b'1', '2026-03-05 09:59:54', '2026-03-05 09:59:54', NULL, NULL, NULL, NULL),
	(26, 'MAQ-PLA', 'Plataforma elevadora', b'1', '2026-03-05 09:59:54', '2026-03-05 09:59:54', NULL, NULL, NULL, NULL),
	(27, 'MAQ-TEH', 'Telehandler', b'1', '2026-03-05 09:59:54', '2026-03-05 09:59:54', NULL, NULL, NULL, NULL),
	(28, 'MAQ-DMP', 'Dumper articulado', b'1', '2026-03-05 09:59:54', '2026-03-05 09:59:54', NULL, NULL, NULL, NULL),
	(29, 'MAQ-PAV', 'Pavimentadora / Terminadora', b'1', '2026-03-05 09:59:54', '2026-03-05 09:59:54', NULL, NULL, NULL, NULL),
	(30, 'MAQ-FRE', 'Fresadora', b'1', '2026-03-05 09:59:54', '2026-03-05 09:59:54', NULL, NULL, NULL, NULL),
	(31, 'MAQ-ZAN', 'Zanjadora', b'1', '2026-03-05 09:59:54', '2026-03-05 09:59:54', NULL, NULL, NULL, NULL),
	(32, 'MAQ-PER', 'Perforadora', b'1', '2026-03-05 09:59:54', '2026-03-05 09:59:54', NULL, NULL, NULL, NULL),
	(33, 'MAQ-TRI', 'Trituradora / Chancadora', b'1', '2026-03-05 09:59:54', '2026-03-05 09:59:54', NULL, NULL, NULL, NULL),
	(34, 'MAQ-PLN', 'Planta (Asfalto / Concreto)', b'1', '2026-03-05 09:59:54', '2026-03-05 09:59:54', NULL, NULL, NULL, NULL),
	(35, 'EQP-MON', 'Montacargas', b'1', '2026-03-05 09:59:54', '2026-03-05 09:59:54', NULL, NULL, NULL, NULL),
	(36, 'EQP-GEN', 'Generador eléctrico', b'1', '2026-03-05 09:59:54', '2026-03-05 09:59:54', NULL, NULL, NULL, NULL),
	(37, 'EQP-COM', 'Compresor de aire', b'1', '2026-03-05 09:59:54', '2026-03-05 09:59:54', NULL, NULL, NULL, NULL),
	(38, 'EQP-SOL', 'Soldadora', b'1', '2026-03-05 09:59:54', '2026-03-05 09:59:54', NULL, NULL, NULL, NULL),
	(39, 'EQP-BOM', 'Bomba (agua / lodo)', b'1', '2026-03-05 09:59:54', '2026-03-05 09:59:54', NULL, NULL, NULL, NULL),
	(40, 'EQP-HID', 'Unidad hidráulica', b'1', '2026-03-05 09:59:54', '2026-03-05 09:59:54', NULL, NULL, NULL, NULL),
	(41, 'EQP-ILU', 'Torre de iluminación', b'1', '2026-03-05 09:59:54', '2026-03-05 09:59:54', NULL, NULL, NULL, NULL),
	(42, 'EQP-HER', 'Herramienta eléctrica', b'1', '2026-03-05 09:59:54', '2026-03-05 09:59:54', NULL, NULL, NULL, NULL),
	(43, 'AGR-TRC', 'Tractor agrícola', b'1', '2026-03-05 09:59:54', '2026-03-05 09:59:54', NULL, NULL, NULL, NULL),
	(44, 'AGR-COB', 'Cosechadora', b'1', '2026-03-05 09:59:54', '2026-03-05 09:59:54', NULL, NULL, NULL, NULL),
	(45, 'AGR-PUL', 'Pulverizadora', b'1', '2026-03-05 09:59:54', '2026-03-05 09:59:54', NULL, NULL, NULL, NULL),
	(46, 'AGR-IMP', 'Implemento agrícola', b'1', '2026-03-05 09:59:54', '2026-03-05 09:59:54', NULL, NULL, NULL, NULL),
	(47, 'REP-MOT', 'Repuesto - Motor', b'1', '2026-03-05 09:59:54', '2026-03-05 09:59:54', NULL, NULL, NULL, NULL),
	(48, 'REP-TRN', 'Repuesto - Transmisión', b'1', '2026-03-05 09:59:54', '2026-03-05 09:59:54', NULL, NULL, NULL, NULL),
	(49, 'REP-HID', 'Repuesto - Hidráulico', b'1', '2026-03-05 09:59:54', '2026-03-05 09:59:54', NULL, NULL, NULL, NULL),
	(50, 'REP-ELC', 'Repuesto - Eléctrico', b'1', '2026-03-05 09:59:54', '2026-03-05 09:59:54', NULL, NULL, NULL, NULL),
	(51, 'REP-FIL', 'Repuesto - Filtros', b'1', '2026-03-05 09:59:54', '2026-03-05 09:59:54', NULL, NULL, NULL, NULL),
	(52, 'REP-NEU', 'Repuesto - Neumáticos / Llantas', b'1', '2026-03-05 09:59:54', '2026-03-05 09:59:54', NULL, NULL, NULL, NULL),
	(53, 'REP-BAT', 'Repuesto - Baterías', b'1', '2026-03-05 09:59:54', '2026-03-05 09:59:54', NULL, NULL, NULL, NULL),
	(54, NULL, 'Deportivo', b'1', '2026-03-31 10:35:55', '2026-03-31 10:35:55', NULL, 1, NULL, NULL);

-- Volcando estructura para tabla inspecciones.certificados
CREATE TABLE IF NOT EXISTS `certificados` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tipo_certificado_id` bigint(20) unsigned NOT NULL,
  `inspeccion_id` bigint(20) unsigned DEFAULT NULL,
  `detalle_inspeccion_id` bigint(20) unsigned NOT NULL,
  `numero` varchar(40) NOT NULL,
  `fecha_emision` date NOT NULL,
  `fecha_vencimiento` date DEFAULT NULL,
  `pdf_ruta` text DEFAULT NULL,
  `anulado` bit(1) DEFAULT b'0',
  `motivo_anulacion` varchar(255) DEFAULT NULL,
  `estado` bit(1) DEFAULT b'1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `updated_by` bigint(20) unsigned DEFAULT NULL,
  `deleted_by` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `certificados_numero_unique` (`numero`) USING BTREE,
  KEY `certificados_inspeccion_id_foreign` (`inspeccion_id`) USING BTREE,
  KEY `certificados_fecha_emision_index` (`fecha_emision`) USING BTREE,
  KEY `certificados_fecha_vencimiento_index` (`fecha_vencimiento`) USING BTREE,
  KEY `certificados_estado_index` (`estado`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Volcando datos para la tabla inspecciones.certificados: ~0 rows (aproximadamente)
DELETE FROM `certificados`;

-- Volcando estructura para tabla inspecciones.cuestionario_categorias
CREATE TABLE IF NOT EXISTS `cuestionario_categorias` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(120) NOT NULL,
  `estado` bit(1) DEFAULT b'1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `updated_by` bigint(20) unsigned DEFAULT NULL,
  `deleted_by` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- Volcando datos para la tabla inspecciones.cuestionario_categorias: ~4 rows (aproximadamente)
DELETE FROM `cuestionario_categorias`;
INSERT INTO `cuestionario_categorias` (`id`, `descripcion`, `estado`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
	(1, 'DATOS GENERALES DEL EQUIPO', b'1', '2026-03-31 15:37:29', '2026-03-31 15:37:29', NULL, NULL, NULL, NULL),
	(2, 'SEGURIDAD Y OTROS', b'1', '2026-03-31 15:37:29', '2026-03-31 15:37:29', NULL, NULL, NULL, NULL),
	(3, 'INSPECCION DEL EQUIPO', b'1', '2026-03-31 15:37:29', '2026-03-31 15:37:29', NULL, NULL, NULL, NULL),
	(4, 'DOCUMENTACION', b'1', '2026-03-31 15:37:29', '2026-03-31 15:37:29', NULL, NULL, NULL, NULL);

-- Volcando estructura para tabla inspecciones.cuestionario_preguntas
CREATE TABLE IF NOT EXISTS `cuestionario_preguntas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cuestionario_categoria_id` bigint(20) unsigned NOT NULL,
  `cuestionario_sub_categoria_id` bigint(20) unsigned NOT NULL,
  `equipo_tipo_ids` varchar(255) DEFAULT NULL,
  `equipo_categoria_ids` varchar(255) DEFAULT NULL,
  `equipo_marca_ids` varchar(255) DEFAULT NULL,
  `equipo_modelo_ids` varchar(255) DEFAULT NULL,
  `pregunta_numero_orden` int(11) DEFAULT NULL,
  `pregunta_visualizacion` enum('ingreso_salida','valor_unico') DEFAULT NULL,
  `pregunta_enunciado` varchar(255) NOT NULL,
  `ingeso_preguntar` tinyint(1) DEFAULT NULL,
  `ingreso_respuesta_tipo` enum('select','radio','entero','decimal','texto','') DEFAULT NULL,
  `ingreso_respuesta_valores` varchar(255) DEFAULT NULL,
  `salida_preguntar` tinyint(1) DEFAULT NULL,
  `salida_respuesta_tipo` enum('select','radio','entero','decimal','texto','') DEFAULT NULL,
  `salida_respuesta_valores` varchar(255) DEFAULT NULL,
  `permitir_observaciones` tinyint(1) DEFAULT NULL,
  `estado` bit(1) DEFAULT b'1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `updated_by` bigint(20) unsigned DEFAULT NULL,
  `deleted_by` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=150 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- Volcando datos para la tabla inspecciones.cuestionario_preguntas: ~149 rows (aproximadamente)
DELETE FROM `cuestionario_preguntas`;
INSERT INTO `cuestionario_preguntas` (`id`, `cuestionario_categoria_id`, `cuestionario_sub_categoria_id`, `equipo_tipo_ids`, `equipo_categoria_ids`, `equipo_marca_ids`, `equipo_modelo_ids`, `pregunta_numero_orden`, `pregunta_visualizacion`, `pregunta_enunciado`, `ingeso_preguntar`, `ingreso_respuesta_tipo`, `ingreso_respuesta_valores`, `salida_preguntar`, `salida_respuesta_tipo`, `salida_respuesta_valores`, `permitir_observaciones`, `estado`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
	(8, 1, 1, '.2.', NULL, NULL, NULL, 8, 'ingreso_salida', 'Horómetro / Kilometraje actual', 1, 'radio', NULL, 1, 'radio', NULL, 0, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(9, 1, 1, '.2.', NULL, NULL, NULL, 9, 'ingreso_salida', 'Nivel de combustible en el tanque', 1, 'radio', '1=>ADD,2=>1/4,3=>1/2,4=>3/4,5=>FULL', 1, 'radio', '1=>ADD,2=>1/4,3=>1/2,4=>3/4,5=>FULL', 0, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(10, 1, 1, '.2.', NULL, NULL, NULL, 10, 'valor_unico', 'Fecha de ultimo mantenimiento preventivo', 1, 'radio', NULL, 0, 'radio', NULL, 0, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(11, 1, 1, '.2.', NULL, NULL, NULL, 11, 'valor_unico', 'Tipo de mantenimiento preventivo', 1, 'radio', NULL, 0, 'radio', NULL, 0, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(16, 1, 1, '.2.', NULL, NULL, NULL, 16, 'valor_unico', 'Seguro contra todo riesgo / Fecha de vencimiento / Copia / Nombre de la aseguradora', 1, 'radio', NULL, 0, 'radio', NULL, 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(17, 2, 2, '.2.', NULL, NULL, NULL, 1, 'ingreso_salida', 'ROPS (Roller Over Protection System) Sistema protector contra volcaduras', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(18, 2, 2, '.2.', NULL, NULL, NULL, 2, 'ingreso_salida', 'Faros neblineros (02) (opcional)', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(19, 2, 2, '.2.', NULL, NULL, NULL, 3, 'ingreso_salida', 'Porta tacos (lado izquierdo)', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(20, 2, 2, '.2.', NULL, NULL, NULL, 4, 'ingreso_salida', 'Tacos para llantas (02)', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(21, 2, 2, '.2.', NULL, NULL, NULL, 5, 'ingreso_salida', 'Faros piratas (02)', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(22, 2, 2, '.2.', NULL, NULL, NULL, 6, 'ingreso_salida', 'Certificado de opacidad', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(23, 2, 2, '.2.', NULL, NULL, NULL, 7, 'ingreso_salida', 'Bandeja contra derrames', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(24, 2, 2, '.2.', NULL, NULL, NULL, 8, 'ingreso_salida', 'Kit anti derrames', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(25, 2, 2, '.2.', NULL, NULL, NULL, 9, 'ingreso_salida', 'Conos color naranja con cinta reflectiva (02)', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(26, 2, 2, '.2.', NULL, NULL, NULL, 10, 'ingreso_salida', 'Cinturones de seguridad en buen estado / cantidad', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(27, 2, 2, '.2.', NULL, NULL, NULL, 11, 'ingreso_salida', 'Soporte de extintor que permita un retiro rapido y facil acceso', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(28, 2, 2, '.2.', NULL, NULL, NULL, 12, 'ingreso_salida', 'Extintor, carga y en buenas condiciones (fecha de vencimiento)', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(29, 2, 2, '.2.', NULL, NULL, NULL, 13, 'ingreso_salida', 'Botiquin de primeros auxilios', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(30, 2, 2, '.2.', NULL, NULL, NULL, 14, 'ingreso_salida', 'Alarma de retroceso con 10 metros de radio de audicion', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(31, 2, 2, '.2.', NULL, NULL, NULL, 15, 'ingreso_salida', 'Baliza (ambar)', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(32, 2, 2, '.2.', NULL, NULL, NULL, 16, 'ingreso_salida', 'Radio base', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(33, 3, 3, '.2.', NULL, NULL, NULL, 1, 'valor_unico', 'Modelo de Motor', 1, 'radio', NULL, 0, 'radio', NULL, 0, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(34, 3, 3, '.2.', NULL, NULL, NULL, 2, 'valor_unico', 'No de Serie del Motor', 1, 'radio', NULL, 0, 'radio', NULL, 0, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(35, 3, 3, '.2.', NULL, NULL, NULL, 3, 'ingreso_salida', 'Funcionamiento del motor', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(36, 3, 3, '.2.', NULL, NULL, NULL, 4, 'ingreso_salida', 'Inspeccion de fugas por ventilador', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(37, 3, 3, '.2.', NULL, NULL, NULL, 5, 'ingreso_salida', 'Inspeccion de fugas por arrancador(es)', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(38, 3, 3, '.2.', NULL, NULL, NULL, 6, 'ingreso_salida', 'Inspeccion de fugas por bomba de agua', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(39, 3, 3, '.2.', NULL, NULL, NULL, 7, 'ingreso_salida', 'Inspeccion de fugas por enfriadores hidraulicos', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(40, 3, 3, '.2.', NULL, NULL, NULL, 8, 'ingreso_salida', 'Inspeccion de fugas por bomba de combustible', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(41, 3, 3, '.2.', NULL, NULL, NULL, 9, 'ingreso_salida', 'Inspeccion de fugas por riel comun / canerias de combustible', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(42, 3, 3, '.2.', NULL, NULL, NULL, 10, 'ingreso_salida', 'Inspeccion de fugas por compresor de A/C', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(43, 3, 3, '.2.', NULL, NULL, NULL, 11, 'ingreso_salida', 'Inspeccion de fugas por carter', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(44, 3, 3, '.2.', NULL, NULL, NULL, 12, 'ingreso_salida', 'Inspeccion de fugas por tapa de balancines', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(45, 3, 3, '.2.', NULL, NULL, NULL, 13, 'ingreso_salida', 'Inspeccion de fugas por radiador', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(46, 3, 3, '.2.', NULL, NULL, NULL, 14, 'ingreso_salida', 'Inspeccion de fugas por mangueras de enfriamiento', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(47, 3, 3, '.2.', NULL, NULL, NULL, 15, 'ingreso_salida', 'Inspeccion de fugas por mangueras del sistema de lubricacion', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(48, 3, 3, '.2.', NULL, NULL, NULL, 16, 'ingreso_salida', 'Inspeccion de fugas por mangueras de combustible', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(49, 3, 3, '.2.', NULL, NULL, NULL, 17, 'ingreso_salida', 'Inspeccion de soportes de motor', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(50, 3, 3, '.2.', NULL, NULL, NULL, 18, 'ingreso_salida', 'Revision de nivel de aceite de motor', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(51, 3, 3, '.2.', NULL, NULL, NULL, 19, 'ingreso_salida', 'Inspeccion de varilla de nivel de aceite de motor', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(52, 3, 3, '.2.', NULL, NULL, NULL, 20, 'ingreso_salida', 'Revision de nivel de refrigerante', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(53, 3, 3, '.2.', NULL, NULL, NULL, 21, 'ingreso_salida', 'Inspeccion de deposito de expansion', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(54, 3, 3, '.2.', NULL, NULL, NULL, 22, 'ingreso_salida', 'Inspeccion de alternador, templador y poleas de alternador', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(55, 3, 3, '.2.', NULL, NULL, NULL, 23, 'ingreso_salida', 'Inspeccion de fugas de gases de escape por sistema', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(56, 3, 3, '.2.', NULL, NULL, NULL, 24, 'ingreso_salida', 'Inspeccion de estado de mangueras del sistema de admision', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(57, 3, 3, '.2.', NULL, NULL, NULL, 25, 'ingreso_salida', 'Inspeccion del estado de caja de filtros de aire', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(58, 3, 3, '.2.', NULL, NULL, NULL, 26, 'ingreso_salida', 'Otros', 1, 'radio', NULL, 1, 'radio', NULL, 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(59, 3, 4, '.2.', NULL, NULL, NULL, 1, 'valor_unico', 'No de Serie de la Transmision', 1, 'radio', NULL, 0, 'radio', NULL, 0, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(60, 3, 4, '.2.', NULL, NULL, NULL, 2, 'ingreso_salida', 'Sonidos anormal en la transmision', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(61, 3, 4, '.2.', NULL, NULL, NULL, 3, 'ingreso_salida', 'Inspeccion de fugas por la caja de transmision', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(62, 3, 4, '.2.', NULL, NULL, NULL, 4, 'ingreso_salida', 'Inspeccion de fugas por lineas de transmision', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(63, 3, 4, '.2.', NULL, NULL, NULL, 5, 'ingreso_salida', 'Evaluacion de ruidos extranos en transmision', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(64, 3, 4, '.2.', NULL, NULL, NULL, 6, 'ingreso_salida', 'Inspeccion de pedal de embrague', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(65, 3, 4, '.2.', NULL, NULL, NULL, 7, 'ingreso_salida', 'Inspeccion de tapones de drenaje de transmision', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(66, 3, 5, '.2.', NULL, NULL, NULL, 1, 'ingreso_salida', 'Inspeccion de fugas por diferencial posterior', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(67, 3, 5, '.2.', NULL, NULL, NULL, 2, 'ingreso_salida', 'Inspeccion de fugas por reten del diferencial frontal', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(68, 3, 5, '.2.', NULL, NULL, NULL, 3, 'ingreso_salida', 'Inspeccion de estado de funda de diferencial (golpes / abolladuras)', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(69, 3, 5, '.2.', NULL, NULL, NULL, 4, 'ingreso_salida', 'Condicion de los tapones de diferenciales', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(70, 3, 5, '.2.', NULL, NULL, NULL, 5, 'ingreso_salida', 'Fuga de aceite por tapones de diferenciales', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(71, 3, 6, '.2.', NULL, NULL, NULL, 1, 'ingreso_salida', 'Verificar el nivel de aceite de tanque de direccion', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(72, 3, 6, '.2.', NULL, NULL, NULL, 2, 'ingreso_salida', 'Verificar la condicion de las mangueras y lineas de direccion', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(73, 3, 6, '.2.', NULL, NULL, NULL, 3, 'ingreso_salida', 'Verificar juego en la volante de direccion', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(74, 3, 6, '.2.', NULL, NULL, NULL, 4, 'ingreso_salida', 'Verificar estado de terminales de direccion', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(75, 3, 6, '.2.', NULL, NULL, NULL, 5, 'ingreso_salida', 'Verificar estado de barras de direccion', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(76, 3, 6, '.2.', NULL, NULL, NULL, 6, 'ingreso_salida', 'Inspeccion de fugas por caja de direccion', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(77, 3, 7, '.2.', NULL, NULL, NULL, 1, 'ingreso_salida', 'Verificar funcionamiento del freno de servicio', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(78, 3, 7, '.2.', NULL, NULL, NULL, 2, 'ingreso_salida', 'Verificar funcionamiento del freno de estacionamiento (freno de mano)', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(79, 3, 7, '.2.', NULL, NULL, NULL, 3, 'ingreso_salida', 'Verificar estado de manometro indicador de presion de aire', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(80, 3, 7, '.2.', NULL, NULL, NULL, 4, 'ingreso_salida', 'Verificar estado de bomba maestra de freno - pulmones', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(81, 3, 7, '.2.', NULL, NULL, NULL, 5, 'ingreso_salida', 'Verificar estado de canerias de freno', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(82, 3, 7, '.2.', NULL, NULL, NULL, 6, 'ingreso_salida', 'Verificar estado de zapatas de freno', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(83, 3, 7, '.2.', NULL, NULL, NULL, 7, 'ingreso_salida', 'Verificar estado de compresora de aire', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(84, 3, 7, '.2.', NULL, NULL, NULL, 8, 'ingreso_salida', 'Verificar estado de valvula reguladora de aire', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(85, 3, 7, '.2.', NULL, NULL, NULL, 9, 'ingreso_salida', 'Verificar estado de tanque de aire (estado/soportes/# de tanques)', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(86, 3, 7, '.2.', NULL, NULL, NULL, 10, 'ingreso_salida', 'Verificar estado de pedal de freno', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(87, 3, 7, '.2.', NULL, NULL, NULL, 11, 'ingreso_salida', 'Inspeccion de fugas por lineas de freno', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(88, 3, 8, '.2.', NULL, NULL, NULL, 1, 'ingreso_salida', 'Verificar el funcionamiento de luces e indicadores', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(89, 3, 8, '.2.', NULL, NULL, NULL, 2, 'ingreso_salida', 'Verificar el funcionamiento del velocimetro / tacometro', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(90, 3, 8, '.2.', NULL, NULL, NULL, 3, 'ingreso_salida', 'Verificar el funcionamiento de horometro', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(91, 3, 8, '.2.', NULL, NULL, NULL, 4, 'ingreso_salida', 'Verificar el funcionamiento de claxon de aire o electrico', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(92, 3, 8, '.2.', NULL, NULL, NULL, 5, 'ingreso_salida', 'Verificar el estado de baterias', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(93, 3, 8, '.2.', NULL, NULL, NULL, 6, 'ingreso_salida', 'Verificar el estado de bornes de bateria', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(94, 3, 8, '.2.', NULL, NULL, NULL, 7, 'ingreso_salida', 'Verificar el estado de cables de bateria', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(95, 3, 8, '.2.', NULL, NULL, NULL, 8, 'ingreso_salida', 'Verificar el estado del cableado del circuito en general', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(96, 3, 8, '.2.', NULL, NULL, NULL, 9, 'ingreso_salida', 'Switch de corte de energia', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(97, 3, 8, '.2.', NULL, NULL, NULL, 10, 'ingreso_salida', 'Sistema de bloqueo mecanico del switch de corte de energia', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(98, 3, 8, '.2.', NULL, NULL, NULL, 11, 'ingreso_salida', 'Verificar el estado de la alarma de retroceso', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(99, 3, 8, '.2.', NULL, NULL, NULL, 12, 'ingreso_salida', 'Verificar el estado de la chapa de arranque', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(100, 3, 8, '.2.', NULL, NULL, NULL, 13, 'ingreso_salida', 'Verificar el estado de faros delanteros (baja/alta)', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(101, 3, 8, '.2.', NULL, NULL, NULL, 14, 'ingreso_salida', 'Verificar el estado de faros direccionales delanteros', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(102, 3, 8, '.2.', NULL, NULL, NULL, 15, 'ingreso_salida', 'Verificar el estado de faros posteriores (freno/direccional/retroceso/estacionamiento)', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(103, 3, 9, '.2.', NULL, NULL, NULL, 1, 'ingreso_salida', 'Luz de lectura', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(104, 3, 9, '.2.', NULL, NULL, NULL, 2, 'ingreso_salida', 'Luz de salon', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(105, 3, 9, '.2.', NULL, NULL, NULL, 3, 'ingreso_salida', 'Verificar estado de las lunas de cabina', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(106, 3, 9, '.2.', NULL, NULL, NULL, 4, 'ingreso_salida', 'Verificar estado de los espejos retrovisores y central', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(107, 3, 9, '.2.', NULL, NULL, NULL, 5, 'ingreso_salida', 'Verificar estado de filtro de cabina', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(108, 3, 9, '.2.', NULL, NULL, NULL, 6, 'ingreso_salida', 'Verificar estado de instrumentos e indicadores', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(109, 3, 9, '.2.', NULL, NULL, NULL, 7, 'ingreso_salida', 'Verificar estado de auto radio musical', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(110, 3, 9, '.2.', NULL, NULL, NULL, 8, 'ingreso_salida', 'Verificar estado de controles de cabina', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(111, 3, 9, '.2.', NULL, NULL, NULL, 9, 'ingreso_salida', 'Verificar estado de sistema de A/C y calefaccion', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(112, 3, 9, '.2.', NULL, NULL, NULL, 10, 'ingreso_salida', 'Verificar nivel de deposito de limpiaparabrisas', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(113, 3, 9, '.2.', NULL, NULL, NULL, 11, 'ingreso_salida', 'Verificar estado de limpia parabrisas', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(114, 3, 9, '.2.', NULL, NULL, NULL, 12, 'ingreso_salida', 'Verificar estado de asiento de operador', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(115, 3, 9, '.2.', NULL, NULL, NULL, 13, 'ingreso_salida', 'Verificar estado de asiento de copiloto', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(116, 3, 9, '.2.', NULL, NULL, NULL, 14, 'ingreso_salida', 'Verificar estado de faros de luces de cabina', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(117, 3, 9, '.2.', NULL, NULL, NULL, 15, 'ingreso_salida', 'Verificar mascarilla frontal', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(118, 3, 9, '.2.', NULL, NULL, NULL, 16, 'ingreso_salida', 'Verificar soporte metalico de capot', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(119, 3, 9, '.2.', NULL, NULL, NULL, 17, 'ingreso_salida', 'Verificar jebe de capot', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(120, 3, 9, '.2.', NULL, NULL, NULL, 18, 'ingreso_salida', 'Verificar emblema frontal (marca de vehiculo)', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(121, 3, 9, '.2.', NULL, NULL, NULL, 19, 'ingreso_salida', 'Verificar estado de coderas', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(122, 3, 9, '.2.', NULL, NULL, NULL, 20, 'ingreso_salida', 'Verificar estado de correas de seguridad', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(123, 3, 9, '.2.', NULL, NULL, NULL, 21, 'ingreso_salida', 'Verificar estado de pisos de jebe', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(124, 3, 9, '.2.', NULL, NULL, NULL, 22, 'ingreso_salida', 'Verificar estado de puertas c/lunas', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(125, 3, 9, '.2.', NULL, NULL, NULL, 23, 'ingreso_salida', 'Verificar estado de chapas de puerta', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(126, 3, 9, '.2.', NULL, NULL, NULL, 24, 'ingreso_salida', 'Verificar deflector de aire', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(127, 3, 9, '.2.', NULL, NULL, NULL, 25, 'ingreso_salida', 'Verificar estado de bisagras de puertas', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(128, 3, 9, '.2.', NULL, NULL, NULL, 26, 'ingreso_salida', 'Verificar estado de gomas de puertas', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(129, 3, 9, '.2.', NULL, NULL, NULL, 27, 'ingreso_salida', 'Verificar tope de puerta (tope al abrir puerta)', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(130, 3, 9, '.2.', NULL, NULL, NULL, 28, 'ingreso_salida', 'Verificar estado de tapa sol', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(131, 3, 9, '.2.', NULL, NULL, NULL, 29, 'ingreso_salida', 'Verificar estado de capot', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(132, 3, 10, '.2.', NULL, NULL, NULL, 1, 'ingreso_salida', 'Verificar estado de chasis principal', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(133, 3, 10, '.2.', NULL, NULL, NULL, 2, 'ingreso_salida', 'Verificar estado de barra estabilizadora', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(134, 3, 10, '.2.', NULL, NULL, NULL, 3, 'ingreso_salida', 'Verificar estado de muelles delanteros', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(135, 3, 10, '.2.', NULL, NULL, NULL, 4, 'ingreso_salida', 'Verificar estado de muelles posteriores', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(136, 3, 10, '.2.', NULL, NULL, NULL, 5, 'ingreso_salida', 'Verificar estado de amortiguadores delanteros', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(137, 3, 10, '.2.', NULL, NULL, NULL, 6, 'ingreso_salida', 'Verificar estado de amortiguadores posteriores', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(138, 3, 10, '.2.', NULL, NULL, NULL, 7, 'ingreso_salida', 'Verificar estado de guardafangos delanteros', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(139, 3, 10, '.2.', NULL, NULL, NULL, 8, 'ingreso_salida', 'Verificar estado de pintura', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(140, 3, 10, '.2.', NULL, NULL, NULL, 9, 'ingreso_salida', 'Verificar estado de guardafangos posteriores', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(141, 3, 10, '.2.', NULL, NULL, NULL, 10, 'ingreso_salida', 'Verificar estado de para choque delantero', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(142, 3, 10, '.2.', '.16.', NULL, NULL, 11, 'ingreso_salida', 'Verificar estado de para choque posterior', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, 'radio', '1=>OK,2=>NO,3=>N/A', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 20:49:28', NULL, NULL, NULL, NULL),
	(143, 4, 11, '.2.', NULL, NULL, NULL, 1, 'ingreso_salida', 'Copia del manual de partes', 1, 'radio', '1=>SI,2=>NO', 1, 'radio', '1=>SI,2=>NO', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(144, 4, 11, '.2.', NULL, NULL, NULL, 2, 'ingreso_salida', 'Copia de manual de operacion', 1, 'radio', '1=>SI,2=>NO', 1, 'radio', '1=>SI,2=>NO', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(145, 4, 11, '.2.', NULL, NULL, NULL, 3, 'ingreso_salida', 'Informe de mantenimientos anteriores', 1, 'radio', '1=>SI,2=>NO', 1, 'radio', '1=>SI,2=>NO', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(146, 4, 11, '.2.', NULL, NULL, NULL, 4, 'ingreso_salida', 'Informe de evaluacion integral de sistemas', 1, 'radio', '1=>SI,2=>NO', 1, 'radio', '1=>SI,2=>NO', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(147, 4, 11, '.2.', NULL, NULL, NULL, 5, 'ingreso_salida', 'Datos de neumaticos', 1, 'radio', '1=>SI,2=>NO', 1, 'radio', '1=>SI,2=>NO', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(148, 4, 11, '.2.', NULL, NULL, NULL, 6, 'ingreso_salida', 'Tabla de cargas de pluma', 1, 'radio', '1=>SI,2=>NO', 1, 'radio', '1=>SI,2=>NO', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 15:39:01', NULL, NULL, NULL, NULL),
	(149, 4, 11, '.2.', NULL, NULL, NULL, 7, 'ingreso_salida', 'Certificado de operatividad de la pluma', 1, 'radio', '1=>SI,2=>NO', 1, 'radio', '1=>SI,2=>NO', 1, b'1', '2026-03-31 15:39:01', '2026-03-31 21:28:06', NULL, NULL, NULL, NULL);



-- Volcando estructura para tabla inspecciones.cuestionario_respuestas
CREATE TABLE IF NOT EXISTS `cuestionario_respuestas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `detalle_inspeccion_id` int(11) NOT NULL,
  `cuestionario_categoria_id` int(11) NOT NULL,
  `cuestionario_sub_categoria_id` int(11) NOT NULL,
  `cuestionario_pregunta_id` int(11) DEFAULT NULL,
  `cuestionario_pregunta_personalizada` varchar(255) DEFAULT NULL,
  `ingreso_respuesta` varchar(255) DEFAULT NULL,
  `salida_respuesta` varchar(255) DEFAULT NULL,
  `observaciones` varchar(255) DEFAULT NULL,
  `estado_respuesta` enum('aceptable','requiere_corregir') DEFAULT NULL,
  `estado` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `deleted_by` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=149 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;


-- Volcando estructura para tabla inspecciones.cuestionario_respuestas_observaciones
CREATE TABLE IF NOT EXISTS `cuestionario_respuestas_observaciones` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cuestionario_respuesta_id` bigint(20) unsigned NOT NULL,
  `inspeccion_archivo_equipo_id` bigint(20) unsigned DEFAULT NULL,
  `descripcion` varchar(255) NOT NULL,
  `momento` enum('ingreso','salida','ambos') DEFAULT NULL,
  `severidad` enum('baja','media','alta') DEFAULT NULL,
  `estado` bit(1) DEFAULT b'1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `updated_by` bigint(20) unsigned DEFAULT NULL,
  `deleted_by` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- Volcando datos para la tabla inspecciones.cuestionario_respuestas_observaciones: ~0 rows (aproximadamente)
DELETE FROM `cuestionario_respuestas_observaciones`;

-- Volcando estructura para tabla inspecciones.cuestionario_sub_categorias
CREATE TABLE IF NOT EXISTS `cuestionario_sub_categorias` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(255) DEFAULT NULL,
  `estado` bit(1) DEFAULT b'1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `updated_by` bigint(20) unsigned DEFAULT NULL,
  `deleted_by` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- Volcando datos para la tabla inspecciones.cuestionario_sub_categorias: ~11 rows (aproximadamente)
DELETE FROM `cuestionario_sub_categorias`;
INSERT INTO `cuestionario_sub_categorias` (`id`, `descripcion`, `estado`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
	(1, 'DETALLES DEL EQUIPO', b'1', '2026-03-31 15:38:24', '2026-03-31 15:38:24', NULL, NULL, NULL, NULL),
	(2, 'INSUMOS DE SEGURIDAD', b'1', '2026-03-31 15:38:24', '2026-03-31 15:38:24', NULL, NULL, NULL, NULL),
	(3, 'MOTOR', b'1', '2026-03-31 15:38:24', '2026-03-31 15:38:24', NULL, NULL, NULL, NULL),
	(4, 'TRANSMISION', b'1', '2026-03-31 15:38:24', '2026-03-31 15:38:24', NULL, NULL, NULL, NULL),
	(5, 'CORONA', b'1', '2026-03-31 15:38:24', '2026-03-31 15:38:24', NULL, NULL, NULL, NULL),
	(6, 'SISTEMA DE DIRECCION', b'1', '2026-03-31 15:38:24', '2026-03-31 15:38:24', NULL, NULL, NULL, NULL),
	(7, 'SISTEMA DE FRENO', b'1', '2026-03-31 15:38:24', '2026-03-31 15:38:24', NULL, NULL, NULL, NULL),
	(8, 'SISTEMA ELECTRICO', b'1', '2026-03-31 15:38:24', '2026-03-31 15:38:24', NULL, NULL, NULL, NULL),
	(9, 'CABINA', b'1', '2026-03-31 15:38:24', '2026-03-31 15:38:24', NULL, NULL, NULL, NULL),
	(10, 'CHASIS / SUSPENSION', b'1', '2026-03-31 15:38:24', '2026-03-31 15:38:24', NULL, NULL, NULL, NULL),
	(11, 'DOCUMENTOS ENTREGADOS POR EL PROVEEDOR', b'1', '2026-03-31 15:38:24', '2026-03-31 15:38:24', NULL, NULL, NULL, NULL);

-- Volcando estructura para tabla inspecciones.detalle_inspeccion
CREATE TABLE IF NOT EXISTS `detalle_inspeccion` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `inspeccion_id` bigint(20) NOT NULL,
  `inespeccion_numero` smallint(6) NOT NULL,
  `inspeccion_estado` enum('borrador','en_inspeccion','observado','subsanacion','aprobado','rechazado','anulado') DEFAULT 'borrador',
  `inspeccion_fecha` datetime DEFAULT NULL,
  `correcion_vigencia_fecha` date DEFAULT NULL,
  `severidad` enum('baja','media','alta','critica') DEFAULT NULL,
  `inspeccion_observaciones` text DEFAULT NULL,
  `estado` bit(1) DEFAULT b'1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `updated_by` bigint(20) unsigned DEFAULT NULL,
  `deleted_by` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `detalle_inspeccion_severidad_index` (`severidad`) USING BTREE,
  KEY `detalle_inspeccion_estado_index` (`estado`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Volcando datos para la tabla inspecciones.detalle_inspeccion: ~5 rows (aproximadamente)
DELETE FROM `detalle_inspeccion`;
INSERT INTO `detalle_inspeccion` (`id`, `inspeccion_id`, `inespeccion_numero`, `inspeccion_estado`, `inspeccion_fecha`, `correcion_vigencia_fecha`, `severidad`, `inspeccion_observaciones`, `estado`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
	(1, 1, 1, 'en_inspeccion', '2026-03-31 05:44:56', NULL, 'media', NULL, b'1', '2026-03-31 10:44:56', '2026-03-31 10:44:56', NULL, 1, 1, NULL),
	(2, 1, 1, 'en_inspeccion', '2026-03-31 15:45:36', NULL, 'media', NULL, b'1', '2026-03-31 20:45:36', '2026-03-31 20:45:36', NULL, 1, 1, NULL),
	(3, 1, 1, 'en_inspeccion', '2026-03-31 16:11:13', NULL, 'media', NULL, b'1', '2026-03-31 21:11:13', '2026-03-31 21:11:13', NULL, 1, 1, NULL),
	(4, 1, 1, 'en_inspeccion', '2026-03-31 16:30:14', NULL, 'media', NULL, b'1', '2026-03-31 21:30:14', '2026-03-31 21:30:14', NULL, 1, 1, NULL),
	(5, 1, 1, 'en_inspeccion', '2026-04-01 00:18:56', NULL, 'media', NULL, b'1', '2026-04-01 05:18:56', '2026-04-01 05:18:56', NULL, 1, 1, NULL);

-- Volcando estructura para tabla inspecciones.empresa_contacto
CREATE TABLE IF NOT EXISTS `empresa_contacto` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `persona_id` bigint(20) unsigned NOT NULL,
  `empresa_id` bigint(20) unsigned NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  `estado` bit(1) NOT NULL DEFAULT b'1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `updated_by` bigint(20) unsigned DEFAULT NULL,
  `deleted_by` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `empresa_contacto_email_unique` (`email`) USING BTREE,
  KEY `empresa_contacto_persona_id_index` (`persona_id`) USING BTREE,
  KEY `empresa_contacto_empresa_id_index` (`empresa_id`) USING BTREE,
  KEY `empresa_contacto_estado_index` (`estado`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Volcando datos para la tabla inspecciones.empresa_contacto: ~3 rows (aproximadamente)
DELETE FROM `empresa_contacto`;
INSERT INTO `empresa_contacto` (`id`, `persona_id`, `empresa_id`, `email`, `telefono`, `estado`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
	(1, 6, 3, NULL, NULL, b'1', '2026-03-31 10:00:53', '2026-03-31 10:00:53', NULL, 1, NULL, NULL),
	(2, 7, 3, 'juanp69@gmail.com', '976001682', b'0', '2026-03-31 10:00:53', '2026-03-31 10:00:53', NULL, 1, NULL, NULL),
	(3, 1, 4, 'admin@sis-cursos.test', NULL, b'1', '2026-03-31 21:08:58', '2026-03-31 21:09:13', '2026-03-31 21:09:13', 1, NULL, NULL);

-- Volcando estructura para tabla inspecciones.empresa_equipos
CREATE TABLE IF NOT EXISTS `empresa_equipos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `empresa_id` bigint(20) unsigned NOT NULL,
  `equipo_id` bigint(20) unsigned NOT NULL,
  `servicio_id` bigint(20) unsigned DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `serie_tipo` enum('placa','codigo') DEFAULT NULL,
  `serie_codigo` varchar(50) DEFAULT NULL,
  `estado` bit(1) DEFAULT b'1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `updated_by` bigint(20) unsigned DEFAULT NULL,
  `deleted_by` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- Volcando datos para la tabla inspecciones.empresa_equipos: ~4 rows (aproximadamente)
DELETE FROM `empresa_equipos`;
INSERT INTO `empresa_equipos` (`id`, `empresa_id`, `equipo_id`, `servicio_id`, `descripcion`, `serie_tipo`, `serie_codigo`, `estado`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
	(1, 3, 1, 1, 'Vehiculo - Vehículo - SUV - Hyundai - Tucson - Moises Gutierrez Terrones', 'placa', 'AVV-196', b'1', '2026-03-31 10:26:56', '2026-03-31 10:26:56', NULL, 1, 1, NULL),
	(2, 3, 1, 1, 'Vehiculo - Vehículo - SUV - Hyundai - Tucson - 2009 - Moises Gutierrez Terrones', 'placa', 'XXX-069', b'1', '2026-03-31 10:30:50', '2026-03-31 10:30:50', NULL, 1, 1, NULL),
	(3, 3, 2, 1, 'Vehiculo - Deportivo - Mazda1 - Runner XB - 2020 - Moises Gutierrez Terrones', 'placa', 'BAX-001', b'1', '2026-03-31 10:36:21', '2026-03-31 10:36:21', NULL, 1, 1, NULL),
	(4, 4, 1, NULL, 'Vehiculo - Vehículo - SUV - Hyundai - Tucson - 2009 - LUCHO GRILL', 'placa', 'XXX-069', b'1', '2026-03-31 21:10:47', '2026-03-31 21:10:47', NULL, 1, 1, NULL);

-- Volcando estructura para tabla inspecciones.empresa_equipos_historico
CREATE TABLE IF NOT EXISTS `empresa_equipos_historico` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `empresa_equipo_id` bigint(20) unsigned NOT NULL,
  `empresa_id` bigint(20) unsigned NOT NULL,
  `servicio_id` bigint(20) unsigned DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `serie_tipo` enum('placa','codigo') DEFAULT NULL,
  `serie_codigo` varchar(50) DEFAULT NULL,
  `accion` enum('nuevo','edicion','eliminacion') DEFAULT NULL,
  `estado` bit(1) DEFAULT b'1',
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- Volcando datos para la tabla inspecciones.empresa_equipos_historico: ~0 rows (aproximadamente)
DELETE FROM `empresa_equipos_historico`;

-- Volcando estructura para tabla inspecciones.empresa_servicios
CREATE TABLE IF NOT EXISTS `empresa_servicios` (
  `empresa_id` bigint(20) unsigned NOT NULL,
  `servicio_id` bigint(20) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- Volcando datos para la tabla inspecciones.empresa_servicios: ~4 rows (aproximadamente)
DELETE FROM `empresa_servicios`;
INSERT INTO `empresa_servicios` (`empresa_id`, `servicio_id`) VALUES
	(3, 1),
	(4, 1),
	(4, 2),
	(4, 4);

-- Volcando estructura para tabla inspecciones.empresa_servicios_historico
CREATE TABLE IF NOT EXISTS `empresa_servicios_historico` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `empresa_id` bigint(20) unsigned NOT NULL,
  `servicio_id` bigint(20) unsigned NOT NULL,
  `accion` enum('nuevo','edicion','eliminacion') NOT NULL,
  `estado` bit(1) DEFAULT b'1',
  `created_at` timestamp NOT NULL,
  `created_by` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- Volcando datos para la tabla inspecciones.empresa_servicios_historico: ~0 rows (aproximadamente)
DELETE FROM `empresa_servicios_historico`;

-- Volcando estructura para tabla inspecciones.empresas
CREATE TABLE IF NOT EXISTS `empresas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tipo` enum('unidad_minera','empresa') NOT NULL,
  `unidad_minera_id` bigint(20) unsigned DEFAULT NULL,
  `ruc` varchar(11) DEFAULT NULL,
  `razon_social` varchar(200) NOT NULL,
  `nombre_comercial` varchar(200) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  `pais_id` bigint(20) unsigned DEFAULT NULL,
  `region_id` bigint(20) unsigned DEFAULT NULL,
  `ciudad` varchar(200) DEFAULT NULL,
  `direccion` varchar(250) DEFAULT NULL,
  `estado` bit(1) DEFAULT b'1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `updated_by` bigint(20) unsigned DEFAULT NULL,
  `deleted_by` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `empresas_unidad_minera_id_foreign` (`unidad_minera_id`) USING BTREE,
  KEY `empresas_tipo_unidad_minera_id_ruc_razon_social_index` (`tipo`,`unidad_minera_id`,`ruc`,`razon_social`) USING BTREE,
  KEY `empresas_tipo_index` (`tipo`) USING BTREE,
  KEY `empresas_ruc_index` (`ruc`) USING BTREE,
  KEY `empresas_estado_index` (`estado`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Volcando datos para la tabla inspecciones.empresas: ~4 rows (aproximadamente)
DELETE FROM `empresas`;
INSERT INTO `empresas` (`id`, `tipo`, `unidad_minera_id`, `ruc`, `razon_social`, `nombre_comercial`, `email`, `telefono`, `pais_id`, `region_id`, `ciudad`, `direccion`, `estado`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
	(1, 'unidad_minera', NULL, '20123456789', 'UNIDAD MINERA DEMO S.A.C.', 'UM DEMO', NULL, NULL, NULL, NULL, NULL, NULL, b'1', '2026-03-05 09:55:25', '2026-03-05 09:55:25', NULL, NULL, NULL, NULL),
	(2, 'empresa', 1, '20654321098', 'SERVICE DEMO S.R.L.', 'SERVICE DEMO', NULL, NULL, NULL, NULL, NULL, NULL, b'1', '2026-03-05 09:55:25', '2026-03-05 09:55:25', NULL, NULL, NULL, NULL),
	(3, 'empresa', NULL, '10732085157', 'Moises Gutierrez Terrones', 'Moises Gutierrez Terrones', NULL, NULL, NULL, NULL, NULL, NULL, b'1', '2026-03-31 09:25:32', '2026-03-31 10:00:53', NULL, 1, 1, NULL),
	(4, 'empresa', NULL, '10704957608', 'LUCHO VIP', 'LUCHO GRILL', NULL, NULL, NULL, NULL, NULL, NULL, b'1', '2026-03-31 21:07:04', '2026-03-31 21:09:26', NULL, 1, 1, NULL);

-- Volcando estructura para tabla inspecciones.equipos
CREATE TABLE IF NOT EXISTS `equipos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tipo_id` bigint(20) unsigned NOT NULL,
  `categoria_id` bigint(20) unsigned NOT NULL,
  `marca_id` bigint(20) unsigned NOT NULL,
  `modelo_id` bigint(20) unsigned NOT NULL,
  `descripcion` varchar(120) NOT NULL,
  `anio` year(4) DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `estado` bit(1) DEFAULT b'1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `updated_by` bigint(20) unsigned DEFAULT NULL,
  `deleted_by` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- Volcando datos para la tabla inspecciones.equipos: ~2 rows (aproximadamente)
DELETE FROM `equipos`;
INSERT INTO `equipos` (`id`, `tipo_id`, `categoria_id`, `marca_id`, `modelo_id`, `descripcion`, `anio`, `observaciones`, `estado`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
	(1, 2, 2, 2, 64, 'Vehiculo - Vehículo - SUV - Hyundai - Tucson - 2009', '2009', NULL, b'1', '2026-03-31 10:26:56', '2026-03-31 10:26:56', NULL, 1, 1, NULL),
	(2, 2, 54, 91, 65, 'Vehiculo - Deportivo - Mazda1 - Runner XB - 2020', '2020', NULL, b'1', '2026-03-31 10:36:21', '2026-03-31 10:36:21', NULL, 1, 1, NULL);

-- Volcando estructura para tabla inspecciones.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Volcando datos para la tabla inspecciones.failed_jobs: ~0 rows (aproximadamente)
DELETE FROM `failed_jobs`;

-- Volcando estructura para tabla inspecciones.inspeccion_archivos_equipo
CREATE TABLE IF NOT EXISTS `inspeccion_archivos_equipo` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `inspeccion_id` bigint(20) unsigned NOT NULL,
  `archivo_descripcion` varchar(255) NOT NULL,
  `archivo_autogenerado` bit(1) DEFAULT b'0',
  `archivo_tipo` enum('imagen','pdf') NOT NULL,
  `archivo_ruta` varchar(255) NOT NULL,
  `archivo_origen` enum('original','observacion','autogenerado') NOT NULL,
  `mostrar_certificado` bit(1) DEFAULT NULL,
  `estado` bit(1) DEFAULT b'1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `updated_by` bigint(20) unsigned DEFAULT NULL,
  `deleted_by` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- Volcando datos para la tabla inspecciones.inspeccion_archivos_equipo: ~1 rows (aproximadamente)
DELETE FROM `inspeccion_archivos_equipo`;
INSERT INTO `inspeccion_archivos_equipo` (`id`, `inspeccion_id`, `archivo_descripcion`, `archivo_autogenerado`, `archivo_tipo`, `archivo_ruta`, `archivo_origen`, `mostrar_certificado`, `estado`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
	(1, 1, 'modificacion carnet vacucnacionaaa', b'0', 'imagen', 'uploads/inspecciones/26-0001-XXX-069/1/20260331164340_h5Mnow6SVc.png', 'original', b'1', b'1', '2026-03-31 21:43:40', '2026-03-31 21:43:40', NULL, 1, 1, NULL);

-- Volcando estructura para tabla inspecciones.inspecciones
CREATE TABLE IF NOT EXISTS `inspecciones` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `anio` int(11) NOT NULL,
  `correlativo` int(11) DEFAULT NULL,
  `codigo` varchar(30) NOT NULL,
  `tipo_inspeccion_id` bigint(20) unsigned DEFAULT NULL,
  `empresa_equipo_id` bigint(20) unsigned DEFAULT NULL,
  `fecha_ingreso` date DEFAULT NULL,
  `fecha_salida` date DEFAULT NULL,
  `estado_inspeccion` enum('borrador','en_inspeccion','observado','subsanacion','aprobado','rechazado','anulado') NOT NULL DEFAULT 'borrador',
  `observaciones` text DEFAULT NULL,
  `certificado_generado` bit(1) DEFAULT b'0',
  `estado` bit(1) DEFAULT b'1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `updated_by` bigint(20) unsigned DEFAULT NULL,
  `deleted_by` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Volcando datos para la tabla inspecciones.inspecciones: ~1 rows (aproximadamente)
DELETE FROM `inspecciones`;
INSERT INTO `inspecciones` (`id`, `anio`, `correlativo`, `codigo`, `tipo_inspeccion_id`, `empresa_equipo_id`, `fecha_ingreso`, `fecha_salida`, `estado_inspeccion`, `observaciones`, `certificado_generado`, `estado`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
	(1, 2026, 1, '26-0001', NULL, 4, '2026-04-01', NULL, 'en_inspeccion', NULL, b'0', b'1', '2026-04-01 05:18:56', '2026-04-01 05:18:56', NULL, 1, 1, NULL);

-- Volcando estructura para tabla inspecciones.marcas
CREATE TABLE IF NOT EXISTS `marcas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(255) DEFAULT NULL,
  `marca` varchar(255) DEFAULT NULL,
  `estado` bit(1) DEFAULT b'1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `updated_by` bigint(20) unsigned DEFAULT NULL,
  `deleted_by` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `marcas_codigo_index` (`codigo`) USING BTREE,
  KEY `marcas_marca_index` (`marca`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Volcando datos para la tabla inspecciones.marcas: ~91 rows (aproximadamente)
DELETE FROM `marcas`;
INSERT INTO `marcas` (`id`, `codigo`, `marca`, `estado`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
	(1, 'TOY', 'Toyota', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(2, 'HYU', 'Hyundai', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(3, 'KIA', 'Kia', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(4, 'NIS', 'Nissan', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(5, 'HON', 'Honda', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(6, 'MAZ', 'Mazda', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(7, 'MIT', 'Mitsubishi', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(8, 'SUB', 'Subaru', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(9, 'SUZ', 'Suzuki', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(10, 'CHE', 'Chevrolet', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(11, 'FOR', 'Ford', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(12, 'VW', 'Volkswagen', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(13, 'REN', 'Renault', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(14, 'PEU', 'Peugeot', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(15, 'CIT', 'Citroën', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(16, 'FIA', 'Fiat', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(17, 'JEE', 'Jeep', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(18, 'DOD', 'Dodge', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(19, 'RAM', 'RAM', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(20, 'BMW', 'BMW', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(21, 'MB', 'Mercedes-Benz', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(22, 'AUD', 'Audi', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(23, 'POR', 'Porsche', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(24, 'TES', 'Tesla', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(25, 'BYD', 'BYD', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(26, 'CHA', 'Chery', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(27, 'GEE', 'Geely', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(28, 'JAC', 'JAC', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(29, 'DFSK', 'DFSK', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(30, 'MG', 'MG', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(31, 'LAN', 'Land Rover', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(32, 'JAG', 'Jaguar', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(33, 'LEX', 'Lexus', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(34, 'VOL', 'Volvo', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(35, 'SKO', 'Škoda', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(36, 'SEA', 'SEAT', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(37, 'OPE', 'Opel', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(38, 'ISU', 'Isuzu', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(39, 'HIN', 'Hino', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(40, 'FUS', 'FUSO (Mitsubishi)', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(41, 'IVE', 'Iveco', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(42, 'MAN', 'MAN', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(43, 'SCA', 'Scania', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(44, 'DAF', 'DAF', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(45, 'FRE', 'Freightliner', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(46, 'INT', 'International', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(47, 'KEN', 'Kenworth', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(48, 'PET', 'Peterbilt', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(49, 'VTR', 'Volvo Trucks', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(50, 'MAC', 'Mack', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(51, 'TAT', 'Tata Motors', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(52, 'ASH', 'Ashok Leyland', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(53, 'YUT', 'Yutong', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(54, 'CAT', 'Caterpillar', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(55, 'KOM', 'Komatsu', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(56, 'VCE', 'Volvo Construction Equipment', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(57, 'HIT', 'Hitachi Construction Machinery', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(58, 'JCB', 'JCB', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(59, 'LIE', 'Liebherr', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(60, 'DOO', 'Doosan', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(61, 'HCE', 'Hyundai Construction Equipment', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(62, 'SNY', 'SANY', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(63, 'XCM', 'XCMG', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(64, 'LIG', 'LiuGong', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(65, 'CAS', 'CASE Construction Equipment', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(66, 'JDE', 'John Deere', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(67, 'NHC', 'New Holland Construction', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(68, 'BOB', 'Bobcat', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(69, 'KOB', 'Kobelco', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(70, 'TAK', 'Takeuchi', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(71, 'YAN', 'Yanmar', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(72, 'MANI', 'Manitou', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(73, 'TER', 'Terex', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(74, 'WNE', 'Wacker Neuson', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(75, 'SDLG', 'SDLG', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(76, 'SEM', 'SEM', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(77, 'HAM', 'Hamm', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(78, 'BOM', 'BOMAG', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(79, 'DYN', 'Dynapac', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(80, 'TOYF', 'Toyota Material Handling (Montacargas)', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(81, 'HYS', 'Hyster', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(82, 'YAL', 'Yale', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(83, 'JUNF', 'Jungheinrich', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(84, 'LIN', 'Linde', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(85, 'CLA', 'Clark', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(86, 'KAL', 'Kalmar', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(87, 'GEN', 'Generac', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(88, 'CUM', 'Cummins', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(89, 'PERK', 'Perkins', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(90, 'DEU', 'DEUTZ', b'1', '2026-03-05 09:58:17', '2026-03-05 09:58:17', NULL, NULL, NULL, NULL),
	(91, NULL, 'Mazda1', b'1', '2026-03-31 10:36:01', '2026-03-31 10:36:01', NULL, 1, NULL, NULL);

-- Volcando estructura para tabla inspecciones.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Volcando datos para la tabla inspecciones.migrations: ~28 rows (aproximadamente)
DELETE FROM `migrations`;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2013_03_04_041648_create_paises_table', 1),
	(2, '2013_03_04_041724_create_marcas_table', 1),
	(3, '2013_03_04_041742_create_modelos_table', 1),
	(4, '2013_03_04_041802_create_cargos_table', 1),
	(5, '2013_03_04_041902_create_regiones_table', 1),
	(6, '2013_03_04_042209_create_tipos_table', 1),
	(7, '2013_03_04_042944_create_placas_table', 1),
	(8, '2013_03_04_050441_create_categorias_table', 1),
	(9, '2013_09_11_000000_create_personas_table', 1),
	(10, '2013_12_23_031907_create_empresas_table', 1),
	(11, '2014_10_12_000000_create_users_table', 1),
	(12, '2014_10_12_100000_create_password_reset_tokens_table', 1),
	(13, '2014_10_12_200000_add_two_factor_columns_to_users_table', 1),
	(14, '2015_03_04_044214_create_empresa_contacto_table', 1),
	(15, '2019_08_19_000000_create_failed_jobs_table', 1),
	(16, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(17, '2026_02_01_041816_create_servicios_table', 1),
	(18, '2026_02_04_051257_create_tipo_certificado_table', 1),
	(19, '2026_02_04_051310_create_tipo_inspeccion_table', 1),
	(20, '2026_02_08_220425_create_equipos_table', 1),
	(21, '2026_03_04_051127_create_equipo_empresa_table', 1),
	(22, '2026_03_04_051140_create_equipo_servicio_table', 1),
	(23, '2026_03_04_051217_create_observaciones_table', 1),
	(24, '2026_03_08_220604_create_inspecciones_table', 1),
	(25, '2026_03_08_220920_create_certificados_table', 1),
	(26, '2026_03_09_051202_create_detalle_inspeccion_table', 1),
	(27, '2026_03_09_182956_create_antecedente_equipo_table', 1),
	(28, '2026_03_09_220840_create_archivos_table', 1);

-- Volcando estructura para tabla inspecciones.modelos
CREATE TABLE IF NOT EXISTS `modelos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `modelos` varchar(255) DEFAULT NULL,
  `modelo` varchar(255) DEFAULT NULL,
  `estado` bit(1) DEFAULT b'1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `updated_by` bigint(20) unsigned DEFAULT NULL,
  `deleted_by` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `modelos_modelos_index` (`modelos`) USING BTREE,
  KEY `modelos_modelo_index` (`modelo`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Volcando datos para la tabla inspecciones.modelos: ~65 rows (aproximadamente)
DELETE FROM `modelos`;
INSERT INTO `modelos` (`id`, `modelos`, `modelo`, `estado`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
	(1, 'HILUX', 'Hilux', b'1', '2026-03-05 09:59:15', '2026-03-05 09:59:15', NULL, NULL, NULL, NULL),
	(2, 'RAV4', 'RAV4', b'1', '2026-03-05 09:59:15', '2026-03-05 09:59:15', NULL, NULL, NULL, NULL),
	(3, 'FORTUNER', 'Fortuner', b'1', '2026-03-05 09:59:15', '2026-03-05 09:59:15', NULL, NULL, NULL, NULL),
	(4, 'LANDCRUISER', 'Land Cruiser', b'1', '2026-03-05 09:59:15', '2026-03-05 09:59:15', NULL, NULL, NULL, NULL),
	(5, 'PRADO', 'Prado', b'1', '2026-03-05 09:59:15', '2026-03-05 09:59:15', NULL, NULL, NULL, NULL),
	(6, 'COROLLA', 'Corolla', b'1', '2026-03-05 09:59:15', '2026-03-05 09:59:15', NULL, NULL, NULL, NULL),
	(7, 'YARIS', 'Yaris', b'1', '2026-03-05 09:59:15', '2026-03-05 09:59:15', NULL, NULL, NULL, NULL),
	(8, 'HIACE', 'Hiace', b'1', '2026-03-05 09:59:15', '2026-03-05 09:59:15', NULL, NULL, NULL, NULL),
	(9, 'URVAN', 'Urvan', b'1', '2026-03-05 09:59:15', '2026-03-05 09:59:15', NULL, NULL, NULL, NULL),
	(10, 'FRONTIER', 'Frontier', b'1', '2026-03-05 09:59:15', '2026-03-05 09:59:15', NULL, NULL, NULL, NULL),
	(11, 'XTRAIL', 'X-Trail', b'1', '2026-03-05 09:59:15', '2026-03-05 09:59:15', NULL, NULL, NULL, NULL),
	(12, 'L200', 'L200', b'1', '2026-03-05 09:59:15', '2026-03-05 09:59:15', NULL, NULL, NULL, NULL),
	(13, 'MONTERO', 'Montero / Pajero', b'1', '2026-03-05 09:59:15', '2026-03-05 09:59:15', NULL, NULL, NULL, NULL),
	(14, 'DMAX', 'D-Max', b'1', '2026-03-05 09:59:15', '2026-03-05 09:59:15', NULL, NULL, NULL, NULL),
	(15, 'NPR', 'Camión NPR', b'1', '2026-03-05 09:59:15', '2026-03-05 09:59:15', NULL, NULL, NULL, NULL),
	(16, 'NQR', 'Camión NQR', b'1', '2026-03-05 09:59:15', '2026-03-05 09:59:15', NULL, NULL, NULL, NULL),
	(17, 'FRR', 'Camión FRR', b'1', '2026-03-05 09:59:15', '2026-03-05 09:59:15', NULL, NULL, NULL, NULL),
	(18, 'FTR', 'Camión FTR', b'1', '2026-03-05 09:59:15', '2026-03-05 09:59:15', NULL, NULL, NULL, NULL),
	(19, 'HINO300', 'Hino 300 Series', b'1', '2026-03-05 09:59:15', '2026-03-05 09:59:15', NULL, NULL, NULL, NULL),
	(20, 'HINO500', 'Hino 500 Series', b'1', '2026-03-05 09:59:15', '2026-03-05 09:59:15', NULL, NULL, NULL, NULL),
	(21, 'HINO700', 'Hino 700 Series', b'1', '2026-03-05 09:59:15', '2026-03-05 09:59:15', NULL, NULL, NULL, NULL),
	(22, 'SCANIA_P', 'Scania P-series', b'1', '2026-03-05 09:59:15', '2026-03-05 09:59:15', NULL, NULL, NULL, NULL),
	(23, 'SCANIA_G', 'Scania G-series', b'1', '2026-03-05 09:59:15', '2026-03-05 09:59:15', NULL, NULL, NULL, NULL),
	(24, 'SCANIA_R', 'Scania R-series', b'1', '2026-03-05 09:59:15', '2026-03-05 09:59:15', NULL, NULL, NULL, NULL),
	(25, 'VOLVO_FH', 'Volvo FH', b'1', '2026-03-05 09:59:15', '2026-03-05 09:59:15', NULL, NULL, NULL, NULL),
	(26, 'VOLVO_FM', 'Volvo FM', b'1', '2026-03-05 09:59:15', '2026-03-05 09:59:15', NULL, NULL, NULL, NULL),
	(27, 'VOLVO_FMX', 'Volvo FMX', b'1', '2026-03-05 09:59:15', '2026-03-05 09:59:15', NULL, NULL, NULL, NULL),
	(28, 'CAT320', 'Excavadora 320', b'1', '2026-03-05 09:59:15', '2026-03-05 09:59:15', NULL, NULL, NULL, NULL),
	(29, 'CAT336', 'Excavadora 336', b'1', '2026-03-05 09:59:15', '2026-03-05 09:59:15', NULL, NULL, NULL, NULL),
	(30, 'CAT950M', 'Cargador frontal 950M', b'1', '2026-03-05 09:59:15', '2026-03-05 09:59:15', NULL, NULL, NULL, NULL),
	(31, 'CAT988K', 'Cargador frontal 988K', b'1', '2026-03-05 09:59:15', '2026-03-05 09:59:15', NULL, NULL, NULL, NULL),
	(32, 'CAT140M', 'Motoniveladora 140M', b'1', '2026-03-05 09:59:15', '2026-03-05 09:59:15', NULL, NULL, NULL, NULL),
	(33, 'CATD6T', 'Bulldozer D6T', b'1', '2026-03-05 09:59:15', '2026-03-05 09:59:15', NULL, NULL, NULL, NULL),
	(34, 'CATD8T', 'Bulldozer D8T', b'1', '2026-03-05 09:59:15', '2026-03-05 09:59:15', NULL, NULL, NULL, NULL),
	(35, 'PC200', 'Excavadora PC200', b'1', '2026-03-05 09:59:15', '2026-03-05 09:59:15', NULL, NULL, NULL, NULL),
	(36, 'PC210', 'Excavadora PC210', b'1', '2026-03-05 09:59:15', '2026-03-05 09:59:15', NULL, NULL, NULL, NULL),
	(37, 'D65', 'Bulldozer D65', b'1', '2026-03-05 09:59:15', '2026-03-05 09:59:15', NULL, NULL, NULL, NULL),
	(38, 'WA380', 'Cargador frontal WA380', b'1', '2026-03-05 09:59:15', '2026-03-05 09:59:15', NULL, NULL, NULL, NULL),
	(39, 'GD655', 'Motoniveladora GD655', b'1', '2026-03-05 09:59:15', '2026-03-05 09:59:15', NULL, NULL, NULL, NULL),
	(40, 'JCB3CX', 'Retroexcavadora 3CX', b'1', '2026-03-05 09:59:15', '2026-03-05 09:59:15', NULL, NULL, NULL, NULL),
	(41, 'JCB4CX', 'Retroexcavadora 4CX', b'1', '2026-03-05 09:59:15', '2026-03-05 09:59:15', NULL, NULL, NULL, NULL),
	(42, 'JS220', 'Excavadora JS220', b'1', '2026-03-05 09:59:15', '2026-03-05 09:59:15', NULL, NULL, NULL, NULL),
	(43, 'EC210', 'Excavadora EC210', b'1', '2026-03-05 09:59:15', '2026-03-05 09:59:15', NULL, NULL, NULL, NULL),
	(44, 'EC220', 'Excavadora EC220', b'1', '2026-03-05 09:59:15', '2026-03-05 09:59:15', NULL, NULL, NULL, NULL),
	(45, 'L120H', 'Cargador frontal L120H', b'1', '2026-03-05 09:59:15', '2026-03-05 09:59:15', NULL, NULL, NULL, NULL),
	(46, 'A40G', 'Dumper articulado A40G', b'1', '2026-03-05 09:59:15', '2026-03-05 09:59:15', NULL, NULL, NULL, NULL),
	(47, 'DX225', 'Excavadora DX225', b'1', '2026-03-05 09:59:15', '2026-03-05 09:59:15', NULL, NULL, NULL, NULL),
	(48, 'DL300', 'Cargador frontal DL300', b'1', '2026-03-05 09:59:15', '2026-03-05 09:59:15', NULL, NULL, NULL, NULL),
	(49, 'SY215', 'Excavadora SY215', b'1', '2026-03-05 09:59:15', '2026-03-05 09:59:15', NULL, NULL, NULL, NULL),
	(50, 'SY365', 'Excavadora SY365', b'1', '2026-03-05 09:59:15', '2026-03-05 09:59:15', NULL, NULL, NULL, NULL),
	(51, 'XE215', 'Excavadora XE215', b'1', '2026-03-05 09:59:15', '2026-03-05 09:59:15', NULL, NULL, NULL, NULL),
	(52, 'LW500', 'Cargador frontal LW500', b'1', '2026-03-05 09:59:15', '2026-03-05 09:59:15', NULL, NULL, NULL, NULL),
	(53, 'CLG856', 'Cargador frontal CLG856', b'1', '2026-03-05 09:59:15', '2026-03-05 09:59:15', NULL, NULL, NULL, NULL),
	(54, 'CLG922', 'Excavadora CLG922', b'1', '2026-03-05 09:59:15', '2026-03-05 09:59:15', NULL, NULL, NULL, NULL),
	(55, 'S650', 'Minicargador S650', b'1', '2026-03-05 09:59:15', '2026-03-05 09:59:15', NULL, NULL, NULL, NULL),
	(56, 'T590', 'Minicargador oruga T590', b'1', '2026-03-05 09:59:15', '2026-03-05 09:59:15', NULL, NULL, NULL, NULL),
	(57, 'MT732', 'Telehandler MT 732', b'1', '2026-03-05 09:59:15', '2026-03-05 09:59:15', NULL, NULL, NULL, NULL),
	(58, 'MT1840', 'Telehandler MT 1840', b'1', '2026-03-05 09:59:15', '2026-03-05 09:59:15', NULL, NULL, NULL, NULL),
	(59, 'TA300', 'Dumper TA300', b'1', '2026-03-05 09:59:15', '2026-03-05 09:59:15', NULL, NULL, NULL, NULL),
	(60, 'H25FT', 'Montacargas H2.5FT', b'1', '2026-03-05 09:59:15', '2026-03-05 09:59:15', NULL, NULL, NULL, NULL),
	(61, 'H30FT', 'Montacargas H3.0FT', b'1', '2026-03-05 09:59:15', '2026-03-05 09:59:15', NULL, NULL, NULL, NULL),
	(62, 'GDP25VX', 'Montacargas GDP25VX', b'1', '2026-03-05 09:59:15', '2026-03-05 09:59:15', NULL, NULL, NULL, NULL),
	(63, 'GDP30VX', 'Montacargas GDP30VX', b'1', '2026-03-05 09:59:15', '2026-03-05 09:59:15', NULL, NULL, NULL, NULL),
	(64, 'TUCSON', 'Tucson', b'1', '2026-03-31 10:26:26', '2026-03-31 10:26:26', NULL, 1, NULL, NULL),
	(65, 'RUNNER XB', 'Runner XB', b'1', '2026-03-31 10:36:09', '2026-03-31 10:36:09', NULL, 1, NULL, NULL);

-- Volcando estructura para tabla inspecciones.paises
CREATE TABLE IF NOT EXISTS `paises` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pais` varchar(255) DEFAULT NULL,
  `codigo` varchar(5) DEFAULT NULL,
  `flag` varchar(255) DEFAULT NULL,
  `iso3` varchar(255) DEFAULT NULL,
  `iso_num` varchar(255) NOT NULL DEFAULT '1',
  `estado` bit(1) DEFAULT b'1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `updated_by` bigint(20) unsigned DEFAULT NULL,
  `deleted_by` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `paises_pais_index` (`pais`) USING BTREE,
  KEY `paises_codigo_index` (`codigo`) USING BTREE,
  KEY `paises_iso_num_index` (`iso_num`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=249 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Volcando datos para la tabla inspecciones.paises: ~248 rows (aproximadamente)
DELETE FROM `paises`;
INSERT INTO `paises` (`id`, `pais`, `codigo`, `flag`, `iso3`, `iso_num`, `estado`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
	(1, 'Afganistán', 'AF', NULL, 'AFG', '004', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(2, 'Åland', 'AX', NULL, 'ALA', '248', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(3, 'Albania', 'AL', NULL, 'ALB', '008', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(4, 'Argelia', 'DZ', NULL, 'DZA', '012', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(5, 'Samoa Americana', 'AS', NULL, 'ASM', '016', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(6, 'Andorra', 'AD', NULL, 'AND', '020', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(7, 'Angola', 'AO', NULL, 'AGO', '024', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(8, 'Anguila', 'AI', NULL, 'AIA', '660', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(9, 'Antártida', 'AQ', NULL, 'ATA', '010', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(10, 'Antigua y Barbuda', 'AG', NULL, 'ATG', '028', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(11, 'Argentina', 'AR', NULL, 'ARG', '032', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(12, 'Armenia', 'AM', NULL, 'ARM', '051', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(13, 'Aruba', 'AW', NULL, 'ABW', '533', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(14, 'Australia', 'AU', NULL, 'AUS', '036', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(15, 'Austria', 'AT', NULL, 'AUT', '040', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(16, 'Azerbaiyán', 'AZ', NULL, 'AZE', '031', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(17, 'Bahamas', 'BS', NULL, 'BHS', '044', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(18, 'Baréin', 'BH', NULL, 'BHR', '048', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(19, 'Bangladés', 'BD', NULL, 'BGD', '050', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(20, 'Barbados', 'BB', NULL, 'BRB', '052', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(21, 'Bielorrusia', 'BY', NULL, 'BLR', '112', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(22, 'Bélgica', 'BE', NULL, 'BEL', '056', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(23, 'Belice', 'BZ', NULL, 'BLZ', '084', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(24, 'Benín', 'BJ', NULL, 'BEN', '204', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(25, 'Bermudas', 'BM', NULL, 'BMU', '060', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(26, 'Bután', 'BT', NULL, 'BTN', '064', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(27, 'Bolivia', 'BO', NULL, 'BOL', '068', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(28, 'Bonaire, San Eustaquio y Saba', 'BQ', NULL, 'BES', '535', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(29, 'Bosnia y Herzegovina', 'BA', NULL, 'BIH', '070', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(30, 'Botsuana', 'BW', NULL, 'BWA', '072', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(31, 'Isla Bouvet', 'BV', NULL, 'BVT', '074', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(32, 'Brasil', 'BR', NULL, 'BRA', '076', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(33, 'Territorio Británico del Océano Índico', 'IO', NULL, 'IOT', '086', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(34, 'Brunéi', 'BN', NULL, 'BRN', '096', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(35, 'Bulgaria', 'BG', NULL, 'BGR', '100', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(36, 'Burkina Faso', 'BF', NULL, 'BFA', '854', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(37, 'Burundi', 'BI', NULL, 'BDI', '108', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(38, 'Cabo Verde', 'CV', NULL, 'CPV', '132', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(39, 'Camboya', 'KH', NULL, 'KHM', '116', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(40, 'Camerún', 'CM', NULL, 'CMR', '120', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(41, 'Canadá', 'CA', NULL, 'CAN', '124', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(42, 'Islas Caimán', 'KY', NULL, 'CYM', '136', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(43, 'República Centroafricana', 'CF', NULL, 'CAF', '140', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(44, 'Chad', 'TD', NULL, 'TCD', '148', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(45, 'Chile', 'CL', NULL, 'CHL', '152', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(46, 'China', 'CN', NULL, 'CHN', '156', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(47, 'Isla de Navidad', 'CX', NULL, 'CXR', '162', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(48, 'Islas Cocos (Keeling)', 'CC', NULL, 'CCK', '166', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(49, 'Colombia', 'CO', NULL, 'COL', '170', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(50, 'Comoras', 'KM', NULL, 'COM', '174', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(51, 'Congo (Rep. Dem.)', 'CD', NULL, 'COD', '180', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(52, 'Congo', 'CG', NULL, 'COG', '178', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(53, 'Islas Cook', 'CK', NULL, 'COK', '184', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(54, 'Costa Rica', 'CR', NULL, 'CRI', '188', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(55, 'Costa de Marfil', 'CI', NULL, 'CIV', '384', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(56, 'Croacia', 'HR', NULL, 'HRV', '191', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(57, 'Cuba', 'CU', NULL, 'CUB', '192', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(58, 'Curazao', 'CW', NULL, 'CUW', '531', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(59, 'Chipre', 'CY', NULL, 'CYP', '196', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(60, 'Chequia', 'CZ', NULL, 'CZE', '203', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(61, 'Dinamarca', 'DK', NULL, 'DNK', '208', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(62, 'Yibuti', 'DJ', NULL, 'DJI', '262', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(63, 'Dominica', 'DM', NULL, 'DMA', '212', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(64, 'República Dominicana', 'DO', NULL, 'DOM', '214', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(65, 'Ecuador', 'EC', NULL, 'ECU', '218', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(66, 'Egipto', 'EG', NULL, 'EGY', '818', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(67, 'El Salvador', 'SV', NULL, 'SLV', '222', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(68, 'Guinea Ecuatorial', 'GQ', NULL, 'GNQ', '226', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(69, 'Eritrea', 'ER', NULL, 'ERI', '232', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(70, 'Estonia', 'EE', NULL, 'EST', '233', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(71, 'Esuatini', 'SZ', NULL, 'SWZ', '748', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(72, 'Etiopía', 'ET', NULL, 'ETH', '231', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(73, 'Islas Malvinas', 'FK', NULL, 'FLK', '238', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(74, 'Islas Feroe', 'FO', NULL, 'FRO', '234', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(75, 'Fiyi', 'FJ', NULL, 'FJI', '242', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(76, 'Finlandia', 'FI', NULL, 'FIN', '246', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(77, 'Francia', 'FR', NULL, 'FRA', '250', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(78, 'Guayana Francesa', 'GF', NULL, 'GUF', '254', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(79, 'Polinesia Francesa', 'PF', NULL, 'PYF', '258', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(80, 'Tierras Australes y Antárticas Francesas', 'TF', NULL, 'ATF', '260', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(81, 'Gabón', 'GA', NULL, 'GAB', '266', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(82, 'Gambia', 'GM', NULL, 'GMB', '270', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(83, 'Georgia', 'GE', NULL, 'GEO', '268', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(84, 'Alemania', 'DE', NULL, 'DEU', '276', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(85, 'Ghana', 'GH', NULL, 'GHA', '288', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(86, 'Gibraltar', 'GI', NULL, 'GIB', '292', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(87, 'Grecia', 'GR', NULL, 'GRC', '300', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(88, 'Groenlandia', 'GL', NULL, 'GRL', '304', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(89, 'Granada', 'GD', NULL, 'GRD', '308', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(90, 'Guadalupe', 'GP', NULL, 'GLP', '312', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(91, 'Guam', 'GU', NULL, 'GUM', '316', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(92, 'Guatemala', 'GT', NULL, 'GTM', '320', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(93, 'Guernesey', 'GG', NULL, 'GGY', '831', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(94, 'Guinea', 'GN', NULL, 'GIN', '324', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(95, 'Guinea-Bisáu', 'GW', NULL, 'GNB', '624', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(96, 'Guyana', 'GY', NULL, 'GUY', '328', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(97, 'Haití', 'HT', NULL, 'HTI', '332', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(98, 'Islas Heard y McDonald', 'HM', NULL, 'HMD', '334', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(99, 'Honduras', 'HN', NULL, 'HND', '340', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(100, 'Hong Kong', 'HK', NULL, 'HKG', '344', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(101, 'Hungría', 'HU', NULL, 'HUN', '348', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(102, 'Islandia', 'IS', NULL, 'ISL', '352', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(103, 'India', 'IN', NULL, 'IND', '356', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(104, 'Indonesia', 'ID', NULL, 'IDN', '360', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(105, 'Irán', 'IR', NULL, 'IRN', '364', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(106, 'Irak', 'IQ', NULL, 'IRQ', '368', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(107, 'Irlanda', 'IE', NULL, 'IRL', '372', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(108, 'Isla de Man', 'IM', NULL, 'IMN', '833', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(109, 'Israel', 'IL', NULL, 'ISR', '376', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(110, 'Italia', 'IT', NULL, 'ITA', '380', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(111, 'Jamaica', 'JM', NULL, 'JAM', '388', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(112, 'Japón', 'JP', NULL, 'JPN', '392', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(113, 'Jersey', 'JE', NULL, 'JEY', '832', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(114, 'Jordania', 'JO', NULL, 'JOR', '400', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(115, 'Kazajistán', 'KZ', NULL, 'KAZ', '398', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(116, 'Kenia', 'KE', NULL, 'KEN', '404', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(117, 'Kiribati', 'KI', NULL, 'KIR', '296', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(118, 'Corea del Norte', 'KP', NULL, 'PRK', '408', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(119, 'Corea del Sur', 'KR', NULL, 'KOR', '410', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(120, 'Kuwait', 'KW', NULL, 'KWT', '414', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(121, 'Kirguistán', 'KG', NULL, 'KGZ', '417', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(122, 'Laos', 'LA', NULL, 'LAO', '418', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(123, 'Letonia', 'LV', NULL, 'LVA', '428', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(124, 'Líbano', 'LB', NULL, 'LBN', '422', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(125, 'Lesoto', 'LS', NULL, 'LSO', '426', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(126, 'Liberia', 'LR', NULL, 'LBR', '430', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(127, 'Libia', 'LY', NULL, 'LBY', '434', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(128, 'Liechtenstein', 'LI', NULL, 'LIE', '438', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(129, 'Lituania', 'LT', NULL, 'LTU', '440', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(130, 'Luxemburgo', 'LU', NULL, 'LUX', '442', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(131, 'Macao', 'MO', NULL, 'MAC', '446', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(132, 'Madagascar', 'MG', NULL, 'MDG', '450', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(133, 'Malaui', 'MW', NULL, 'MWI', '454', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(134, 'Malasia', 'MY', NULL, 'MYS', '458', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(135, 'Maldivas', 'MV', NULL, 'MDV', '462', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(136, 'Malí', 'ML', NULL, 'MLI', '466', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(137, 'Malta', 'MT', NULL, 'MLT', '470', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(138, 'Islas Marshall', 'MH', NULL, 'MHL', '584', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(139, 'Martinica', 'MQ', NULL, 'MTQ', '474', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(140, 'Mauritania', 'MR', NULL, 'MRT', '478', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(141, 'Mauricio', 'MU', NULL, 'MUS', '480', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(142, 'Mayotte', 'YT', NULL, 'MYT', '175', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(143, 'México', 'MX', NULL, 'MEX', '484', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(144, 'Micronesia', 'FM', NULL, 'FSM', '583', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(145, 'Moldavia', 'MD', NULL, 'MDA', '498', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(146, 'Mónaco', 'MC', NULL, 'MCO', '492', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(147, 'Mongolia', 'MN', NULL, 'MNG', '496', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(148, 'Montenegro', 'ME', NULL, 'MNE', '499', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(149, 'Montserrat', 'MS', NULL, 'MSR', '500', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(150, 'Marruecos', 'MA', NULL, 'MAR', '504', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(151, 'Mozambique', 'MZ', NULL, 'MOZ', '508', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(152, 'Myanmar', 'MM', NULL, 'MMR', '104', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(153, 'Namibia', 'NA', NULL, 'NAM', '516', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(154, 'Nauru', 'NR', NULL, 'NRU', '520', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(155, 'Nepal', 'NP', NULL, 'NPL', '524', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(156, 'Países Bajos', 'NL', NULL, 'NLD', '528', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(157, 'Nueva Caledonia', 'NC', NULL, 'NCL', '540', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(158, 'Nueva Zelanda', 'NZ', NULL, 'NZL', '554', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(159, 'Nicaragua', 'NI', NULL, 'NIC', '558', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(160, 'Níger', 'NE', NULL, 'NER', '562', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(161, 'Nigeria', 'NG', NULL, 'NGA', '566', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(162, 'Niue', 'NU', NULL, 'NIU', '570', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(163, 'Isla Norfolk', 'NF', NULL, 'NFK', '574', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(164, 'Macedonia del Norte', 'MK', NULL, 'MKD', '807', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(165, 'Islas Marianas del Norte', 'MP', NULL, 'MNP', '580', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(166, 'Noruega', 'NO', NULL, 'NOR', '578', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(167, 'Omán', 'OM', NULL, 'OMN', '512', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(168, 'Pakistán', 'PK', NULL, 'PAK', '586', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(169, 'Palaos', 'PW', NULL, 'PLW', '585', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(170, 'Palestina', 'PS', NULL, 'PSE', '275', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(171, 'Panamá', 'PA', NULL, 'PAN', '591', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(172, 'Papúa Nueva Guinea', 'PG', NULL, 'PNG', '598', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(173, 'Paraguay', 'PY', NULL, 'PRY', '600', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(174, 'Perú', 'PE', NULL, 'PER', '604', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(175, 'Filipinas', 'PH', NULL, 'PHL', '608', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(176, 'Islas Pitcairn', 'PN', NULL, 'PCN', '612', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(177, 'Polonia', 'PL', NULL, 'POL', '616', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(178, 'Portugal', 'PT', NULL, 'PRT', '620', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(179, 'Puerto Rico', 'PR', NULL, 'PRI', '630', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(180, 'Catar', 'QA', NULL, 'QAT', '634', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(181, 'Reunión', 'RE', NULL, 'REU', '638', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(182, 'Rumania', 'RO', NULL, 'ROU', '642', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(183, 'Rusia', 'RU', NULL, 'RUS', '643', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(184, 'Ruanda', 'RW', NULL, 'RWA', '646', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(185, 'San Bartolomé', 'BL', NULL, 'BLM', '652', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(186, 'Santa Elena', 'SH', NULL, 'SHN', '654', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(187, 'San Cristóbal y Nieves', 'KN', NULL, 'KNA', '659', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(188, 'Santa Lucía', 'LC', NULL, 'LCA', '662', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(189, 'San Martín (Francia)', 'MF', NULL, 'MAF', '663', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(190, 'San Pedro y Miquelón', 'PM', NULL, 'SPM', '666', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(191, 'San Vicente y las Granadinas', 'VC', NULL, 'VCT', '670', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(192, 'Samoa', 'WS', NULL, 'WSM', '882', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(193, 'San Marino', 'SM', NULL, 'SMR', '674', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(194, 'Santo Tomé y Príncipe', 'ST', NULL, 'STP', '678', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(195, 'Arabia Saudita', 'SA', NULL, 'SAU', '682', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(196, 'Senegal', 'SN', NULL, 'SEN', '686', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(197, 'Serbia', 'RS', NULL, 'SRB', '688', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(198, 'Seychelles', 'SC', NULL, 'SYC', '690', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(199, 'Sierra Leona', 'SL', NULL, 'SLE', '694', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(200, 'Singapur', 'SG', NULL, 'SGP', '702', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(201, 'Sint Maarten (Países Bajos)', 'SX', NULL, 'SXM', '534', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(202, 'Eslovaquia', 'SK', NULL, 'SVK', '703', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(203, 'Eslovenia', 'SI', NULL, 'SVN', '705', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(204, 'Islas Salomón', 'SB', NULL, 'SLB', '090', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(205, 'Somalia', 'SO', NULL, 'SOM', '706', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(206, 'Sudáfrica', 'ZA', NULL, 'ZAF', '710', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(207, 'Georgia del Sur e Islas Sándwich del Sur', 'GS', NULL, 'SGS', '239', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(208, 'Sudán del Sur', 'SS', NULL, 'SSD', '728', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(209, 'España', 'ES', NULL, 'ESP', '724', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(210, 'Sri Lanka', 'LK', NULL, 'LKA', '144', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(211, 'Sudán', 'SD', NULL, 'SDN', '729', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(212, 'Surinam', 'SR', NULL, 'SUR', '740', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(213, 'Suecia', 'SE', NULL, 'SWE', '752', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(214, 'Suiza', 'CH', NULL, 'CHE', '756', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(215, 'Siria', 'SY', NULL, 'SYR', '760', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(216, 'Taiwán', 'TW', NULL, 'TWN', '158', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(217, 'Tayikistán', 'TJ', NULL, 'TJK', '762', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(218, 'Tanzania', 'TZ', NULL, 'TZA', '834', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(219, 'Tailandia', 'TH', NULL, 'THA', '764', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(220, 'Timor-Leste', 'TL', NULL, 'TLS', '626', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(221, 'Togo', 'TG', NULL, 'TGO', '768', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(222, 'Tokelau', 'TK', NULL, 'TKL', '772', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(223, 'Tonga', 'TO', NULL, 'TON', '776', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(224, 'Trinidad y Tobago', 'TT', NULL, 'TTO', '780', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(225, 'Túnez', 'TN', NULL, 'TUN', '788', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(226, 'Turquía', 'TR', NULL, 'TUR', '792', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(227, 'Turkmenistán', 'TM', NULL, 'TKM', '795', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(228, 'Islas Turcas y Caicos', 'TC', NULL, 'TCA', '796', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(229, 'Tuvalu', 'TV', NULL, 'TUV', '798', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(230, 'Uganda', 'UG', NULL, 'UGA', '800', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(231, 'Ucrania', 'UA', NULL, 'UKR', '804', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(232, 'Emiratos Árabes Unidos', 'AE', NULL, 'ARE', '784', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(233, 'Reino Unido', 'GB', NULL, 'GBR', '826', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(234, 'Estados Unidos', 'US', NULL, 'USA', '840', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(235, 'Islas menores alejadas de Estados Unidos', 'UM', NULL, 'UMI', '581', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(236, 'Uruguay', 'UY', NULL, 'URY', '858', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(237, 'Uzbekistán', 'UZ', NULL, 'UZB', '860', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(238, 'Vanuatu', 'VU', NULL, 'VUT', '548', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(239, 'Ciudad del Vaticano', 'VA', NULL, 'VAT', '336', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(240, 'Venezuela', 'VE', NULL, 'VEN', '862', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(241, 'Vietnam', 'VN', NULL, 'VNM', '704', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(242, 'Islas Vírgenes Británicas', 'VG', NULL, 'VGB', '092', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(243, 'Islas Vírgenes de los Estados Unidos', 'VI', NULL, 'VIR', '850', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(244, 'Wallis y Futuna', 'WF', NULL, 'WLF', '876', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(245, 'Sáhara Occidental', 'EH', NULL, 'ESH', '732', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(246, 'Yemen', 'YE', NULL, 'YEM', '887', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(247, 'Zambia', 'ZM', NULL, 'ZMB', '894', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL),
	(248, 'Zimbabue', 'ZW', NULL, 'ZWE', '716', b'1', '2026-03-05 09:55:35', '2026-03-05 09:55:35', NULL, NULL, NULL, NULL);

-- Volcando estructura para tabla inspecciones.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Volcando datos para la tabla inspecciones.password_reset_tokens: ~0 rows (aproximadamente)
DELETE FROM `password_reset_tokens`;

-- Volcando estructura para tabla inspecciones.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`) USING BTREE,
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Volcando datos para la tabla inspecciones.personal_access_tokens: ~0 rows (aproximadamente)
DELETE FROM `personal_access_tokens`;

-- Volcando estructura para tabla inspecciones.personas
CREATE TABLE IF NOT EXISTS `personas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tipo_documento` enum('DNI','CE','PAS') NOT NULL DEFAULT 'DNI',
  `numero_documento` varchar(20) NOT NULL,
  `nombres` varchar(120) NOT NULL,
  `apellido_paterno` varchar(120) NOT NULL,
  `apellido_materno` varchar(120) NOT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `ubigeo` varchar(20) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  `sexo` enum('m','f') DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `estado` bit(1) DEFAULT b'1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `updated_by` bigint(20) unsigned DEFAULT NULL,
  `deleted_by` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `personas_numero_documento_unique` (`numero_documento`) USING BTREE,
  UNIQUE KEY `personas_email_unique` (`email`) USING BTREE,
  KEY `personas_apellido_paterno_apellido_materno_nombres_index` (`apellido_paterno`,`apellido_materno`,`nombres`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Volcando datos para la tabla inspecciones.personas: ~7 rows (aproximadamente)
DELETE FROM `personas`;
INSERT INTO `personas` (`id`, `tipo_documento`, `numero_documento`, `nombres`, `apellido_paterno`, `apellido_materno`, `fecha_nacimiento`, `ubigeo`, `email`, `telefono`, `sexo`, `foto`, `estado`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
	(1, 'DNI', '70495760', 'Luis', 'Paredes', 'Caipo', NULL, NULL, 'admin@sis-cursos.test', NULL, NULL, NULL, b'1', '2026-03-05 09:55:27', '2026-03-31 21:08:58', NULL, NULL, 1, NULL),
	(2, 'DNI', '43931957', 'Arturo David', 'Gonzales', 'Briones', NULL, NULL, 'abriones@elcumbe.com.pe', NULL, NULL, NULL, b'1', '2026-03-05 09:55:28', '2026-03-05 09:55:28', NULL, NULL, NULL, NULL),
	(3, 'DNI', '74581236', 'Carlos', 'Vargas', 'Rojas', NULL, NULL, 'service@sis-cursos.test', NULL, NULL, NULL, b'1', '2026-03-05 09:55:30', '2026-03-05 09:55:30', NULL, NULL, NULL, NULL),
	(4, 'DNI', '48921763', 'Renato', 'Salazar', 'Paredes', NULL, NULL, 'docente@sis-cursos.test', NULL, NULL, NULL, b'1', '2026-03-05 09:55:32', '2026-03-05 09:55:32', NULL, NULL, NULL, NULL),
	(5, 'DNI', '53609418', 'Bruno', 'Huaman', 'Torres', NULL, NULL, 'alumno@sis-cursos.test', NULL, NULL, NULL, b'1', '2026-03-05 09:55:34', '2026-03-05 09:55:34', NULL, NULL, NULL, NULL),
	(6, 'DNI', '73208695', 'Moises', 'Gutierrez', 'Terrones', NULL, NULL, NULL, NULL, NULL, NULL, b'1', '2026-03-31 10:00:53', '2026-03-31 10:00:53', NULL, NULL, 1, NULL),
	(7, 'DNI', '73208690', 'Juan', 'perez', 'Ceras', NULL, NULL, 'juanp69@gmail.com', '976001682', NULL, NULL, b'1', '2026-03-31 10:00:53', '2026-03-31 10:00:53', NULL, NULL, 1, NULL);

-- Volcando estructura para tabla inspecciones.regiones
CREATE TABLE IF NOT EXISTS `regiones` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pais_id` bigint(20) unsigned DEFAULT NULL,
  `region` varchar(255) DEFAULT NULL,
  `codigo` varchar(255) DEFAULT NULL,
  `estado` bit(1) DEFAULT b'1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `updated_by` bigint(20) unsigned DEFAULT NULL,
  `deleted_by` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `regiones_pais_id_index` (`pais_id`) USING BTREE,
  KEY `regiones_region_index` (`region`) USING BTREE,
  KEY `regiones_codigo_index` (`codigo`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Volcando datos para la tabla inspecciones.regiones: ~25 rows (aproximadamente)
DELETE FROM `regiones`;
INSERT INTO `regiones` (`id`, `pais_id`, `region`, `codigo`, `estado`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
	(1, 174, 'Amazonas', 'AMA', b'1', '2026-03-05 09:58:02', '2026-03-05 09:58:02', NULL, NULL, NULL, NULL),
	(2, 174, 'Áncash', 'ANC', b'1', '2026-03-05 09:58:02', '2026-03-05 09:58:02', NULL, NULL, NULL, NULL),
	(3, 174, 'Apurímac', 'APU', b'1', '2026-03-05 09:58:02', '2026-03-05 09:58:02', NULL, NULL, NULL, NULL),
	(4, 174, 'Arequipa', 'ARE', b'1', '2026-03-05 09:58:02', '2026-03-05 09:58:02', NULL, NULL, NULL, NULL),
	(5, 174, 'Ayacucho', 'AYA', b'1', '2026-03-05 09:58:02', '2026-03-05 09:58:02', NULL, NULL, NULL, NULL),
	(6, 174, 'Cajamarca', 'CAJ', b'1', '2026-03-05 09:58:02', '2026-03-05 09:58:02', NULL, NULL, NULL, NULL),
	(7, 174, 'Callao', 'CAL', b'1', '2026-03-05 09:58:02', '2026-03-05 09:58:02', NULL, NULL, NULL, NULL),
	(8, 174, 'Cusco', 'CUS', b'1', '2026-03-05 09:58:02', '2026-03-05 09:58:02', NULL, NULL, NULL, NULL),
	(9, 174, 'Huancavelica', 'HUV', b'1', '2026-03-05 09:58:02', '2026-03-05 09:58:02', NULL, NULL, NULL, NULL),
	(10, 174, 'Huánuco', 'HUC', b'1', '2026-03-05 09:58:02', '2026-03-05 09:58:02', NULL, NULL, NULL, NULL),
	(11, 174, 'Ica', 'ICA', b'1', '2026-03-05 09:58:02', '2026-03-05 09:58:02', NULL, NULL, NULL, NULL),
	(12, 174, 'Junín', 'JUN', b'1', '2026-03-05 09:58:02', '2026-03-05 09:58:02', NULL, NULL, NULL, NULL),
	(13, 174, 'La Libertad', 'LAL', b'1', '2026-03-05 09:58:02', '2026-03-05 09:58:02', NULL, NULL, NULL, NULL),
	(14, 174, 'Lambayeque', 'LAM', b'1', '2026-03-05 09:58:02', '2026-03-05 09:58:02', NULL, NULL, NULL, NULL),
	(15, 174, 'Lima', 'LIM', b'1', '2026-03-05 09:58:02', '2026-03-05 09:58:02', NULL, NULL, NULL, NULL),
	(16, 174, 'Loreto', 'LOR', b'1', '2026-03-05 09:58:02', '2026-03-05 09:58:02', NULL, NULL, NULL, NULL),
	(17, 174, 'Madre de Dios', 'MDD', b'1', '2026-03-05 09:58:02', '2026-03-05 09:58:02', NULL, NULL, NULL, NULL),
	(18, 174, 'Moquegua', 'MOQ', b'1', '2026-03-05 09:58:02', '2026-03-05 09:58:02', NULL, NULL, NULL, NULL),
	(19, 174, 'Pasco', 'PAS', b'1', '2026-03-05 09:58:02', '2026-03-05 09:58:02', NULL, NULL, NULL, NULL),
	(20, 174, 'Piura', 'PIU', b'1', '2026-03-05 09:58:02', '2026-03-05 09:58:02', NULL, NULL, NULL, NULL),
	(21, 174, 'Puno', 'PUN', b'1', '2026-03-05 09:58:02', '2026-03-05 09:58:02', NULL, NULL, NULL, NULL),
	(22, 174, 'San Martín', 'SAM', b'1', '2026-03-05 09:58:02', '2026-03-05 09:58:02', NULL, NULL, NULL, NULL),
	(23, 174, 'Tacna', 'TAC', b'1', '2026-03-05 09:58:02', '2026-03-05 09:58:02', NULL, NULL, NULL, NULL),
	(24, 174, 'Tumbes', 'TUM', b'1', '2026-03-05 09:58:02', '2026-03-05 09:58:02', NULL, NULL, NULL, NULL),
	(25, 174, 'Ucayali', 'UCA', b'1', '2026-03-05 09:58:02', '2026-03-05 09:58:02', NULL, NULL, NULL, NULL);

-- Volcando estructura para tabla inspecciones.servicios
CREATE TABLE IF NOT EXISTS `servicios` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(120) NOT NULL,
  `estado` bit(1) DEFAULT b'1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `updated_by` bigint(20) unsigned DEFAULT NULL,
  `deleted_by` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- Volcando datos para la tabla inspecciones.servicios: ~4 rows (aproximadamente)
DELETE FROM `servicios`;
INSERT INTO `servicios` (`id`, `descripcion`, `estado`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
	(1, 'Mantenimiento', b'1', '2026-03-31 09:25:49', '2026-03-31 09:25:49', NULL, 1, NULL, NULL),
	(2, 'Cucardas', b'1', '2026-03-31 09:25:57', '2026-03-31 09:25:57', NULL, 1, NULL, NULL),
	(3, 'Inmobiliario', b'1', '2026-03-31 09:26:07', '2026-03-31 09:26:07', NULL, 1, NULL, NULL),
	(4, 'Movimiento de tierras', b'1', '2026-03-31 21:08:00', '2026-03-31 21:08:00', NULL, 1, NULL, NULL);

-- Volcando estructura para tabla inspecciones.tipo_certificado
CREATE TABLE IF NOT EXISTS `tipo_certificado` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tipo_certificado` varchar(255) DEFAULT NULL,
  `estado` bit(1) DEFAULT b'1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `updated_by` bigint(20) unsigned DEFAULT NULL,
  `deleted_by` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `tipo_certificado_tipo_certificado_index` (`tipo_certificado`) USING BTREE,
  KEY `tipo_certificado_estado_index` (`estado`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Volcando datos para la tabla inspecciones.tipo_certificado: ~0 rows (aproximadamente)
DELETE FROM `tipo_certificado`;

-- Volcando estructura para tabla inspecciones.tipo_inspeccion
CREATE TABLE IF NOT EXISTS `tipo_inspeccion` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tipo_inspeccion` varchar(255) DEFAULT NULL,
  `estado` bit(1) DEFAULT b'1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `updated_by` bigint(20) unsigned DEFAULT NULL,
  `deleted_by` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `tipo_inspeccion_tipo_inspeccion_index` (`tipo_inspeccion`) USING BTREE,
  KEY `tipo_inspeccion_estado_index` (`estado`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Volcando datos para la tabla inspecciones.tipo_inspeccion: ~0 rows (aproximadamente)
DELETE FROM `tipo_inspeccion`;

-- Volcando estructura para tabla inspecciones.tipos
CREATE TABLE IF NOT EXISTS `tipos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tipo` varchar(255) NOT NULL,
  `estado` bit(1) DEFAULT b'1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `updated_by` bigint(20) unsigned DEFAULT NULL,
  `deleted_by` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `tipos_tipo_index` (`tipo`) USING BTREE,
  KEY `tipos_estado_index` (`estado`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Volcando datos para la tabla inspecciones.tipos: ~7 rows (aproximadamente)
DELETE FROM `tipos`;
INSERT INTO `tipos` (`id`, `tipo`, `estado`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
	(1, 'asdasdasd', b'1', '2026-03-29 10:50:32', '2026-03-29 10:50:37', '2026-03-29 10:50:37', NULL, NULL, NULL),
	(2, 'Vehiculo', b'1', '2026-03-29 21:41:35', '2026-03-29 21:41:35', NULL, NULL, NULL, NULL),
	(3, 'Motocicleta', b'1', '2026-03-29 21:41:43', '2026-03-29 21:41:43', NULL, NULL, NULL, NULL),
	(4, 'Generadores', b'1', '2026-03-29 21:41:55', '2026-03-29 21:41:55', NULL, NULL, NULL, NULL),
	(5, 'Luminarias', b'1', '2026-03-29 21:42:04', '2026-03-29 21:42:04', NULL, NULL, NULL, NULL),
	(6, 'Vehi', b'1', '2026-03-31 10:35:45', '2026-03-31 10:35:45', NULL, 1, NULL, NULL),
	(7, 've', b'1', '2026-03-31 23:20:35', '2026-03-31 23:20:35', NULL, 1, NULL, NULL);

-- Volcando estructura para tabla inspecciones.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `persona_id` bigint(20) unsigned DEFAULT NULL,
  `empresa_id` bigint(20) unsigned DEFAULT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `two_factor_secret` text DEFAULT NULL,
  `two_factor_recovery_codes` text DEFAULT NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `estado` tinyint(4) NOT NULL DEFAULT 1,
  `avatar` text DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Volcando datos para la tabla inspecciones.users: ~5 rows (aproximadamente)
DELETE FROM `users`;
INSERT INTO `users` (`id`, `persona_id`, `empresa_id`, `user_id`, `name`, `email`, `email_verified_at`, `username`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `estado`, `avatar`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 1, NULL, NULL, 'Luis Paredes Caipo', 'admin@sis-cursos.test', NULL, '70495760', '$2y$12$pX7ZQIwR1DTXTwvkNZd2qeLZBTfEuX4yDPnEmpJJgT1tX7bTPOZQe', NULL, NULL, NULL, 1, NULL, NULL, '2026-03-05 09:55:28', '2026-03-05 09:55:28'),
	(2, 2, 1, NULL, 'Arturo David Gonzales Briones', 'um@sis-cursos.test', NULL, '43931957', '$2y$12$Ay.j7hebMrDsXFlE07GpKuS9kVfwxhxXSPa6Mp/rRW4OC5U1FnbLy', NULL, NULL, NULL, 1, NULL, NULL, '2026-03-05 09:55:29', '2026-03-05 09:55:29'),
	(3, 3, NULL, NULL, 'Carlos Vargas Rojas', 'service@sis-cursos.test', NULL, '74581236', '$2y$12$Eat/IjEisxmeRH7tZudewuB4x9Ksf.M4n2fq1V0mC315DxQRtcBsm', NULL, NULL, NULL, 1, NULL, NULL, '2026-03-05 09:55:31', '2026-03-05 09:55:31'),
	(4, 4, NULL, NULL, 'Renato Salazar Paredes', 'docente@sis-cursos.test', NULL, '48921763', '$2y$12$ylhpr8VbdeV8A8787k8YzuXqfdmgk.6XBkEfbZKpeBP.htmNaI.sG', NULL, NULL, NULL, 1, NULL, NULL, '2026-03-05 09:55:33', '2026-03-05 09:55:33'),
	(5, 5, NULL, NULL, 'Bruno Huaman Torres', 'alumno@sis-cursos.test', NULL, '53609418', '$2y$12$0zGhYMxS8byhvLNkLRY8g.CqJYJObalEJ.GEj0qHLDw5sfFm3EUWe', NULL, NULL, NULL, 1, NULL, NULL, '2026-03-05 09:55:35', '2026-03-05 09:55:35');



ALTER TABLE `inspecciones`.`cuestionario_preguntas` ADD COLUMN `ingreso_respuesta_defecto` varchar(255) NULL AFTER `ingreso_respuesta_valores`;

ALTER TABLE `inspecciones`.`cuestionario_preguntas` ADD COLUMN `salida_respuesta_defecto` varchar(255) NULL AFTER `salida_respuesta_valores`;

ALTER TABLE `inspecciones`.`cuestionario_preguntas` MODIFY COLUMN `ingreso_respuesta_tipo` enum('select','radio','entero','decimal','texto','fecha','fecha_hora','') CHARACTER SET utf8mb4 COLLATE utf8mb4_uca1400_ai_ci NULL DEFAULT NULL AFTER `ingeso_preguntar`;

ALTER TABLE `inspecciones`.`cuestionario_preguntas` MODIFY COLUMN `salida_respuesta_tipo` enum('select','radio','entero','decimal','texto','fecha','fecha_hora','') CHARACTER SET utf8mb4 COLLATE utf8mb4_uca1400_ai_ci NULL DEFAULT NULL AFTER `salida_preguntar`;

ALTER TABLE `inspecciones`.`cuestionario_respuestas` ADD COLUMN `ingreso_respuesta_tipo` enum('select','radio','entero','decimal','texto','fecha','fecha_hora','') NULL AFTER `cuestionario_pregunta_personalizada`;

ALTER TABLE `inspecciones`.`cuestionario_respuestas` ADD COLUMN `salida_respuesta_tipo` enum('select','radio','entero','decimal','texto','fecha','fecha_hora','') NULL AFTER `ingreso_respuesta`;

ALTER TABLE `inspecciones`.`detalle_inspeccion` ADD COLUMN `pdf_ruta` text NULL AFTER `inspeccion_observaciones`;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
