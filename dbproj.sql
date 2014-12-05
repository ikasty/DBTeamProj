-- phpMyAdmin SQL Dump
-- version 3.2.3
-- http://www.phpmyadmin.net
--
-- 호스트: localhost
-- 처리한 시간: 14-12-05 19:46 
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

--
-- 테이블의 덤프 데이터 `개발자`
--

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

--
-- 테이블의 덤프 데이터 `근무`
--

INSERT INTO `근무` (`회사이름`, `개발자id`, `입사일`, `퇴사일`) VALUES
('NHN', 'busan5', '2014-12-05', '2100-12-31'),
('NHN', 'gyeongi4', '2014-12-05', '2100-12-31'),
('NHN', 'seoul3', '2014-12-05', '2100-12-31'),
('NHN', 'ulsan6', '2014-12-05', '2100-12-31'),
('넥슨', 'kaist8', '2014-12-05', '2100-12-31'),
('넥슨', 'postech7', '2014-12-05', '2100-12-31'),
('넥슨', 'yonsei1', '2014-12-05', '2100-12-31'),
('프리랜서', 'ewha9', '2014-12-05', '2100-12-31'),
('프리랜서', 'korea2', '2014-12-05', '2100-12-31');

-- --------------------------------------------------------

--
-- 테이블 구조 `부서`
--

CREATE TABLE IF NOT EXISTS `부서` (
  `회사이름` varchar(10) NOT NULL DEFAULT '' COMMENT '회사이름',
  `부서id` int(10) NOT NULL DEFAULT '0' COMMENT '부서id',
  PRIMARY KEY (`회사이름`,`부서id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='회사 내의 부서들의 목록';

--
-- 테이블의 덤프 데이터 `부서`
--

INSERT INTO `부서` (`회사이름`, `부서id`) VALUES
('NHN', 0),
('NHN', 1),
('NHN', 2),
('넥슨', 0),
('넥슨', 1),
('넥슨', 2),
('넥슨', 3),
('넥슨', 4),
('넥슨', 5),
('넥슨', 6);

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
('test', 'dGVzdA==', 'test id'),
('1', '1', '연세대1'),
('2', '2', '고려대2'),
('3', '3', '서울대3'),
('4', '4', '경기대4'),
('5', '5', '부산대5'),
('6', '6', '울산대6'),
('7', '7', '포항공대7'),
('8', '8', '카이스트8'),
('9', '9', '이화여대9');

-- --------------------------------------------------------

--
-- 테이블 구조 `자료분야`
--

CREATE TABLE IF NOT EXISTS `자료분야` (
  `자료id` varchar(20) NOT NULL DEFAULT '',
  `자료분야` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`자료id`,`자료분야`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='자료의 자료분야';

--
-- 테이블의 덤프 데이터 `자료분야`
--

INSERT INTO `자료분야` (`자료id`, `자료분야`) VALUES
('10', '짝수'),
('11', '소수'),
('12', '짝수'),
('3', '소수'),
('4', '제곱수'),
('5', '소수'),
('6', '짝수'),
('7', '소수'),
('8', '짝수'),
('9', '제곱수');

-- --------------------------------------------------------

--
-- 테이블 구조 `전문분야`
--

CREATE TABLE IF NOT EXISTS `전문분야` (
  `id` varchar(20) NOT NULL DEFAULT '0' COMMENT '개발자의 id',
  `전문분야` varchar(20) NOT NULL DEFAULT '0' COMMENT '개발자의 전문분야',
  PRIMARY KEY (`id`,`전문분야`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='개발자의 전문 분야';

--
-- 테이블의 덤프 데이터 `전문분야`
--

INSERT INTO `전문분야` (`id`, `전문분야`) VALUES
('busan5', '지방대'),
('ewha9', '수도권'),
('gyeongi4', '수도권'),
('kaist8', '공대'),
('kaist8', '지방대'),
('korea2', 'SKY'),
('postech7', '공대'),
('postech7', '지방대'),
('seoul3', 'SKY'),
('ulsan6', '지방대'),
('yonsei1', 'SKY');

-- --------------------------------------------------------

--
-- 테이블 구조 `평가`
--

CREATE TABLE IF NOT EXISTS `평가` (
  `평가id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`평가id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='평가자 그룹이 실행한 평가의 id';

--
-- 테이블의 덤프 데이터 `평가`
--


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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='평가의 일정 조정' AUTO_INCREMENT=3 ;

--
-- 테이블의 덤프 데이터 `평가일정`
--

INSERT INTO `평가일정` (`평가회차`, `모집시작일`, `평가시작일`, `종료일`) VALUES
(2, '2014-12-05 16:05:45', NULL, NULL);

-- --------------------------------------------------------

--
-- 테이블 구조 `평가자 그룹`
--

CREATE TABLE IF NOT EXISTS `평가자 그룹` (
  `평가회차id` int(11) NOT NULL DEFAULT '0' COMMENT '몇번째 회차인지',
  `그룹id` int(11) NOT NULL DEFAULT '0' COMMENT '어떤 그룹인지',
  PRIMARY KEY (`평가회차id`,`그룹id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='회차별 평가자 그룹의 목록';

--
-- 테이블의 덤프 데이터 `평가자 그룹`
--


-- --------------------------------------------------------

--
-- 테이블 구조 `평가자료`
--

CREATE TABLE IF NOT EXISTS `평가자료` (
  `자료id` int(11) NOT NULL AUTO_INCREMENT,
  `자료이름` varchar(20) DEFAULT NULL COMMENT '사용자의 자료구분 편의를 위한 이름',
  `개발자id` varchar(20) DEFAULT NULL,
  `업로드시간` datetime DEFAULT NULL,
  `기여도` float DEFAULT NULL COMMENT '기여도',
  `자료정보` varchar(200) DEFAULT NULL COMMENT '업로드 자료 정보(url)',
  PRIMARY KEY (`자료id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='평가자료 정보' AUTO_INCREMENT=13 ;

--
-- 테이블의 덤프 데이터 `평가자료`
--

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

-- --------------------------------------------------------

--
-- 테이블 구조 `평가자 선정`
--

CREATE TABLE IF NOT EXISTS `평가자 선정` (
  `평가회차` int(11) NOT NULL DEFAULT '0' COMMENT '몇회차인지',
  `평가그룹` int(11) NOT NULL DEFAULT '0' COMMENT '어떤그룹인지',
  `개발자id` varchar(20) NOT NULL COMMENT '어떤 개발자가'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='개발자의 어떤 평가 회차별 소속 평가자 그룹';

--
-- 테이블의 덤프 데이터 `평가자 선정`
--


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

--
-- 테이블의 덤프 데이터 `평가지표`
--


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

--
-- 테이블의 덤프 데이터 `평가하기`
--


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

--
-- 테이블의 덤프 데이터 `피평가자 그룹`
--


-- --------------------------------------------------------

--
-- 테이블 구조 `피평가자 신청`
--

CREATE TABLE IF NOT EXISTS `피평가자 신청` (
  `평가회차` int(11) NOT NULL DEFAULT '0' COMMENT '어떤 회차에',
  `평가그룹` int(11) NOT NULL DEFAULT '0' COMMENT '어떤 그룹인지',
  `개발자id` varchar(20) NOT NULL DEFAULT '' COMMENT '피평가받는 개발자가',
  PRIMARY KEY (`평가회차`,`평가그룹`,`개발자id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='피평가받는 개발자가 어떤 회차에 어떤 그룹인지';

--
-- 테이블의 덤프 데이터 `피평가자 신청`
--


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
('NHN'),
('넥슨'),
('프리랜서');