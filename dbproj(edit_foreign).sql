CREATE DATABASE  IF NOT EXISTS `dbproj` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `dbproj`;
-- MySQL dump 10.13  Distrib 5.6.13, for Win32 (x86)
--
-- Host: localhost    Database: dbproj
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
-- Table structure for table `유저`
--

DROP TABLE IF EXISTS `유저`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `유저` (
  `id` varchar(20) NOT NULL DEFAULT '' COMMENT '유저id (개발자id와 다름)',
  `비밀번호` varchar(20) DEFAULT NULL COMMENT '비밀번호',
  `이름` varchar(20) DEFAULT NULL COMMENT '이름',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='유저(관리자 + 개발자)의 개인 정보 관리';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `유저`
--

LOCK TABLES `유저` WRITE;
/*!40000 ALTER TABLE `유저` DISABLE KEYS */;
INSERT INTO `유저` (`id`, `비밀번호`, `이름`) VALUES
('test', 'test', '관리자'),
('yonsei1', 'test', '연세1'),
('korea2', 'test', 'korea2'),
('seoul3', 'test', 'seoul3'),
('gyeongi4', 'test', 'gyeongi4'),
('busan5', 'test', 'busan5'),
('ulsan6', 'test', 'ulsan6'),
('postech7', 'test', 'postech7'),
('kaist8', 'test', 'kaist8'),
('ewha9', 'test', 'ewha9');
/*!40000 ALTER TABLE `유저` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `개발자`
--

DROP TABLE IF EXISTS `개발자`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `개발자` (
  `id` varchar(20) NOT NULL DEFAULT '',
  `대학교` varchar(20) DEFAULT NULL,
  `고향` varchar(20) DEFAULT NULL,
  `유저id` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_to_user_id_idx` (`id`,`유저id`),
  CONSTRAINT `id_to_user_id` FOREIGN KEY (`id`) REFERENCES `유저` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='개발자 신상정보';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `개발자`
--

LOCK TABLES `개발자` WRITE;
/*!40000 ALTER TABLE `개발자` DISABLE KEYS */;
INSERT INTO `개발자` (`id`, `대학교`, `고향`, `유저id`) VALUES
('yonsei1', '연세대학교', '서울특별시 서대문구', '1'),
('korea2', '고려대학교', '서울특별시 성북구', '2'),
('seoul3', '서울대학교', '서울특별시 관악구', '3'),
('gyeongi4', '경기대학교', '경기도', '4'),
('busan5', '부산대학교', '부산', '5'),
('ulsan6', '울산대학교', '울산', '6'),
('postech7', '포항공대', '포항', '7'),
('kaist8', '카이스트', '대전', '8'),
('ewha9', '이화여자대학교', '서울특별시 서대문구', '9');
/*!40000 ALTER TABLE `개발자` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `회사`
--

DROP TABLE IF EXISTS `회사`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `회사` (
  `이름` varchar(10) NOT NULL DEFAULT '' COMMENT '회사이름',
  PRIMARY KEY (`이름`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `회사`
--

LOCK TABLES `회사` WRITE;
/*!40000 ALTER TABLE `회사` DISABLE KEYS */;
INSERT INTO `회사` VALUES ('NHN'),('넥슨'),('프리랜서');
/*!40000 ALTER TABLE `회사` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `근무`
--

DROP TABLE IF EXISTS `근무`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `근무` (
  `회사이름` varchar(10) NOT NULL DEFAULT '' COMMENT '회사이름',
  `개발자id` varchar(20) NOT NULL DEFAULT '' COMMENT '개발자id',
  `입사일` date NOT NULL DEFAULT '0000-00-00' COMMENT '입사일',
  `퇴사일` date DEFAULT '2100-12-31' COMMENT '퇴사일',
  PRIMARY KEY (`회사이름`,`개발자id`,`입사일`),
  KEY `did_to_did_idx` (`개발자id`),
  CONSTRAINT `cname_to_cname` FOREIGN KEY (`회사이름`) REFERENCES `회사` (`이름`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `did_to_did` FOREIGN KEY (`개발자id`) REFERENCES `개발자` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='개발자의 근무 일지';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `근무`
--

LOCK TABLES `근무` WRITE;
/*!40000 ALTER TABLE `근무` DISABLE KEYS */;
INSERT INTO `근무` (`회사이름`, `개발자id`, `입사일`, `퇴사일`) VALUES
('NHN', 'busan5', '2014-12-05', NULL),
('NHN', 'gyeongi4', '2014-12-05', NULL),
('NHN', 'seoul3', '2014-12-05', NULL),
('NHN', 'ulsan6', '2014-12-05', '2014-12-09'),
('넥슨', 'kaist8', '2014-12-05', NULL),
('넥슨', 'postech7', '2014-12-05', NULL),
('넥슨', 'yonsei1', '2014-12-05', NULL),
('프리랜서', 'ewha9', '2014-12-05', NULL),
('프리랜서', 'korea2', '2014-12-05', NULL);
/*!40000 ALTER TABLE `근무` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `부서`
--

DROP TABLE IF EXISTS `부서`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `부서` (
  `회사이름` varchar(10) NOT NULL DEFAULT '' COMMENT '회사이름',
  `부서id` int(10) NOT NULL DEFAULT '0' COMMENT '부서id',
  PRIMARY KEY (`회사이름`,`부서id`),
  CONSTRAINT `cname_in_depart_to_cname` FOREIGN KEY (`회사이름`) REFERENCES `회사` (`이름`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='회사 내의 부서들의 목록';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `부서`
--

LOCK TABLES `부서` WRITE;
/*!40000 ALTER TABLE `부서` DISABLE KEYS */;
INSERT INTO `부서` VALUES ('NHN',0),('NHN',1),('NHN',2),('넥슨',0),('넥슨',1),('넥슨',2),('넥슨',3),('넥슨',4),('넥슨',5),('넥슨',6);
/*!40000 ALTER TABLE `부서` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `평가자료`
--

DROP TABLE IF EXISTS `평가자료`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `평가자료` (
  `자료id` int(11) NOT NULL,
  `자료이름` varchar(20) DEFAULT NULL COMMENT '사용자의 자료구분 편의를 위한 이름',
  `개발자id` varchar(20) DEFAULT NULL,
  `업로드시간` timestamp DEFAULT CURRENT_TIMESTAMP,
  `기여도` float DEFAULT NULL COMMENT '기여도',
  `자료정보` varchar(200) DEFAULT NULL COMMENT '업로드 자료 정보(url)',
  PRIMARY KEY (`자료id`),
  KEY `did_in_mat_to_did_idx` (`개발자id`),
  CONSTRAINT `did_in_mat_to_did` FOREIGN KEY (`개발자id`) REFERENCES `개발자` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='평가자료 정보';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `평가자료`
--

LOCK TABLES `평가자료` WRITE;
/*!40000 ALTER TABLE `평가자료` DISABLE KEYS */;
INSERT INTO `평가자료` (`자료id`, `자료이름`, `개발자id`, `업로드시간`, `기여도`, `자료정보`) VALUES
(4, 'yonsei1 test', 'yonsei1', '2014-12-05 15:28:24', 1, 'test'),
(3, 'yonsei1 test', 'yonsei1', '2014-12-05 15:28:24', 1, 'test'),
(5, 'yonsei1 test', 'yonsei1', '2014-12-05 15:28:24', 1, 'test'),
(6, 'korea2 test', 'korea2', '2014-12-05 15:28:24', 1, 'test'),
(7, 'yonsei1 test', 'yonsei1', '2014-12-05 15:28:24', 0.7, 'test'),
(8, 'korea2 test', 'korea2', '2014-12-05 15:28:24', 0.3, 'test'),
(9, 'seoul3 test', 'seoul3', '2014-12-05 15:28:24', 1, 'test'),
(10, 'yonsei1 test', 'yonsei1', '2014-12-05 15:28:24', 0.5, 'test'),
(11, 'korea2 test', 'korea2', '2014-12-05 15:28:24', 0.2, 'test'),
(12, 'seoul3 test', 'seoul3', '2014-12-05 15:28:24', 0.3, 'test');
/*!40000 ALTER TABLE `평가자료` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `자료분야`
--

DROP TABLE IF EXISTS `자료분야`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `자료분야` (
  `자료id` int(11) NOT NULL,
  `자료분야` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`자료id`,`자료분야`),
  CONSTRAINT `mid_in_mkind_to_mkind` FOREIGN KEY (`자료id`) REFERENCES `평가자료` (`자료id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='자료의 자료분야';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `자료분야`
--

LOCK TABLES `자료분야` WRITE;
/*!40000 ALTER TABLE `자료분야` DISABLE KEYS */;
INSERT INTO `자료분야` (`자료id`, `자료분야`) VALUES
(10, '논문'),
(11, '소스코드'),
(12, '논문'),
(3, '소스코드'),
(4, '보고서'),
(5, '소스코드'),
(6, '논문'),
(7, '소스코드'),
(8, '논문'),
(9, '보고서');
/*!40000 ALTER TABLE `자료분야` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `전문분야`
--

DROP TABLE IF EXISTS `전문분야`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `전문분야` (
  `id` varchar(20) NOT NULL DEFAULT '0' COMMENT '개발자의 id',
  `전문분야` varchar(20) NOT NULL DEFAULT '0' COMMENT '개발자의 전문분야',
  `수정시간` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`,`전문분야`,`수정시간`),
  CONSTRAINT `id_in_major_to_did` FOREIGN KEY (`id`) REFERENCES `개발자` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='개발자의 전문 분야';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `전문분야`
--

LOCK TABLES `전문분야` WRITE;
/*!40000 ALTER TABLE `전문분야` DISABLE KEYS */;
INSERT INTO `전문분야` (`id`, `전문분야`, `수정시간`) VALUES
('busan5', '지방대', '2014-12-09 23:52:05'),
('ewha9', '수도권', '2014-12-09 23:52:05'),
('gyeongi4', '수도권', '2014-12-09 23:52:05'),
('kaist8', '공대', '2014-12-09 23:52:05'),
('kaist8', '지방대', '2014-12-09 23:52:05'),
('korea2', 'SKY', '2014-12-09 23:52:05'),
('postech7', '공대', '2014-12-09 23:52:05'),
('postech7', '지방대', '2014-12-09 23:52:05'),
('seoul3', 'SKY', '2014-12-09 23:52:05'),
('ulsan6', '지방대', '2014-12-09 23:52:05'),
('yonsei1', 'SKY', '2014-12-09 23:52:05');
/*!40000 ALTER TABLE `전문분야` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `평가`
--

DROP TABLE IF EXISTS `평가`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `평가` (
  `평가id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`평가id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='평가자 그룹이 실행한 평가의 id';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `평가`
--

LOCK TABLES `평가` WRITE;
/*!40000 ALTER TABLE `평가` DISABLE KEYS */;
INSERT INTO `평가` (`평가id`) VALUES
(1),(2),(3),(4),(5),(6);
/*!40000 ALTER TABLE `평가` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `평가일정`
--

DROP TABLE IF EXISTS `평가일정`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `평가일정` (
  `평가회차` int(11) NOT NULL AUTO_INCREMENT COMMENT '평가회차',
  `모집시작일` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '평가시작일',
  `평가시작일` timestamp NULL DEFAULT NULL,
  `종료일` timestamp NULL DEFAULT NULL COMMENT '평가종료일',
  PRIMARY KEY (`평가회차`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='평가의 일정 조정';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `평가일정`
--

LOCK TABLES `평가일정` WRITE;
/*!40000 ALTER TABLE `평가일정` DISABLE KEYS */;
INSERT INTO `평가일정` VALUES (2,'2014-12-05 07:05:45',NULL,NULL);
/*!40000 ALTER TABLE `평가일정` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `평가자 그룹`
--

DROP TABLE IF EXISTS `평가자 그룹`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `평가자 그룹` (
  `평가회차id` int(11) NOT NULL DEFAULT '0' COMMENT '몇번째 회차인지',
  `그룹id` int(11) NOT NULL DEFAULT '0' COMMENT '어떤 그룹인지',
  PRIMARY KEY (`평가회차id`,`그룹id`),
  CONSTRAINT `period_in_deg_to_period` FOREIGN KEY (`평가회차id`) REFERENCES `평가일정` (`평가회차`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='회차별 평가자 그룹의 목록';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `평가자 그룹`
--

LOCK TABLES `평가자 그룹` WRITE;
/*!40000 ALTER TABLE `평가자 그룹` DISABLE KEYS */;
/*!40000 ALTER TABLE `평가자 그룹` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `평가자 선정`
--

DROP TABLE IF EXISTS `평가자 선정`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `평가자 선정` (
  `평가회차` int(11) NOT NULL DEFAULT '0' COMMENT '몇회차인지',
  `평가그룹` int(11) NOT NULL DEFAULT '0' COMMENT '어떤그룹인지',
  `개발자id` varchar(20) NOT NULL COMMENT '어떤 개발자가',
  PRIMARY KEY (`개발자id`,`평가회차`),
  KEY `period_in_pde_to_period_idx` (`평가회차`),
  CONSTRAINT `period_in_pde_to_period` FOREIGN KEY (`평가회차`) REFERENCES `평가일정` (`평가회차`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `did_in_pde_to_did` FOREIGN KEY (`개발자id`) REFERENCES `개발자` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='개발자의 어떤 평가 회차별 소속 평가자 그룹';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `평가자 선정`
--

LOCK TABLES `평가자 선정` WRITE;
/*!40000 ALTER TABLE `평가자 선정` DISABLE KEYS */;
/*!40000 ALTER TABLE `평가자 선정` ENABLE KEYS */;
UNLOCK TABLES;


--
-- Table structure for table `평가지표`
--

DROP TABLE IF EXISTS `평가지표`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `평가지표` (
  `평가id` int(11) NOT NULL DEFAULT '0' COMMENT '평가id',
  `지표이름` varchar(20) NOT NULL DEFAULT '' COMMENT '지표이름',
  `점수` int(11) DEFAULT NULL COMMENT '평가점수',
  PRIMARY KEY (`평가id`,`지표이름`),
  CONSTRAINT `eid_in_es_eid` FOREIGN KEY (`평가id`) REFERENCES `평가` (`평가id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='평가에 대한 지표와 그 평가점수';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `평가지표`
--

LOCK TABLES `평가지표` WRITE;
/*!40000 ALTER TABLE `평가지표` DISABLE KEYS */;
INSERT INTO `평가지표` (`평가id`, `지표이름`, `점수`) VALUES
(1, '속도', 10),
(2, '범용성', 2),
(3, '속도', 1),
(1, '크기', 3),
(1, '사용 편의성', 5),
(2, '크기', 4),
(2, '사용 편의성', 7),
(3, '크기', 9),
(3, '사용 편의성', 0),
(3, '신뢰성', 0),
(3, '견고성', 3),
(4, '크기', 1),
(4, '사용 편의성', 7),
(5, '속도', 1),
(5, '크기', 4),
(5, '사용 편의성', 9),
(5, '신뢰성', 7),
(6, '속도', 3),
(6, '크기', 4);
/*!40000 ALTER TABLE `평가지표` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `평가하기`
--

DROP TABLE IF EXISTS `평가하기`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `평가하기` (
  `평가id` int(11) NOT NULL DEFAULT '0',
  `자료id` int(11) NOT NULL DEFAULT '0',
  `개발자id` varchar(20) DEFAULT NULL,
  `평가날짜` date DEFAULT NULL,
  `평가회차` int(11) DEFAULT NULL,
  PRIMARY KEY (`평가id`,`자료id`),
  KEY `did_in_de_to_did_idx` (`개발자id`),
  KEY `mid_in_de_to_mid_idx` (`자료id`),
  CONSTRAINT `eid_in_de_to_eid` FOREIGN KEY (`평가id`) REFERENCES `평가` (`평가id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `did_in_de_to_did` FOREIGN KEY (`개발자id`) REFERENCES `개발자` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `mid_in_de_to_mid` FOREIGN KEY (`자료id`) REFERENCES `평가자료` (`자료id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='평가자 그룹이 실행한 평가의 결과 및 로그';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `평가하기`
--

LOCK TABLES `평가하기` WRITE;
/*!40000 ALTER TABLE `평가하기` DISABLE KEYS */;
INSERT INTO `평가하기` (`평가id`, `자료id`, `개발자id`, `평가날짜`, `평가회차`) VALUES
(1, 4, 'yonsei1', '2014-12-08', 2),
(2, 5, 'yonsei1', '2014-12-08', 2),
(3, 6, 'korea2', '2014-12-08', 2),
(4, 9, 'seoul3', '2014-12-08', 2),
(5, 10, 'yonsei1', '2014-12-08', 2),
(6, 11, 'korea2', '2014-12-08', 2);
/*!40000 ALTER TABLE `평가하기` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `피평가자 그룹`
--

DROP TABLE IF EXISTS `피평가자 그룹`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `피평가자 그룹` (
  `평가회차id` int(11) NOT NULL DEFAULT '0' COMMENT '어떤 회차에',
  `그룹id` int(11) NOT NULL DEFAULT '0' COMMENT '어떤 피평가자그룹이',
  `평가자그룹` int(11) DEFAULT NULL COMMENT '어떤 평가자 그룹에',
  PRIMARY KEY (`평가회차id`,`그룹id`),
  KEY `deg_in_geg_to_deg_idx` (`평가자그룹`),
  CONSTRAINT `period_in_geg_to_period` FOREIGN KEY (`평가회차id`) REFERENCES `평가일정` (`평가회차`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `deg_in_geg_to_deg` FOREIGN KEY (`평가자그룹`) REFERENCES `평가자 그룹` (`평가회차id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='피평가자 그룹이 어떤 회차에 어떤 평가자 그룹에게 평가받는지';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `피평가자 그룹`
--

LOCK TABLES `피평가자 그룹` WRITE;
/*!40000 ALTER TABLE `피평가자 그룹` DISABLE KEYS */;
/*!40000 ALTER TABLE `피평가자 그룹` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `피평가자 신청`
--

DROP TABLE IF EXISTS `피평가자 신청`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `피평가자 신청` (
  `평가회차` int(11) NOT NULL DEFAULT '0' COMMENT '어떤 회차에',
  `평가그룹` int(11) NOT NULL DEFAULT '0' COMMENT '어떤 그룹인지',
  `개발자id` varchar(20) NOT NULL DEFAULT '' COMMENT '피평가받는 개발자가',
  `자료id` int(11) NOT NULL COMMENT '자료id',
  PRIMARY KEY (`평가회차`,`평가그룹`,`개발자id`,`자료id`),
  KEY `geg_in_parge_to_geg_idx` (`평가그룹`),
  KEY `did_in_parge_to_did_idx` (`개발자id`),
  KEY `mid_in_parge_to_mid_idx` (`자료id`),
  CONSTRAINT `did_in_parge_to_did` FOREIGN KEY (`개발자id`) REFERENCES `개발자` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `mid_in_parge_to_mid` FOREIGN KEY (`자료id`) REFERENCES `평가자료` (`자료id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `geg_in_parge_to_geg` FOREIGN KEY (`평가회차`, `평가그룹`) REFERENCES `피평가자 그룹` (`평가회차id`, `그룹id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='피평가받는 개발자가 어떤 회차에 어떤 그룹인지';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `피평가자 신청`
--

LOCK TABLES `피평가자 신청` WRITE;
/*!40000 ALTER TABLE `피평가자 신청` DISABLE KEYS */;
/*!40000 ALTER TABLE `피평가자 신청` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Structure for view `평가점수`
--
DROP TABLE IF EXISTS `평가점수`;
DROP VIEW IF EXISTS `평가점수`;

CREATE ALGORITHM=UNDEFINED DEFINER=`dbproj`@`localhost` SQL SECURITY DEFINER VIEW `평가점수` AS select `평가지표`.`평가id` AS `평가id`,avg(`평가지표`.`점수`) AS `평균점수`,`평가하기`.`평가회차` AS `평가회차`,`평가하기`.`개발자id` AS `개발자id` from (`평가지표` left join `평가하기` on((`평가지표`.`평가id` = `평가하기`.`평가id`))) group by `평가지표`.`평가id`;

--
-- Structure for view `회사성적`
--
DROP TABLE IF EXISTS `회사성적`;
DROP VIEW IF EXISTS `회사성적`;

CREATE ALGORITHM=UNDEFINED DEFINER=`dbproj`@`localhost` SQL SECURITY DEFINER VIEW `회사성적` AS select `근무`.`회사이름` AS `회사이름`,avg(`평가점수`.`평균점수`) AS `평균점수` from (`근무` left join `평가점수` on((`근무`.`개발자id` = `평가점수`.`개발자id`))) where isnull(`근무`.`퇴사일`) group by `근무`.`회사이름`;

--
-- Structure for view `회사전문분야`
--
DROP TABLE IF EXISTS `회사전문분야`;
DROP VIEW IF EXISTS `회사전문분야`;

CREATE ALGORITHM=UNDEFINED DEFINER=`dbproj`@`localhost` SQL SECURITY DEFINER VIEW `회사전문분야` AS select distinct `근무`.`회사이름` AS `회사이름`,`전문분야`.`전문분야` AS `전문분야` from ((`근무` left join `평가점수` on((`근무`.`개발자id` = `평가점수`.`개발자id`))) left join `전문분야` on((`전문분야`.`id` = `근무`.`개발자id`))) where isnull(`근무`.`퇴사일`);

--
-- Structure for view `최신전문분야`
--
DROP TABLE IF EXISTS `최신전문분야`;
DROP VIEW IF EXISTS `최신전문분야`;

CREATE ALGORITHM=UNDEFINED DEFINER=`dbproj`@`localhost` SQL SECURITY DEFINER VIEW `최신전문분야` AS select `개발자`.`id` AS `개발자id`,`T`.`전문분야` AS `전문분야` from (`개발자` left join `전문분야` `T` on((`개발자`.`id` = `T`.`id`))) where (`T`.`수정시간` = (select max(`X`.`수정시간`) from `전문분야` `X` where (`T`.`id` = `X`.`id`) group by `X`.`id`));


/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-12-10  4:05:42
