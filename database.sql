-- MariaDB dump 10.19  Distrib 10.4.24-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: colegio
-- ------------------------------------------------------
-- Server version	10.4.24-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `colegio`
--

-- CREATE DATABASE /*!32312 IF NOT EXISTS*/ `colegio` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

-- USE `colegio`;

--
-- Table structure for table `alumnos`
--

DROP TABLE IF EXISTS `alumnos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `alumnos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` int(11) NOT NULL,
  `baja` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alumnos`
--

LOCK TABLES `alumnos` WRITE;
/*!40000 ALTER TABLE `alumnos` DISABLE KEYS */;
/*!40000 ALTER TABLE `alumnos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `anuncio`
--

DROP TABLE IF EXISTS `anuncio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `anuncio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `fecha_creacion` datetime DEFAULT current_timestamp(),
  `fecha_vencimiento` date NOT NULL,
  `codUsuario` int(11) NOT NULL,
  `baja` tinyint(4) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `anuncio`
--

LOCK TABLES `anuncio` WRITE;
/*!40000 ALTER TABLE `anuncio` DISABLE KEYS */;
INSERT INTO `anuncio` VALUES (1,'suspencion de clases','El dia 25 de abril no abra clases por motivo de reunion de profesores','2026-04-24 20:57:35','2026-04-30',1,0);
/*!40000 ALTER TABLE `anuncio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `curso`
--

DROP TABLE IF EXISTS `curso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `curso` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grado` varchar(255) NOT NULL,
  `nivel` varchar(255) NOT NULL,
  `baja` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `curso`
--

LOCK TABLES `curso` WRITE;
/*!40000 ALTER TABLE `curso` DISABLE KEYS */;
INSERT INTO `curso` VALUES (1,'primero','secundaria',0),(2,'Segundo','Secundaria ',0),(3,'Tercero','Secundaria ',0),(4,'Cuarto ','Secundaria',0),(5,'Quinto','Secundaria',0),(6,'Sexto','Secundaria',0),(7,'Primero','Primaria',0);
/*!40000 ALTER TABLE `curso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cursoalumnos`
--

DROP TABLE IF EXISTS `cursoalumnos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cursoalumnos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codCurso` int(11) NOT NULL,
  `codProfesor` int(11) DEFAULT NULL,
  `nombres` varchar(255) NOT NULL,
  `apellidos` varchar(255) NOT NULL,
  `rude` varchar(300) DEFAULT NULL,
  `gestion` int(11) DEFAULT NULL,
  `baja` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cursoalumnos_codcurso_foreign` (`codCurso`),
  KEY `cursoalumnos_codprofesor_foreign` (`codProfesor`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=85 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cursoalumnos`
--

LOCK TABLES `cursoalumnos` WRITE;
/*!40000 ALTER TABLE `cursoalumnos` DISABLE KEYS */;
INSERT INTO `cursoalumnos` VALUES (2,1,0,'rodrigo','alvarez moreno','242342344',2026,0),(3,1,0,'yoselin','anajia cespedes','435353454',2026,0),(4,1,0,'ayelen','avendaño mendoza','534534534',2026,0),(5,1,0,'carmen','carrasco flores','353453454',2026,0),(6,1,0,'noemy','cholima terrazas','768678677',2026,0),(7,1,0,'yersia guadalupe','coronado romero','75675756',2026,0),(8,1,0,'victor manuel','coronado romero','23534534',2026,0),(12,3,0,'samuel','quiroga salazar','87886767',2026,0),(11,3,0,'thiago','moron quiroga','67854533',2026,0),(9,1,0,'tamara','guzman flores','34556734',2026,0),(10,2,0,'jorge','morón','34547654',2026,0),(45,5,0,'Ana','Rivera','73853173',2026,0),(44,5,0,'Luciano','Pereira Soliz','2342342',2026,0),(43,4,0,'Camila','Rodriguez','70614017',2026,0),(42,4,0,'Luis','Perez','70879426',2026,0),(41,4,0,'Paola','Castro','72246458',2026,0),(40,4,0,'Roxana','Rivera','71441969',2026,0),(39,4,0,'Jose','Cruz','74310072',2026,0),(38,4,0,'Carlos','Morales','71220421',2026,0),(37,4,0,'Miguel','Castro','71923444',2026,0),(36,4,0,'Jose','Morales','76864588',2026,0),(35,4,0,'Fernando','Mamani','77833998',2026,0),(46,5,0,'Miguel','Herrera','78143300',2026,0),(47,5,0,'Jose','Rivera','72901911',2026,0),(48,5,0,'Ricardo','Perez','77481679',2026,0),(49,5,0,'Miguel','Medina','79375433',2026,0),(50,5,0,'Andrea','Rivera','71898764',2026,0),(51,5,0,'Oscar','Medina','72404210',2026,0),(52,5,0,'Luis','Alvarez','75976252',2026,0),(53,5,0,'Ana','Rivera','79968591',2026,0),(54,6,0,'Fernando','Flores','77321996',2026,0),(55,6,0,'Andrea','Suarez','78681787',2026,0),(56,6,0,'Carlos','Mamani','76816925',2026,0),(57,6,0,'Miguel','Rivera','71659662',2026,0),(58,6,0,'Roxana','Quispe','79020374',2026,0),(59,6,0,'Juan','Vargas','73166990',2026,0),(60,6,0,'Andrea','Morales','73912931',2026,0),(61,6,0,'Daniel','Medina','74192086',2026,0),(62,6,0,'Roxana','Medina','76812349',2026,0),(63,2,0,'Jorge','Fernandez','71426170',2026,0),(64,2,0,'Camila','Medina','73230990',2026,0),(65,2,0,'Daniel','Herrera','79499206',2026,0),(66,2,0,'Ricardo','Morales','74019260',2026,0),(67,2,0,'Jose','Rivera','78765738',2026,0),(68,2,0,'Carlos','Garcia','71917155',2026,0),(69,2,0,'Valeria','Cruz','74830468',2026,0),(70,2,0,'Juan','Cruz','75588968',2026,0),(71,2,0,'Juan','Rojas','75540980',2026,0),(72,2,0,'Paola','Castro','75466231',2026,0),(73,3,0,'Diego','Lopez','71918289',2026,0),(74,3,0,'Valeria','Torrez','75097551',2026,0),(75,3,0,'Valeria','Suarez','74836427',2026,0),(76,3,0,'Maria','Quispe','74631366',2026,0),(77,3,0,'Diego','Rivera','73438293',2026,0),(78,3,0,'Andrea','Suarez','72570105',2026,0),(79,3,0,'Fernando','Lopez','71267490',2026,0),(80,3,0,'Daniel','Herrera','74817608',2026,0),(82,4,0,'Federico','Rodriguez','222222',2026,0),(83,7,0,'Felipe','Franco','43534334',2026,0),(84,7,0,'Ruben','Dario','3242323',2026,0);
/*!40000 ALTER TABLE `cursoalumnos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cursomateria`
--

DROP TABLE IF EXISTS `cursomateria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cursomateria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codCurso` int(11) NOT NULL,
  `codMateria` int(11) NOT NULL,
  `codProfesor` int(11) NOT NULL,
  `gestion` int(11) NOT NULL,
  `baja` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cursomateria_codprofesor_foreign` (`codProfesor`),
  KEY `cursomateria_codcurso_foreign` (`codCurso`),
  KEY `cursomateria_codmateria_foreign` (`codMateria`)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cursomateria`
--

LOCK TABLES `cursomateria` WRITE;
/*!40000 ALTER TABLE `cursomateria` DISABLE KEYS */;
INSERT INTO `cursomateria` VALUES (1,1,1,1,2025,0),(2,3,1,1,2025,0),(29,1,2,8,2026,0),(28,1,6,8,2026,0),(27,1,7,8,2026,0),(26,1,3,8,2026,0),(25,1,4,8,2026,0),(24,5,8,7,2026,0),(23,4,8,7,2026,0),(22,6,2,9,2026,0),(21,5,2,9,2026,0),(20,4,2,9,2026,0),(19,2,1,1,2026,0),(18,3,1,1,2026,0),(17,1,1,1,2026,0),(30,1,5,8,2026,0),(31,1,9,8,2026,0),(32,1,8,8,2026,0),(33,1,2,8,2025,0),(34,1,6,8,2025,0),(35,1,7,8,2025,0),(36,1,3,8,2025,0),(37,1,4,8,2025,0),(38,1,5,8,2025,0),(39,1,9,8,2025,0),(40,1,8,8,2025,0),(41,7,2,10,2026,0);
/*!40000 ALTER TABLE `cursomateria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `datoscolegio`
--

DROP TABLE IF EXISTS `datoscolegio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `datoscolegio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigoUnidad` varchar(200) DEFAULT NULL,
  `unidadEducativa` varchar(800) DEFAULT NULL,
  `distritoEducativo` varchar(800) DEFAULT NULL,
  `codDepartamento` int(11) DEFAULT NULL,
  `dependencia` varchar(200) DEFAULT NULL,
  `turno` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `codDepartamento` (`codDepartamento`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `datoscolegio`
--

LOCK TABLES `datoscolegio` WRITE;
/*!40000 ALTER TABLE `datoscolegio` DISABLE KEYS */;
INSERT INTO `datoscolegio` VALUES (1,'81980992','SANTA ANA D','SANTA CRUZ 1',7,'CONVENIO','TARDE');
/*!40000 ALTER TABLE `datoscolegio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departamento`
--

DROP TABLE IF EXISTS `departamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `departamento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `baja` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departamento`
--

LOCK TABLES `departamento` WRITE;
/*!40000 ALTER TABLE `departamento` DISABLE KEYS */;
INSERT INTO `departamento` VALUES (1,'Chuquisaca',0),(2,'La Paz',0),(3,'Cochabamba',0),(4,'Oruro',0),(5,'Potosí',0),(6,'Tarija',0),(7,'Santa Cruz',0),(8,'Beni',0),(9,'Pando',0);
/*!40000 ALTER TABLE `departamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `conceptos_egresos`
--

DROP TABLE IF EXISTS `conceptos_egresos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `conceptos_egresos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `concepto` varchar(255) NOT NULL,
  `baja` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_concepto_egreso` (`concepto`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `conceptos_egresos`
--

LOCK TABLES `conceptos_egresos` WRITE;
/*!40000 ALTER TABLE `conceptos_egresos` DISABLE KEYS */;
INSERT INTO `conceptos_egresos` VALUES (1,'pago de luz',0),(2,'pago al guardia',0);
/*!40000 ALTER TABLE `conceptos_egresos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `egresos`
--

DROP TABLE IF EXISTS `egresos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `egresos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `monto` decimal(10,2) NOT NULL,
  `fechaEgreso` date NOT NULL,
  `mes` int(11) NOT NULL,
  `gestion` int(11) NOT NULL,
  `concepto` varchar(255) NOT NULL,
  `codUsuario` int(11) DEFAULT NULL,
  `baja` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `egresos`
--

LOCK TABLES `egresos` WRITE;
/*!40000 ALTER TABLE `egresos` DISABLE KEYS */;
INSERT INTO `egresos` VALUES (1,200.00,'2026-04-24',4,2026,'pago de luz',1,0),(2,500.00,'2026-04-24',4,2026,'pago al guardia',1,0);
/*!40000 ALTER TABLE `egresos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ingresos`
--

DROP TABLE IF EXISTS `ingresos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ingresos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codAlumno` int(11) NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `fechaPago` date NOT NULL,
  `mes` int(11) NOT NULL,
  `gestion` int(11) NOT NULL,
  `concepto` varchar(255) NOT NULL,
  `codUsuario` int(11) DEFAULT NULL,
  `baja` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ingresos`
--

LOCK TABLES `ingresos` WRITE;
/*!40000 ALTER TABLE `ingresos` DISABLE KEYS */;
INSERT INTO `ingresos` VALUES (1,2,250.00,'2026-04-24',4,2026,'Mensualidad Escolar',1,0),(2,41,250.00,'2026-04-24',4,2026,'Mensualidad Escolar',1,0),(3,37,250.00,'2026-04-24',4,2026,'Mensualidad Escolar',1,0),(4,2,250.00,'2026-04-24',5,2026,'Mensualidad Escolar',1,0),(5,3,250.00,'2026-04-24',5,2026,'Mensualidad Escolar',1,0),(6,52,250.00,'2026-04-24',5,2026,'Mensualidad Escolar',1,0),(7,52,250.00,'2026-04-24',5,2026,'Mensualidad Escolar',1,1);
/*!40000 ALTER TABLE `ingresos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `materia`
--

DROP TABLE IF EXISTS `materia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `materia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `areasCurriculares` varchar(600) DEFAULT NULL,
  `saberesConocimiento` varchar(600) DEFAULT NULL,
  `baja` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `materia`
--

LOCK TABLES `materia` WRITE;
/*!40000 ALTER TABLE `materia` DISABLE KEYS */;
INSERT INTO `materia` VALUES (1,'Matematica','MATEMÁTICA','CIENCIA TECNOLOGÍA Y PRODUCCIÓN',0),(2,'Lenguaje','COMUNICACIÓN Y LENGUAJES (CASTELLANA, ORIGINARIA Y LENGUA EXTRANJERA)','COMUNIDAD Y SOCIEDAD',0),(3,'Ciencas Naturales','CIENCAS NATURALES','VIDA TIERRA TERRITORIO',0),(4,'Artes Plasticas','ARTES PLÁSTICAS Y VISUALES','COMUNIDAD Y SOCIEDAD',0),(5,'Musica','EDUCACIÓN MUSICAL','COMUNIDAD Y SOCIEDAD',0),(6,'Educacion Fisica','EDUCACIÓN FISICA Y DEPORTES','COMUNIDAD Y SOCIEDAD',0),(7,'Ciencia Sociales','CIENCIA SOCIALES','COMUNIDAD Y SOCIEDAD',0),(8,'Tecnologia','TÉCNICA TECNOLÓGICA','CIENCIA TECNOLOGÍA Y PRODUCCIÓN',0),(9,'Religión','VALORES, ESPIRITUALIDAD Y RELIGIONES','COSMOS Y PENSAMIENTO',0);
/*!40000 ALTER TABLE `materia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notas`
--

DROP TABLE IF EXISTS `notas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codCursoAlumnos` int(11) NOT NULL,
  `codMateria` int(11) DEFAULT NULL,
  `calificacion1Ser` int(11) DEFAULT NULL,
  `calificacion2Ser` int(11) DEFAULT NULL,
  `calificacion3Ser` int(11) DEFAULT NULL,
  `calificacion1Saber` int(11) DEFAULT NULL,
  `calificacion2Saber` int(11) DEFAULT NULL,
  `calificacion3Saber` int(11) DEFAULT NULL,
  `calificacion4Saber` int(11) DEFAULT NULL,
  `calificacion5Saber` int(11) DEFAULT NULL,
  `calificacion6Saber` int(11) DEFAULT NULL,
  `calificacion7Saber` int(11) DEFAULT NULL,
  `calificacion1Hacer` int(11) DEFAULT NULL,
  `calificacion2Hacer` int(11) DEFAULT NULL,
  `calificacion3Hacer` int(11) DEFAULT NULL,
  `calificacion4Hacer` int(11) DEFAULT NULL,
  `calificacion5Hacer` int(11) DEFAULT NULL,
  `calificacion6Hacer` int(11) DEFAULT NULL,
  `calificacion7Hacer` int(11) DEFAULT NULL,
  `calificacion1Decidir` int(11) DEFAULT NULL,
  `calificacion2Decidir` int(11) DEFAULT NULL,
  `calificacion3Decidir` int(11) DEFAULT NULL,
  `trimestre` int(11) DEFAULT NULL,
  `autoevaluacion` int(11) DEFAULT NULL,
  `gestion` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notas_codcursolAalumnos_foreign` (`codCursoAlumnos`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notas`
--

LOCK TABLES `notas` WRITE;
/*!40000 ALTER TABLE `notas` DISABLE KEYS */;
INSERT INTO `notas` VALUES (2,2,1,4,0,0,33,18,13,12,18,0,NULL,1,20,15,30,0,NULL,NULL,3,NULL,NULL,1,3,2025),(3,3,1,4,0,0,3,0,0,0,0,NULL,NULL,22,NULL,NULL,NULL,NULL,NULL,NULL,2,NULL,NULL,1,3,2025),(4,4,1,5,0,0,45,45,0,0,NULL,NULL,NULL,30,40,40,40,NULL,NULL,NULL,5,NULL,NULL,1,4,2025),(5,5,1,5,0,0,12,45,9,30,NULL,NULL,NULL,40,40,40,40,NULL,NULL,NULL,5,NULL,NULL,1,5,2025),(6,6,1,4,1,1,40,42,30,20,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,2025),(7,8,1,NULL,2,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,2025),(8,7,1,NULL,4,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,2025),(9,9,1,NULL,3,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,2025),(10,2,1,4,NULL,NULL,45,40,45,NULL,NULL,NULL,NULL,12,40,40,40,NULL,NULL,NULL,5,NULL,NULL,2,NULL,2025),(11,2,1,5,NULL,NULL,15,45,40,30,NULL,NULL,NULL,20,30,40,35,NULL,NULL,NULL,2,5,NULL,3,NULL,2025),(12,11,1,5,NULL,NULL,10,15,45,5,NULL,NULL,NULL,40,40,35,30,NULL,NULL,NULL,NULL,4,NULL,1,4,2025),(13,12,1,3,NULL,NULL,45,45,30,40,NULL,NULL,NULL,30,30,40,25,NULL,NULL,NULL,3,NULL,NULL,1,5,2025),(14,11,1,3,3,3,15,20,45,40,40,NULL,NULL,40,40,20,10,NULL,NULL,NULL,5,NULL,NULL,2,NULL,2025),(15,12,1,5,NULL,NULL,20,20,45,45,40,NULL,NULL,40,40,40,20,NULL,NULL,NULL,3,NULL,NULL,2,NULL,2025),(16,2,2,4,NULL,NULL,30,20,45,20,NULL,NULL,NULL,30,40,40,NULL,NULL,NULL,NULL,5,NULL,NULL,1,5,2025),(17,2,1,5,8,10,40,40,40,40,40,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,5,2026),(18,3,1,5,NULL,NULL,20,24,25,40,45,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,5,2026),(19,2,1,2,2,NULL,40,20,NULL,NULL,NULL,NULL,NULL,NULL,40,35,NULL,NULL,NULL,NULL,NULL,NULL,NULL,2,NULL,2026),(20,2,1,10,NULL,NULL,40,45,40,20,40,NULL,NULL,40,40,30,NULL,NULL,NULL,NULL,NULL,NULL,NULL,3,5,2026),(21,2,2,10,10,10,40,30,45,20,NULL,NULL,NULL,20,40,40,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,4,2026),(22,2,3,10,NULL,NULL,40,40,45,NULL,NULL,NULL,NULL,30,40,30,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,5,2026),(23,2,4,7,NULL,NULL,5,45,45,40,NULL,NULL,NULL,40,40,20,30,NULL,NULL,NULL,NULL,NULL,NULL,1,5,2026),(24,41,8,NULL,5,NULL,40,40,45,45,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,2026);
/*!40000 ALTER TABLE `notas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `persona`
--

DROP TABLE IF EXISTS `persona`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `persona` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) DEFAULT NULL,
  `apellidos` varchar(200) DEFAULT NULL,
  `baja` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `persona`
--

LOCK TABLES `persona` WRITE;
/*!40000 ALTER TABLE `persona` DISABLE KEYS */;
INSERT INTO `persona` VALUES (1,'Marcela','Moron',0),(5,'Jorge','Moron',0),(3,'Julio','Perez',0),(4,'Sonia','Pereira',0),(6,'Carmen','Soliz',0),(7,'Jose','Salvatierra',0),(8,'Daniela','Viruez',0),(9,'Julio andres','Soliz',0),(10,'Fernando','Antelo',0),(11,'Ruben','Arteaga',0);
/*!40000 ALTER TABLE `persona` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profesor`
--

DROP TABLE IF EXISTS `profesor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `profesor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codUsuario` int(11) DEFAULT NULL,
  `nombre` varchar(300) DEFAULT NULL,
  `baja` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profesor`
--

LOCK TABLES `profesor` WRITE;
/*!40000 ALTER TABLE `profesor` DISABLE KEYS */;
INSERT INTO `profesor` VALUES (1,1,'Marcela Moron',0),(9,6,'Jose Salvatierra',0),(7,3,'Julio Perez',0),(8,4,'Sonia Pereira',0),(10,8,'Julio andres Soliz',0),(11,9,'Fernando Antelo',0),(12,10,'Ruben Arteaga',0);
/*!40000 ALTER TABLE `profesor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipousuario`
--

DROP TABLE IF EXISTS `tipousuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipousuario` (
  `codTipoUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) DEFAULT NULL,
  `baja` int(11) DEFAULT NULL,
  PRIMARY KEY (`codTipoUsuario`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipousuario`
--

LOCK TABLES `tipousuario` WRITE;
/*!40000 ALTER TABLE `tipousuario` DISABLE KEYS */;
INSERT INTO `tipousuario` VALUES (1,'Superusuario',0),(2,'Profesor(a)',0),(3,'Director(a)',0),(4,'Tutor(a)',0),(5,'Secretaría',0);
INSERT INTO `tipousuario` VALUES (6,'Contabilidad',0);
/*!40000 ALTER TABLE `tipousuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tutor`
--

DROP TABLE IF EXISTS `tutor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tutor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codCurso` int(11) DEFAULT NULL,
  `codProfesor` int(11) DEFAULT NULL,
  `baja` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `codCurso` (`codCurso`),
  KEY `codProfesor` (`codProfesor`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tutor`
--

LOCK TABLES `tutor` WRITE;
/*!40000 ALTER TABLE `tutor` DISABLE KEYS */;
INSERT INTO `tutor` VALUES (4,1,1,0),(7,5,9,0),(6,4,9,0),(5,3,1,0),(8,6,9,0),(9,2,1,0),(10,7,9,0);
/*!40000 ALTER TABLE `tutor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `codUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(200) DEFAULT NULL,
  `clave` varchar(200) DEFAULT NULL,
  `codTipoUsuario` int(11) DEFAULT NULL,
  `codPersona` int(11) DEFAULT NULL,
  `baja` int(11) DEFAULT NULL,
  PRIMARY KEY (`codUsuario`),
  KEY `codTipoUsuario` (`codTipoUsuario`),
  KEY `codPersona` (`codPersona`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'admin','$2y$10$Ko0WB6JpG25siBNukC.opeVPk2CXNMGkdaTGsp4eP7/X1aHwMLywW',1,1,0),(2,'jmoron','$2y$10$G7cigfjfdQBNvbI5Rx2UBOh1F5gkAQAVpyAyZluYvMo4S52crezxq',1,5,0),(3,'jperez','$2y$10$JgCw5yUr2DnYZU8I7zLw0eG5WLhtFJrFO5IE5izAPi3PTN6e3Thyq',2,3,0),(4,'spereira','$2y$10$F5ItGk3HMBSPHpB3bHWORuavEpgZTil44bwm2JrzY.UOMmcrOFhMe',2,4,0),(5,'csoliz','$2y$10$ZliA8JCUxPF3L522j8L7ieokQzDUiJUsyd1GtIHzpx61cQ5d35MVi',3,6,0),(6,'lsalvatierra','$2y$10$TyDJ3fXdgtDX5cJir3utnuahSpdwxrj5v3gcA0ly/WGditF1NzZe.',4,7,0),(7,'dviruez','$2y$10$CPL3Ss1wzuqhp.Jy/gVfQ.ze.9APR4hWozrEyW.j7YwylRmmvJN7q',5,8,0),(8,'julio','$2y$10$qt7fXlQ.yxR9ZkaulaSIg.1S0Pnd4nsJx5OXBDt/6uG3VCy2AsPhi',2,9,0),(9,'fantelo',NULL,4,10,1),(10,'rarteaga','$2y$10$NwV7W6.ZFMx4MFBwdC4NJuRI998Z3SquM/5XsLWQrOspoTlzHyYxu',2,11,0);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-04-24 21:08:31
