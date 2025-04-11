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
  `matricula` int(11) NOT NULL,
  `fk_user` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `matricula` (`matricula`),
  KEY `fk_user` (`fk_user`),
  CONSTRAINT `alunos_ibfk_1` FOREIGN KEY (`fk_user`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alunos`
--

LOCK TABLES `alunos` WRITE;
/*!40000 ALTER TABLE `alunos` DISABLE KEYS */;
INSERT INTO `alunos` VALUES (1,202401,1),(2,202402,2),(3,202403,3),(4,202404,4),(5,202405,5),(6,202406,6),(7,202407,9),(8,202408,10),(9,202409,11),(10,202410,12),(11,202411,13),(12,202412,14),(13,202413,15),(14,202414,16),(15,202415,17),(16,202416,18),(17,202417,19),(18,202418,20),(19,202419,21),(20,202420,22);
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
  `nome` varchar(30) NOT NULL,
  `fk_prof` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_prof` (`fk_prof`),
  CONSTRAINT `disciplinas_ibfk_1` FOREIGN KEY (`fk_prof`) REFERENCES `professores` (`id`) ON DELETE SET NULL
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
  `nota` decimal(5,2) NOT NULL,
  `dataL` date NOT NULL,
  `fk_aluno` int(11) NOT NULL,
  `fk_prof` int(11) NOT NULL,
  `fk_disc` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_aluno` (`fk_aluno`),
  KEY `fk_prof` (`fk_prof`),
  KEY `fk_disc` (`fk_disc`),
  CONSTRAINT `notas_ibfk_1` FOREIGN KEY (`fk_aluno`) REFERENCES `alunos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `notas_ibfk_2` FOREIGN KEY (`fk_prof`) REFERENCES `professores` (`id`) ON DELETE CASCADE,
  CONSTRAINT `notas_ibfk_3` FOREIGN KEY (`fk_disc`) REFERENCES `disciplinas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=161 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notas`
--

LOCK TABLES `notas` WRITE;
/*!40000 ALTER TABLE `notas` DISABLE KEYS */;
INSERT INTO `notas` VALUES (1,8.50,'2024-03-05',1,1,1),(2,7.00,'2024-03-12',1,1,2),(3,9.00,'2024-03-20',1,1,3),(4,6.50,'2024-03-08',1,1,4),(5,8.00,'2024-06-05',1,2,5),(6,7.50,'2024-06-12',1,2,6),(7,8.20,'2024-06-20',1,2,7),(8,7.80,'2024-06-08',1,2,8),(9,8.70,'2024-03-06',2,1,1),(10,7.30,'2024-03-13',2,1,2),(11,9.10,'2024-03-21',2,1,3),(12,6.80,'2024-03-09',2,1,4),(13,7.50,'2024-06-06',2,2,5),(14,8.10,'2024-06-13',2,2,6),(15,7.90,'2024-06-21',2,2,7),(16,7.40,'2024-06-09',2,2,8),(17,8.40,'2024-03-07',3,1,1),(18,7.60,'2024-03-14',3,1,2),(19,9.20,'2024-03-22',3,1,3),(20,6.90,'2024-03-10',3,1,4),(21,8.30,'2024-06-07',3,2,5),(22,7.70,'2024-06-14',3,2,6),(23,8.00,'2024-06-22',3,2,7),(24,7.60,'2024-06-10',3,2,8),(25,9.00,'2024-03-08',4,1,1),(26,7.90,'2024-03-15',4,1,2),(27,9.30,'2024-03-23',4,1,3),(28,6.70,'2024-03-11',4,1,4),(29,7.60,'2024-06-08',4,2,5),(30,8.20,'2024-06-15',4,2,6),(31,8.10,'2024-06-23',4,2,7),(32,7.90,'2024-06-11',4,2,8),(33,8.60,'2024-03-09',5,1,1),(34,7.40,'2024-03-16',5,1,2),(35,9.40,'2024-03-24',5,1,3),(36,6.60,'2024-03-12',5,1,4),(37,7.80,'2024-06-09',5,2,5),(38,8.30,'2024-06-16',5,2,6),(39,8.00,'2024-06-24',5,2,7),(40,7.50,'2024-06-12',5,2,8),(41,8.80,'2024-03-10',6,1,1),(42,7.10,'2024-03-17',6,1,2),(43,9.50,'2024-03-25',6,1,3),(44,6.40,'2024-03-13',6,1,4),(45,8.00,'2024-06-10',6,2,5),(46,8.40,'2024-06-17',6,2,6),(47,8.10,'2024-06-25',6,2,7),(48,7.70,'2024-06-13',6,2,8),(49,7.60,'2024-03-11',7,1,1),(50,6.00,'2024-03-18',7,1,2),(51,8.30,'2024-03-26',7,1,3),(52,5.00,'2024-03-14',7,1,4),(53,5.90,'2024-06-11',7,2,5),(54,10.00,'2024-06-18',7,2,6),(55,7.30,'2024-06-26',7,2,7),(56,6.00,'2024-06-14',7,2,8),(57,10.00,'2024-03-12',8,1,1),(58,0.00,'2024-03-19',8,1,2),(59,0.00,'2024-03-27',8,1,3),(60,8.00,'2024-03-15',8,1,4),(61,0.00,'2024-06-12',8,2,5),(62,0.00,'2024-06-19',8,2,6),(63,0.00,'2024-06-27',8,2,7),(64,7.00,'2024-06-15',8,2,8),(65,10.00,'2024-03-13',9,1,1),(66,0.00,'2024-03-20',9,1,2),(67,10.00,'2024-03-28',9,1,3),(68,0.00,'2024-03-16',9,1,4),(69,0.00,'2024-06-13',9,2,5),(70,10.00,'2024-06-20',9,2,6),(71,0.00,'2024-06-28',9,2,7),(72,10.00,'2024-06-16',9,2,8),(73,8.50,'2024-03-14',10,1,1),(74,7.00,'2024-03-21',10,1,2),(75,9.00,'2024-03-29',10,1,3),(76,6.50,'2024-03-17',10,1,4),(77,8.00,'2024-06-14',10,2,5),(78,7.50,'2024-06-21',10,2,6),(79,8.00,'2024-06-29',10,2,7),(80,7.00,'2024-06-17',10,2,8),(81,8.20,'2024-03-15',11,1,1),(82,7.30,'2024-03-22',11,1,2),(83,8.90,'2024-03-30',11,1,3),(84,6.70,'2024-03-18',11,1,4),(85,7.90,'2024-06-15',11,2,5),(86,8.30,'2024-06-22',11,2,6),(87,7.80,'2024-06-30',11,2,7),(88,7.20,'2024-06-18',11,2,8),(89,9.10,'2024-03-16',12,1,1),(90,8.10,'2024-03-23',12,1,2),(91,9.30,'2024-03-31',12,1,3),(92,7.30,'2024-03-19',12,1,4),(93,8.50,'2024-06-16',12,2,5),(94,8.80,'2024-06-23',12,2,6),(95,8.20,'2024-07-01',12,2,7),(96,7.70,'2024-06-19',12,2,8),(97,7.80,'2024-03-17',13,1,1),(98,6.90,'2024-03-24',13,1,2),(99,8.50,'2024-04-01',13,1,3),(100,6.10,'2024-03-20',13,1,4),(101,7.70,'2024-06-17',13,2,5),(102,8.10,'2024-06-24',13,2,6),(103,7.60,'2024-07-02',13,2,7),(104,7.00,'2024-06-20',13,2,8),(105,8.90,'2024-03-18',14,1,1),(106,8.00,'2024-03-25',14,1,2),(107,9.20,'2024-04-02',14,1,3),(108,7.20,'2024-03-21',14,1,4),(109,8.60,'2024-06-18',14,2,5),(110,8.90,'2024-06-25',14,2,6),(111,8.30,'2024-07-03',14,2,7),(112,7.80,'2024-06-21',14,2,8),(113,7.50,'2024-03-19',15,1,1),(114,6.70,'2024-03-26',15,1,2),(115,8.30,'2024-04-03',15,1,3),(116,5.90,'2024-03-22',15,1,4),(117,7.60,'2024-06-19',15,2,5),(118,8.00,'2024-06-26',15,2,6),(119,7.50,'2024-07-04',15,2,7),(120,6.90,'2024-06-22',15,2,8),(121,8.70,'2024-03-20',16,1,1),(122,7.50,'2024-03-27',16,1,2),(123,9.00,'2024-04-04',16,1,3),(124,6.80,'2024-03-23',16,1,4),(125,8.40,'2024-06-20',16,2,5),(126,8.70,'2024-06-27',16,2,6),(127,8.10,'2024-07-05',16,2,7),(128,7.60,'2024-06-23',16,2,8),(129,9.20,'2024-03-21',17,1,1),(130,8.30,'2024-03-28',17,1,2),(131,9.40,'2024-04-05',17,1,3),(132,7.60,'2024-03-24',17,1,4),(133,8.80,'2024-06-21',17,2,5),(134,9.10,'2024-06-28',17,2,6),(135,8.50,'2024-07-06',17,2,7),(136,8.00,'2024-06-24',17,2,8),(137,7.90,'2024-03-22',18,1,1),(138,7.10,'2024-03-29',18,1,2),(139,8.70,'2024-04-06',18,1,3),(140,6.40,'2024-03-25',18,1,4),(141,8.00,'2024-06-22',18,2,5),(142,8.40,'2024-06-29',18,2,6),(143,7.90,'2024-07-07',18,2,7),(144,7.30,'2024-06-25',18,2,8),(145,8.30,'2024-03-23',19,1,1),(146,7.60,'2024-03-30',19,1,2),(147,8.90,'2024-04-07',19,1,3),(148,6.90,'2024-03-26',19,1,4),(149,8.30,'2024-06-23',19,2,5),(150,8.70,'2024-06-30',19,2,6),(151,8.20,'2024-07-08',19,2,7),(152,7.70,'2024-06-26',19,2,8),(153,8.00,'2024-03-24',20,1,1),(154,7.30,'2024-03-31',20,1,2),(155,8.80,'2024-04-08',20,1,3),(156,6.60,'2024-03-27',20,1,4),(157,8.20,'2024-06-24',20,2,5),(158,8.60,'2024-07-01',20,2,6),(159,8.10,'2024-07-09',20,2,7),(160,7.60,'2024-06-27',20,2,8);
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
  `fk_user` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `fk_user` (`fk_user`),
  CONSTRAINT `professores_ibfk_1` FOREIGN KEY (`fk_user`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE
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
-- Table structure for table `turma_alunos`
--

DROP TABLE IF EXISTS `turma_alunos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `turma_alunos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_turma` int(11) NOT NULL,
  `fk_aluno` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `fk_turma` (`fk_turma`,`fk_aluno`),
  KEY `fk_aluno` (`fk_aluno`),
  CONSTRAINT `turma_alunos_ibfk_1` FOREIGN KEY (`fk_turma`) REFERENCES `turmas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `turma_alunos_ibfk_2` FOREIGN KEY (`fk_aluno`) REFERENCES `alunos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `turma_alunos`
--

LOCK TABLES `turma_alunos` WRITE;
/*!40000 ALTER TABLE `turma_alunos` DISABLE KEYS */;
INSERT INTO `turma_alunos` VALUES (1,1,1),(2,1,2),(3,1,3),(4,1,4),(5,1,5),(6,2,6),(7,2,7),(8,2,8),(9,2,9),(10,2,10),(11,3,11),(12,3,12),(13,3,13),(14,3,14),(15,3,15),(16,4,16),(17,4,17),(18,4,18),(19,4,19),(20,4,20);
/*!40000 ALTER TABLE `turma_alunos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `turmas`
--

DROP TABLE IF EXISTS `turmas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `turmas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `fk_prof` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_prof` (`fk_prof`),
  CONSTRAINT `turmas_ibfk_1` FOREIGN KEY (`fk_prof`) REFERENCES `professores` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `turmas`
--

LOCK TABLES `turmas` WRITE;
/*!40000 ALTER TABLE `turmas` DISABLE KEYS */;
INSERT INTO `turmas` VALUES (1,'Turma A',1),(2,'Turma B',1),(3,'Turma C',2),(4,'Turma D',2);
/*!40000 ALTER TABLE `turmas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(40) NOT NULL,
  `email` varchar(50) NOT NULL,
  `idade` int(11) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `tipo` enum('Professor','Aluno') NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `cpf` (`cpf`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'Helder','helder@gmail.com',20,'121.456.789-00','12345','Aluno'),(2,'Matheus','matheus@gmail.com',18,'122.456.789-00','12345','Aluno'),(3,'Ari','ari@gmail.com',27,'123.456.789-00','12345','Aluno'),(4,'Giovanna','giovanna@gmail.com',17,'124.456.789-00','12345','Aluno'),(5,'Gillis','gillis@gmail.com',40,'125.456.789-00','12345','Aluno'),(6,'William','william@gmail.com',17,'126.456.789-00','12345','Aluno'),(7,'Nicholas','nicholas@gmail.com',25,'127.456.789-00','12345','Professor'),(8,'Jhonta','jhonta@gmail.com',28,'128.456.789-00','12345','Professor'),(9,'lucas','lucas@gmail.com',23,'129.456.789-00','12345','Aluno'),(10,'caio','caio@gmail.com',34,'130.456.789-00','12345','Aluno'),(11,'alex','alex@gmail.com',23,'000.456.789-00','12345','Aluno'),(12,'Pedro','pedro@gmail.com',21,'001.456.789-00','12345','Aluno'),(13,'Gabriel','gabriel@gmail.com',23,'020.456.789-00','12345','Aluno'),(14,'Rafael','rafael@gmail.com',19,'002.456.789-00','12345','Aluno'),(15,'Felipe','felipe@gmail.com',22,'003.456.789-00','12345','Aluno'),(16,'Gabriele','gabriele@gmail.com',20,'004.456.789-00','12345','Aluno'),(17,'Marcos','marcos@gmail.com',24,'005.456.789-00','12345','Aluno'),(18,'Leonardo','leonardo@gmail.com',18,'006.456.789-00','12345','Aluno'),(19,'Thiago','thiago@gmail.com',21,'007.456.789-00','12345','Aluno'),(20,'Yasmim','yasmim@gmail.com',22,'008.456.789-00','12345','Aluno'),(21,'Daniel','daniel@gmail.com',31,'009.456.789-00','12345','Aluno'),(22,'Bruno','bruno@gmail.com',40,'010.456.789-00','12345','Aluno');
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

-- Dump completed on 2025-04-10 20:36:35
