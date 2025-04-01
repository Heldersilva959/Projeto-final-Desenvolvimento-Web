-- MySQL dump 10.13  Distrib 8.0.41, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: sistema_esc
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

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
-- Table structure for table `alunos`
--

DROP TABLE IF EXISTS `alunos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `alunos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `matricula` int(10) DEFAULT NULL,
  `fk_user` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `matricula` (`matricula`),
  KEY `fk_user` (`fk_user`),
  CONSTRAINT `alunos_ibfk_1` FOREIGN KEY (`fk_user`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alunos`
--

LOCK TABLES `alunos` WRITE;
/*!40000 ALTER TABLE `alunos` DISABLE KEYS */;
INSERT INTO `alunos` VALUES (1,202401,1),(2,202402,2),(3,202403,3),(4,202404,4),(5,202405,5),(6,202406,6),(7,202407,9),(8,202408,10),(9,202409,11);
/*!40000 ALTER TABLE `alunos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `disciplinas`
--

DROP TABLE IF EXISTS `disciplinas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `disciplinas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(30) DEFAULT NULL,
  `fk_prof` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_prof` (`fk_prof`),
  CONSTRAINT `disciplinas_ibfk_1` FOREIGN KEY (`fk_prof`) REFERENCES `professores` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `disciplinas`
--

LOCK TABLES `disciplinas` WRITE;
/*!40000 ALTER TABLE `disciplinas` DISABLE KEYS */;
INSERT INTO `disciplinas` VALUES (1,'BANCO DE DADOS',1),(2,'LINGUAGEM PHP',1),(3,'HTML',1),(4,'CSS',1),(5,'JAVASCRIPT',2),(6,'GIT E GITHUB',2),(7,'JQUERY',2),(8,'BOOTSTRAP',2);
/*!40000 ALTER TABLE `disciplinas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notas`
--

DROP TABLE IF EXISTS `notas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nota` decimal(10,1) DEFAULT NULL,
  `dataL` date DEFAULT NULL,
  `fk_aluno` int(11) DEFAULT NULL,
  `fk_prof` int(11) DEFAULT NULL,
  `fk_disc` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_aluno` (`fk_aluno`),
  KEY `fk_prof` (`fk_prof`),
  KEY `fk_disc` (`fk_disc`),
  CONSTRAINT `notas_ibfk_1` FOREIGN KEY (`fk_aluno`) REFERENCES `alunos` (`id`),
  CONSTRAINT `notas_ibfk_2` FOREIGN KEY (`fk_prof`) REFERENCES `professores` (`id`),
  CONSTRAINT `notas_ibfk_3` FOREIGN KEY (`fk_disc`) REFERENCES `disciplinas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notas`
--

LOCK TABLES `notas` WRITE;
/*!40000 ALTER TABLE `notas` DISABLE KEYS */;
INSERT INTO `notas` VALUES (1,8.5,'2024-08-01',1,1,1),(2,7.0,'2024-08-02',1,1,2),(3,9.0,'2024-08-03',1,1,3),(4,6.5,'2024-08-04',1,1,4),(5,8.0,'2024-08-05',1,2,5),(6,7.5,'2024-08-06',1,2,6),(7,8.2,'2024-08-07',1,2,7),(8,7.8,'2024-08-08',1,2,8),(9,8.7,'2024-08-01',2,1,1),(10,7.3,'2024-08-02',2,1,2),(11,9.1,'2024-08-03',2,1,3),(12,6.8,'2024-08-04',2,1,4),(13,7.5,'2024-08-05',2,2,5),(14,8.1,'2024-08-06',2,2,6),(15,7.9,'2024-08-07',2,2,7),(16,7.4,'2024-08-08',2,2,8),(17,8.4,'2024-08-01',3,1,1),(18,7.6,'2024-08-02',3,1,2),(19,9.2,'2024-08-03',3,1,3),(20,6.9,'2024-08-04',3,1,4),(21,8.3,'2024-08-05',3,2,5),(22,7.7,'2024-08-06',3,2,6),(23,8.0,'2024-08-07',3,2,7),(24,7.6,'2024-08-08',3,2,8),(25,9.0,'2024-08-01',4,1,1),(26,7.9,'2024-08-02',4,1,2),(27,9.3,'2024-08-03',4,1,3),(28,6.7,'2024-08-04',4,1,4),(29,7.6,'2024-08-05',4,2,5),(30,8.2,'2024-08-06',4,2,6),(31,8.1,'2024-08-07',4,2,7),(32,7.9,'2024-08-08',4,2,8),(33,8.6,'2024-08-01',5,1,1),(34,7.4,'2024-08-02',5,1,2),(35,9.4,'2024-08-03',5,1,3),(36,6.6,'2024-08-04',5,1,4),(37,7.8,'2024-08-05',5,2,5),(38,8.3,'2024-08-06',5,2,6),(39,8.0,'2024-08-07',5,2,7),(40,7.5,'2024-08-08',5,2,8),(41,8.8,'2024-08-01',6,1,1),(42,7.1,'2024-08-02',6,1,2),(43,9.5,'2024-08-03',6,1,3),(44,6.4,'2024-08-04',6,1,4),(45,8.0,'2024-08-05',6,2,5),(46,8.4,'2024-08-06',6,2,6),(47,8.1,'2024-08-07',6,2,7),(48,7.7,'2024-08-08',6,2,8),(49,7.6,'2024-08-27',7,1,1),(50,6.0,'2024-08-27',7,1,2),(51,8.3,'2024-08-27',7,1,3),(52,5.0,'2024-08-27',7,1,4),(53,5.9,'2024-08-27',7,2,5),(54,10.0,'2024-08-27',7,2,6),(55,7.3,'2024-08-27',7,2,7),(56,6.0,'2024-08-27',7,2,8),(57,10.0,'2024-08-27',8,1,1),(58,0.0,'2024-08-27',8,1,2),(59,0.0,'2024-08-27',8,1,3),(60,8.0,'2024-08-27',8,1,4),(61,0.0,'2024-08-27',8,2,5),(62,0.0,'2024-08-27',8,2,6),(63,0.0,'2024-08-27',8,2,7),(64,7.0,'2024-08-27',8,2,8),(65,10.0,'2024-08-27',9,1,1),(66,0.0,'2024-08-27',9,1,2),(67,10.0,'2024-08-27',9,1,3),(68,0.0,'2024-08-27',9,1,4),(69,0.0,'2024-08-27',9,2,5),(70,10.0,'2024-08-27',9,2,6),(71,0.0,'2024-08-27',9,2,7),(72,10.0,'2024-08-27',9,2,8);
/*!40000 ALTER TABLE `notas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `professores`
--

DROP TABLE IF EXISTS `professores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `professores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_user` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user` (`fk_user`),
  CONSTRAINT `professores_ibfk_1` FOREIGN KEY (`fk_user`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `professores`
--

LOCK TABLES `professores` WRITE;
/*!40000 ALTER TABLE `professores` DISABLE KEYS */;
INSERT INTO `professores` VALUES (1,7),(2,8);
/*!40000 ALTER TABLE `professores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(40) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `idade` int(11) DEFAULT NULL,
  `cpf` varchar(30) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `tipo` enum('Professor','Aluno') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'Helder','helder@gmail.com',20,'121.456.789-00','12345','Aluno'),(2,'Matheus','matheus@gmail.com',18,'122.456.789-00','12345','Aluno'),(3,'Ari','ari@gmail.com',27,'123.456.789-00','12345','Aluno'),(4,'Giovanna','giovanna@gmail.com',17,'124.456.789-00','12345','Aluno'),(5,'Gillis','gillis@gmail.com',40,'125.456.789-00','12345','Aluno'),(6,'William','william@gmail.com',17,'126.456.789-00','12345','Aluno'),(7,'Nicholas','nicholas@gmail.com',25,'127.456.789-00','12345','Professor'),(8,'Jhonta','jhonta@gmail.com',28,'128.456.789-00','12345','Professor'),(9,'lucas','lucas@gmail.com',23,'129.456.789-00','12345','Aluno'),(10,'caio','caio@gmail.com',34,'130.456.789-00','12345','Aluno'),(11,'alex','alex@gmail.com',23,'000.456.789-00','12345','Aluno');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-03-21 11:07:30
