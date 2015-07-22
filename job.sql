/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : job

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2015-07-13 16:16:13
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `admin`
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `uid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` char(15) NOT NULL DEFAULT '',
  `password` char(32) NOT NULL DEFAULT '',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO `admin` VALUES ('1', 'admin', 'c3284d0f94606de1fd2af172aba15bf3');

-- ----------------------------
-- Table structure for `dict_function`
-- ----------------------------
DROP TABLE IF EXISTS `dict_function`;
CREATE TABLE `dict_function` (
  `function_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `function_name` varchar(255) NOT NULL,
  PRIMARY KEY (`function_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dict_function
-- ----------------------------

-- ----------------------------
-- Table structure for `dict_location`
-- ----------------------------
DROP TABLE IF EXISTS `dict_location`;
CREATE TABLE `dict_location` (
  `location_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '城市ID',
  `location_pid` int(11) NOT NULL COMMENT '上级城市ID',
  `location_name` varchar(255) NOT NULL COMMENT '城市名称',
  PRIMARY KEY (`location_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dict_location
-- ----------------------------

-- ----------------------------
-- Table structure for `dict_major`
-- ----------------------------
DROP TABLE IF EXISTS `dict_major`;
CREATE TABLE `dict_major` (
  `major_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '专业ID',
  `major_name` varchar(255) NOT NULL COMMENT '专业名称',
  PRIMARY KEY (`major_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dict_major
-- ----------------------------

-- ----------------------------
-- Table structure for `intention`
-- ----------------------------
DROP TABLE IF EXISTS `intention`;
CREATE TABLE `intention` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `jobarea` int(11) NOT NULL,
  `salary` tinyint(1) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of intention
-- ----------------------------

-- ----------------------------
-- Table structure for `intro`
-- ----------------------------
DROP TABLE IF EXISTS `intro`;
CREATE TABLE `intro` (
  `uid` int(11) NOT NULL,
  `intro` text NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of intro
-- ----------------------------

-- ----------------------------
-- Table structure for `job`
-- ----------------------------
DROP TABLE IF EXISTS `job`;
CREATE TABLE `job` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) unsigned NOT NULL COMMENT '用户ID',
  `starttime` int(11) unsigned NOT NULL COMMENT '开始时间',
  `endtime` int(11) unsigned NOT NULL COMMENT '结束时间',
  `company` varchar(255) NOT NULL COMMENT '公司',
  `industry` varchar(255) NOT NULL COMMENT '行业',
  `division` varchar(255) NOT NULL COMMENT '部门',
  `job` varchar(255) NOT NULL COMMENT '职位',
  `responsibility` text NOT NULL COMMENT '职位描述',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of job
-- ----------------------------

-- ----------------------------
-- Table structure for `keyword`
-- ----------------------------
DROP TABLE IF EXISTS `keyword`;
CREATE TABLE `keyword` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `keyword` varchar(255) NOT NULL,
  `hot` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of keyword
-- ----------------------------

-- ----------------------------
-- Table structure for `project`
-- ----------------------------
DROP TABLE IF EXISTS `project`;
CREATE TABLE `project` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) unsigned NOT NULL COMMENT '用户ID',
  `starttime` int(11) unsigned NOT NULL COMMENT '开始时间',
  `endtime` int(11) unsigned NOT NULL COMMENT '结束时间',
  `projectname` varchar(255) NOT NULL COMMENT '项目名称',
  `description` text NOT NULL COMMENT '项目描述',
  `responsibility` text NOT NULL COMMENT '责任描述',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of project
-- ----------------------------

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `uid` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `id_51job` int(11) NOT NULL COMMENT '51JOB简历ID',
  `name` varchar(255) NOT NULL COMMENT '姓名',
  `sex` tinyint(1) NOT NULL COMMENT '性别',
  `birthday` int(11) NOT NULL COMMENT '出生日期',
  `workyear` tinyint(1) NOT NULL COMMENT '工作年限',
  `mobile` varchar(11) NOT NULL COMMENT '手机号码',
  `email` varchar(50) NOT NULL COMMENT 'Email',
  `location` int(11) NOT NULL COMMENT '居住地',
  `jobstatus` tinyint(1) NOT NULL COMMENT '求职状态',
  `degrees` tinyint(1) NOT NULL COMMENT '学历',
  `major` int(11) NOT NULL COMMENT '专业',
  `resumepath` varchar(255) NOT NULL COMMENT '简历存放路径',
  `resumemd5` varchar(32) NOT NULL COMMENT 'Word简历md5值',
  `ctime` int(11) NOT NULL COMMENT '处理时间',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------

-- ----------------------------
-- Table structure for `user_join_function`
-- ----------------------------
DROP TABLE IF EXISTS `user_join_function`;
CREATE TABLE `user_join_function` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `function_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_join_function
-- ----------------------------

-- ----------------------------
-- Table structure for `user_join_keyword`
-- ----------------------------
DROP TABLE IF EXISTS `user_join_keyword`;
CREATE TABLE `user_join_keyword` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `keyword_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_join_keyword
-- ----------------------------
