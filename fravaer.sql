CREATE DATABASE  IF NOT EXISTS `fravaer` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `fravaer`;
-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: fravaer
-- ------------------------------------------------------
-- Server version	5.7.23

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
-- Table structure for table `aarsak`
--

DROP TABLE IF EXISTS `aarsak`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aarsak` (
  `aarsak_id` int(11) NOT NULL AUTO_INCREMENT,
  `aarsak_tekst` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`aarsak_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aarsak`
--

LOCK TABLES `aarsak` WRITE;
/*!40000 ALTER TABLE `aarsak` DISABLE KEYS */;
INSERT INTO `aarsak` VALUES (1,'For sent'),(2,'Tannlege'),(3,'Forsov seg'),(4,'Skulk'),(5,'Diverse'),(6,'Eksamen'),(7,'Legetime'),(8,'Helsemessige grunner'),(9,'Syk uten legeerklæring'),(10,'Syk med legeerklæring');
/*!40000 ALTER TABLE `aarsak` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `elev`
--

DROP TABLE IF EXISTS `elev`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `elev` (
  `elevnummer` int(11) NOT NULL AUTO_INCREMENT,
  `fornavn` varchar(45) DEFAULT NULL,
  `etternavn` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`elevnummer`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `elev`
--

LOCK TABLES `elev` WRITE;
/*!40000 ALTER TABLE `elev` DISABLE KEYS */;
INSERT INTO `elev` VALUES (1,'Erik','Salvesen'),(2,'Laurits','Lind'),(3,'Stig','Andersen'),(4,'Eva','Grude'),(5,'Henriette','Braathen'),(8,'Christoffer','Solbakken');
/*!40000 ALTER TABLE `elev` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fravaer`
--

DROP TABLE IF EXISTS `fravaer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fravaer` (
  `elevnummer` int(11) NOT NULL,
  `aarsak_id` int(11) NOT NULL,
  `dato` date DEFAULT NULL,
  `antall_timer` int(11) DEFAULT NULL,
  PRIMARY KEY (`elevnummer`,`aarsak_id`),
  KEY `fk_fravaer_elev_idx` (`elevnummer`),
  KEY `fk_fravaer_aarsak1_idx` (`aarsak_id`),
  CONSTRAINT `fk_fravaer_aarsak1` FOREIGN KEY (`aarsak_id`) REFERENCES `aarsak` (`aarsak_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_fravaer_elev` FOREIGN KEY (`elevnummer`) REFERENCES `elev` (`elevnummer`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fravaer`
--

LOCK TABLES `fravaer` WRITE;
/*!40000 ALTER TABLE `fravaer` DISABLE KEYS */;
INSERT INTO `fravaer` VALUES (1,2,'2019-05-06',1),(1,6,'2019-05-14',5),(2,3,'2018-12-20',2),(2,8,'2019-02-01',3),(3,1,'2019-04-26',5),(3,10,'2018-08-17',1),(4,3,'2019-03-07',2),(4,4,'2018-09-30',2),(4,5,'2018-10-09',1),(4,9,'2019-01-05',3),(5,10,'2018-11-21',1);
/*!40000 ALTER TABLE `fravaer` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-04-26 14:02:10
