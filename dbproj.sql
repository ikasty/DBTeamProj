-- phpMyAdmin SQL Dump
-- version 3.2.3
-- http://www.phpmyadmin.net
--
-- 호스트: localhost
-- 처리한 시간: 14-11-24 16:35 
-- 서버 버전: 5.1.41
-- PHP 버전: 5.2.12

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 데이터베이스: `dbproj`
--
CREATE DATABASE `dbproj` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `dbproj`;

-- --------------------------------------------------------

--
-- 테이블 구조 `유저`
--

CREATE TABLE IF NOT EXISTS `유저` (
  `id` varchar(20) NOT NULL DEFAULT '' COMMENT '유저id (개발자id와 다름)',
  `비밀번호` varchar(20) DEFAULT NULL COMMENT '비밀번호',
  `이름` varchar(20) DEFAULT NULL COMMENT '이름',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='유저(관리자 + 개발자)의 개인 정보 관리';

--
-- 테이블의 덤프 데이터 `유저`
--

INSERT INTO `유저` (`id`, `비밀번호`, `이름`) VALUES
('test', 'dGVzdA==', 'test id');

-- --------------------------------------------------------

--
-- 테이블 구조 `개발자`
--

CREATE TABLE IF NOT EXISTS `개발자` (
  `id` varchar(20) NOT NULL DEFAULT '',
  `대학교` varchar(20) DEFAULT NULL,
  `고향` varchar(20) DEFAULT NULL,
  `유저id` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='개발자 신상정보';

-- --------------------------------------------------------

--
-- 테이블 구조 `근무`
--

CREATE TABLE IF NOT EXISTS `근무` (
  `회사이름` varchar(10) NOT NULL DEFAULT '' COMMENT '회사이름',
  `개발자id` varchar(20) NOT NULL DEFAULT '' COMMENT '개발자id',
  `입사일` date NOT NULL DEFAULT '0000-00-00' COMMENT '입사일',
  `퇴사일` date NOT NULL DEFAULT '2100-12-31' COMMENT '퇴사일',
  PRIMARY KEY (`회사이름`,`개발자id`,`입사일`,`퇴사일`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='개발자의 근무 일지';

-- --------------------------------------------------------

--
-- 테이블 구조 `부서`
--

CREATE TABLE IF NOT EXISTS `부서` (
  `회사이름` varchar(10) NOT NULL DEFAULT '' COMMENT '회사이름',
  `부서id` int(10) NOT NULL DEFAULT '0' COMMENT '부서id',
  PRIMARY KEY (`회사이름`,`부서id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='회사 내의 부서들의 목록';

-- --------------------------------------------------------

--
-- 테이블 구조 `전문분야`
--

CREATE TABLE IF NOT EXISTS `전문분야` (
  `id` varchar(20) NOT NULL DEFAULT '0' COMMENT '개발자의 id',
  `전문분야` varchar(20) NOT NULL DEFAULT '0' COMMENT '개발자의 전문분야',
  PRIMARY KEY (`id`,`전문분야`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='개발자의 전문 분야';

-- --------------------------------------------------------

--
-- 테이블 구조 `평가`
--

CREATE TABLE IF NOT EXISTS `평가` (
  `평가id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`평가id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='평가자 그룹이 실행한 평가의 id';

-- --------------------------------------------------------

--
-- 테이블 구조 `평가일정`
--

CREATE TABLE IF NOT EXISTS `평가일정` (
  `평가회차` int(11) NOT NULL AUTO_INCREMENT COMMENT '평가회차',
  `모집시작일` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '평가시작일',
  `평가시작일` timestamp NULL DEFAULT NULL,
  `종료일` timestamp NULL DEFAULT NULL COMMENT '평가종료일',
  PRIMARY KEY (`평가회차`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='평가의 일정 조정' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 테이블 구조 `평가자 그룹`
--

CREATE TABLE IF NOT EXISTS `평가자 그룹` (
  `평가회차id` int(11) NOT NULL DEFAULT '0' COMMENT '몇번째 회차인지',
  `그룹id` int(11) NOT NULL DEFAULT '0' COMMENT '어떤 그룹인지',
  PRIMARY KEY (`평가회차id`,`그룹id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='회차별 평가자 그룹의 목록';

-- --------------------------------------------------------

--
-- 테이블 구조 `평가자 선정`
--

CREATE TABLE IF NOT EXISTS `평가자 선정` (
  `평가회차` int(11) NOT NULL DEFAULT '0' COMMENT '몇회차인지',
  `평가그룹` int(11) NOT NULL DEFAULT '0' COMMENT '어떤그룹인지',
  `개발자id` varchar(20) NOT NULL COMMENT '어떤 개발자가',
  PRIMARY KEY (`평가회차`, `개발자id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='개발자의 어떤 평가 회차별 소속 평가자 그룹';

-- --------------------------------------------------------

--
-- 테이블 구조 `평가자료`
--

CREATE TABLE IF NOT EXISTS `평가자료` (
  `자료id` int(11) NOT NULL AUTO_INCREMENT,
  `개발자id` varchar(20) DEFAULT NULL,
  `업로드시간` datetime DEFAULT NULL,
  `기여도` float DEFAULT NULL COMMENT '기여도',
  PRIMARY KEY (`자료id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='평가자료 정보' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 테이블 구조 `자료분야`
--

CREATE TABLE IF NOT EXISTS `자료분야` (
  `자료id` varchar(20) NOT NULL DEFAULT '',
  `자료분야` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`자료id`, `자료분야`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='평가자료의 자료분야';

-- --------------------------------------------------------

--
-- 테이블 구조 `평가지표`
--

CREATE TABLE IF NOT EXISTS `평가지표` (
  `평가id` int(11) NOT NULL DEFAULT '0' COMMENT '평가id',
  `지표이름` varchar(20) NOT NULL DEFAULT '' COMMENT '지표이름',
  `점수` int(11) DEFAULT NULL COMMENT '평가점수',
  PRIMARY KEY (`평가id`,`지표이름`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='평가에 대한 지표와 그 평가점수';

-- --------------------------------------------------------

--
-- 테이블 구조 `평가하기`
--

CREATE TABLE IF NOT EXISTS `평가하기` (
  `평가id` int(11) NOT NULL DEFAULT '0',
  `자료id` int(11) NOT NULL DEFAULT '0',
  `개발자id` varchar(20) DEFAULT NULL,
  `평가날짜` date DEFAULT NULL,
  PRIMARY KEY (`평가id`,`자료id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='평가자 그룹이 실행한 평가의 결과 및 로그';

-- --------------------------------------------------------

--
-- 테이블 구조 `피평가자 그룹`
--

CREATE TABLE IF NOT EXISTS `피평가자 그룹` (
  `평가회차id` int(11) NOT NULL DEFAULT '0' COMMENT '어떤 회차에',
  `그룹id` int(11) NOT NULL DEFAULT '0' COMMENT '어떤 피평가자그룹이',
  `평가자그룹` int(11) DEFAULT NULL COMMENT '어떤 평가자 그룹에',
  PRIMARY KEY (`평가회차id`,`그룹id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='피평가자 그룹이 어떤 회차에 어떤 평가자 그룹에게 평가받는지';

-- --------------------------------------------------------

--
-- 테이블 구조 `피평가자 신청`
--

CREATE TABLE IF NOT EXISTS `피평가자 신청` (
  `평가회차` int(11) NOT NULL DEFAULT '0' COMMENT '어떤 회차에',
  `평가그룹` int(11) NOT NULL DEFAULT '0' COMMENT '어떤 그룹인지',
  `개발자id` varchar(20) NOT NULL DEFAULT '' COMMENT '피평가받는 개발자가',
  PRIMARY KEY (`평가회차`,`개발자id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='피평가받는 개발자가 어떤 회차에 어떤 그룹인지';

-- --------------------------------------------------------

--
-- 테이블 구조 `회사`
--

CREATE TABLE IF NOT EXISTS `회사` (
  `이름` varchar(10) NOT NULL DEFAULT '' COMMENT '회사이름',
  PRIMARY KEY (`이름`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `회사`
--

INSERT INTO `회사` (`이름`) VALUES
('연세대학교');
