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
-- Table structure for table `cat_juzgado`
--

DROP TABLE IF EXISTS `cat_juzgado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cat_juzgado` (
  `ID_Juzgado` int NOT NULL AUTO_INCREMENT,
  `Juzgado` char(255) NOT NULL,
  `Juez` char(255) NOT NULL,
  PRIMARY KEY (`ID_Juzgado`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cat_juzgado`
--

LOCK TABLES `cat_juzgado` WRITE;
/*!40000 ALTER TABLE `cat_juzgado` DISABLE KEYS */;
INSERT INTO `cat_juzgado` VALUES (1,'Juzgado Primero Civil de Proceso Oral','Lic. Ivonne Moreno Ortiz'),(2,'Juzgado Segundo Civil de Proceso Oral','Dr. Ángel Velázquez Villaseñor'),(3,'Juzgado Tercero Civil de Proceso Oral','Mtro. Salvador Ramírez Rodriguez'),(4,'Juzgado Cuarto Civil de Proceso Oral','Lic. Alejandra García Luna (Ml)'),(5,'Juzgado Quinto Civil de Proceso Oral','Lic. Jorge Belmont Alcíbar'),(6,'Juzgado Sexto Civil de Proceso Oral','Mtra. Gloria Ortiz Sánchez'),(7,'Juzgado Septimo Civil de Proceso Oral','Lic. Laura Patricia Hernández Ruíz'),(8,'Juzgado Octavo Civil de Proceso Oral','Mtos. Juan Ángel Lara Lara'),(9,'Juzgado Noveno Civil de Proceso Oral','Dr. Enrique De Jesús Duran Sánchez'),(10,'Juzgado Décimo Civil de Proceso Oral','Mtro. Román Juárez González.'),(11,'Juzgado Décimo Primero Civil de Proceso Oral','Mtra. Minerva Tanía Martínez Cisneros'),(12,'Juzgado Décimo Segundo Civil de Proceso Oral','Lic. Luz Edith Velarde Bernal(Int)'),(13,'Juzgado Décimo Tercero Civil de Proceso Oral','Lic. Yassmin Vázquez Longino (Ml)'),(14,'Juzgado Décimo Cuarto Civil de Proceso Oral','Mtro. Francisco Neri Rosales'),(15,'Juzgado Décimo Quinto Civil de Proceso Oral','Mtra. Claudia Díaz Zepeda'),(16,'Juzgado Décimo Sexto Civil de Proceso Oral','Lic. Georgina Ramírez Paredes'),(17,'Juzgado Décimo Séptimo Civil de Proceso Oral','Lic. Claudia Pérez Ramírez'),(18,'Juzgado Décimo Octavo Civil de Proceso Oral','Lic. Jorge Luis Ramírez Sánchez'),(19,'Juzgado Décimo Noveno Civil de Proceso Oral','Mtra. Haydee De La Rosa García'),(20,'Juzgado Vigésimo Civil de Proceso Oral','Mtro. Fernando Serrano García'),(21,'Juzgado Vigésimo Primero Civil de Proceso Oral','Mtro. Felipe De Jesús Rodríguez De Mendoza'),(22,'Juzgado Vigésimo Segundo Civil de Proceso Oral','Mtro. Rául Castillo Vega'),(23,'Juzgado Vigésimo Tercero Civil de Proceso Oral','Mtro. Alejandro Hernández Tlecuitl'),(24,'Juzgado Vigésimo Cuarto Civil de Proceso Oral','Mtro. Andrés Martínez Guerrero'),(25,'Juzgado Vigésimo Quinto Civil de Proceso Oral','Mtro David López Rechy'),(26,'Juzgado Vigésimo Sexto Civil de Proceso Oral','Mitzi Aquino Cruz'),(27,'Juzgado Vigésimo Séptimo Civil de Proceso Oral','Mtro. Víctor Hoyos Gándara'),(28,'Juzgado Vigésimo Octavo Civil de Proceso Oral','Mtro. Hiram Arturo Cervantes García'),(29,'Juzgado Vigésimo Noveno Civil de Proceso Oral','Lic. Yaneth Karina Hernández Nicolás'),(30,'Juzgado Trigésimo Civil de Proceso Oral','Lic. Horacio Cruz Tenorio'),(31,'Juzgado Trigésimo Primero Civil de Proceso Oral','Lic. Mónica Marcos Sánchez'),(32,'Juzgado Trigésimo Segundo Civil de Proceso Oral','Mtro Fernando Sánchez Ruíz'),(33,'Juzgado Trigésimo Tercero Civil de Proceso Oral','Lic. Víctor Hugo Quiroz Bautista'),(34,'Juzgado Trigésimo Cuarto Civil de Proceso Oral','Mtro. Holbin Guadalupe Pérez López'),(35,'Juzgado Trigésimo Quinto Civil de Proceso Oral','Dra. Sonia Alejandra García Beltrán.'),(36,'Juzgado Trigésimo Sexto Civil de Proceso Oral','Lic. Eric Daniel Prado Martínez'),(37,'Juzgado Trigésimo Septimo Civil de Proceso Oral','Dr. Humberto Pang Nuñez'),(38,'Juzgado Trigésimo Octavo Civil de Proceso Oral','Mtra. Nancy Lechuga Trejo'),(39,'Juzgado Trigésimo Noveno Civil de Proceso Oral','Lic. Manuel Alfonso Cortes Bustos'),(40,'Juzgado Cuadragésimo Civil de Proceso Oral','Mtra. María Ivonne Jauffred Puente'),(41,'Juzgado Cuadragésimo Primero Civil de Proceso Oral','Mtra. Bibiana Camacho Reyes'),(42,'Juzgado Cuadragésimo Segundo Civil de Proceso Oral','Mtro. Huguet Rodríguez Godínez'),(43,'Juzgado Cuadragésimo Tercero Civil de Proceso Oral','Mtra. Laura Elena Rosales Rosales'),(44,'Juzgado Cuadragésimo Cuarto Civil de Proceso Oral','Mtra. Francisco Javier Jiménez Rodríguez.');
/*!40000 ALTER TABLE `cat_juzgado` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-03-22  9:03:33
