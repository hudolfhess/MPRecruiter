-- MySQL dump 10.13  Distrib 5.6.17, for Win64 (x86_64)
--
-- Host: localhost    Database: mprecruiter
-- ------------------------------------------------------
-- Server version	5.6.17

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `job`
--

DROP TABLE IF EXISTS `job`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job`
--

LOCK TABLES `job` WRITE;
/*!40000 ALTER TABLE `job` DISABLE KEYS */;
/*!40000 ALTER TABLE `job` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobquestion`
--

DROP TABLE IF EXISTS `jobquestion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobquestion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `job_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_27BAF229BE04EA9` (`job_id`),
  CONSTRAINT `FK_27BAF229BE04EA9` FOREIGN KEY (`job_id`) REFERENCES `job` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobquestion`
--

LOCK TABLES `jobquestion` WRITE;
/*!40000 ALTER TABLE `jobquestion` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobquestion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobrule`
--

DROP TABLE IF EXISTS `jobrule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobrule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `job_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_content` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_A0E9B005BE04EA9` (`job_id`),
  CONSTRAINT `FK_A0E9B005BE04EA9` FOREIGN KEY (`job_id`) REFERENCES `job` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobrule`
--

LOCK TABLES `jobrule` WRITE;
/*!40000 ALTER TABLE `jobrule` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobrule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobruleconfig`
--

DROP TABLE IF EXISTS `jobruleconfig`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobruleconfig` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `job_rule_id` int(11) DEFAULT NULL,
  `job_question_id` int(11) DEFAULT NULL,
  `min_value` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E123E03FEEA1B4CA` (`job_rule_id`),
  KEY `IDX_E123E03F7D4BEDF6` (`job_question_id`),
  CONSTRAINT `FK_E123E03F7D4BEDF6` FOREIGN KEY (`job_question_id`) REFERENCES `jobquestion` (`id`),
  CONSTRAINT `FK_E123E03FEEA1B4CA` FOREIGN KEY (`job_rule_id`) REFERENCES `jobrule` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobruleconfig`
--

LOCK TABLES `jobruleconfig` WRITE;
/*!40000 ALTER TABLE `jobruleconfig` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobruleconfig` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `register`
--

DROP TABLE IF EXISTS `register`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `register` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `job_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_A68F2242BE04EA9` (`job_id`),
  CONSTRAINT `FK_A68F2242BE04EA9` FOREIGN KEY (`job_id`) REFERENCES `job` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `register`
--

LOCK TABLES `register` WRITE;
/*!40000 ALTER TABLE `register` DISABLE KEYS */;
/*!40000 ALTER TABLE `register` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `registerjobquestion`
--

DROP TABLE IF EXISTS `registerjobquestion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `registerjobquestion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `register_id` int(11) DEFAULT NULL,
  `job_rule_id` int(11) DEFAULT NULL,
  `value` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_37F8A07F4976CB7E` (`register_id`),
  KEY `IDX_37F8A07FEEA1B4CA` (`job_rule_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registerjobquestion`
--

LOCK TABLES `registerjobquestion` WRITE;
/*!40000 ALTER TABLE `registerjobquestion` DISABLE KEYS */;
/*!40000 ALTER TABLE `registerjobquestion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `registerjobrule`
--

DROP TABLE IF EXISTS `registerjobrule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `registerjobrule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `register_id` int(11) DEFAULT NULL,
  `job_rule_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_62AF11F24976CB7E` (`register_id`),
  KEY `IDX_62AF11F2EEA1B4CA` (`job_rule_id`),
  CONSTRAINT `FK_62AF11F2EEA1B4CA` FOREIGN KEY (`job_rule_id`) REFERENCES `jobrule` (`id`),
  CONSTRAINT `FK_62AF11F24976CB7E` FOREIGN KEY (`register_id`) REFERENCES `register` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registerjobrule`
--

LOCK TABLES `registerjobrule` WRITE;
/*!40000 ALTER TABLE `registerjobrule` DISABLE KEYS */;
/*!40000 ALTER TABLE `registerjobrule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `registerquestion`
--

DROP TABLE IF EXISTS `registerquestion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `registerquestion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `register_id` int(11) DEFAULT NULL,
  `job_question_id` int(11) DEFAULT NULL,
  `value` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6C9A0A064976CB7E` (`register_id`),
  KEY `IDX_6C9A0A067D4BEDF6` (`job_question_id`),
  CONSTRAINT `FK_6C9A0A067D4BEDF6` FOREIGN KEY (`job_question_id`) REFERENCES `jobquestion` (`id`),
  CONSTRAINT `FK_6C9A0A064976CB7E` FOREIGN KEY (`register_id`) REFERENCES `register` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registerquestion`
--

LOCK TABLES `registerquestion` WRITE;
/*!40000 ALTER TABLE `registerquestion` DISABLE KEYS */;
/*!40000 ALTER TABLE `registerquestion` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-08-28  3:09:06
