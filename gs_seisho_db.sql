-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: gs_seisho_db
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `gs_seisho_db`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `gs_seisho_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_bin */;

USE `gs_seisho_db`;

--
-- Table structure for table `seisho_table`
--

DROP TABLE IF EXISTS `seisho_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `seisho_table` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer` varchar(128) NOT NULL,
  `subject` varchar(128) NOT NULL,
  `amount` int(11) NOT NULL,
  `deadline` date NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `seisho_table`
--

LOCK TABLES `seisho_table` WRITE;
/*!40000 ALTER TABLE `seisho_table` DISABLE KEYS */;
INSERT INTO `seisho_table` VALUES (1,'譬ｪ蠑丈ｼ夂､ｾ螻ｱ逕ｰ陬ｽ菴懈園','邊ｾ蟇?す繝｣繝輔ヨ蜉?蟾･ 荳?蠑?',480000,'2026-07-31','2026-07-02 21:56:58','2026-07-02 21:56:58'),(2,'譚ｱ豬ｷ邊ｾ讖滓?ｪ蠑丈ｼ夂､ｾ','繝悶Λ繧ｱ繝?ヨ隧ｦ菴? 10蛟?',120000,'2026-07-15','2026-07-02 21:56:58','2026-07-02 21:56:58'),(3,'荳ｭ驛ｨ蟾･讌ｭ譬ｪ蠑丈ｼ夂､ｾ','繧ｮ繧｢繧ｱ繝ｼ繧ｹ驥冗肇 100蛟?',2350000,'2026-08-20','2026-07-02 21:56:58','2026-07-02 21:56:58'),(4,'?e?X?g????','?????m?F?W???u',99999,'2026-09-01','2026-07-02 21:59:13','2026-07-02 21:59:13');
/*!40000 ALTER TABLE `seisho_table` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-07-02 22:02:39
