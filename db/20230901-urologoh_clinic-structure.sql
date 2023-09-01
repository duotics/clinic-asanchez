-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 01-09-2023 a las 16:43:33
-- Versión del servidor: 5.7.23-23
-- Versión de PHP: 8.1.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `urologoh_clinic`
--
CREATE DATABASE IF NOT EXISTS `urologoh_clinic` DEFAULT CHARACTER SET  utf8mb4 COLLATE  utf8mb4_general_ci;
USE `urologoh_clinic`;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `db_auditoria`
--

CREATE TABLE `db_auditoria` (
  `id_aud` bigint(20) NOT NULL,
  `aud_datet` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET= utf8mb4 COMMENT='Auditoria Principal';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `db_auditoria_detalle`
--

CREATE TABLE `db_auditoria_detalle` (
  `id` bigint(20) NOT NULL,
  `id_aud` bigint(20) NOT NULL,
  `usr_id` int(6) DEFAULT NULL,
  `audd_datet` datetime DEFAULT NULL,
  `audd_eve` varchar(255) DEFAULT NULL,
  `audd_des` text
) ENGINE=InnoDB DEFAULT CHARSET= utf8mb4 COMMENT='Detalles de Auditoria';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `db_iess`
--

CREATE TABLE `db_iess` (
  `id` int(11) NOT NULL COMMENT 'Primary Key ID REPORTE',
  `fecha` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `emp_cod` int(11) DEFAULT NULL,
  `id_aud` bigint(20) DEFAULT NULL COMMENT 'Auditoria',
  `pac_cod` int(6) NOT NULL COMMENT 'ID PACIENTE Requerido',
  `con_num` int(6) DEFAULT NULL COMMENT 'ID CONSULTA Relacionada, no es obligatorio',
  `id_suc` int(11) DEFAULT NULL COMMENT 'Sucursal o Institucion',
  `mot_con` varchar(50) DEFAULT NULL,
  `ant_per` varchar(250) DEFAULT NULL,
  `ant_fam_sel` varchar(100) DEFAULT NULL,
  `ant_fam_des` varchar(100) DEFAULT NULL,
  `enf_act` varchar(400) DEFAULT NULL,
  `rev_org_sel` varchar(100) DEFAULT NULL,
  `rev_org_des` varchar(100) DEFAULT NULL,
  `exa_fis_sel` varchar(100) DEFAULT NULL,
  `exa_fis_des` varchar(200) DEFAULT NULL,
  `planes` varchar(400) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET= utf8mb4 COLLATE= utf8mb4_general_ci COMMENT='REPORTE IESS - main table';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `db_iess_diag`
--

CREATE TABLE `db_iess_diag` (
  `id` int(11) NOT NULL,
  `id_rep` int(11) NOT NULL,
  `diag` varchar(50) DEFAULT NULL,
  `cie` varchar(15) DEFAULT NULL,
  `tip` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET= utf8mb4 COLLATE= utf8mb4_general_ci COMMENT='Reporte IESS Diagnosticos';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `db_iess_evo`
--

CREATE TABLE `db_iess_evo` (
  `id` int(11) NOT NULL,
  `id_rep` int(11) NOT NULL,
  `fecha` varchar(10) DEFAULT NULL,
  `hora` varchar(5) DEFAULT NULL,
  `notas` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET= utf8mb4 COLLATE= utf8mb4_general_ci COMMENT='Reporte IESS Evolucion';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `db_iess_pres`
--

CREATE TABLE `db_iess_pres` (
  `id` int(11) NOT NULL,
  `id_rep` int(11) NOT NULL,
  `farmaco` varchar(100) DEFAULT NULL,
  `admin` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET= utf8mb4 COLLATE= utf8mb4_general_ci COMMENT='Reporte IESS Prescripcion';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `db_iess_sig`
--

CREATE TABLE `db_iess_sig` (
  `id` int(11) NOT NULL,
  `id_rep` int(11) NOT NULL COMMENT 'Id Reporte IESS db_iess',
  `fecha` date DEFAULT NULL,
  `temp` varchar(10) DEFAULT NULL,
  `presA` int(11) DEFAULT NULL,
  `presB` int(11) DEFAULT NULL,
  `puls` int(11) DEFAULT NULL,
  `frec` int(11) DEFAULT NULL,
  `peso` varchar(10) DEFAULT NULL,
  `talla` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET= utf8mb4 COLLATE= utf8mb4_general_ci COMMENT='Reporte IESS Signos';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_cirugias`
--

CREATE TABLE `tbl_cirugias` (
  `id` int(11) NOT NULL,
  `pac_cod` int(6) NOT NULL,
  `con_num` int(6) NOT NULL,
  `fecha` date NOT NULL,
  `diagnostico` text,
  `cirugiap` varchar(100) DEFAULT NULL,
  `fechap` datetime DEFAULT NULL,
  `cirugiar` varchar(100) DEFAULT NULL,
  `fechar` datetime DEFAULT NULL,
  `protocolo` text,
  `evolucion` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET= utf8mb4 COMMENT='Cirugias';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_cirugias_multimedia`
--

CREATE TABLE `tbl_cirugias_multimedia` (
  `id` int(11) NOT NULL,
  `idcirugia` int(11) NOT NULL,
  `filecir` varchar(255) DEFAULT NULL,
  `descfile` text
) ENGINE=InnoDB DEFAULT CHARSET= utf8mb4 COMMENT='Multimedia de Cirugias';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_compra_cab`
--

CREATE TABLE `tbl_compra_cab` (
  `com_num` int(10) NOT NULL,
  `fac_com_num` varchar(20) NOT NULL COMMENT 'Numero Factura Compra',
  `fac_com_fec` date NOT NULL COMMENT 'Fecha Compra Factura',
  `prov_cod` int(10) UNSIGNED ZEROFILL NOT NULL,
  `com_tip` char(1) NOT NULL,
  `com_fec_ing` datetime NOT NULL COMMENT 'Fecha Ingreso Factura',
  `emp_cod` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET= utf8mb4 COMMENT='Compras Cabecera';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_compra_det`
--

CREATE TABLE `tbl_compra_det` (
  `com_num` int(10) NOT NULL DEFAULT '0',
  `prod_id` int(5) NOT NULL DEFAULT '0',
  `com_prod_can` int(3) DEFAULT NULL,
  `com_prod_pre` double(8,3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET= utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_consultas`
--

CREATE TABLE `tbl_consultas` (
  `sec` int(11) NOT NULL,
  `con_num` int(6) NOT NULL DEFAULT '0',
  `pac_cod` int(6) NOT NULL DEFAULT '0',
  `con_fec` date DEFAULT NULL COMMENT 'Fecha de la Consulta',
  `con_upd` date DEFAULT NULL,
  `con_typ` int(6) DEFAULT NULL COMMENT 'ID Tipo de Consulta',
  `con_seg` char(1) DEFAULT NULL COMMENT 'Seguimiento de Consulta',
  `con_diagp` varchar(50) DEFAULT NULL COMMENT 'Diagnostico Presuntivo',
  `con_diagd` int(11) DEFAULT NULL COMMENT 'ID Diagnistivo Definitivo (tbl_diagnosticos)',
  `con_val` double(8,2) DEFAULT NULL COMMENT 'Valor Consulta',
  `tip_pag` char(1) DEFAULT NULL COMMENT 'Tipo de Pago',
  `dcon_mot` text COMMENT 'Motivo de la consulta',
  `dcon_antp` text COMMENT 'Antecedentes personales',
  `dcon_antf` text COMMENT 'Antecedentes familiares',
  `dcon_enf` text COMMENT 'Enfermedad actual',
  `dcon_exa` text COMMENT 'Examen fisico',
  `dcon_evo` text COMMENT 'Evolucion',
  `con_stat` char(1) NOT NULL DEFAULT '0' COMMENT 'Estado de la consulta',
  `mot_typ` int(6) DEFAULT NULL,
  `id_aud` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET= utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_consultas_res`
--

CREATE TABLE `tbl_consultas_res` (
  `cons_res_num` int(6) NOT NULL,
  `pac_cod` int(6) DEFAULT NULL,
  `con_num` int(6) DEFAULT NULL,
  `cons_res_fec` datetime DEFAULT NULL,
  `emp_cod` int(4) DEFAULT NULL,
  `cons_res_val` double(7,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET= utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_cta_por_cobrar`
--

CREATE TABLE `tbl_cta_por_cobrar` (
  `num_cta` int(6) NOT NULL,
  `con_num` int(6) DEFAULT NULL,
  `pac_cod` int(6) DEFAULT NULL,
  `cta_fecha` datetime NOT NULL,
  `cta_detalle` varchar(30) DEFAULT NULL,
  `cta_valor` double(8,2) DEFAULT NULL,
  `cta_cantidad` int(11) DEFAULT NULL,
  `cta_est` char(1) NOT NULL DEFAULT 'P'
) ENGINE=InnoDB DEFAULT CHARSET= utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_det_factura`
--

CREATE TABLE `tbl_det_factura` (
  `id_det_factura` int(11) NOT NULL,
  `id_fac` int(11) DEFAULT NULL,
  `num_cta` int(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET= utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_diagnosticos`
--

CREATE TABLE `tbl_diagnosticos` (
  `id` int(11) NOT NULL,
  `codigo` varchar(10) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET= utf8mb4 COMMENT='Diagnosticos';

--
-- Volcado de datos para la tabla `tbl_diagnosticos`
--

INSERT INTO `tbl_diagnosticos` (`id`, `codigo`, `nombre`) VALUES
(6, 'N40', 'HIPERPLASIA PROSTATICA'),
(7, 'Q643', 'ESTENOSIS DE LA URETRA '),
(8, 'N411', 'PROSTATITIS CRONICA'),
(9, 'N20', 'CALCULO DEL RIÑON Y DEL URETER'),
(10, 'N410', 'PROSTATITIS AGUDA'),
(12, 'N43', 'HIDROCELE '),
(14, 'N412', 'ABSCESO DE LA PROSTATA'),
(15, 'N46', 'ESTERILIDAD EN EL VARON'),
(16, 'N432', 'OTROS HIDROCELES'),
(17, 'A06', 'AMEBIASIS'),
(18, 'N30', 'CISTITIS'),
(19, 'N45', 'ORQUITIS Y EPIDIDIMITIS'),
(20, 'N434', 'ESPERMATOCELE'),
(21, 'N44', 'TORSION DEL TESTICULO'),
(22, 'N450', 'ORQUITIS, EPIDIDIMITIS Y ORQUIEPIDIDIMITIS CON ABS'),
(23, 'N459', 'ORQUITIS, EPIDIDIMITIS Y ORQUIEPIDIDIMITIS SIN ABS'),
(24, 'N47', 'PREPUCIO REDUNDANTE, FIMOSIS Y PARAFIMOSIS'),
(25, 'N48', 'OTROS TRASTORNOS DEL PENE'),
(26, 'N481', 'BALANOPOSTITIS'),
(27, 'N482', 'OTROS TRASTORNOS INFLAMATORIOS DEL PENE'),
(28, 'N480', 'LEUCOPLASIA DEL PENE'),
(29, 'N483', 'PRIAPISMO'),
(30, 'N484', 'IMPOTENCIA DE ORIGEN ORGANICO'),
(31, 'N485', 'ULCERA DEL PENE'),
(32, 'N486', 'BALANITIS XEROTICA OBLITERANTE'),
(33, 'N488', 'OTROS TRASTORNOS ESPECIFICADOS DEL PENE'),
(34, 'N489', 'TRASTORNO DEL PENE, NO ESPECIFICADO'),
(36, 'N209', 'CALCULO URINARIO, NO ESPECIFICADO'),
(37, 'I86', 'VARICES ESCROTALES'),
(38, 'N394', 'OTRAS INCONTINENCIAS URINARIAS ESPECIFICADAS'),
(39, 'N393', 'INCONTINENCIA URINARIA POR TENSION'),
(40, 'N390', 'INFECCION DE VIAS URINARIAS, SITIO NO ESPECIFICADO'),
(41, 'C61', 'TUMOR MALIGNO DE LA PROSTATA'),
(42, 'C62', 'TUMOR MALIGNO DEL TESTICULO'),
(43, 'R31', 'HEMATURIA NO ESPECIFICADA'),
(45, 'R33', 'RETENCION URINARIA'),
(46, 'R301', 'TENESMO VESICAL'),
(47, 'R309', 'MICCION DOLOROSA, NO ESPECIFICADA'),
(48, 'N811', 'CISTOCELE'),
(49, 'N810', 'URETROCELE FEMENINO'),
(50, 'N81', 'PROLAPSO GENITAL FEMENINO'),
(51, 'N679', 'TUMOR MALIGNO DE LA VEJIGA'),
(52, 'C64', 'TUMOR MALIGNO DEL RIÑON EXCEPTO DE LA PELVIS RENAL'),
(53, 'R935', 'HALLAZGOS ANORMALES EN DIAGNOSTICO POR IMAGEN DE OTRAS REGIONES ABDOMINALES INCLUIDO RETROPERITONEO'),
(55, 'N50.0', 'ATROFIA DEL TESTICULO'),
(56, 'C65', 'TUMOR MALIGNO DE LA PELVIS RENAL'),
(57, 'N130', 'HIDRONEFROSIS CON OBSTRUCCION DE LA UNION URETEROPELVICA'),
(58, 'N991', 'ESTRECHEZ URETRAL CONSECUTIVA A PROCEDIMEINTOS'),
(59, 'Q53', 'TESTICULO NO DESCENDIDO'),
(60, 'N200', 'LITIASIS RENOURETERAL'),
(61, 'F524', 'EYACULACION PRECOZ'),
(62, 'F529', 'DISFUNCION ERECTIL'),
(63, 'Z008', 'CHECK UP PROSTATICO'),
(66, 'A630', 'VERRUGAS GENITALES'),
(67, 'N512', 'DERMATOSIS PENEANA'),
(68, 'N312', 'VEJIGA NEUROGENA'),
(69, 'Z988', 'CONTROL POSTQUIRURGICO'),
(70, 'N500', 'ATROFIA TESTICULAR'),
(71, 'N340', 'ABSCESO URETRAL'),
(72, 'Q620', 'HDRONEFROSIS CONGENITA'),
(73, 'N281', 'QUISTE DE RIÑON ADQUIRIDO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_documentos`
--

CREATE TABLE `tbl_documentos` (
  `id` int(11) NOT NULL COMMENT 'ID Documento',
  `pac_cod` int(6) DEFAULT NULL COMMENT 'ID Paciente',
  `con_num` int(6) DEFAULT NULL COMMENT 'ID Consulta',
  `nombre` varchar(100) DEFAULT NULL,
  `contenido` longtext NOT NULL COMMENT 'Contenido Documento',
  `fecha` date NOT NULL COMMENT 'Fecha de Creación del Documento'
) ENGINE=MyISAM DEFAULT CHARSET= utf8mb4 COMMENT='Documentos';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_documentos_formato`
--

CREATE TABLE `tbl_documentos_formato` (
  `id_df` int(11) NOT NULL COMMENT 'ID Documento formato',
  `nombre` varchar(100) DEFAULT NULL COMMENT 'Nombre del Documento formato',
  `formato` longtext COMMENT 'Formato del Documento'
) ENGINE=MyISAM DEFAULT CHARSET= utf8mb4 COMMENT='Formatos para Documentos';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_documentos_poliza`
--

CREATE TABLE `tbl_documentos_poliza` (
  `cod_doc` int(11) NOT NULL,
  `path` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET= utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_empleados`
--

CREATE TABLE `tbl_empleados` (
  `emp_cod` int(6) NOT NULL,
  `typ_cod` int(6) DEFAULT NULL,
  `emp_ced` varchar(15) DEFAULT NULL,
  `emp_nom` varchar(50) DEFAULT NULL,
  `emp_ape` varchar(50) DEFAULT NULL,
  `emp_dir` varchar(30) DEFAULT NULL,
  `emp_tel1` varchar(15) DEFAULT NULL,
  `emp_tel2` varchar(15) DEFAULT NULL,
  `emp_mail` varchar(50) DEFAULT NULL,
  `emp_esp` varchar(50) DEFAULT NULL COMMENT 'Especialidad del Medico - info para Documentos',
  `emp_img` varchar(255) DEFAULT 'img_db/emp/no-pic.jpg'
) ENGINE=InnoDB DEFAULT CHARSET= utf8mb4;

--
-- Volcado de datos para la tabla `tbl_empleados`
--

INSERT INTO `tbl_empleados` (`emp_cod`, `typ_cod`, `emp_ced`, `emp_nom`, `emp_ape`, `emp_dir`, `emp_tel1`, `emp_tel2`, `emp_mail`, `emp_esp`, `emp_img`) VALUES
(1, 16, '0104198486', 'Admin', 'DUOTICS', 'Cuenca', '2888888', '0987654321', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_estudios`
--

CREATE TABLE `tbl_estudios` (
  `id` int(11) NOT NULL,
  `pac_cod` int(6) NOT NULL,
  `con_num` int(6) NOT NULL,
  `fecha` date NOT NULL,
  `est_cist` char(1) DEFAULT '0' COMMENT 'Estado CISTOSCOPIA',
  `det_cist` text COMMENT 'Detalle CISTOSCOPIA',
  `est_uret` char(1) DEFAULT '0' COMMENT 'Estado URETEROSCOPIA',
  `det_uret` text,
  `est_peno` char(1) DEFAULT '0',
  `det_peno` text,
  `con_diagp` varchar(100) DEFAULT NULL,
  `con_diagd` varchar(100) DEFAULT NULL,
  `observaciones` text
) ENGINE=InnoDB DEFAULT CHARSET= utf8mb4 COMMENT='Estudios Urologicos';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_examenes`
--

CREATE TABLE `tbl_examenes` (
  `id` int(11) NOT NULL,
  `pac_cod` int(6) NOT NULL,
  `con_num` int(6) NOT NULL,
  `fecha` date NOT NULL,
  `fechae` date DEFAULT NULL,
  `typ_cod` int(6) DEFAULT NULL,
  `descripcion` text,
  `resultado` text
) ENGINE=InnoDB DEFAULT CHARSET= utf8mb4 COMMENT='Registro de Examenes';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_examenes_img`
--

CREATE TABLE `tbl_examenes_img` (
  `id` int(11) NOT NULL,
  `idexamen` int(11) NOT NULL,
  `imagen` varchar(255) NOT NULL,
  `descimg` text
) ENGINE=InnoDB DEFAULT CHARSET= utf8mb4 COMMENT='Registro de Imagenes de Examen';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_examenes_solicitud`
--

CREATE TABLE `tbl_examenes_solicitud` (
  `id` int(11) NOT NULL COMMENT 'ID Documento',
  `pac_cod` int(6) NOT NULL COMMENT 'ID Paciente',
  `con_num` int(6) NOT NULL COMMENT 'ID Consulta',
  `nombre` varchar(100) DEFAULT NULL,
  `contenido` longtext NOT NULL COMMENT 'Contenido Documento',
  `fecha` date NOT NULL COMMENT 'Fecha de Creación del Documento'
) ENGINE=MyISAM DEFAULT CHARSET= utf8mb4 COMMENT='Solicitude Examen';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_factura`
--

CREATE TABLE `tbl_factura` (
  `id_fac` int(11) NOT NULL,
  `id_suc` int(11) NOT NULL,
  `fac_num` int(11) NOT NULL,
  `fac_fech` date DEFAULT NULL,
  `total` decimal(10,2) NOT NULL,
  `saldo` decimal(10,2) DEFAULT NULL,
  `fac_estado` varchar(1) DEFAULT NULL,
  `det_anul` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET= utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_images`
--

CREATE TABLE `tbl_images` (
  `img_cod` int(6) NOT NULL,
  `mod_cod` smallint(3) NOT NULL,
  `cod_ref` int(6) NOT NULL,
  `img_date` date NOT NULL,
  `img_path` varchar(255) NOT NULL,
  `img_title` varchar(50) DEFAULT NULL,
  `img_des` text,
  `img_stat` varchar(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET= utf8mb4 COMMENT='Imágenes del Sistema';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_images_pacientes`
--

CREATE TABLE `tbl_images_pacientes` (
  `ima_pac_cod` int(11) NOT NULL,
  `pac_cod` int(6) NOT NULL,
  `img_path` varchar(255) DEFAULT NULL,
  `img_status` char(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET= utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_modules`
--

CREATE TABLE `tbl_modules` (
  `mod_cod` smallint(3) NOT NULL,
  `mod_ref` varchar(4) NOT NULL,
  `mod_nom` varchar(50) NOT NULL,
  `mod_des` text NOT NULL,
  `mod_img` varchar(255) DEFAULT NULL,
  `mod_stat` char(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET= utf8mb4 COMMENT='Modulos del Sistema';

--
-- Volcado de datos para la tabla `tbl_modules`
--

INSERT INTO `tbl_modules` (`mod_cod`, `mod_ref`, `mod_nom`, `mod_des`, `mod_img`, `mod_stat`) VALUES
(15, 'HOME', 'Inicio', 'Sistema de Gestión de Historial Clinicas', NULL, '1'),
(16, 'PAC', 'Pacientes', 'Gestión de Pacientes', 'Outpatient.png', '1'),
(17, 'CON', 'Consultas', 'Administracion de Consultas', 'Library.png', '1'),
(18, 'PAG', 'Pagos', 'Gestión de Pagos de Pacientes', 'Cashier.png', '1'),
(19, 'FAC', 'Facturación', 'Servicios Medicos', 'Document-Archive-48.png', '1'),
(20, 'EMP', 'EMPLEADOS', 'Administracion de Empleados', 'User.png', '1'),
(21, 'USER', 'USUARIOS', 'Administracion de Usuarios', 'User.png', '1'),
(22, 'REP', 'REPORTES', 'Reportes del Sistema', NULL, '1'),
(23, 'DOC', 'Documentos', 'Listado de Documentos', NULL, '1'),
(24, 'TRAT', 'Recetas', 'Medicacion, tratamientos', NULL, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_pacientes`
--

CREATE TABLE `tbl_pacientes` (
  `pac_cod` int(6) NOT NULL,
  `pac_ced` varchar(15) DEFAULT NULL COMMENT 'Cedula / RUC / Pasaporte',
  `pac_fec` date DEFAULT NULL COMMENT 'Fecha de Nacimiento',
  `pac_nom` varchar(50) NOT NULL,
  `pac_ape` varchar(50) NOT NULL,
  `pac_lugp` varchar(20) DEFAULT NULL COMMENT 'Lugar Procedencia del Paciente',
  `pac_lugr` varchar(20) DEFAULT NULL COMMENT 'Lugar Residencia del Paciente',
  `pac_sect` int(6) DEFAULT NULL COMMENT 'Sector de Vivienda, Urbano - Rural',
  `pac_dir` varchar(50) DEFAULT NULL,
  `pac_tel1` varchar(15) DEFAULT NULL,
  `pac_tel2` varchar(15) DEFAULT NULL,
  `pac_email` varchar(60) DEFAULT NULL COMMENT 'E-mail del paciente',
  `pac_tipsan` int(6) DEFAULT NULL COMMENT 'ID Tipo de Sangre',
  `pac_estciv` int(6) DEFAULT NULL COMMENT 'ID Estado Civil',
  `pac_hijos` tinyint(4) DEFAULT NULL,
  `pac_sexo` int(6) DEFAULT NULL,
  `pac_ins` int(11) DEFAULT NULL,
  `pac_pro` varchar(20) DEFAULT NULL COMMENT 'Profesion del Paciente',
  `pac_emp` varchar(20) DEFAULT NULL COMMENT 'Empresa donde trabaja',
  `pac_ocu` varchar(20) DEFAULT NULL COMMENT 'Ocupación del Paciente',
  `pac_nompar` varchar(50) DEFAULT NULL COMMENT 'Emergencia - Nombre',
  `pac_telpar` varchar(15) DEFAULT NULL COMMENT 'Emergencia - Telefono',
  `id_aud` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET= utf8mb4 COMMENT='DATOS DEL PACIENTE';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_paciente_historial`
--

CREATE TABLE `tbl_paciente_historial` (
  `id` int(11) NOT NULL,
  `pac_cod` int(6) NOT NULL,
  `fecha` date NOT NULL,
  `peso` double(4,2) DEFAULT NULL,
  `pa` varchar(10) DEFAULT NULL,
  `talla` mediumint(9) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET= utf8mb4 COMMENT='Historial Talla Peso y Presion';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_pagopac_cab`
--

CREATE TABLE `tbl_pagopac_cab` (
  `pag_num` int(6) NOT NULL,
  `id_fac` int(11) NOT NULL,
  `pag_fech` date DEFAULT NULL,
  `pag_val` decimal(10,2) DEFAULT NULL,
  `pag_tip` varchar(15) DEFAULT NULL,
  `id_sucursal` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET= utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_pagopac_det`
--

CREATE TABLE `tbl_pagopac_det` (
  `sec_pag` int(6) NOT NULL,
  `pag_num` int(11) NOT NULL,
  `nom_banco` varchar(60) DEFAULT NULL,
  `detalle` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET= utf8mb4 COLLATE= utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_polizas`
--

CREATE TABLE `tbl_polizas` (
  `cod_pol` int(11) NOT NULL,
  `cod_pol_doc` int(11) DEFAULT NULL,
  `est_pol` varchar(1) DEFAULT NULL,
  `val_pol` float DEFAULT NULL,
  `fec_pol` date NOT NULL,
  `con_num` int(11) NOT NULL,
  `cod_pac` int(11) NOT NULL,
  `file_poliza` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET= utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_sesiones`
--

CREATE TABLE `tbl_sesiones` (
  `ses_num` int(2) NOT NULL DEFAULT '0',
  `ter_num` int(6) NOT NULL DEFAULT '0',
  `emp_cod` int(4) DEFAULT NULL,
  `ses_diag` varchar(255) DEFAULT NULL,
  `ses_val` double(8,2) DEFAULT NULL,
  `ses_fec` date DEFAULT NULL,
  `ses_hor_ini` time DEFAULT NULL,
  `ses_hor_fin` time DEFAULT NULL,
  `ses_status` char(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET= utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_sucursales`
--

CREATE TABLE `tbl_sucursales` (
  `id_suc` int(11) NOT NULL,
  `nom_suc` varchar(45) DEFAULT NULL,
  `dir_suc` varchar(45) DEFAULT NULL,
  `tel_suc` varchar(45) DEFAULT NULL,
  `num_fact_ini` int(11) NOT NULL,
  `est_suc` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET= utf8mb4 COLLATE= utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_sucursales`
--

INSERT INTO `tbl_sucursales` (`id_suc`, `nom_suc`, `dir_suc`, `tel_suc`, `num_fact_ini`, `est_suc`) VALUES
(1, 'Establecimiento 1', 'Cuenca', '28888', 1, 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_terapias`
--

CREATE TABLE `tbl_terapias` (
  `ter_num` int(6) NOT NULL,
  `con_num` int(6) DEFAULT NULL,
  `pac_cod` int(6) DEFAULT NULL,
  `ter_ses_fec` date DEFAULT NULL,
  `ter_ses_hor` time DEFAULT NULL,
  `ter_ses_val` double(8,2) DEFAULT NULL,
  `ter_num_ses` tinyint(2) UNSIGNED ZEROFILL DEFAULT NULL,
  `ter_num_ses_rel` tinyint(2) UNSIGNED ZEROFILL NOT NULL DEFAULT '00'
) ENGINE=InnoDB DEFAULT CHARSET= utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_tratamientos`
--

CREATE TABLE `tbl_tratamientos` (
  `tid` int(11) NOT NULL,
  `con_num` int(6) DEFAULT NULL,
  `pac_cod` int(6) DEFAULT NULL,
  `diagnostico` varchar(255) DEFAULT NULL,
  `nomDif` varchar(255) DEFAULT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET= utf8mb4 COMMENT='Tratamientos de Consultas';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_tratamientos_det`
--

CREATE TABLE `tbl_tratamientos_det` (
  `id` int(11) NOT NULL,
  `tid` int(11) NOT NULL,
  `medicamento` varchar(255) NOT NULL,
  `presentacion` varchar(50) DEFAULT NULL,
  `numero` smallint(6) DEFAULT NULL,
  `instrucciones` text
) ENGINE=InnoDB DEFAULT CHARSET= utf8mb4 COMMENT='Detalle (Medicamentos, instrucciones) del Tratamiento';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_types`
--

CREATE TABLE `tbl_types` (
  `typ_cod` int(6) NOT NULL,
  `mod_cod` smallint(3) DEFAULT NULL,
  `typ_ref` varchar(10) NOT NULL,
  `typ_val` varchar(50) NOT NULL,
  `typ_aux` varchar(2) DEFAULT NULL,
  `typ_ord` smallint(6) DEFAULT '1',
  `typ_stat` char(1) NOT NULL DEFAULT '1',
  `typ_pre` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET= utf8mb4 COMMENT='Typos para el Sistema';

--
-- Volcado de datos para la tabla `tbl_types`
--

INSERT INTO `tbl_types` (`typ_cod`, `mod_cod`, `typ_ref`, `typ_val`, `typ_aux`, `typ_ord`, `typ_stat`, `typ_pre`) VALUES
(16, NULL, 'TIPEMP', 'Administrador', NULL, 1, '1', NULL),
(17, NULL, 'ESTCIV', 'CASADO', NULL, 1, '1', NULL),
(18, NULL, 'ESTCIV', 'SOLTERO', NULL, 1, '1', NULL),
(19, NULL, 'ESTCIV', 'DIVORCIADO', NULL, 1, '1', NULL),
(20, NULL, 'ESTCIV', 'VIUDO', NULL, 1, '1', NULL),
(21, NULL, 'ESTCIV', 'UNION LIBRE', NULL, 1, '1', NULL),
(22, NULL, 'SEXO', 'Masculino', NULL, 1, '1', NULL),
(23, NULL, 'SEXO', 'Femenino', NULL, 1, '1', NULL),
(30, NULL, 'TIPCON', 'CORTESIA', NULL, 1, '1', 0.00),
(31, NULL, 'TIPEXAM', 'Examen de Sangre', NULL, 1, '1', NULL),
(32, NULL, 'TIPEXAM', 'Examen de Orina', NULL, 1, '1', NULL),
(33, NULL, 'TIPEXAM', 'Examen de Heces', NULL, 1, '1', NULL),
(34, NULL, 'TIPEXAM', 'IMAGENEOLOGIA', NULL, 1, '1', NULL),
(35, NULL, 'TIPEMP', 'Doctor', NULL, 1, '1', NULL),
(36, NULL, 'TIPSAN', 'AB Rh +', NULL, 1, '1', NULL),
(37, NULL, 'TIPSAN', 'AB Rh -', NULL, 1, '1', NULL),
(38, NULL, 'TIPSAN', 'A Rh +', NULL, 1, '1', NULL),
(39, NULL, 'TIPSAN', 'A Rh -', NULL, 1, '1', NULL),
(40, NULL, 'TIPSAN', 'B Rh +', NULL, 1, '1', NULL),
(41, NULL, 'TIPSAN', 'B Rh -', NULL, 1, '1', NULL),
(42, NULL, 'TIPSAN', 'O Rh +', NULL, 1, '1', NULL),
(43, NULL, 'TIPSAN', 'O Rh -', NULL, 1, '1', NULL),
(44, NULL, 'INST', 'Primaria', NULL, 1, '1', NULL),
(45, NULL, 'INST', 'Secundaria', NULL, 1, '1', NULL),
(46, NULL, 'INST', 'Superior', NULL, 1, '1', NULL),
(47, NULL, 'INST', 'Cuarto Nivel', NULL, 1, '1', NULL),
(48, NULL, 'INST', 'Tecnica Vocacional', NULL, 1, '1', NULL),
(49, NULL, 'TIPEMP', 'Medico', NULL, 1, '1', NULL),
(50, NULL, 'TIPEMP', 'Enfermera', NULL, 1, '1', NULL),
(51, NULL, 'TIPEMP', 'Secretaria', NULL, 1, '1', NULL),
(60, NULL, 'SECTOR', 'Urbano', NULL, 1, '1', NULL),
(61, NULL, 'SECTOR', 'Rural', NULL, 1, '1', NULL),
(62, NULL, 'EMPTRB', 'NINGUNA', NULL, 1, '1', NULL),
(63, NULL, 'EMPTRB', 'PRIVADA', NULL, 1, '1', NULL),
(64, NULL, 'EMPTRB', 'PUBLICA', NULL, 1, '1', NULL),
(65, NULL, 'EMPTRB', 'PROPIA', NULL, 1, '1', NULL),
(66, NULL, 'INST', 'Ninguna', NULL, 1, '1', NULL),
(67, NULL, 'ESTCIV', 'SEPARADO', NULL, 1, '1', NULL),
(89, NULL, 'TIPCON', 'CONSULTA PRIVADA', NULL, 1, '1', 40.00),
(97, NULL, 'TIPCON', 'IESS', NULL, 1, '1', NULL),
(100, NULL, 'RIESS-AF', 'CARDIOPATIA', NULL, 1, '1', NULL),
(101, NULL, 'RIESS-AF', 'DIABETES', NULL, 2, '1', NULL),
(102, NULL, 'RIESS-AF', 'ENF. C. VASCULAR', NULL, 3, '1', NULL),
(103, NULL, 'RIESS-AF', 'HIPERTENSION', NULL, 4, '1', NULL),
(104, NULL, 'RIESS-AF', 'CANCER', NULL, 5, '1', NULL),
(105, NULL, 'RIESS-AF', 'TUBERCULOSIS', NULL, 6, '1', NULL),
(106, NULL, 'RIESS-AF', 'ENF MENTAL', NULL, 7, '1', NULL),
(107, NULL, 'RIESS-AF', 'ENF INFECCIOSA', NULL, 8, '1', NULL),
(108, NULL, 'RIESS-AF', 'MAL FORMACION', NULL, 9, '1', NULL),
(109, NULL, 'RIESS-AF', 'OTRO', NULL, 10, '1', NULL),
(110, NULL, 'RIESS-ROS', 'ORGANOS DE LOS SENTIDOS', 'CP', 1, '1', NULL),
(111, NULL, 'RIESS-ROS', 'ORGANOS DE LOS SENTIDOS', 'SP', 1, '1', NULL),
(112, NULL, 'RIESS-ROS', 'RESPIRATORIO', 'CP', 2, '1', NULL),
(113, NULL, 'RIESS-ROS', 'RESPIRATORIO', 'SP', 2, '1', NULL),
(114, NULL, 'RIESS-ROS', 'CARDIO VASCULAR', 'CP', 3, '1', NULL),
(115, NULL, 'RIESS-ROS', 'CARDIO VASCULAR', 'SP', 3, '1', NULL),
(116, NULL, 'RIESS-ROS', 'DIGESTIVO', 'CP', 4, '1', NULL),
(117, NULL, 'RIESS-ROS', 'DIGESTIVO', 'SP', 4, '1', NULL),
(118, NULL, 'RIESS-ROS', 'GENITAL', 'CP', 5, '1', NULL),
(119, NULL, 'RIESS-ROS', 'GENITAL', 'SP', 5, '1', NULL),
(120, NULL, 'RIESS-ROS', 'URINARIO', 'CP', 6, '1', NULL),
(121, NULL, 'RIESS-ROS', 'URINARIO', 'SP', 6, '1', NULL),
(122, NULL, 'RIESS-ROS', 'MUSCULO ESQUELETICO', 'CP', 7, '1', NULL),
(123, NULL, 'RIESS-ROS', 'MUSCULO ESQUELETICO', 'SP', 7, '1', NULL),
(124, NULL, 'RIESS-ROS', 'ENDOCRINO', 'CP', 8, '1', NULL),
(125, NULL, 'RIESS-ROS', 'ENDOCRINO', 'SP', 8, '1', NULL),
(126, NULL, 'RIESS-ROS', 'HEMO LINFATICO', 'CP', 9, '1', NULL),
(127, NULL, 'RIESS-ROS', 'HEMO LINFATICO', 'SP', 9, '1', NULL),
(128, NULL, 'RIESS-ROS', 'NERVIOSO', 'SP', 10, '1', NULL),
(129, NULL, 'RIESS-ROS', 'NERVIOSO', 'CP', 10, '1', NULL),
(130, NULL, 'RIESS-EFR', 'CABEZA', 'CP', 1, '1', NULL),
(131, NULL, 'RIESS-EFR', 'CABEZA', 'SP', 1, '1', NULL),
(132, NULL, 'RIESS-EFR', 'CUELLO', 'CP', 2, '1', NULL),
(133, NULL, 'RIESS-EFR', 'CUELLO', 'SP', 2, '1', NULL),
(134, NULL, 'RIESS-EFR', 'TORAX', 'CP', 3, '1', NULL),
(135, NULL, 'RIESS-EFR', 'TORAX', 'SP', 3, '1', NULL),
(136, NULL, 'RIESS-EFR', 'ABDOMEN', 'CP', 4, '1', NULL),
(137, NULL, 'RIESS-EFR', 'ABDOMEN', 'SP', 4, '1', NULL),
(138, NULL, 'RIESS-EFR', 'PELVIS', 'CP', 5, '1', NULL),
(139, NULL, 'RIESS-EFR', 'PELVIS', 'SP', 5, '1', NULL),
(140, NULL, 'RIESS-EFR', 'EXTREMIDADES', 'CP', 6, '1', NULL),
(141, NULL, 'RIESS-EFR', 'EXTREMIDADES', 'SP', 6, '1', NULL),
(442, NULL, 'MOTCON', 'INFECCION TRACTO URINARIO', NULL, 1, '1', NULL),
(444, NULL, 'MOTCON', 'ORQUIALGIA', NULL, 1, '1', NULL),
(445, NULL, 'MOTCON', 'FIMOSIS-PREPUCIO REDUNDANTE', NULL, 1, '1', NULL),
(446, NULL, 'MOTCON', 'CRIPTORQUIDIA', NULL, 1, '1', NULL),
(447, NULL, 'MOTCON', 'SINTOMAS DEL TRACTO URINARIO BAJO', NULL, 1, '1', NULL),
(448, NULL, 'MOTCON', 'HEMATURIA', NULL, 1, '1', NULL),
(449, NULL, 'MOTCON', 'INCONTINENCIA URINARIA', NULL, 1, '1', NULL),
(450, NULL, 'MOTCON', 'CANCER DE PROSTATA ', NULL, 1, '1', NULL),
(451, NULL, 'MOTCON', 'LITIASIS RENOURETERAL', NULL, 1, '1', NULL),
(452, NULL, 'TIPCON', 'SEGURO PRIVADO', NULL, 1, '1', 40.00),
(453, NULL, 'MOTCON', 'ORQUIEPIDIDIMITIS', NULL, 1, '1', NULL),
(454, NULL, 'MOTCON', 'BALANITIS ', NULL, 1, '1', NULL),
(455, NULL, 'MOTCON', 'REVISION DE EXAMENES ', NULL, 1, '1', NULL),
(456, NULL, 'MOTCON', 'CONTROL POSTQUIRURGICO', NULL, 1, '1', NULL),
(457, NULL, 'MOTCON', 'PROGRAMAR CIRUGIA ', NULL, 1, '1', NULL),
(458, NULL, 'MOTCON', 'VERRUGAS GENITALES ', NULL, 1, '1', NULL),
(459, NULL, 'MOTCON', 'INFECCION TRANSMISION SEXUAL ', NULL, 1, '1', NULL),
(460, NULL, 'MOTCON', 'CHECK UP PROSTATICO', NULL, 1, '1', NULL),
(461, NULL, 'MOTCON', 'VARICOCELE', NULL, 1, '1', NULL),
(462, NULL, 'MOTCON', 'HIDROCELE', NULL, 1, '1', NULL),
(463, NULL, 'MOTCON', 'QUISTE EPIDIDIMO', NULL, 1, '1', NULL),
(464, NULL, 'MOTCON', 'REFLUJO VESICOURETERAL', NULL, 1, '1', NULL),
(465, NULL, 'MOTCON', 'UROPATIA OBSTRUCTIVA ', NULL, 1, '1', NULL),
(466, NULL, 'MOTCON', 'DISFUNCION ERECTIL', NULL, 1, '1', NULL),
(467, NULL, 'MOTCON', 'EYACULACION PRECOZ', NULL, 1, '1', NULL),
(468, NULL, 'MOTCON', 'ESTERILIDAD MASCULINA ', NULL, 1, '1', NULL),
(469, NULL, 'MOTCON', 'DESCENSO ORGANOS PELVICOS', NULL, 1, '1', NULL),
(470, NULL, 'MOTCON', 'CRECIMIENTO PROSTATICO', NULL, 1, '1', NULL),
(471, NULL, 'MOTCON', 'PROSTATITIS CRONICA ', NULL, 1, '1', NULL),
(472, NULL, 'MOTCON', 'INFECCION TRACTO URINARIO RECURRENTE', NULL, 1, '1', NULL),
(473, NULL, 'MOTCON', 'FIBROSIS CUELLO VESICAL', NULL, 1, '1', NULL),
(474, NULL, 'MOTCON', 'ESTENOSIS URETRA ', NULL, 1, '1', NULL),
(475, NULL, 'MOTCON', 'HIPOSPADIAS PROXIMAL', NULL, 1, '1', NULL),
(476, NULL, 'MOTCON', 'HIPOSPADIAS DISTAL', NULL, 1, '1', NULL),
(477, NULL, 'MOTCON', 'EXCLUSIÓN RENAL', NULL, 1, '1', NULL),
(478, NULL, 'MOTCON', 'HIPOTROFIA RENAL', NULL, 1, '1', NULL),
(479, NULL, 'MOTCON', 'DOLOR LUMBAR', NULL, 1, '1', NULL),
(480, NULL, 'MOTCON', 'DERMATOSIS PENIANA', NULL, 1, '1', NULL),
(481, NULL, 'MOTCON', 'PROSTATITIS AGUDA ', NULL, 1, '1', NULL),
(482, NULL, 'MOTCON', 'URETRITIS INESPECIFICA', NULL, 1, '1', NULL),
(483, NULL, 'MOTCON', 'TUMOR DE VEJIGA', NULL, 1, '1', NULL),
(484, NULL, 'MOTCON', 'TUMOR RENAL', NULL, 1, '1', NULL),
(485, NULL, 'MOTCON', 'CANCER DE PROSTATA ', NULL, 1, '1', NULL),
(486, NULL, 'MOTCON', 'TUMOR TESTICULAR ', NULL, 1, '1', NULL),
(487, NULL, 'MOTCON', 'INCONTINENCIA URINARIA', NULL, 1, '1', NULL),
(488, NULL, 'MOTCON', 'CONTROL POSTQUIRURGICO', NULL, 1, '1', NULL),
(489, NULL, 'MOTCON', 'VEJIGA NEURÓGENA', NULL, 1, '1', NULL),
(490, NULL, 'MOTCON', 'QUISTE RENAL ', NULL, 1, '1', NULL),
(491, NULL, 'MOTCON', 'PRIAPISMO', NULL, 1, '1', NULL),
(492, NULL, 'MOTCON', 'PEYRONIE', NULL, 1, '1', NULL),
(493, NULL, 'MOTCON', 'PATERNIDAD SATISFECHA ', NULL, 1, '1', NULL),
(494, NULL, 'TIPCON', 'Privado', NULL, 1, '1', NULL),
(495, NULL, 'TIPCON', 'PREPAGO', NULL, 1, '1', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_user_access`
--

CREATE TABLE `tbl_user_access` (
  `access_id` int(11) NOT NULL,
  `user_cod` int(6) NOT NULL,
  `access_ip` varchar(15) DEFAULT NULL COMMENT 'IP User Access',
  `access_datet` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET= utf8mb4 COMMENT='Registro de Acceso de Usuarios del Sistema';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_user_system`
--

CREATE TABLE `tbl_user_system` (
  `user_cod` int(6) NOT NULL,
  `emp_cod` int(6) NOT NULL,
  `user_username` varchar(20) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `user_img` varchar(255) DEFAULT NULL,
  `user_sign` varchar(255) DEFAULT NULL,
  `user_seal` varchar(255) DEFAULT NULL COMMENT 'Sello del Medico',
  `user_level` char(1) NOT NULL DEFAULT '5',
  `user_status` char(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET= utf8mb4 COMMENT='User System';

--
-- Volcado de datos para la tabla `tbl_user_system`
--

INSERT INTO `tbl_user_system` (`user_cod`, `emp_cod`, `user_username`, `user_password`, `user_img`, `user_sign`, `user_seal`, `user_level`, `user_status`) VALUES
(1, 1, 'admin', '21232f297a57a5a743894a0e4a801fc3', NULL, NULL, NULL, '1', '1');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `db_auditoria`
--
ALTER TABLE `db_auditoria`
  ADD PRIMARY KEY (`id_aud`);

--
-- Indices de la tabla `db_auditoria_detalle`
--
ALTER TABLE `db_auditoria_detalle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_auddet_auditoria` (`id_aud`);

--
-- Indices de la tabla `db_iess`
--
ALTER TABLE `db_iess`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `db_iess_diag`
--
ALTER TABLE `db_iess_diag`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `db_iess_evo`
--
ALTER TABLE `db_iess_evo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `db_iess_pres`
--
ALTER TABLE `db_iess_pres`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `db_iess_sig`
--
ALTER TABLE `db_iess_sig`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tbl_cirugias`
--
ALTER TABLE `tbl_cirugias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tbl_cirugias_multimedia`
--
ALTER TABLE `tbl_cirugias_multimedia`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tbl_compra_cab`
--
ALTER TABLE `tbl_compra_cab`
  ADD PRIMARY KEY (`com_num`);

--
-- Indices de la tabla `tbl_compra_det`
--
ALTER TABLE `tbl_compra_det`
  ADD PRIMARY KEY (`com_num`,`prod_id`),
  ADD KEY `fk_com_prod` (`prod_id`);

--
-- Indices de la tabla `tbl_consultas`
--
ALTER TABLE `tbl_consultas`
  ADD PRIMARY KEY (`con_num`,`pac_cod`),
  ADD UNIQUE KEY `sec` (`sec`),
  ADD KEY `fk_consultas_pacientes` (`pac_cod`);

--
-- Indices de la tabla `tbl_consultas_res`
--
ALTER TABLE `tbl_consultas_res`
  ADD PRIMARY KEY (`cons_res_num`),
  ADD KEY `fk_consres_pac` (`pac_cod`),
  ADD KEY `fk_consres_emp` (`emp_cod`),
  ADD KEY `fk_consres_cons` (`con_num`,`pac_cod`);

--
-- Indices de la tabla `tbl_cta_por_cobrar`
--
ALTER TABLE `tbl_cta_por_cobrar`
  ADD PRIMARY KEY (`num_cta`),
  ADD KEY `fk_cuenta_consultas` (`con_num`,`pac_cod`);

--
-- Indices de la tabla `tbl_det_factura`
--
ALTER TABLE `tbl_det_factura`
  ADD PRIMARY KEY (`id_det_factura`),
  ADD KEY `fk_detalle_factura` (`id_fac`),
  ADD KEY `num_cta` (`num_cta`);

--
-- Indices de la tabla `tbl_diagnosticos`
--
ALTER TABLE `tbl_diagnosticos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo` (`codigo`);

--
-- Indices de la tabla `tbl_documentos`
--
ALTER TABLE `tbl_documentos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tbl_documentos_formato`
--
ALTER TABLE `tbl_documentos_formato`
  ADD PRIMARY KEY (`id_df`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `tbl_documentos_poliza`
--
ALTER TABLE `tbl_documentos_poliza`
  ADD PRIMARY KEY (`cod_doc`);

--
-- Indices de la tabla `tbl_empleados`
--
ALTER TABLE `tbl_empleados`
  ADD PRIMARY KEY (`emp_cod`),
  ADD KEY `fk_empleado_tipo` (`typ_cod`);

--
-- Indices de la tabla `tbl_estudios`
--
ALTER TABLE `tbl_estudios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tbl_examenes`
--
ALTER TABLE `tbl_examenes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tbl_examenes_img`
--
ALTER TABLE `tbl_examenes_img`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tbl_examenes_solicitud`
--
ALTER TABLE `tbl_examenes_solicitud`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tbl_factura`
--
ALTER TABLE `tbl_factura`
  ADD PRIMARY KEY (`id_fac`),
  ADD UNIQUE KEY `fac_num` (`fac_num`),
  ADD KEY `fk_factura_empleados` (`fac_estado`),
  ADD KEY `fac_estado` (`fac_estado`),
  ADD KEY `id_suc` (`id_suc`);

--
-- Indices de la tabla `tbl_images`
--
ALTER TABLE `tbl_images`
  ADD PRIMARY KEY (`img_cod`);

--
-- Indices de la tabla `tbl_images_pacientes`
--
ALTER TABLE `tbl_images_pacientes`
  ADD PRIMARY KEY (`ima_pac_cod`);

--
-- Indices de la tabla `tbl_modules`
--
ALTER TABLE `tbl_modules`
  ADD PRIMARY KEY (`mod_cod`),
  ADD UNIQUE KEY `mod_ref` (`mod_ref`);

--
-- Indices de la tabla `tbl_pacientes`
--
ALTER TABLE `tbl_pacientes`
  ADD PRIMARY KEY (`pac_cod`),
  ADD UNIQUE KEY `pac_ced` (`pac_ced`);

--
-- Indices de la tabla `tbl_paciente_historial`
--
ALTER TABLE `tbl_paciente_historial`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tbl_pagopac_cab`
--
ALTER TABLE `tbl_pagopac_cab`
  ADD PRIMARY KEY (`pag_num`),
  ADD KEY `fk_pagopacientes_empleados` (`id_fac`),
  ADD KEY `fk_pagopacientes_pacientes` (`id_sucursal`);

--
-- Indices de la tabla `tbl_pagopac_det`
--
ALTER TABLE `tbl_pagopac_det`
  ADD PRIMARY KEY (`sec_pag`),
  ADD KEY `pag_num` (`pag_num`);

--
-- Indices de la tabla `tbl_polizas`
--
ALTER TABLE `tbl_polizas`
  ADD PRIMARY KEY (`cod_pol`);

--
-- Indices de la tabla `tbl_sesiones`
--
ALTER TABLE `tbl_sesiones`
  ADD PRIMARY KEY (`ses_num`,`ter_num`),
  ADD KEY `fk_sesiones_terapias` (`ter_num`),
  ADD KEY `fk_sesiones_empleados` (`emp_cod`);

--
-- Indices de la tabla `tbl_sucursales`
--
ALTER TABLE `tbl_sucursales`
  ADD PRIMARY KEY (`id_suc`);

--
-- Indices de la tabla `tbl_terapias`
--
ALTER TABLE `tbl_terapias`
  ADD PRIMARY KEY (`ter_num`),
  ADD KEY `fk_terapias_consultas` (`con_num`,`pac_cod`);

--
-- Indices de la tabla `tbl_tratamientos`
--
ALTER TABLE `tbl_tratamientos`
  ADD PRIMARY KEY (`tid`);

--
-- Indices de la tabla `tbl_tratamientos_det`
--
ALTER TABLE `tbl_tratamientos_det`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tbl_types`
--
ALTER TABLE `tbl_types`
  ADD PRIMARY KEY (`typ_cod`);

--
-- Indices de la tabla `tbl_user_access`
--
ALTER TABLE `tbl_user_access`
  ADD PRIMARY KEY (`access_id`);

--
-- Indices de la tabla `tbl_user_system`
--
ALTER TABLE `tbl_user_system`
  ADD PRIMARY KEY (`user_cod`),
  ADD KEY `fk_usuario_empleado` (`emp_cod`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `db_auditoria`
--
ALTER TABLE `db_auditoria`
  MODIFY `id_aud` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `db_auditoria_detalle`
--
ALTER TABLE `db_auditoria_detalle`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `db_iess`
--
ALTER TABLE `db_iess`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key ID REPORTE';

--
-- AUTO_INCREMENT de la tabla `db_iess_diag`
--
ALTER TABLE `db_iess_diag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `db_iess_evo`
--
ALTER TABLE `db_iess_evo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `db_iess_pres`
--
ALTER TABLE `db_iess_pres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `db_iess_sig`
--
ALTER TABLE `db_iess_sig`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_cirugias`
--
ALTER TABLE `tbl_cirugias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_cirugias_multimedia`
--
ALTER TABLE `tbl_cirugias_multimedia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_compra_cab`
--
ALTER TABLE `tbl_compra_cab`
  MODIFY `com_num` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_consultas`
--
ALTER TABLE `tbl_consultas`
  MODIFY `sec` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_consultas_res`
--
ALTER TABLE `tbl_consultas_res`
  MODIFY `cons_res_num` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_cta_por_cobrar`
--
ALTER TABLE `tbl_cta_por_cobrar`
  MODIFY `num_cta` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_det_factura`
--
ALTER TABLE `tbl_det_factura`
  MODIFY `id_det_factura` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_diagnosticos`
--
ALTER TABLE `tbl_diagnosticos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT de la tabla `tbl_documentos`
--
ALTER TABLE `tbl_documentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID Documento';

--
-- AUTO_INCREMENT de la tabla `tbl_documentos_formato`
--
ALTER TABLE `tbl_documentos_formato`
  MODIFY `id_df` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID Documento formato';

--
-- AUTO_INCREMENT de la tabla `tbl_documentos_poliza`
--
ALTER TABLE `tbl_documentos_poliza`
  MODIFY `cod_doc` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_empleados`
--
ALTER TABLE `tbl_empleados`
  MODIFY `emp_cod` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `tbl_estudios`
--
ALTER TABLE `tbl_estudios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_examenes`
--
ALTER TABLE `tbl_examenes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_examenes_img`
--
ALTER TABLE `tbl_examenes_img`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_examenes_solicitud`
--
ALTER TABLE `tbl_examenes_solicitud`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID Documento';

--
-- AUTO_INCREMENT de la tabla `tbl_factura`
--
ALTER TABLE `tbl_factura`
  MODIFY `id_fac` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_images`
--
ALTER TABLE `tbl_images`
  MODIFY `img_cod` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_images_pacientes`
--
ALTER TABLE `tbl_images_pacientes`
  MODIFY `ima_pac_cod` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_modules`
--
ALTER TABLE `tbl_modules`
  MODIFY `mod_cod` smallint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `tbl_pacientes`
--
ALTER TABLE `tbl_pacientes`
  MODIFY `pac_cod` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_paciente_historial`
--
ALTER TABLE `tbl_paciente_historial`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_pagopac_cab`
--
ALTER TABLE `tbl_pagopac_cab`
  MODIFY `pag_num` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_pagopac_det`
--
ALTER TABLE `tbl_pagopac_det`
  MODIFY `sec_pag` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_polizas`
--
ALTER TABLE `tbl_polizas`
  MODIFY `cod_pol` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_sucursales`
--
ALTER TABLE `tbl_sucursales`
  MODIFY `id_suc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tbl_terapias`
--
ALTER TABLE `tbl_terapias`
  MODIFY `ter_num` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_tratamientos`
--
ALTER TABLE `tbl_tratamientos`
  MODIFY `tid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_tratamientos_det`
--
ALTER TABLE `tbl_tratamientos_det`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_types`
--
ALTER TABLE `tbl_types`
  MODIFY `typ_cod` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=496;

--
-- AUTO_INCREMENT de la tabla `tbl_user_access`
--
ALTER TABLE `tbl_user_access`
  MODIFY `access_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_user_system`
--
ALTER TABLE `tbl_user_system`
  MODIFY `user_cod` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `db_auditoria_detalle`
--
ALTER TABLE `db_auditoria_detalle`
  ADD CONSTRAINT `fk_auddet_auditoria` FOREIGN KEY (`id_aud`) REFERENCES `db_auditoria` (`id_aud`);

--
-- Filtros para la tabla `tbl_compra_det`
--
ALTER TABLE `tbl_compra_det`
  ADD CONSTRAINT `fk_com_cab` FOREIGN KEY (`com_num`) REFERENCES `tbl_compra_cab` (`com_num`),
  ADD CONSTRAINT `fk_com_prod` FOREIGN KEY (`prod_id`) REFERENCES `tbl_productos` (`prod_id`);

--
-- Filtros para la tabla `tbl_consultas`
--
ALTER TABLE `tbl_consultas`
  ADD CONSTRAINT `fk_consultas_pacientes` FOREIGN KEY (`pac_cod`) REFERENCES `tbl_pacientes` (`pac_cod`);

--
-- Filtros para la tabla `tbl_consultas_res`
--
ALTER TABLE `tbl_consultas_res`
  ADD CONSTRAINT `fk_consres_cons` FOREIGN KEY (`con_num`,`pac_cod`) REFERENCES `tbl_consultas` (`con_num`, `pac_cod`),
  ADD CONSTRAINT `fk_consres_emp` FOREIGN KEY (`emp_cod`) REFERENCES `tbl_empleados` (`emp_cod`),
  ADD CONSTRAINT `fk_consres_pac` FOREIGN KEY (`pac_cod`) REFERENCES `tbl_pacientes` (`pac_cod`);

--
-- Filtros para la tabla `tbl_cta_por_cobrar`
--
ALTER TABLE `tbl_cta_por_cobrar`
  ADD CONSTRAINT `fk_cuenta_consultas` FOREIGN KEY (`con_num`,`pac_cod`) REFERENCES `tbl_consultas` (`con_num`, `pac_cod`);

--
-- Filtros para la tabla `tbl_det_factura`
--
ALTER TABLE `tbl_det_factura`
  ADD CONSTRAINT `fk_detfac_ctaporcobrar` FOREIGN KEY (`num_cta`) REFERENCES `tbl_cta_por_cobrar` (`num_cta`),
  ADD CONSTRAINT `fk_detfac_fac` FOREIGN KEY (`id_fac`) REFERENCES `tbl_factura` (`id_fac`);

--
-- Filtros para la tabla `tbl_empleados`
--
ALTER TABLE `tbl_empleados`
  ADD CONSTRAINT `fk_empleado_tipo` FOREIGN KEY (`typ_cod`) REFERENCES `tbl_types` (`typ_cod`);

--
-- Filtros para la tabla `tbl_factura`
--
ALTER TABLE `tbl_factura`
  ADD CONSTRAINT `fk_fac_suc` FOREIGN KEY (`id_suc`) REFERENCES `tbl_sucursales` (`id_suc`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_pagopac_cab`
--
ALTER TABLE `tbl_pagopac_cab`
  ADD CONSTRAINT `fk_fac_pago` FOREIGN KEY (`id_fac`) REFERENCES `tbl_det_factura` (`id_fac`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_pagopac_det`
--
ALTER TABLE `tbl_pagopac_det`
  ADD CONSTRAINT `fk_cab_det_pag` FOREIGN KEY (`pag_num`) REFERENCES `tbl_pagopac_cab` (`pag_num`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tbl_sesiones`
--
ALTER TABLE `tbl_sesiones`
  ADD CONSTRAINT `fk_sesiones_empleados` FOREIGN KEY (`emp_cod`) REFERENCES `tbl_empleados` (`emp_cod`),
  ADD CONSTRAINT `fk_sesiones_terapias` FOREIGN KEY (`ter_num`) REFERENCES `tbl_terapias` (`ter_num`);

--
-- Filtros para la tabla `tbl_terapias`
--
ALTER TABLE `tbl_terapias`
  ADD CONSTRAINT `fk_terapias_consultas` FOREIGN KEY (`con_num`,`pac_cod`) REFERENCES `tbl_consultas` (`con_num`, `pac_cod`);

--
-- Filtros para la tabla `tbl_user_system`
--
ALTER TABLE `tbl_user_system`
  ADD CONSTRAINT `fk_usuario_empleado` FOREIGN KEY (`emp_cod`) REFERENCES `tbl_empleados` (`emp_cod`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
