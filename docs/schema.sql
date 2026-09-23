/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;
DROP TABLE IF EXISTS `db_auditoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_auditoria` (
  `id_aud` bigint(20) NOT NULL AUTO_INCREMENT,
  `aud_datet` datetime DEFAULT NULL,
  PRIMARY KEY (`id_aud`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci COMMENT='Auditoria Principal';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `db_auditoria_detalle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_auditoria_detalle` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_aud` bigint(20) NOT NULL,
  `user_cod` int(6) DEFAULT NULL,
  `audd_datet` datetime DEFAULT NULL,
  `audd_eve` varchar(255) DEFAULT NULL,
  `audd_des` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_auddet_auditoria` (`id_aud`),
  CONSTRAINT `fk_auddet_auditoria` FOREIGN KEY (`id_aud`) REFERENCES `db_auditoria` (`id_aud`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci COMMENT='Detalles de Auditoria';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `db_cirugias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_cirugias` (
  `id_cir` int(11) NOT NULL AUTO_INCREMENT,
  `con_num` bigint(20) DEFAULT NULL,
  `pac_cod` bigint(20) NOT NULL,
  `fecha` date NOT NULL,
  `diagnostico` text DEFAULT NULL,
  `cirugiap` varchar(100) DEFAULT NULL,
  `fechap` date DEFAULT NULL,
  `cirugiar` varchar(100) DEFAULT NULL,
  `fechar` date DEFAULT NULL,
  `protocolo` text DEFAULT NULL,
  `evolucion` varchar(20) DEFAULT NULL,
  `id_aud` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id_cir`),
  KEY `fk_cir_con` (`con_num`),
  CONSTRAINT `fk_cir_con` FOREIGN KEY (`con_num`) REFERENCES `db_consultas` (`con_num`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci COMMENT='Cirugias';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `db_cirugias_media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_cirugias_media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cir` int(11) NOT NULL,
  `id_med` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cirmed_cirugia` (`id_cir`),
  KEY `fk_cirmed_media` (`id_med`),
  CONSTRAINT `fk_cirmed_cirugia` FOREIGN KEY (`id_cir`) REFERENCES `db_cirugias` (`id_cir`),
  CONSTRAINT `fk_cirmed_media` FOREIGN KEY (`id_med`) REFERENCES `db_media` (`id_med`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci COMMENT='Multimedia de Cirugias';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `db_componentes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_componentes` (
  `mod_cod` smallint(3) NOT NULL AUTO_INCREMENT,
  `mod_ref` varchar(4) NOT NULL,
  `mod_nom` varchar(50) NOT NULL,
  `mod_des` varchar(100) DEFAULT NULL,
  `mod_icon` varchar(255) DEFAULT NULL,
  `mod_stat` char(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`mod_cod`),
  UNIQUE KEY `mod_ref` (`mod_ref`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci COMMENT='Componentes del Sistema';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `db_conf`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_conf` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ref` varchar(100) NOT NULL,
  `val` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `db_consultas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_consultas` (
  `con_num` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_ant` varchar(10) DEFAULT NULL,
  `pac_cod` bigint(20) NOT NULL DEFAULT 0,
  `con_fec` datetime DEFAULT NULL COMMENT 'Fecha-Hora de la Consulta',
  `con_upd` datetime DEFAULT NULL COMMENT 'Actualizacion',
  `con_fecp` date DEFAULT NULL COMMENT 'Fecha Proxima Visita',
  `con_diapc` smallint(6) DEFAULT NULL COMMENT 'Dias para proxima visita',
  `con_typ` int(6) DEFAULT NULL COMMENT 'ID Tipo Paciente Consulta',
  `con_typvis` int(6) DEFAULT NULL COMMENT 'Tipo de Visita Actual',
  `con_typvisP` int(11) DEFAULT NULL COMMENT 'Tipo Proxima Visitas',
  `con_typvisP_obs` varchar(255) DEFAULT NULL COMMENT 'Proxima Visita Observaciones',
  `con_seg` char(1) DEFAULT NULL COMMENT 'Seguimiento de Consulta',
  `con_val` double(8,2) DEFAULT NULL COMMENT 'Valor Consulta',
  `tip_pag` int(6) DEFAULT NULL COMMENT 'Tipo de Pago',
  `dcon_mot` text DEFAULT NULL COMMENT 'Motivo de la consulta',
  `dcon_enfa` text DEFAULT NULL,
  `dcon_obs` text DEFAULT NULL,
  `dcon_ef_agen` varchar(255) DEFAULT NULL,
  `dcon_ef_estn` varchar(255) DEFAULT NULL,
  `dcon_ef_muco` varchar(255) DEFAULT NULL,
  `dcon_ef_cavo` varchar(255) DEFAULT NULL,
  `dcon_ef_caud` varchar(255) DEFAULT NULL,
  `dcon_ef_fosn` varchar(255) DEFAULT NULL,
  `dcon_ef_cue` varchar(255) DEFAULT NULL,
  `dcon_ef_oro` varchar(255) DEFAULT NULL,
  `dcon_ef_obs` text DEFAULT NULL,
  `dcon_tor_ins` varchar(255) DEFAULT NULL,
  `dcon_tor_per` varchar(255) DEFAULT NULL,
  `dcon_tor_pal` varchar(255) DEFAULT NULL,
  `dcon_tor_aus` varchar(255) DEFAULT NULL,
  `id_aud` bigint(20) DEFAULT NULL,
  `con_stat` char(1) NOT NULL DEFAULT '0' COMMENT 'Estado de la consulta',
  PRIMARY KEY (`con_num`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `db_consultas_diagostico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_consultas_diagostico` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `con_num` bigint(20) NOT NULL,
  `id_diag` int(11) NOT NULL,
  `obs` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_condiag_con` (`con_num`),
  KEY `fk_condiag_diag` (`id_diag`),
  CONSTRAINT `fk_condiag_con` FOREIGN KEY (`con_num`) REFERENCES `db_consultas` (`con_num`),
  CONSTRAINT `fk_condiag_diag` FOREIGN KEY (`id_diag`) REFERENCES `db_diagnosticos` (`id_diag`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci COMMENT='Diagnosticos por Consultas';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `db_consultas_reserva`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_consultas_reserva` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pac_cod` bigint(20) NOT NULL,
  `fecha` datetime NOT NULL,
  `id_aud` bigint(20) NOT NULL,
  `estado` char(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci COMMENT='Reservas de Consultas';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `db_diagnosticos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_diagnosticos` (
  `id_diag` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(50) DEFAULT NULL,
  `nombre` varchar(255) NOT NULL,
  `val` varchar(255) DEFAULT NULL,
  `ref` varchar(255) DEFAULT NULL,
  `estado` char(1) DEFAULT '1',
  PRIMARY KEY (`id_diag`),
  UNIQUE KEY `codigo` (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci COMMENT='Diagnosticos';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `db_documentos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_documentos` (
  `id_doc` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID Documento (Archivo)',
  `id_df` int(11) DEFAULT NULL,
  `con_num` bigint(20) DEFAULT NULL COMMENT 'ID Consulta',
  `pac_cod` bigint(20) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `contenido` longtext DEFAULT NULL COMMENT 'Contenido Documento',
  `fecha` date DEFAULT NULL COMMENT 'Fecha de Creación del Documento',
  `idA` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id_doc`),
  KEY `fk_doc_con` (`con_num`),
  CONSTRAINT `fk_doc_con` FOREIGN KEY (`con_num`) REFERENCES `db_consultas` (`con_num`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci COMMENT='Documentos';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `db_documentos_formato`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_documentos_formato` (
  `id_df` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID Documento formato',
  `nombre` varchar(100) DEFAULT NULL COMMENT 'Nombre del Documento formato',
  `formato` longtext DEFAULT NULL COMMENT 'Formato del Documento',
  `status` char(1) NOT NULL DEFAULT '1',
  `idA` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id_df`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci COMMENT='Formatos para Documentos';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `db_empleados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_empleados` (
  `emp_cod` int(6) NOT NULL AUTO_INCREMENT,
  `typ_cod` int(6) NOT NULL,
  `emp_ced` varchar(15) DEFAULT NULL,
  `emp_nom` varchar(50) DEFAULT NULL,
  `emp_ape` varchar(50) DEFAULT NULL,
  `emp_esp` varchar(50) DEFAULT NULL COMMENT 'Especialidad del Medico - info para Documentos	',
  `emp_dir` varchar(100) DEFAULT NULL,
  `emp_tel` varchar(15) DEFAULT NULL,
  `emp_cel` varchar(15) DEFAULT NULL,
  `emp_mail` varchar(100) DEFAULT NULL,
  `id_med` bigint(20) DEFAULT NULL,
  `emp_status` char(1) NOT NULL DEFAULT '1',
  `id_aud` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`emp_cod`),
  KEY `fk_emp_typ` (`typ_cod`),
  CONSTRAINT `fk_emp_typ` FOREIGN KEY (`typ_cod`) REFERENCES `db_types` (`typ_cod`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `db_examenes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_examenes` (
  `id_exa` int(11) NOT NULL AUTO_INCREMENT,
  `id_ef` int(11) NOT NULL COMMENT 'db_examenes_format.id',
  `con_num` bigint(20) DEFAULT NULL,
  `pac_cod` bigint(20) NOT NULL,
  `fecha` date NOT NULL,
  `fechae` date DEFAULT NULL,
  `typ_cod` int(6) DEFAULT NULL,
  `enc` text DEFAULT NULL,
  `des` longtext DEFAULT NULL,
  `pie` text DEFAULT NULL,
  `obs` text DEFAULT NULL,
  `resultado` text DEFAULT NULL,
  PRIMARY KEY (`id_exa`),
  KEY `fk_exa_con` (`con_num`),
  CONSTRAINT `fk_exa_con` FOREIGN KEY (`con_num`) REFERENCES `db_consultas` (`con_num`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci COMMENT='Registro de Examenes';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `db_examenes_det`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_examenes_det` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ide` int(11) NOT NULL,
  `idefd` int(11) DEFAULT NULL,
  `des` text DEFAULT NULL,
  `res` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci COMMENT='Detalles tipos de examenes resultados';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `db_examenes_format`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_examenes_format` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_ant` int(11) DEFAULT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `enc` text DEFAULT NULL,
  `des` text DEFAULT NULL,
  `pie` text DEFAULT NULL,
  `idA` bigint(20) DEFAULT NULL,
  `stat` char(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `db_examenes_format_det`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_examenes_format_det` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idef` int(11) NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `val` text DEFAULT NULL,
  `sel` char(1) DEFAULT '1',
  `act` char(1) DEFAULT '1',
  `est` char(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `db_examenes_media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_examenes_media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_exa` int(11) NOT NULL,
  `id_med` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_examed_examen` (`id_exa`),
  KEY `fk_examed_media` (`id_med`),
  CONSTRAINT `fk_examed_examen` FOREIGN KEY (`id_exa`) REFERENCES `db_examenes` (`id_exa`),
  CONSTRAINT `fk_examed_media` FOREIGN KEY (`id_med`) REFERENCES `db_media` (`id_med`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci COMMENT='Multimedia de Examenes';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `db_fullcalendar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_fullcalendar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fechai` date NOT NULL,
  `fechaf` date DEFAULT NULL,
  `horai` time DEFAULT NULL,
  `horaf` time DEFAULT NULL,
  `pac_cod` bigint(20) DEFAULT NULL,
  `typ_cod` int(6) DEFAULT NULL COMMENT 'Tipo de Visita TIPVIS',
  `obs` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `zona` varchar(6) DEFAULT '-05:00',
  `est` char(1) NOT NULL DEFAULT '1',
  `id_aud` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci COMMENT='fullcalendar';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `db_iess`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_iess` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key ID REPORTE',
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
  `planes` varchar(400) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci COMMENT='REPORTE IESS - main table';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `db_iess_diag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_iess_diag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rep` int(11) NOT NULL,
  `diag` varchar(50) DEFAULT NULL,
  `cie` varchar(15) DEFAULT NULL,
  `tip` char(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci COMMENT='Reporte IESS Diagnosticos';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `db_iess_evo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_iess_evo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rep` int(11) NOT NULL,
  `fecha` varchar(10) DEFAULT NULL,
  `hora` varchar(5) DEFAULT NULL,
  `notas` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci COMMENT='Reporte IESS Evolucion';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `db_iess_pres`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_iess_pres` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rep` int(11) NOT NULL,
  `farmaco` varchar(100) DEFAULT NULL,
  `admin` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci COMMENT='Reporte IESS Prescripcion';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `db_iess_sig`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_iess_sig` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rep` int(11) NOT NULL COMMENT 'Id Reporte IESS db_iess',
  `fecha` date DEFAULT NULL,
  `temp` varchar(10) DEFAULT NULL,
  `presA` int(11) DEFAULT NULL,
  `presB` int(11) DEFAULT NULL,
  `puls` int(11) DEFAULT NULL,
  `frec` int(11) DEFAULT NULL,
  `peso` varchar(10) DEFAULT NULL,
  `talla` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci COMMENT='Reporte IESS Signos';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `db_indicaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_indicaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_ant` int(11) DEFAULT NULL,
  `des` text DEFAULT NULL,
  `feat` char(1) DEFAULT '0',
  `est` char(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci COMMENT='Indicaciones médicas para tratamiento';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `db_media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_media` (
  `id_med` bigint(20) NOT NULL AUTO_INCREMENT,
  `file` varchar(255) NOT NULL,
  `des` text DEFAULT NULL,
  `estado` char(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_med`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci COMMENT='Table Media Files';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `db_medicamentos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_medicamentos` (
  `id_form` int(11) NOT NULL AUTO_INCREMENT,
  `id_ant` int(11) DEFAULT NULL,
  `lab` int(11) DEFAULT NULL,
  `generico` varchar(50) DEFAULT NULL,
  `comercial` varchar(255) DEFAULT NULL,
  `presentacion` varchar(50) DEFAULT NULL,
  `cantidad` varchar(20) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` char(1) NOT NULL DEFAULT '1',
  `idA` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id_form`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci COMMENT='MEDICAMENTOS';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `db_medicamentos_grp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_medicamentos_grp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idp` int(11) NOT NULL,
  `idm` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci COMMENT='Medicamentos Agrupacion';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `db_menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) DEFAULT NULL,
  `ref` varchar(50) DEFAULT NULL,
  `stat` char(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci COMMENT='Menus Contenedores';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `db_menus_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_menus_items` (
  `men_id` int(11) NOT NULL AUTO_INCREMENT,
  `men_idc` int(11) NOT NULL COMMENT 'Id del Menu Contenedor',
  `men_padre` int(11) NOT NULL,
  `men_nombre` varchar(50) NOT NULL,
  `men_tit` varchar(100) DEFAULT NULL,
  `men_icon` varchar(255) DEFAULT NULL,
  `men_css` varchar(50) DEFAULT NULL,
  `men_precode` varchar(255) DEFAULT NULL,
  `men_postcode` varchar(255) DEFAULT NULL,
  `men_link` varchar(200) DEFAULT NULL,
  `men_orden` int(11) DEFAULT 1,
  `mod_cod` smallint(3) DEFAULT NULL,
  `men_stat` char(1) DEFAULT '1',
  PRIMARY KEY (`men_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `db_menus_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_menus_user` (
  `men_usu_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_cod` int(11) NOT NULL,
  `men_id` int(11) NOT NULL,
  PRIMARY KEY (`men_usu_id`),
  KEY `usr_id` (`user_cod`),
  KEY `men_id` (`men_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `db_paciente_hc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_paciente_hc` (
  `hc_id` int(11) NOT NULL AUTO_INCREMENT,
  `pac_cod` bigint(20) NOT NULL,
  `hc_cir_pre` text DEFAULT NULL,
  `hc_antf` text DEFAULT NULL,
  `hc_antp` text DEFAULT NULL,
  `hc_hab` text DEFAULT NULL,
  `hc_ale` text DEFAULT NULL,
  `hc_cli` text DEFAULT NULL,
  `hc_qui` text DEFAULT NULL,
  `hc_tmed` text DEFAULT NULL,
  `hc_cau_inf` text DEFAULT NULL,
  `hc_cic_ra` text DEFAULT NULL,
  `hc_obs` text DEFAULT NULL,
  `hc_ant` longtext DEFAULT NULL,
  `hc_fuma` int(6) DEFAULT NULL,
  `hc_fumat` text DEFAULT NULL,
  `hc_fumac` text DEFAULT NULL,
  `hc_alco` int(6) DEFAULT NULL,
  `hc_alcot` text DEFAULT NULL,
  `hc_alcoc` text DEFAULT NULL,
  `hc_drog` int(6) DEFAULT NULL,
  `hc_drogt` text DEFAULT NULL,
  `hc_drogc` text DEFAULT NULL,
  `hc_depo` text DEFAULT NULL,
  `hc_fum` date DEFAULT NULL COMMENT 'Fecha de Ultima Menstruación',
  PRIMARY KEY (`hc_id`),
  KEY `fk_hc_paciente` (`pac_cod`),
  CONSTRAINT `fk_hc_paciente` FOREIGN KEY (`pac_cod`) REFERENCES `db_pacientes` (`pac_cod`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci COMMENT='Historia Clinica Paciente';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `db_pacientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_pacientes` (
  `pac_cod` bigint(20) NOT NULL AUTO_INCREMENT,
  `pac_ced` varchar(15) DEFAULT NULL COMMENT 'Cedula / RUC / Pasaporte',
  `pac_fec` date DEFAULT NULL COMMENT 'Fecha de Nacimiento',
  `pac_reg` date DEFAULT NULL COMMENT 'Fecha de Registro del Paciente',
  `pac_nom` varchar(50) NOT NULL,
  `pac_ape` varchar(50) NOT NULL,
  `pac_lugp` varchar(20) DEFAULT NULL COMMENT 'Lugar Procedencia del Paciente',
  `pac_lugr` varchar(20) DEFAULT NULL COMMENT 'Lugar Residencia del Paciente',
  `pac_sect` int(6) DEFAULT NULL COMMENT 'Sector de Vivienda, Urbano - Rural',
  `pac_dir` varchar(100) DEFAULT NULL,
  `pac_tel1` varchar(15) DEFAULT NULL,
  `pac_tel2` varchar(15) DEFAULT NULL,
  `pac_email` varchar(60) DEFAULT NULL COMMENT 'E-mail del paciente',
  `pac_tipsan` int(6) DEFAULT NULL COMMENT 'ID Tipo de Sangre',
  `pac_estciv` int(6) DEFAULT NULL COMMENT 'ID Estado Civil',
  `pac_hijos` tinyint(4) DEFAULT NULL,
  `pac_sexo` int(6) DEFAULT NULL,
  `pac_raza` int(11) DEFAULT NULL,
  `pac_ins` int(6) DEFAULT NULL COMMENT 'Instrucción / Educación',
  `pac_pro` varchar(20) DEFAULT NULL COMMENT 'Profesion del Paciente',
  `pac_emp` varchar(20) DEFAULT NULL COMMENT 'Empresa donde trabaja',
  `pac_ocu` varchar(20) DEFAULT NULL COMMENT 'Ocupación del Paciente',
  `pac_nompar` varchar(50) DEFAULT NULL COMMENT 'Emergencia - Nombre',
  `pac_fecpar` date DEFAULT NULL,
  `pac_tipsanpar` int(6) DEFAULT NULL,
  `pac_telpar` varchar(15) DEFAULT NULL COMMENT 'Emergencia - Telefono',
  `pac_ocupar` varchar(100) DEFAULT NULL,
  `publi` int(6) DEFAULT NULL,
  `pac_tipst` int(6) DEFAULT NULL,
  `pac_obs` text DEFAULT NULL,
  `id_aud` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`pac_cod`),
  UNIQUE KEY `pac_ced` (`pac_ced`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci COMMENT='DATOS DEL PACIENTE';
/*!40101 SET character_set_client = @saved_cs_client */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb3 */ ;
/*!50003 SET character_set_results = utf8mb3 */ ;
/*!50003 SET collation_connection  = utf8mb3_uca1400_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`%`*/ /*!50003 TRIGGER `db_pacientes_AFTER_INSERT` AFTER INSERT ON `clinic_asanchez`.`db_pacientes` FOR EACH ROW BEGIN
 INSERT INTO db_pacientes_nom (pac_cod,pac_nom,pac_ape) 
 VALUES (NEW.pac_cod,NEW.pac_nom,NEW.pac_ape);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb3 */ ;
/*!50003 SET character_set_results = utf8mb3 */ ;
/*!50003 SET collation_connection  = utf8mb3_uca1400_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`%`*/ /*!50003 TRIGGER `update_before_pacientes` AFTER UPDATE ON `clinic_asanchez`.`db_pacientes` FOR EACH ROW BEGIN
 IF EXISTS(SELECT * FROM db_pacientes_nom WHERE pac_cod=old.pac_cod) THEN
  UPDATE db_pacientes_nom SET pac_nom=new.pac_nom , pac_ape=new.pac_ape WHERE pac_cod=old.pac_cod;
 ELSE
  INSERT INTO db_pacientes_nom (pac_cod,pac_nom, pac_ape) values (NEW.pac_cod,NEW.pac_nom,NEW.pac_ape);
 END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb3 */ ;
/*!50003 SET character_set_results = utf8mb3 */ ;
/*!50003 SET collation_connection  = utf8mb3_uca1400_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`%`*/ /*!50003 TRIGGER `delete_before_pacientes` BEFORE DELETE ON `clinic_asanchez`.`db_pacientes` FOR EACH ROW BEGIN
 DELETE FROM db_pacientes_nom
 WHERE pac_cod=old.pac_cod;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
DROP TABLE IF EXISTS `db_pacientes_gin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_pacientes_gin` (
  `gin_id` int(11) NOT NULL AUTO_INCREMENT,
  `pac_cod` bigint(20) NOT NULL,
  `gin_men` varchar(50) DEFAULT NULL,
  `gin_fun` date DEFAULT NULL,
  `gin_ges` varchar(50) DEFAULT NULL,
  `gin_pnor` varchar(50) DEFAULT NULL,
  `gin_pces` varchar(50) DEFAULT NULL,
  `gin_abo` varchar(50) DEFAULT NULL,
  `gin_hviv` varchar(50) DEFAULT NULL,
  `gin_hmue` varchar(50) DEFAULT NULL,
  `gin_mes` varchar(50) DEFAULT NULL,
  `gin_cicm` varchar(50) DEFAULT NULL,
  `gin_obs` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`gin_id`),
  KEY `fk_gin_pac` (`pac_cod`),
  CONSTRAINT `fk_gin_pac` FOREIGN KEY (`pac_cod`) REFERENCES `db_pacientes` (`pac_cod`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `db_pacientes_media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_pacientes_media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cod_pac` bigint(20) NOT NULL,
  `id_med` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_pacmed_paciente` (`cod_pac`),
  KEY `fk_pacmed_media` (`id_med`),
  CONSTRAINT `fk_pacmed_media` FOREIGN KEY (`id_med`) REFERENCES `db_media` (`id_med`),
  CONSTRAINT `fk_pacmed_paciente` FOREIGN KEY (`cod_pac`) REFERENCES `db_pacientes` (`pac_cod`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci COMMENT='Multimedia de Pacientes';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `db_pacientes_nom`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_pacientes_nom` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pac_cod` bigint(20) NOT NULL,
  `pac_nom` varchar(500) DEFAULT NULL,
  `pac_ape` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `FTEXTPACSEARCH` (`pac_nom`,`pac_ape`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci COMMENT='Tabla con el Nombre Completo del Paciente para Busqueda FULL';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `db_rep_eco`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_rep_eco` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `con_num` int(6) DEFAULT NULL,
  `pac_cod` int(11) NOT NULL COMMENT 'Código Paciente',
  `fechar` date NOT NULL COMMENT 'Fecha Registro',
  `fechae` date DEFAULT NULL COMMENT 'Fecha Ecografia',
  `tipo` int(11) DEFAULT NULL,
  `rec_utero` text DEFAULT NULL,
  `rec_ovder` text DEFAULT NULL,
  `obs_ovder` varchar(255) DEFAULT NULL,
  `rec_ovizq` text DEFAULT NULL,
  `obs_ovizq` varchar(255) DEFAULT NULL,
  `eco_hall` longtext DEFAULT NULL,
  `eco_ohall` longtext DEFAULT NULL,
  `eco_diag` text DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `est` char(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci COMMENT='Reporte Ecografico';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `db_rep_eco_media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_rep_eco_media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_eco` int(11) NOT NULL,
  `id_med` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci COMMENT='Multimedia de Reportes Ecografico';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `db_rep_obs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_rep_obs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `con_num` int(6) DEFAULT NULL,
  `pac_cod` int(11) NOT NULL COMMENT 'Código Paciente',
  `fechar` date NOT NULL COMMENT 'Fecha Registro',
  `fechae` date DEFAULT NULL COMMENT 'Fecha Ecografia',
  `fum` date DEFAULT NULL COMMENT 'FUM',
  `file` varchar(255) DEFAULT NULL,
  `est` char(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci COMMENT='Reporte Obstetrico';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `db_rep_obs_detalle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_rep_obs_detalle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rep` int(1) NOT NULL,
  `eg_fum` varchar(20) DEFAULT NULL,
  `eg_us` varchar(20) DEFAULT NULL,
  `fpp_fum` date DEFAULT NULL,
  `fpp_ga` date DEFAULT NULL,
  `pes_fet` varchar(20) DEFAULT NULL,
  `num_fet` smallint(6) DEFAULT NULL,
  `posicion` int(11) DEFAULT NULL,
  `presentacion` int(11) DEFAULT NULL,
  `val_bio` longtext DEFAULT NULL COMMENT 'Valoración Biométrica',
  `cocientes` longtext DEFAULT NULL COMMENT 'Cocientes',
  `fcf` varchar(20) DEFAULT NULL COMMENT 'Frecuencia Cardiaca Feto [C]',
  `liq_ami` int(11) DEFAULT NULL COMMENT 'Liquido Amiotico [C]',
  `placenta` int(11) DEFAULT NULL COMMENT 'Placenta [C]',
  `grado` varchar(20) DEFAULT NULL,
  `va_snc` int(11) DEFAULT NULL COMMENT 'S.N.C [C]',
  `va_cerebelo` int(11) DEFAULT NULL COMMENT 'Cerebelo [C]',
  `va_vent_lat` int(11) DEFAULT NULL COMMENT 'VentLat [C]',
  `va_estomago` int(11) DEFAULT NULL COMMENT 'Estomago [C]',
  `va_par_abd` int(11) DEFAULT NULL COMMENT 'Pared Abdominal [C]',
  `va_4camcar` int(11) DEFAULT NULL COMMENT '4 Cámaras Cardiácas [C]',
  `va_vejiga` int(11) DEFAULT NULL COMMENT 'Vejiga [C]',
  `va_rin` int(11) DEFAULT NULL COMMENT 'Riñones [C]',
  `va_col` int(11) DEFAULT NULL COMMENT 'Columna [C]',
  `va_cor_umb` int(11) DEFAULT NULL COMMENT 'Cordón Umbilical [C]',
  `va_ext` int(11) DEFAULT NULL COMMENT 'Extremidades [C]',
  `va_sex` int(11) DEFAULT NULL COMMENT 'Sexo [C]',
  `obs` text DEFAULT NULL,
  `est` char(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci COMMENT='Reporte Obstetrico detalle';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `db_rep_obs_media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_rep_obs_media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rep` int(11) NOT NULL,
  `id_med` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci COMMENT='Multimedia de Reportes';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `db_signos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_signos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pac_cod` bigint(20) NOT NULL,
  `fecha` date NOT NULL,
  `peso` double(6,2) DEFAULT NULL,
  `pa` varchar(10) DEFAULT NULL COMMENT 'Tension Arterial',
  `fc` mediumint(9) DEFAULT NULL COMMENT 'Frecuencia Cardiaca',
  `fr` mediumint(9) DEFAULT NULL COMMENT 'Frecuencia Respiratoria',
  `po2` mediumint(9) DEFAULT NULL COMMENT 'Presion de Oxigeno',
  `co2` mediumint(9) DEFAULT NULL COMMENT 'co2',
  `talla` double(6,2) DEFAULT NULL COMMENT 'Talla del paciente',
  `imc` double(6,2) DEFAULT NULL COMMENT 'Indice de Masa Corporal',
  `temp` double(5,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_signos_paciente` (`pac_cod`),
  CONSTRAINT `fk_signos_paciente` FOREIGN KEY (`pac_cod`) REFERENCES `db_pacientes` (`pac_cod`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci COMMENT='Historial Signos Vitales Paciente';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `db_sucursales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_sucursales` (
  `id_suc` int(11) NOT NULL AUTO_INCREMENT,
  `nom_suc` varchar(45) DEFAULT NULL,
  `dir_suc` varchar(45) DEFAULT NULL,
  `tel_suc` varchar(45) DEFAULT NULL,
  `num_fact_ini` int(11) NOT NULL,
  `est_suc` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`id_suc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `db_tratamientos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_tratamientos` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `con_num` bigint(20) DEFAULT NULL,
  `pac_cod` bigint(20) DEFAULT NULL,
  `diagnostico` varchar(255) DEFAULT NULL,
  `fecha` date NOT NULL,
  `fechap` date DEFAULT NULL COMMENT 'Proxima Cita',
  `obs` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`tid`),
  KEY `fk_tratamiento_consulta` (`con_num`),
  CONSTRAINT `fk_tratamiento_consulta` FOREIGN KEY (`con_num`) REFERENCES `db_consultas` (`con_num`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci COMMENT='Tratamientos de Consultas';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `db_tratamientos_detalle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_tratamientos_detalle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tid` int(11) NOT NULL,
  `idref` int(11) DEFAULT NULL,
  `tip` char(1) DEFAULT NULL COMMENT 'Tipo: M=Medicamento, I=Indicacion',
  `generico` varchar(255) DEFAULT NULL,
  `comercial` varchar(255) DEFAULT NULL,
  `presentacion` varchar(50) DEFAULT NULL,
  `cantidad` varchar(20) DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `indicacion` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_tratdet_tratamiento` (`tid`),
  CONSTRAINT `fk_tratdet_tratamiento` FOREIGN KEY (`tid`) REFERENCES `db_tratamientos` (`tid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci COMMENT='Detalle (Medicamentos, instrucciones) del Tratamiento';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `db_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_types` (
  `typ_cod` int(6) NOT NULL AUTO_INCREMENT,
  `mod_cod` varchar(50) DEFAULT NULL,
  `typ_nom` varchar(100) DEFAULT NULL,
  `typ_ref` varchar(15) NOT NULL,
  `typ_val` varchar(50) NOT NULL,
  `typ_aux` varchar(50) DEFAULT NULL,
  `typ_ord` smallint(6) DEFAULT 1,
  `typ_icon` varchar(50) DEFAULT NULL,
  `typ_stat` char(1) NOT NULL DEFAULT '1',
  `typ_pre` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`typ_cod`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci COMMENT='Typos para el Sistema';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `db_user_system`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_user_system` (
  `user_cod` int(6) NOT NULL AUTO_INCREMENT,
  `emp_cod` int(6) NOT NULL,
  `user_username` varchar(20) NOT NULL,
  `user_password` varchar(32) NOT NULL,
  `user_level` char(1) NOT NULL DEFAULT '5',
  `user_status` char(1) NOT NULL DEFAULT '1',
  `user_theme` varchar(20) DEFAULT NULL,
  `id_aud` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`user_cod`),
  UNIQUE KEY `user_username` (`user_username`),
  KEY `fk_usuario_empleado` (`emp_cod`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci COMMENT='User System';
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

