CREATE DATABASE  IF NOT EXISTS `kadecaminh` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `kadecaminh`;
-- MySQL dump 10.13  Distrib 5.5.16, for Win32 (x86)
--
-- Host: localhost    Database: kadecaminh
-- ------------------------------------------------------
-- Server version	5.5.24

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
-- Table structure for table `profile`
--

DROP TABLE IF EXISTS `profile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `profile` (
  `id` char(4) NOT NULL,
  `descr` varchar(45) NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `super` tinyint(1) NOT NULL DEFAULT '0',
  `intern` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profile`
--

LOCK TABLES `profile` WRITE;
/*!40000 ALTER TABLE `profile` DISABLE KEYS */;
INSERT INTO `profile` VALUES ('ADMN','Administrador',1,1,1),('CLIE','Cliente Normal',1,0,0),('FUNC','Funcionário Normal',1,0,1);
/*!40000 ALTER TABLE `profile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `link_confirm`
--

DROP TABLE IF EXISTS `link_confirm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `link_confirm` (
  `user_login` varchar(20) NOT NULL,
  `hash` varchar(32) NOT NULL,
  PRIMARY KEY (`user_login`),
  UNIQUE KEY `hash_UNIQUE` (`hash`),
  CONSTRAINT `fk_link_confirm_user1` FOREIGN KEY (`user_login`) REFERENCES `user` (`login`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `link_confirm`
--

LOCK TABLES `link_confirm` WRITE;
/*!40000 ALTER TABLE `link_confirm` DISABLE KEYS */;
/*!40000 ALTER TABLE `link_confirm` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `person_entity`
--

DROP TABLE IF EXISTS `person_entity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `person_entity` (
  `person_id` bigint(20) unsigned NOT NULL,
  `cnpj` char(14) NOT NULL,
  `ie` varchar(18) DEFAULT NULL,
  `contact` varchar(255) NOT NULL,
  PRIMARY KEY (`person_id`),
  UNIQUE KEY `cnpj_UNIQUE` (`cnpj`),
  CONSTRAINT `fk_person_entity_person1` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `person_entity`
--

LOCK TABLES `person_entity` WRITE;
/*!40000 ALTER TABLE `person_entity` DISABLE KEYS */;
/*!40000 ALTER TABLE `person_entity` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vehicle_traveling`
--

DROP TABLE IF EXISTS `vehicle_traveling`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vehicle_traveling` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `vehicle_type_id` int(10) unsigned NOT NULL,
  `date_hr_proc` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `source` enum('WEB','SMS') NOT NULL DEFAULT 'WEB',
  `address_id` bigint(20) unsigned NOT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `status` enum('ONLY_VIEW','UTILIZED','NONE','CANCEL') NOT NULL DEFAULT 'NONE',
  PRIMARY KEY (`id`),
  KEY `idx_qmain` (`date_hr_proc`,`status`),
  KEY `fk_vehicle_traveling_address1` (`address_id`),
  KEY `FK_vehicle_traveling_type` (`vehicle_type_id`),
  CONSTRAINT `fk_vehicle_traveling_address1` FOREIGN KEY (`address_id`) REFERENCES `address` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_vehicle_traveling_type` FOREIGN KEY (`vehicle_type_id`) REFERENCES `vehicle_type` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1000 DEFAULT CHARSET=latin1 PACK_KEYS=1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehicle_traveling`
--

LOCK TABLES `vehicle_traveling` WRITE;
/*!40000 ALTER TABLE `vehicle_traveling` DISABLE KEYS */;
/*!40000 ALTER TABLE `vehicle_traveling` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,TRADITIONAL,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `kadecaminh`.`ao_inserir`
BEFORE INSERT ON `kadecaminh`.`vehicle_traveling`
FOR EACH ROW
BEGIN 
    IF (NEW.status = 'NONE') THEN
        call add_idx_traveling_city(NEW.address_id);
    END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,TRADITIONAL,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `kadecaminh`.`ao_atualizar`
BEFORE UPDATE ON `kadecaminh`.`vehicle_traveling`
FOR EACH ROW
BEGIN 
    IF (NEW.status = 'UTILIZED' || NEW.status = 'CANCEL') THEN
        call remove_idx_traveling_city(NEW.address_id);
    ELSEIF (NEW.status = 'NONE') THEN
        call add_idx_traveling_city(NEW.address_id);
    END IF;
    
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `user_profile`
--

DROP TABLE IF EXISTS `user_profile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_profile` (
  `users_login` varchar(20) NOT NULL,
  `profile_id` char(4) NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`users_login`,`profile_id`),
  KEY `fk_users_has_profile_profile1` (`profile_id`),
  KEY `fk_users_has_profile_users1` (`users_login`),
  CONSTRAINT `fk_users_has_profile_profile1` FOREIGN KEY (`profile_id`) REFERENCES `profile` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_has_profile_users1` FOREIGN KEY (`users_login`) REFERENCES `user` (`login`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_profile`
--

LOCK TABLES `user_profile` WRITE;
/*!40000 ALTER TABLE `user_profile` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_profile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_method`
--

DROP TABLE IF EXISTS `payment_method`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment_method` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `descr` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_method`
--

LOCK TABLES `payment_method` WRITE;
/*!40000 ALTER TABLE `payment_method` DISABLE KEYS */;
/*!40000 ALTER TABLE `payment_method` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `idx_traveling_city`
--

DROP TABLE IF EXISTS `idx_traveling_city`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `idx_traveling_city` (
  `state` char(2) NOT NULL,
  `city` varchar(45) NOT NULL,
  `state_nm` varchar(72) DEFAULT NULL,
  `qty_real` bigint(20) unsigned NOT NULL DEFAULT '1',
  `qty_illus` bigint(20) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`state`,`city`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `idx_traveling_city`
--

LOCK TABLES `idx_traveling_city` WRITE;
/*!40000 ALTER TABLE `idx_traveling_city` DISABLE KEYS */;
INSERT INTO `idx_traveling_city` VALUES ('AM','Manaus','Amazonas',0,2),('AP','Macapá','Amapá',0,14),('GO','Itumbiara','Goiás',0,4),('MG','Araxá','Minas Gerais',0,5),('MT','Cuiabá','Mato Grosso',0,12),('PA','Belém','Pará',0,3),('PE','Cabrobó','Pernambuco',0,19),('PR','Cambé','Paraná',0,9),('PR','Curitiba','Paraná',0,26),('PR','Londrina','Paraná',0,15),('PR','Mandaguari','Paraná',0,21);
/*!40000 ALTER TABLE `idx_traveling_city` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `phone`
--

DROP TABLE IF EXISTS `phone`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phone` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `phone` varchar(11) NOT NULL,
  `ddd` varchar(3) NOT NULL,
  `ddi` varchar(3) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_phone` (`ddi`,`ddd`,`phone`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `phone`
--

LOCK TABLES `phone` WRITE;
/*!40000 ALTER TABLE `phone` DISABLE KEYS */;
/*!40000 ALTER TABLE `phone` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `login` varchar(20) NOT NULL,
  `person_id` bigint(20) unsigned NOT NULL,
  `password` varchar(32) NOT NULL,
  `status` enum('PEND','CHEK','BLCK','CANC') NOT NULL DEFAULT 'PEND',
  `text` text,
  `date_cad` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dt_hr_alt` timestamp NULL DEFAULT NULL,
  `user_alt_login` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`login`),
  UNIQUE KEY `login_UNIQUE` (`login`),
  KEY `fk_user_user1_idx` (`user_alt_login`),
  KEY `fk_users_person1` (`person_id`),
  CONSTRAINT `fk_user_user1` FOREIGN KEY (`user_alt_login`) REFERENCES `user` (`login`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_person1` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,TRADITIONAL,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `kadecaminh`.`ON_BEFORE_INSERT`
BEFORE INSERT ON `kadecaminh`.`user`
FOR EACH ROW
-- Edit trigger body code below this line. Do not edit lines above this one
BEGIN
	IF (NEW.password <> '') THEN
        SET NEW.password = MD5( NEW.password );
    END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,TRADITIONAL,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `kadecaminh`.`ON_BEFORE_UPDATE`
BEFORE UPDATE ON `kadecaminh`.`user`
FOR EACH ROW
-- Edit trigger body code below this line. Do not edit lines above this one
BEGIN
	IF (NEW.password <> '') THEN
        SET NEW.password = MD5( NEW.password );
    END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `vehicle_contact`
--

DROP TABLE IF EXISTS `vehicle_contact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vehicle_contact` (
  `vehicle_traveling_id` bigint(20) unsigned NOT NULL,
  `person_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone_contact_id` bigint(20) NOT NULL,
  PRIMARY KEY (`vehicle_traveling_id`),
  KEY `fk_vehicle_contact_phone1_idx` (`phone_contact_id`),
  KEY `fk_vehicle_contact_vehicle_traveling1` (`vehicle_traveling_id`),
  KEY `fk_vehicle_contact_person1` (`person_id`),
  CONSTRAINT `fk_vehicle_contact_person1` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_vehicle_contact_phone1` FOREIGN KEY (`phone_contact_id`) REFERENCES `phone` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_vehicle_contact_vehicle_traveling1` FOREIGN KEY (`vehicle_traveling_id`) REFERENCES `vehicle_traveling` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehicle_contact`
--

LOCK TABLES `vehicle_contact` WRITE;
/*!40000 ALTER TABLE `vehicle_contact` DISABLE KEYS */;
/*!40000 ALTER TABLE `vehicle_contact` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `address`
--

DROP TABLE IF EXISTS `address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `address` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cep` int(8) unsigned NOT NULL,
  `street` varchar(255) NOT NULL,
  `number` varchar(5) DEFAULT NULL,
  `complement` varchar(255) DEFAULT NULL,
  `neighborhood` varchar(72) DEFAULT NULL,
  `city` varchar(60) NOT NULL,
  `state` char(2) NOT NULL,
  `state_nm` varchar(72) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_cep` (`cep`),
  KEY `idx_city` (`city`),
  KEY `idx_state` (`state`)
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `address`
--

LOCK TABLES `address` WRITE;
/*!40000 ALTER TABLE `address` DISABLE KEYS */;
/*!40000 ALTER TABLE `address` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vehicle_type`
--

DROP TABLE IF EXISTS `vehicle_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vehicle_type` (
  `id` int(10) unsigned NOT NULL,
  `descr` varchar(50) NOT NULL,
  `enabled` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehicle_type`
--

LOCK TABLES `vehicle_type` WRITE;
/*!40000 ALTER TABLE `vehicle_type` DISABLE KEYS */;
INSERT INTO `vehicle_type` VALUES (1,'Rodotrem - (Graneleiro)',1),(2,'Rodotrem - (Caçamba)',1),(3,'Bitrem - (Graneleiro)',1),(4,'Bitrem - (Grade baixa)',1),(5,'Bitrem - (Caçamba)',1),(6,'Carreta LS (Graneleira)',1),(7,'Carreta LS (Grade baixa)',1),(8,'Carreta LS (Baú sider)',1),(9,'Carreta LS (Caçamba)',1),(10,'Carreta LS (Baú)',1),(11,'Carreta (Baú frigorificada)',1),(12,'Carreta Toco (Graneleira)',1),(13,'Carreta Toco (Grade baixa)',1),(14,'Carreta Toco (Caçamba)',1),(15,'Carreta Toco (Baú sider)',1),(16,'Carreta Toco (Baú)',1),(17,'Carreta Toco (Baú)',1),(18,'Bitruck - (Graneleiro)',1),(19,'Bitruck - (Grade baixa)',1),(20,'Bitruck - (Baú Sider)',1),(21,'Bitruck - (Baú)',1),(22,'Bitruck - (Baú frigorífico)',1),(23,'Truck - (Graneleiro)',1),(24,'Truck - (Grade Baixa)',1),(25,'Truck - (Baú sider)',1),(26,'Truck - (Baú)',1),(27,'Truck - (Baú Frigorífico)',1),(28,'Caminhão Toco (Baú)',1),(29,'Caminhão Toco (Graneleiro)',1),(30,'Caminhão Toco (Grade Baixa)',1);
/*!40000 ALTER TABLE `vehicle_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `account`
--

DROP TABLE IF EXISTS `account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `account` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `date_hr_proc` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('PAID','UNPAID','CANCEL') NOT NULL DEFAULT 'UNPAID',
  `client_user_login` varchar(20) NOT NULL,
  `validate_month` int(11) NOT NULL DEFAULT '12',
  PRIMARY KEY (`id`),
  KEY `fk_account_client1` (`client_user_login`),
  CONSTRAINT `fk_account_client1` FOREIGN KEY (`client_user_login`) REFERENCES `client` (`user_login`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `account`
--

LOCK TABLES `account` WRITE;
/*!40000 ALTER TABLE `account` DISABLE KEYS */;
/*!40000 ALTER TABLE `account` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `installment`
--

DROP TABLE IF EXISTS `installment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `installment` (
  `account_id` bigint(20) unsigned NOT NULL,
  `id` int(10) unsigned NOT NULL DEFAULT '1',
  `value` float NOT NULL DEFAULT '0',
  `payment_value` varchar(45) NOT NULL DEFAULT '0',
  `due_date` date NOT NULL,
  `payment_date` date DEFAULT NULL,
  `status` enum('PAID','UNPAID','CANCEL') DEFAULT NULL,
  `payment_method_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`,`account_id`),
  KEY `fk_installment_payment_method1_idx` (`payment_method_id`),
  KEY `fk_installment_account1` (`account_id`),
  CONSTRAINT `fk_installment_account1` FOREIGN KEY (`account_id`) REFERENCES `account` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_installment_payment_method1` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_method` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `installment`
--

LOCK TABLES `installment` WRITE;
/*!40000 ALTER TABLE `installment` DISABLE KEYS */;
/*!40000 ALTER TABLE `installment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log_sms`
--

DROP TABLE IF EXISTS `log_sms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_sms` (
  `id` bigint(19) unsigned NOT NULL AUTO_INCREMENT,
  `from` varchar(45) DEFAULT NULL,
  `body` text,
  `ip_trat` varchar(45) DEFAULT NULL,
  `url_request` text,
  `type_log` varchar(45) DEFAULT NULL,
  `log` text,
  `date_hr` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log_sms`
--

LOCK TABLES `log_sms` WRITE;
/*!40000 ALTER TABLE `log_sms` DISABLE KEYS */;
/*!40000 ALTER TABLE `log_sms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vehicle_traveling_user`
--

DROP TABLE IF EXISTS `vehicle_traveling_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vehicle_traveling_user` (
  `vehicle_traveling_id` bigint(20) unsigned NOT NULL,
  `user_login` varchar(20) NOT NULL,
  `date_hr_used` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('ONLY_VIEW','UTILIZED') NOT NULL DEFAULT 'ONLY_VIEW',
  PRIMARY KEY (`vehicle_traveling_id`,`user_login`,`date_hr_used`),
  KEY `fk_vehicle_traveling_has_users_users1` (`user_login`),
  KEY `fk_vehicle_traveling_has_users_vehicle_traveling1` (`vehicle_traveling_id`),
  CONSTRAINT `fk_vehicle_traveling_has_users_users1` FOREIGN KEY (`user_login`) REFERENCES `user` (`login`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_vehicle_traveling_has_users_vehicle_traveling1` FOREIGN KEY (`vehicle_traveling_id`) REFERENCES `vehicle_traveling` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehicle_traveling_user`
--

LOCK TABLES `vehicle_traveling_user` WRITE;
/*!40000 ALTER TABLE `vehicle_traveling_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `vehicle_traveling_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `person`
--

DROP TABLE IF EXISTS `person`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `person` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `type` enum('PF','PJ','NO') NOT NULL DEFAULT 'NO',
  `address_id` bigint(20) unsigned DEFAULT NULL,
  `phone_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_person_phone1_idx` (`phone_id`),
  KEY `fk_person_address1` (`address_id`),
  CONSTRAINT `fk_person_address1` FOREIGN KEY (`address_id`) REFERENCES `address` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_person_phone1` FOREIGN KEY (`phone_id`) REFERENCES `phone` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `person`
--

LOCK TABLES `person` WRITE;
/*!40000 ALTER TABLE `person` DISABLE KEYS */;
/*!40000 ALTER TABLE `person` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `client`
--

DROP TABLE IF EXISTS `client`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `client` (
  `user_login` varchar(20) NOT NULL,
  PRIMARY KEY (`user_login`),
  CONSTRAINT `fk_client_users1` FOREIGN KEY (`user_login`) REFERENCES `user` (`login`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `client`
--

LOCK TABLES `client` WRITE;
/*!40000 ALTER TABLE `client` DISABLE KEYS */;
/*!40000 ALTER TABLE `client` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employee`
--

DROP TABLE IF EXISTS `employee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employee` (
  `user_login` varchar(20) NOT NULL,
  PRIMARY KEY (`user_login`),
  CONSTRAINT `fk_employee_user1` FOREIGN KEY (`user_login`) REFERENCES `user` (`login`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee`
--

LOCK TABLES `employee` WRITE;
/*!40000 ALTER TABLE `employee` DISABLE KEYS */;
/*!40000 ALTER TABLE `employee` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `person_individual`
--

DROP TABLE IF EXISTS `person_individual`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `person_individual` (
  `person_id` bigint(20) unsigned NOT NULL,
  `cpf` char(11) NOT NULL,
  `gender` enum('MASCULINO','FEMININO') DEFAULT NULL,
  `dateBirth` date DEFAULT NULL,
  PRIMARY KEY (`person_id`),
  UNIQUE KEY `cpf_UNIQUE` (`cpf`),
  CONSTRAINT `fk_person_individual_person` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `person_individual`
--

LOCK TABLES `person_individual` WRITE;
/*!40000 ALTER TABLE `person_individual` DISABLE KEYS */;
/*!40000 ALTER TABLE `person_individual` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'kadecaminh'
--

--
-- Dumping routines for database 'kadecaminh'
--
/*!50003 DROP PROCEDURE IF EXISTS `add_idx_traveling_city` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,TRADITIONAL,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 PROCEDURE `add_idx_traveling_city`(address_id BIGINT)
BEGIN
    DECLARE ld_state CHAR(2);
    DECLARE ld_state_idx CHAR(2);
    DECLARE ld_state_nm VARCHAR(72);
    DECLARE ld_city VARCHAR(60);
    DECLARE CONTINUE HANDLER FOR NOT FOUND BEGIN END;
     SELECT  state
            , state_nm
            , city 
       INTO   ld_state
            , ld_state_nm
            , ld_city
      FROM address
     WHERE id = address_id;
    
    IF (ld_state != '') THEN
        SELECT state
          INTO ld_state_idx
          FROM idx_traveling_city
         WHERE state = ld_state
           AND city  = ld_city;
        
        IF(ld_state_idx != '') THEN
            UPDATE idx_traveling_city
              SET   qty_real = qty_real + 1
                  , qty_illus = qty_illus + 1
            WHERE state = ld_state
              AND city  = ld_city;
        ELSE
            INSERT INTO idx_traveling_city
                ( state
                , city
                , state_nm
                ) VALUES 
                ( ld_state
                , ld_city
                , ld_state_nm
                );
        
        END IF;
        
    END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `remove_idx_traveling_city` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,TRADITIONAL,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 PROCEDURE `remove_idx_traveling_city`(address_id BIGINT)
BEGIN
    DECLARE ld_state CHAR(2);
    DECLARE ld_state_idx CHAR(2);
    DECLARE ld_state_nm VARCHAR(72);
    DECLARE ld_city VARCHAR(60);
    DECLARE CONTINUE HANDLER FOR NOT FOUND BEGIN END;
     SELECT  state
            , state_nm
            , city 
       INTO   ld_state
            , ld_state_nm
            , ld_city
      FROM address
     WHERE id = address_id;
    
    IF (ld_state != '') THEN
        SELECT state
          INTO ld_state_idx
          FROM idx_traveling_city
         WHERE state = ld_state
           AND city  = ld_city;
        
        IF(ld_state_idx != '') THEN
            UPDATE idx_traveling_city
              SET   qty_real = qty_real - 1
                  , qty_illus = qty_illus - 1
            WHERE state = ld_state
              AND city  = ld_city;
        END IF;
        
    END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-10-16 23:55:36
