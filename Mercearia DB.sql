-- MySQL dump 10.13  Distrib 8.0.40, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: mercearia
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
-- Table structure for table `historico_encomendas`
--

DROP TABLE IF EXISTS `historico_encomendas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `historico_encomendas` (
  `encomenda_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `apelido` varchar(255) NOT NULL,
  `nascimento` date DEFAULT NULL,
  `telefone` varchar(20) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `data_encomenda` datetime NOT NULL DEFAULT current_timestamp(),
  `status` enum('Pendente','Aprovada','Rejeitada') NOT NULL DEFAULT 'Pendente',
  PRIMARY KEY (`encomenda_id`),
  KEY `user_id_idx` (`user_id`),
  CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `historico_encomendas`
--

LOCK TABLES `historico_encomendas` WRITE;
/*!40000 ALTER TABLE `historico_encomendas` DISABLE KEYS */;
INSERT INTO `historico_encomendas` VALUES (1,2,'SrNando1','Fernando','Gonçalves',NULL,'912345678','Rua Acacias, Nº23, 5ºFt',13.50,'2025-01-16 16:41:48','Aprovada');
/*!40000 ALTER TABLE `historico_encomendas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `itens_encomenda`
--

DROP TABLE IF EXISTS `itens_encomenda`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `itens_encomenda` (
  `itens_id` int(11) NOT NULL AUTO_INCREMENT,
  `encomenda_id` int(11) NOT NULL,
  `produto_id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `preco_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  PRIMARY KEY (`itens_id`),
  KEY `encomenda_id` (`encomenda_id`),
  KEY `produto_id_idx` (`produto_id`),
  CONSTRAINT `itens_encomenda_ibfk_1` FOREIGN KEY (`encomenda_id`) REFERENCES `historico_encomendas` (`encomenda_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `produto_id` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`Produto_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `itens_encomenda`
--

LOCK TABLES `itens_encomenda` WRITE;
/*!40000 ALTER TABLE `itens_encomenda` DISABLE KEYS */;
INSERT INTO `itens_encomenda` VALUES (1,1,1,'Maçã',1,3.50,3.50),(2,1,2,'Banana',1,3.00,3.00),(3,1,3,'Uva',1,7.00,7.00);
/*!40000 ALTER TABLE `itens_encomenda` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produtos`
--

DROP TABLE IF EXISTS `produtos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `produtos` (
  `Produto_id` int(11) NOT NULL AUTO_INCREMENT,
  `Nome` varchar(255) NOT NULL,
  `Categoria` varchar(255) NOT NULL,
  `Preço` decimal(10,2) NOT NULL,
  `Marca` varchar(255) NOT NULL,
  `Em_Promocao` tinyint(1) NOT NULL,
  `Sem_Gluten` tinyint(1) NOT NULL,
  `Sem_Lactose` tinyint(1) NOT NULL,
  `Vegetariano` tinyint(1) NOT NULL,
  `Vegan` tinyint(1) NOT NULL,
  `Biologico` tinyint(1) NOT NULL,
  `Stock` int(255) NOT NULL,
  `Destaque` tinyint(1) NOT NULL,
  PRIMARY KEY (`Produto_id`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produtos`
--

LOCK TABLES `produtos` WRITE;
/*!40000 ALTER TABLE `produtos` DISABLE KEYS */;
INSERT INTO `produtos` VALUES (1,'Maçã','Fruta',3.50,'WhiteBrand',0,1,1,1,1,1,100,1),(2,'Banana','Fruta',3.00,'WhiteBrand',1,1,1,1,1,1,100,1),(3,'Uva','Fruta',7.00,'WhiteBrand',0,1,1,1,1,1,100,1),(4,'Laranja','Fruta',5.00,'Mercearia',1,1,1,1,1,1,100,1),(5,'Manga','Fruta',6.50,'Mercearia',0,1,1,1,1,1,100,1),(6,'Pêra','Fruta',4.00,'Mercearia',1,1,1,1,1,1,100,1),(7,'Abacaxi','Fruta',8.00,'Deluxe',0,1,1,1,1,1,100,1),(8,'Kiwi','Fruta',9.00,'Deluxe',1,1,1,1,1,1,100,1),(9,'Coco','Fruta',12.00,'Deluxe',0,1,1,1,1,1,100,1),(10,'Morango','Fruta',6.00,'Deluxe',0,1,1,1,1,1,100,1),(11,'Cenoura','Legumes',3.50,'WhiteBrand',0,1,1,1,1,1,100,1),(12,'Batata','Legumes',2.00,'WhiteBrand',0,1,1,1,1,1,100,1),(13,'Abobrinha','Legumes',4.00,'WhiteBrand',1,1,1,1,1,1,100,0),(14,'Tomate','Legumes',5.00,'Mercearia',1,1,1,1,1,1,100,0),(15,'Pepino','Legumes',3.80,'Mercearia',0,1,1,1,1,1,100,0),(16,'Alface','Legumes',2.50,'Mercearia',1,1,1,1,1,1,100,0),(17,'Espinafre','Legumes',6.00,'Deluxe',0,1,1,1,1,1,100,0),(18,'Berinjela','Legumes',4.50,'Deluxe',1,1,1,1,1,1,100,0),(19,'Brócolis','Legumes',7.00,'Deluxe',0,1,1,1,1,1,100,0),(20,'Pimentão','Legumes',5.50,'Deluxe',1,1,1,1,1,1,100,0),(21,'Leite Integral','Laticínios',4.50,'WhiteBrand',0,1,0,1,0,1,100,0),(22,'Queijo Minas Frescal','Laticínios',10.00,'WhiteBrand',1,1,0,1,0,1,100,0),(23,'Yogurte Natural','Laticínios',5.00,'WhiteBrand',0,1,0,1,0,1,100,0),(24,'Queijo Vegano (feito de amêndoas)','Laticínios',15.00,'Mercearia',1,1,1,1,1,1,100,0),(25,'Leite de Amêndoas','Laticínios',8.00,'Mercearia',0,1,1,1,1,1,100,0),(26,'Queijo Parmesão','Laticínios',20.00,'Mercearia',1,1,0,1,0,1,100,0),(27,'Leite de Coco','Laticínios',9.00,'Deluxe',0,1,1,1,1,1,100,0),(28,'Queijo Cottage','Laticínios',12.00,'Deluxe',0,1,0,1,0,1,100,0),(29,'Iogurte Vegano (feito de coco)','Laticínios',6.50,'Deluxe',1,1,1,1,1,1,100,0),(30,'Ricota','Laticínios',7.50,'Deluxe',0,1,0,1,0,1,100,0),(31,'Frango Orgânico','Carnes',15.00,'WhiteBrand',0,1,1,0,0,1,100,0),(32,'Carne de Vaca (Bovina)','Carnes',25.00,'WhiteBrand',0,1,1,0,0,1,100,0),(33,'Carne de Porco','Carnes',18.00,'WhiteBrand',0,1,1,0,0,1,100,0),(34,'Salsicha Vegana','Carnes',12.00,'Mercearia',1,1,1,1,1,1,100,0),(35,'Almôndega de Soja','Carnes',8.00,'Mercearia',0,1,1,1,1,1,100,0),(36,'Carne de Frango Vegetal','Carnes',14.00,'Mercearia',1,1,1,1,1,1,100,0),(37,'Linguiça Vegetal','Carnes',10.00,'Deluxe',0,1,1,1,1,1,100,0),(38,'Carne Moída de Frango','Carnes',20.00,'Deluxe',0,1,1,0,0,1,100,0),(39,'Hambúrguer Vegano','Carnes',12.00,'Deluxe',1,1,1,1,1,1,100,0),(40,'Peito de Peru Orgânico','Carnes',22.00,'Deluxe',0,1,1,0,0,1,100,0),(41,'Pão Integral','Padaria',5.00,'WhiteBrand',0,0,1,1,1,1,100,0),(42,'Pão de Forma Sem Glúten','Padaria',10.00,'WhiteBrand',1,1,1,1,1,1,100,0),(43,'Baguete','Padaria',6.00,'WhiteBrand',0,0,1,1,1,0,100,0),(44,'Croissant Vegano','Padaria',7.50,'Mercearia',1,0,1,1,1,0,100,0),(45,'Pão de Queijo (sem glúten e sem lactose)','Padaria',8.00,'Mercearia',0,1,1,1,0,1,100,0),(46,'Bolo de Cenoura Vegano','Padaria',9.00,'Mercearia',1,0,1,1,1,1,100,0),(47,'Bolo de Chocolate Sem Glúten','Padaria',10.50,'Deluxe',1,1,1,1,1,1,100,0),(48,'Pão de Alho','Padaria',5.50,'Deluxe',0,0,0,1,0,0,100,0),(49,'Pão de Centeio','Padaria',6.50,'Deluxe',0,0,1,1,1,1,100,0),(50,'Biscoito de Aveia Sem Glúten','Padaria',4.00,'Deluxe',0,1,1,1,1,1,100,0),(51,'Maçã Verde','Frutas',5.00,'WhiteBrand',0,1,1,1,1,1,100,0),(52,'Maçã Vermelha','Frutas',3.50,'WhiteBrand',0,1,1,1,1,1,100,0),(53,'Maçã Fuji','Frutas',3.00,'WhiteBrand',0,1,1,1,1,1,100,0),(54,'Banana Da Terra','Frutas',3.00,'WhiteBrand',0,1,1,1,1,1,100,0),(55,'Banana Da Madeira','Frutas',2.00,'Mercearia',0,1,1,1,1,1,100,1);
/*!40000 ALTER TABLE `produtos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `apelido` varchar(255) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `idade` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `telefone` varchar(15) NOT NULL,
  `nascimento` date NOT NULL,
  `genero` enum('masculino','feminino','outro') NOT NULL,
  `data_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_admin` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'SrNando','Fernando','Gonçalves','Rua Das Acacias, n23, 5ºFt',14,'fernandosantosav135@gmail.com','$2y$10$ZgHOUbiuCj8/eMf1kMYCAeKgwLwZulJe7U75I9b8i9Hyt0kLSpxtO','912345678','2010-05-23','masculino','2025-01-16 16:21:27',1),(2,'SrNando1','Fernando','Gonçalves','Rua Acacias, Nº23, 5ºFt',23,'fernandosantosav135@gmail.com','$2y$10$063h5pX6e809QymZDLYFL.miQjXtk1TCl7ibmQASCbBLInoiuImBy','912345678','2001-04-23','masculino','2025-01-16 16:40:57',0);
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

-- Dump completed on 2025-01-16 16:49:26
