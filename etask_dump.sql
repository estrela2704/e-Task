CREATE DATABASE  IF NOT EXISTS `e-task` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `e-task`;
-- MySQL dump 10.13  Distrib 8.0.36, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: e-task
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.27-MariaDB

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
-- Table structure for table `tasks`
--

DROP TABLE IF EXISTS `tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `status` enum('em_andamento','concluida') NOT NULL,
  `urgent` enum('Não','Sim') NOT NULL,
  `Users_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `task_user_id_idx` (`Users_id`),
  CONSTRAINT `task_user_id` FOREIGN KEY (`Users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tasks`
--

LOCK TABLES `tasks` WRITE;
/*!40000 ALTER TABLE `tasks` DISABLE KEYS */;
INSERT INTO `tasks` VALUES (5,'Johan','Estrela','em_andamento','Não',44),(6,'teste','teste','concluida','Não',44),(15,'teste','teste','em_andamento','Não',44),(17,'teste','123','concluida','Sim',37),(18,'teste 2 ','123','concluida','Sim',37),(19,'teste 3','123','concluida','Sim',37),(20,'teste4','1123','em_andamento','Não',37),(21,'teste5','123','em_andamento','Sim',37),(22,'Bater uma','as 15h30hsd','concluida','Sim',51);
/*!40000 ALTER TABLE `tasks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `image` varchar(200) DEFAULT NULL,
  `token` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (37,'Johan','Estrela','haha@gmail.com','teste','a231656a505412be301aee0dcbf0267ff456f175cb26dc9d18c1178d4330788db468bc2c0db7f86bc438a5e7d27837103d7c','$2y$10$ZfFJwpVSlRTmeg.fZTioQeAgp.v2rvt5yZtuSNt6VXU8o.8vGtJLO'),(44,'John','Doe','john.doe@example.com',NULL,'5d7d6f5762291be031962ada37849d4b07890020cc337e43e7fe92ad2c045895dd0211737da417fc8591d209bfa738352e12','$2y$10$uDi7ZJnWDJ585azVrjO5i.abTL1LU75885PArnB70AjzHZKHEKN.e'),(45,'Felipe','Albuquerque','felipeestrelatv@gmail.com',NULL,'e4f6a3a726809923854f90afcdbe6ecf04a0f8d1838ba69dac18bf2ec7b4c44f1e27b0e4fc479fa5c1577fce36ac192155ae','$2y$10$1OKmQdLZaBNIKsuHqO9Upe5645Whf.SYL505Bayssd73PY7v84Zmi'),(46,'Felipe','Albuquerque','contamail543@gmail.com',NULL,'fc476af2db5b696582c9b845a457266a0fafbfc2a66d58cda29ec80d30662097696a482203d1fab13280392bc472ade5f287','$2y$10$DWl2PvChojRJPFvd8DclEO2TGkN.0NlQoGj5AMTc5jQmSHVYiGxEe'),(48,'John','Doe','john.doe@example.com',NULL,'acf485508791e8c1d865f3a10e8550f18f4e4dd0f0a875ac1aa5dfdd3ff52a342d9319a80ce835de598176f1bc336b3b0eeb','$2y$10$s0usNoeTX7ooQx5Wajvaouh9Ep0XAFEAnrhaRkL6NGQv4ZXsPrYMe'),(49,'Felipe','Albuquerque','riva2005@gmail.com',NULL,'de47b804bd14dc1ffade94b15d39f5a5e9568555a99c0a333c3ff3911ce08b739957292386f7be93ac9dba543cc9728ec0e2','$2y$10$VVW6TlflPGbn2E8DmSlUwuVjHolJagQpiASISrOcFcE3txR/fmMli'),(50,'Felipe','Albuquerque','hahaha@gmail.com',NULL,'e05ad140119d305d3153d44ec91c4da68379a048f513c9e026ba3694d6c43d0f8be7dac14ec94cf4b7bc501e46b2d88e9f92','$2y$10$o7cNBY55wIJpmXXio9hoi.SH/gYwwLpsyJZfSRw436/.54hEUTa9K'),(51,'Maicon','Batista','maicao123@gmail.com',NULL,'55d019fd68fc0953c20e116de4a7a61c15915d69d9e3a6df931db1d974835f4d314154fa967e5b7d469d89a2e386aa745b34','$2y$10$.V7umcEZWUPeXXKtxcIONu3Sg1Yu3na5ad8Q7birfo58pSZfguinW');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-02-09 11:24:07
