-- MySQL dump 10.13  Distrib 8.0.26, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: encuesta_qr
-- ------------------------------------------------------
-- Server version	8.0.26

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `encuesta`
--

DROP TABLE IF EXISTS `encuesta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `encuesta` (
  `ID_Encuesta` int NOT NULL AUTO_INCREMENT,
  `ID_Juzgado` int NOT NULL,
  `Juez` char(255) NOT NULL,
  `Expediente` char(255) NOT NULL,
  `Parte` tinyint(1) NOT NULL DEFAULT '0',
  `P1` tinyint(1) NOT NULL DEFAULT '0',
  `P2` tinyint(1) NOT NULL DEFAULT '0',
  `P3` tinyint(1) NOT NULL DEFAULT '0',
  `P4` tinyint(1) NOT NULL DEFAULT '0',
  `P5` tinyint(1) NOT NULL DEFAULT '0',
  `P6` tinyint(1) NOT NULL DEFAULT '0',
  `P7` tinyint(1) NOT NULL DEFAULT '0',
  `P8` char(255) DEFAULT NULL,
  `Estatus` tinyint(1) NOT NULL DEFAULT '1',
  `Fecha_Registro` date NOT NULL,
  PRIMARY KEY (`ID_Encuesta`),
  KEY `encuesta_ibfk_1_idx` (`ID_Juzgado`),
  CONSTRAINT `encuesta_ibfk_1` FOREIGN KEY (`ID_Juzgado`) REFERENCES `cat_juzgado` (`ID_Juzgado`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `encuesta`
--

LOCK TABLES `encuesta` WRITE;
/*!40000 ALTER TABLE `encuesta` DISABLE KEYS */;
INSERT INTO `encuesta` VALUES (10,1,'Lic. Ivonne Moreno Ortiz','202/2022',1,1,1,1,1,1,1,1,'Este es un comentario',1,'2022-03-20'),(11,30,'Lic. Horacio Cruz Tenorio','0001/2022',1,1,1,1,1,1,1,1,'Este es un comentario',1,'2022-03-20'),(12,40,'Mtra. María Ivonne Jauffred Puente','0001/2022',1,1,1,1,1,1,1,1,'Este es un comentario',1,'2022-03-20'),(13,1,'Lic. Ivonne Moreno Ortiz','202/2022',1,1,1,1,1,1,1,1,'Este es un comentario',1,'2022-03-20'),(14,44,'Mtra. Francisco Javier Jiménez Rodríguez.','306/2021',2,2,1,1,1,2,1,1,'',1,'2022-03-21'),(15,30,'Lic. Horacio Cruz Tenorio','306/2021',2,2,1,1,1,2,1,1,'',1,'2022-03-22'),(16,30,'Lic. Horacio Cruz Tenorio','306/2021',2,2,1,1,1,2,1,1,'Este es un comentario',1,'2022-03-22');
/*!40000 ALTER TABLE `encuesta` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-03-22  9:03:32
