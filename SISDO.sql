/*
 Navicat Premium Data Transfer

 Source Server         : BDproduccion1.12
 Source Server Type    : PostgreSQL
 Source Server Version : 130005
 Source Host           : 192.168.1.12:5432
 Source Catalog        : sisdo
 Source Schema         : public

 Target Server Type    : MySQL
 Target Server Version : 80099
 File Encoding         : 65001

 Date: 10/03/2023 17:51:13
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for definicion_status
-- ----------------------------
DROP TABLE IF EXISTS `definicion_status`;
CREATE TABLE `definicion_status`  (
  `id_defsta` int NOT NULL,
  `nombre_defsta` varchar(50) NULL,
  PRIMARY KEY (`id_defsta`)
);

-- ----------------------------
-- Table structure for departamento
-- ----------------------------
DROP TABLE IF EXISTS `departamento`;
CREATE TABLE `departamento`  (
  `id_dep` int NOT NULL,
  `departamento` varchar(50) NULL,
  PRIMARY KEY (`id_dep`)
);

-- ----------------------------
-- Table structure for donaciones
-- ----------------------------
DROP TABLE IF EXISTS `donaciones`;
CREATE TABLE `donaciones`  (
  `id_donaci` int NOT NULL,
  `nombre_donaci` varchar(50) NOT NULL,
  `id_tipdon1` int NOT NULL,
  PRIMARY KEY (`id_donaci`),
  INDEX `id_donaci1`(`id_donaci` ASC) USING BTREE,
  INDEX `id_tipdon`(`id_tipdon1` ASC) USING BTREE,
  CONSTRAINT `donaciones` FOREIGN KEY (`id_tipdon1`) REFERENCES `tipo_donaciones` (`id_tipdon`),
  CONSTRAINT `donaciones_ibfk_1` FOREIGN KEY (`id_tipdon1`) REFERENCES `tipo_donaciones` (`id_tipdon`)
);

-- ----------------------------
-- Table structure for listado
-- ----------------------------
DROP TABLE IF EXISTS `listado`;
CREATE TABLE `listado`  (
  `id_listado` int NOT NULL,
  `nac` varchar(2) NULL,
  `cedula` int NULL,
  `apellidos` varchar(60) NULL,
  `nombres` varchar(60) NULL,
  `sexo` varchar(5) NULL,
  `fecha_nacimiento` date NULL,
  `telefonos` varchar(40) NULL,
  `parroquia` int NULL,
  `sector` varchar(30) NULL,
  PRIMARY KEY (`id_listado`)
);

-- ----------------------------
-- Table structure for localidades
-- ----------------------------
DROP TABLE IF EXISTS `localidades`;
CREATE TABLE `localidades`  (
  `id_localidades` int NOT NULL,
  `cod_estado` int NOT NULL,
  `id_municipio` int NOT NULL,
  `id_parroquia` int NULL,
  `name_estado` varchar(30) NULL,
  `name_municipio` varchar(50) NULL,
  `name_parroquia` varchar(50) NULL,
  PRIMARY KEY (`id_localidades`),
  INDEX `id_localidades1`(`id_parroquia` ASC) USING BTREE
);

-- ----------------------------
-- Table structure for login
-- ----------------------------
DROP TABLE IF EXISTS `login`;
CREATE TABLE `login`  (
  `id_login` int NOT NULL,
  `nombre_login` varchar(50) NULL,
  `apellido_login` varchar(50) NULL,
  `usuario` varchar(50) NULL,
  `password` varchar(50) NULL,
  `id_nivusu1` int NULL,
  `id_dep1` int NULL,
  `fecha_login` date NULL,
  PRIMARY KEY (`id_login`),
  INDEX `id_dep`(`id_dep1` ASC) USING BTREE,
  INDEX `id_login`(`id_login` ASC) USING BTREE,
  INDEX `id_nivusu`(`id_nivusu1` ASC) USING BTREE,
  CONSTRAINT `login_ibfk_2` FOREIGN KEY (`id_nivusu1`) REFERENCES `nivel_usuario` (`id_nivusu`),
  CONSTRAINT `login_ibfk_3` FOREIGN KEY (`id_dep1`) REFERENCES `departamento` (`id_dep`)
);

-- ----------------------------
-- Table structure for nivel_usuario
-- ----------------------------
DROP TABLE IF EXISTS `nivel_usuario`;
CREATE TABLE `nivel_usuario`  (
  `id_nivusu` int NOT NULL,
  `nivel_nivusu` varchar(50) NULL,
  PRIMARY KEY (`id_nivusu`)
);

-- ----------------------------
-- Table structure for patologias
-- ----------------------------
DROP TABLE IF EXISTS `patologias`;
CREATE TABLE `patologias`  (
  `idpat` int NOT NULL,
  `patologia` varchar(60) NOT NULL,
  PRIMARY KEY (`idpat`)
);

-- ----------------------------
-- Table structure for recepcion
-- ----------------------------
DROP TABLE IF EXISTS `recepcion`;
CREATE TABLE `recepcion`  (
  `idrecepcion` int NOT NULL,
  `recepcion` varchar(50) NULL,
  PRIMARY KEY (`idrecepcion`),
  INDEX `idrecepcion1`(`idrecepcion` ASC) USING BTREE
);

-- ----------------------------
-- Table structure for redsalud
-- ----------------------------
DROP TABLE IF EXISTS `redsalud`;
CREATE TABLE `redsalud`  (
  `id_redsal` int NOT NULL,
  `nombre_redsal` varchar(100) NULL,
  `id_localidades2` int NOT NULL,
  `id_tiporedsal` int NOT NULL,
  PRIMARY KEY (`id_redsal`),
  INDEX `id_localidades`(`id_localidades2` ASC) USING BTREE,
  INDEX `id_tiporedsal`(`id_tiporedsal` ASC) USING BTREE,
  INDEX `idoperado`(`id_redsal` ASC) USING BTREE,
  CONSTRAINT `redsalud_ibfk_2` FOREIGN KEY (`id_tiporedsal`) REFERENCES `tiporedsalud` (`id_tiporedsal`),
  CONSTRAINT `redsalud_ibfk_3` FOREIGN KEY (`id_localidades2`) REFERENCES `localidades` (`id_localidades`)
);

-- ----------------------------
-- Table structure for solicitud
-- ----------------------------
DROP TABLE IF EXISTS `solicitud`;
CREATE TABLE `solicitud`  (
  `id_solici` int NOT NULL,
  `id_localidades1` int NULL,
  `idpat1` int NULL,
  `id_donaci1` int NULL,
  `id_login` int NULL,
  `id_redsal1` int NULL,
  `id_listado1` int NULL,
  `idrecepcion1` int NULL,
  `ingresado_por` varchar(80) NULL,
  `fecha_registro_sistema` date NULL,
  `fecha_recibido_solicitud` date NULL,
  `fecha_recibido_srs` date NULL,
  `nombre_sol` varchar(30) NULL,
  `apellido_sol` varchar(30) NULL,
  `cedula_sol` int NULL,
  `telefono_sol` varchar(45) NULL,
  `fec_nac_sol` date NULL,
  `edad_sol` varchar(80) NULL,
  `sector_sol` varchar(80) NULL,
  `vinculofamiliar` varchar(30) NULL,
  `cedula_pac` int NULL,
  `telefono_pac` varchar(45) NULL,
  `nombre_pac` varchar(30) NULL,
  `apellido_pac` varchar(30) NULL,
  `fec_nac_pac` date NULL,
  `edad_pac` varchar(80) NULL,
  `id_localidadespac` int NULL,
  `sector_pac` varchar(80) NULL,
  `patologias` varchar(250) NULL,
  `requerimientos` text NULL,
  `medioderecepcion` varchar(70) NULL,
  `id_localidadrecepcion` int NULL,
  `firmado` varchar(2) NULL,
  `observaciones` varchar(100) NULL,
  `activo` varchar(8) NULL,
  `eliminadopor` varchar(80) NULL,
  `actualizadopor` text NULL,
  `idoperado` int NULL,
  `informemedico` varchar(2) NULL,
  `copiacedula` varchar(2) NULL,
  `cartadesolicitud` varchar(2) NULL,
  `presupuesto` varchar(2) NULL,
  PRIMARY KEY (`id_solici`),
  INDEX `id_donaci`(`id_donaci1` ASC) USING BTREE,
  INDEX `id_listado`(`id_listado1` ASC) USING BTREE,
  INDEX `id_pat`(`idpat1` ASC) USING BTREE,
  INDEX `id_redsal`(`id_redsal1` ASC) USING BTREE,
  INDEX `idrecepcion`(`idrecepcion1` ASC) USING BTREE,
  CONSTRAINT `solicitud1` FOREIGN KEY (`idpat1`) REFERENCES `patologias` (`idpat`),
  CONSTRAINT `solicitud10` FOREIGN KEY (`idoperado`) REFERENCES `redsalud` (`id_redsal`),
  CONSTRAINT `solicitud2` FOREIGN KEY (`id_redsal1`) REFERENCES `redsalud` (`id_redsal`),
  CONSTRAINT `solicitud3` FOREIGN KEY (`idrecepcion1`) REFERENCES `recepcion` (`idrecepcion`),
  CONSTRAINT `solicitud4` FOREIGN KEY (`id_localidades1`) REFERENCES `localidades` (`id_localidades`),
  CONSTRAINT `solicitud5` FOREIGN KEY (`id_login`) REFERENCES `login` (`id_login`),
  CONSTRAINT `solicitud6` FOREIGN KEY (`id_redsal1`) REFERENCES `redsalud` (`id_redsal`),
  CONSTRAINT `solicitud7` FOREIGN KEY (`id_donaci1`) REFERENCES `donaciones` (`id_donaci`),
  CONSTRAINT `solicitud9` FOREIGN KEY (`id_listado1`) REFERENCES `listado` (`id_listado`)
);

-- ----------------------------
-- Table structure for solicitudRespaldo
-- ----------------------------
DROP TABLE IF EXISTS `solicitudRespaldo`;
CREATE TABLE `solicitudRespaldo`  (
  `id_solici` int NOT NULL,
  `id_localidades1` int NULL,
  `idpat1` int NULL,
  `id_donaci1` int NULL,
  `id_login` int NULL,
  `id_redsal1` int NULL,
  `id_listado1` int NULL,
  `idrecepcion1` int NULL,
  `ingresado_por` varchar(80) NULL,
  `fecha_registro_sistema` date NULL,
  `fecha_recibido_solicitud` date NULL,
  `fecha_recibido_srs` date NULL,
  `nombre_sol` varchar(30) NULL,
  `apellido_sol` varchar(30) NULL,
  `cedula_sol` int NULL,
  `telefono_sol` varchar(45) NULL,
  `fec_nac_sol` date NULL,
  `edad_sol` varchar(80) NULL,
  `sector_sol` varchar(80) NULL,
  `vinculofamiliar` varchar(30) NULL,
  `cedula_pac` int NULL,
  `telefono_pac` varchar(45) NULL,
  `nombre_pac` varchar(30) NULL,
  `apellido_pac` varchar(30) NULL,
  `fec_nac_pac` date NULL,
  `edad_pac` varchar(80) NULL,
  `id_localidadespac` int NULL,
  `sector_pac` varchar(80) NULL,
  `patologias` varchar(250) NULL,
  `requerimientos` text NULL,
  `medioderecepcion` varchar(70) NULL,
  `id_localidadrecepcion` int NULL,
  `firmado` varchar(2) NULL,
  `observaciones` varchar(100) NULL,
  `activo` varchar(8) NULL,
  `desactivadopor` varchar(80) NULL,
  `actualizadopor` text NULL,
  `idoperado` int NULL,
  `informemedico` varchar(2) NULL,
  `copiacedula` varchar(2) NULL,
  `cartadesolicitud` varchar(2) NULL,
  `presupuesto` varchar(2) NULL,
  PRIMARY KEY (`id_solici`),
  INDEX `id_donaci_copy1`(`id_donaci1` ASC) USING BTREE,
  INDEX `id_listado_copy1`(`id_listado1` ASC) USING BTREE,
  INDEX `id_pat_copy1`(`idpat1` ASC) USING BTREE,
  INDEX `id_redsal_copy1`(`id_redsal1` ASC) USING BTREE,
  INDEX `idrecepcion_copy1`(`idrecepcion1` ASC) USING BTREE,
  CONSTRAINT `solicitud_copy1_id_donaci1_fkey` FOREIGN KEY (`id_donaci1`) REFERENCES `donaciones` (`id_donaci`),
  CONSTRAINT `solicitud_copy1_id_listado1_fkey` FOREIGN KEY (`id_listado1`) REFERENCES `listado` (`id_listado`),
  CONSTRAINT `solicitud_copy1_id_localidades1_fkey` FOREIGN KEY (`id_localidades1`) REFERENCES `localidades` (`id_localidades`),
  CONSTRAINT `solicitud_copy1_id_login_fkey` FOREIGN KEY (`id_login`) REFERENCES `login` (`id_login`),
  CONSTRAINT `solicitud_copy1_id_redsal1_fkey` FOREIGN KEY (`id_redsal1`) REFERENCES `redsalud` (`id_redsal`),
  CONSTRAINT `solicitud_copy1_id_redsal1_fkey1` FOREIGN KEY (`id_redsal1`) REFERENCES `redsalud` (`id_redsal`),
  CONSTRAINT `solicitud_copy1_idoperado_fkey` FOREIGN KEY (`idoperado`) REFERENCES `redsalud` (`id_redsal`),
  CONSTRAINT `solicitud_copy1_idpat1_fkey` FOREIGN KEY (`idpat1`) REFERENCES `patologias` (`idpat`),
  CONSTRAINT `solicitud_copy1_idrecepcion1_fkey` FOREIGN KEY (`idrecepcion1`) REFERENCES `recepcion` (`idrecepcion`)
);

-- ----------------------------
-- Table structure for status
-- ----------------------------
DROP TABLE IF EXISTS `status`;
CREATE TABLE `status`  (
  `id_status` int NOT NULL,
  `observaciones_status` text NULL,
  `fecha_status` date NOT NULL,
  `id_defsta1` int NOT NULL,
  `id_solici1` int NOT NULL,
  `id_login1` int NULL,
  `nombre_login` varchar(50) NULL,
  `asignado` varchar(30) NULL,
  `id_redsal2` int NULL,
  `requerimientosaprobados` varchar(200) NULL,
  `costo` float NULL,
  `activa` char(2) NULL,
  `realizadopor` char(80) NULL,
  `fecha_registro_status` date NULL,
  PRIMARY KEY (`id_status`),
  CONSTRAINT `status1` FOREIGN KEY (`id_solici1`) REFERENCES `solicitud` (`id_solici`),
  CONSTRAINT `status2` FOREIGN KEY (`id_defsta1`) REFERENCES `definicion_status` (`id_defsta`),
  CONSTRAINT `status3` FOREIGN KEY (`id_redsal2`) REFERENCES `redsalud` (`id_redsal`)
);

-- ----------------------------
-- Table structure for tipo_donaciones
-- ----------------------------
DROP TABLE IF EXISTS `tipo_donaciones`;
CREATE TABLE `tipo_donaciones`  (
  `id_tipdon` int NOT NULL,
  `nombre_tipdon` varchar(50) NULL,
  PRIMARY KEY (`id_tipdon`)
);

-- ----------------------------
-- Table structure for tiporedsalud
-- ----------------------------
DROP TABLE IF EXISTS `tiporedsalud`;
CREATE TABLE `tiporedsalud`  (
  `id_tiporedsal` int NOT NULL,
  `nombre_tiporedsal` varchar(50) NOT NULL,
  PRIMARY KEY (`id_tiporedsal`)
);

SET FOREIGN_KEY_CHECKS = 1;
