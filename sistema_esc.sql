-- Criação do banco de dados
drop DATABASE IF EXISTS sistema_esc;
CREATE DATABASE IF NOT EXISTS sistema_esc;
USE sistema_esc;

-- Tabela de usuários
DROP TABLE IF EXISTS usuarios;
CREATE TABLE usuarios (
  id INT NOT NULL AUTO_INCREMENT,
  nome VARCHAR(40) NOT NULL,
  email VARCHAR(50) UNIQUE NOT NULL,
  idade INT NOT NULL,
  cpf VARCHAR(14) UNIQUE NOT NULL,
  senha VARCHAR(255) NOT NULL,
  tipo ENUM('Professor','Aluno', "Administrador") NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabela de disciplinas
DROP TABLE IF EXISTS disciplinas;
CREATE TABLE disciplinas (
  id INT NOT NULL AUTO_INCREMENT,
  nome VARCHAR(30) NOT NULL,
  PRIMARY KEY (id)
  );
  
DROP TABLE IF EXISTS administradores;
CREATE TABLE administradores (
 id INT NOT NULL AUTO_INCREMENT,
  fk_user INT NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY (fk_user),
  FOREIGN KEY (fk_user) REFERENCES usuarios (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabela de professores
DROP TABLE IF EXISTS professores;
CREATE TABLE professores (
  id INT NOT NULL AUTO_INCREMENT,
  fk_user INT NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY (fk_user),
  FOREIGN KEY (fk_user) REFERENCES usuarios (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabela de alunos
DROP TABLE IF EXISTS alunos;
CREATE TABLE alunos (
  id INT NOT NULL AUTO_INCREMENT,
  matricula INT NOT NULL UNIQUE,
  fk_user INT NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (fk_user) REFERENCES usuarios (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- Tabela de turmas
DROP TABLE IF EXISTS turmas;
CREATE TABLE turmas (
  id INT NOT NULL AUTO_INCREMENT,
  nome VARCHAR(50) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE prof_disc_turma (
  id INT AUTO_INCREMENT PRIMARY KEY,
  fk_prof INT NOT NULL,
  fk_disc INT NOT NULL,
  fk_turma INT NOT NULL,
  FOREIGN KEY (fk_prof) REFERENCES professores(id) ON DELETE CASCADE,
  FOREIGN KEY (fk_disc) REFERENCES disciplinas(id) ON DELETE CASCADE,
  FOREIGN KEY (fk_turma) REFERENCES turmas(id) ON DELETE CASCADE,
  UNIQUE KEY (fk_prof, fk_disc, fk_turma)
);

-- Tabela de relação alunos-turmas
DROP TABLE IF EXISTS turma_alunos;
CREATE TABLE turma_alunos (
  id INT NOT NULL AUTO_INCREMENT,
  fk_turma INT NOT NULL,
  fk_aluno INT NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (fk_turma) REFERENCES turmas(id) ON DELETE CASCADE,
  FOREIGN KEY (fk_aluno) REFERENCES alunos(id) ON DELETE CASCADE,
  UNIQUE KEY (fk_turma, fk_aluno)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabela de notas
DROP TABLE IF EXISTS notas;
CREATE TABLE notas (
  id INT NOT NULL AUTO_INCREMENT,
  nota DECIMAL(5,2) NOT NULL,
  dataL DATE NOT NULL,
  fk_aluno INT NOT NULL,
  fk_prof INT NOT NULL,
  fk_disc INT NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (fk_aluno) REFERENCES alunos (id) ON DELETE CASCADE,
  FOREIGN KEY (fk_prof) REFERENCES professores (id) ON DELETE CASCADE,
  FOREIGN KEY (fk_disc) REFERENCES disciplinas (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

    
-- Inserção de dados na tabela usuarios
LOCK TABLES usuarios WRITE;
INSERT INTO usuarios VALUES 
(1,'Helder','helder@gmail.com',20,'121.456.789-00','12345','Aluno'),
(2,'Matheus','matheus@gmail.com',18,'122.456.789-00','12345','Aluno'),
(3,'Ari','ari@gmail.com',27,'123.456.789-00','12345','Aluno'),
(4,'Giovanna','giovanna@gmail.com',17,'124.456.789-00','12345','Aluno'),
(5,'Gillis','gillis@gmail.com',40,'125.456.789-00','12345','Aluno'),
(6,'William','william@gmail.com',17,'126.456.789-00','12345','Aluno'),
(7,'Nicholas','nicholas@gmail.com',25,'127.456.789-00','12345','Professor'),
(8,'Jhonta','jhonta@gmail.com',28,'128.456.789-00','12345','Professor'),
(9,'lucas','lucas@gmail.com',23,'129.456.789-00','12345','Aluno'),
(10,'caio','caio@gmail.com',34,'130.456.789-00','12345','Aluno'),
(11,'alex','alex@gmail.com',23,'000.456.789-00','12345','Aluno'),
(12,'Pedro','pedro@gmail.com',21,'001.456.789-00','12345','Aluno'),
(13,'Gabriel','gabriel@gmail.com',23,'020.456.789-00','12345','Aluno'),
(14, 'Rafael', 'rafael@gmail.com', 19, '002.456.789-00', '12345', 'Aluno'),
(15, 'Felipe', 'felipe@gmail.com', 22, '003.456.789-00', '12345', 'Aluno'),
(16, 'Gabriele', 'gabriele@gmail.com', 20, '004.456.789-00', '12345', 'Aluno'),
(17, 'Marcos', 'marcos@gmail.com', 24, '005.456.789-00', '12345', 'Aluno'),
(18, 'Leonardo', 'leonardo@gmail.com', 18, '006.456.789-00', '12345', 'Aluno'),
(19, 'Thiago', 'thiago@gmail.com', 21, '007.456.789-00', '12345', 'Aluno'),
(20, 'Yasmim', 'yasmim@gmail.com', 22, '008.456.789-00', '12345', 'Aluno'),
(21, 'Daniel', 'daniel@gmail.com', 31, '009.456.789-00', '12345', 'Aluno'),
(22, 'Bruno', 'bruno@gmail.com', 40, '010.456.789-00', '12345', 'Aluno'),
(23, 'Fernando', 'fernando@gmail.com', 60, '011.456.789-00', '12345', 'Administrador'),
(24, 'Fernanda', 'fernanda@gmail.com', 55, '012.456.789-00', '12345', 'Administrador');
UNLOCK TABLES;

LOCK TABLES disciplinas WRITE;
INSERT INTO disciplinas VALUES 
(1,'BANCO DE DADOS'), 
(2,'LINGUAGEM PHP'),
(3,'HTML'), 
(4,'CSS'),
(5,'JAVASCRIPT'),
(6,'GIT E GITHUB'),
(7,'JQUERY'),
(8,'BOOTSTRAP');
UNLOCK TABLES;
-- Inserção de dados na tabela professores
LOCK TABLES professores WRITE;
INSERT INTO professores VALUES (1,7),(2,8); -- 1 relaciona com Nicholas e 2 relaciona com Jhonta
UNLOCK TABLES;

LOCK TABLES administradores WRITE;
INSERT INTO administradores VALUES (1,23),(2,24); -- 1 relaciona com Fernando e 2 relaciona com Fernanda
UNLOCK TABLES;

-- Inserção de dados na tabela alunos
LOCK TABLES alunos WRITE;
INSERT INTO alunos VALUES 
(1,202401,1),  -- Relaciona com usuário Helder (id 1)
(2,202402,2), -- Relaciona com usuário Matheus (id 2)
(3,202403,3), -- Relaciona com usuário Ari (id 3)
(4,202404,4),  -- Relaciona com usuário Giovanna (id 4)
(5,202405,5), -- Relaciona com usuário Gillis (id 5)
(6,202406,6), -- Relaciona com usuário william (id 6)
(7,202407,9), -- Relaciona com usuário lucas (id 9)
(8,202408,10), -- Relaciona com usuário caio (id 10)
(9,202409,11), -- Relaciona com usuário alex (id 11)
(10, 202410, 12),  -- Relaciona com usuário Pedro (id 12)
(11, 202411, 13),  -- Relaciona com usuário Gabriel (id 13
(12, 202412, 14), -- Relaciona com usuário Rafael (id 14)
(13, 202413, 15),  -- Relaciona com usuário Felipe (id 15)
(14, 202414, 16),  -- Relaciona com usuário Gabriele (id 16)
(15, 202415, 17),  -- Relaciona com usuário Marcos (id 17)
(16, 202416, 18),  -- Relaciona com usuário Leonardo (id 18)
(17, 202417, 19),  -- Relaciona com usuário Thiago (id 19)
(18, 202418, 20),  -- Relaciona com usuário yasmim (id 20)
(19, 202419, 21),  -- Relaciona com usuário Daniel (id 21)
(20, 202420, 22); -- Relaciona com usuário Bruno (id 22)
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `professores`
--

LOCK TABLES `professores` WRITE;
/*!40000 ALTER TABLE `professores` DISABLE KEYS */;
INSERT INTO `professores` VALUES (1,7),(2,8),(4,26);
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
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `turma_alunos`
--

LOCK TABLES `turma_alunos` WRITE;
/*!40000 ALTER TABLE `turma_alunos` DISABLE KEYS */;
INSERT INTO `turma_alunos` VALUES (21,1,1),(2,1,2),(3,1,3),(4,1,4),(5,1,5),(6,2,6),(7,2,7),(8,2,8),(9,2,9),(10,2,10),(11,3,11),(12,3,12),(13,3,13),(14,3,14),(15,3,15),(16,4,16),(17,4,17),(18,4,18),(19,4,19),(20,4,20);
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `turmas`
--

LOCK TABLES `turmas` WRITE;
/*!40000 ALTER TABLE `turmas` DISABLE KEYS */;
INSERT INTO `turmas` VALUES (1,'Turma A'),(2,'Turma B'),(3,'Turma C'),(4,'Turma D');
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
  `tipo` enum('Professor','Aluno','Administrador') NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `cpf` (`cpf`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'Helder','helder@gmail.com',20,'121.456.789-00','12345','Aluno'),(2,'Matheus','matheus@gmail.com',18,'122.456.789-00','12345','Aluno'),(3,'Ari','ari@gmail.com',27,'123.456.789-00','12345','Aluno'),(4,'Giovanna','giovanna@gmail.com',17,'124.456.789-00','12345','Aluno'),(5,'Gillis','gillis@gmail.com',40,'125.456.789-00','12345','Aluno'),(6,'William','william@gmail.com',17,'126.456.789-00','12345','Aluno'),(7,'Nicholas','nicholas@gmail.com',25,'127.456.789-00','12345','Professor'),(8,'Jhonta','jhonta@gmail.com',28,'128.456.789-00','12345','Professor'),(9,'lucas','lucas@gmail.com',23,'129.456.789-00','12345','Aluno'),(10,'caio','caio@gmail.com',34,'130.456.789-00','12345','Aluno'),(11,'alex','alex@gmail.com',23,'000.456.789-00','12345','Aluno'),(12,'Pedro','pedro@gmail.com',21,'001.456.789-00','12345','Aluno'),(13,'Gabriel','gabriel@gmail.com',23,'020.456.789-00','12345','Aluno'),(14,'Rafael','rafael@gmail.com',19,'002.456.789-00','12345','Aluno'),(15,'Felipe','felipe@gmail.com',22,'003.456.789-00','12345','Aluno'),(16,'Gabriele','gabriele@gmail.com',20,'004.456.789-00','12345','Aluno'),(17,'Marcos','marcos@gmail.com',24,'005.456.789-00','12345','Aluno'),(18,'Leonardo','leonardo@gmail.com',18,'006.456.789-00','12345','Aluno'),(19,'Thiago','thiago@gmail.com',21,'007.456.789-00','12345','Aluno'),(20,'Yasmim','yasmim@gmail.com',22,'008.456.789-00','12345','Aluno'),(21,'Daniel','daniel@gmail.com',31,'009.456.789-00','12345','Aluno'),(22,'Bruno','bruno@gmail.com',40,'010.456.789-00','12345','Aluno'),(23,'Fernando','fernando@gmail.com',60,'011.456.789-00','12345','Administrador'),(24,'Fernanda','fernanda@gmail.com',55,'012.456.789-00','12345','Administrador'),(26,'jose','jose@gmail.com',32,'123.456.147-76','12345','Professor');
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

