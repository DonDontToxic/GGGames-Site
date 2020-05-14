CREATE DATABASE  IF NOT EXISTS `gamedb` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `gamedb`;
-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: testdb1.ccb04kao6nyb.ap-southeast-1.rds.amazonaws.com    Database: gamedb
-- ------------------------------------------------------
-- Server version	5.7.22-log

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
-- Table structure for table `accountInfo`
--

DROP TABLE IF EXISTS `accountInfo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `accountInfo` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Username` varchar(45) NOT NULL,
  `Password` varchar(45) NOT NULL,
  `Mail` varchar(200) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Mail_UNIQUE` (`Mail`),
  UNIQUE KEY `Username_UNIQUE` (`Username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `commentInfo`
--

DROP TABLE IF EXISTS `commentInfo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `commentInfo` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` text NOT NULL,
  `Content` text NOT NULL,
  `Mail` text NOT NULL,
  `DateTime` text NOT NULL,
  `In_gameID` int(11) NOT NULL,
  `CommentedBy` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `gameID_fk_idx` (`In_gameID`),
  KEY `accountID_fk_idx` (`CommentedBy`),
  CONSTRAINT `accountID_fk` FOREIGN KEY (`CommentedBy`) REFERENCES `accountInfo` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `gameID_fk` FOREIGN KEY (`In_gameID`) REFERENCES `gameInfo` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `gameInfo`
--

DROP TABLE IF EXISTS `gameInfo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gameInfo` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` tinytext NOT NULL,
  `Description` text NOT NULL,
  `CDate` date NOT NULL,
  `Category` tinytext NOT NULL,
  `Size` varchar(50) NOT NULL,
  `View` int(11) NOT NULL,
  `Images` text NOT NULL,
  `Videos` text NOT NULL,
  `Downloads` text NOT NULL,
  `VDownloads` text NOT NULL,
  `Buy` text NOT NULL,
  `GPImages` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `requestInfo`
--

DROP TABLE IF EXISTS `requestInfo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `requestInfo` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `GName` text NOT NULL,
  `GVersion` text NOT NULL,
  `Infos` text NOT NULL,
  `DateTime` text NOT NULL,
  `RequestedBy` varchar(45) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `FK_Username_idx` (`RequestedBy`),
  CONSTRAINT `FK_Username` FOREIGN KEY (`RequestedBy`) REFERENCES `accountInfo` (`Username`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-05-14 14:29:31
