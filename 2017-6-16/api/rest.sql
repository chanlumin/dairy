/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50714
Source Host           : localhost:3306
Source Database       : rest

Target Server Type    : MYSQL
Target Server Version : 50714
File Encoding         : 65001

Date: 2017-06-19 16:09:40
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `article`
-- ----------------------------
DROP TABLE IF EXISTS `article`;
CREATE TABLE `article` (
  `article_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '文章ID',
  `title` varchar(40) NOT NULL COMMENT '文章标题',
  `content` text NOT NULL COMMENT '文章内容',
  `user_id` int(11) NOT NULL COMMENT '关联的用户id',
  `create_time` int(11) NOT NULL,
  PRIMARY KEY (`article_id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COMMENT='文章表';

-- ----------------------------
-- Records of article
-- ----------------------------
INSERT INTO `article` VALUES ('7', '周凡爱我', '我爱周凡', '3', '1497694755');
INSERT INTO `article` VALUES ('9', 'zhoufai love me', 'I love zhoufan', '3', '1497694884');
INSERT INTO `article` VALUES ('10', 'zhoufai love me', 'I love zhoufan', '3', '1497694914');
INSERT INTO `article` VALUES ('11', 'zhoufai love me', 'I love zhoufan', '3', '1497695225');
INSERT INTO `article` VALUES ('12', '我爱周凡', '周凡嫁给我', '3', '1497695254');
INSERT INTO `article` VALUES ('13', '我爱周凡', '周凡我爱你', '3', '1497695330');
INSERT INTO `article` VALUES ('16', 'å‘¨å‡¡çˆ±æˆ‘', 'æˆ‘çˆ±å‘¨å‡¡', '3', '1497695365');
INSERT INTO `article` VALUES ('17', 'å‘¨å‡¡çˆ±æˆ‘', 'æˆ‘çˆ±å‘¨å‡¡', '3', '1497695370');
INSERT INTO `article` VALUES ('18', 'å‘¨å‡¡çˆ±æˆ‘', 'æˆ‘çˆ±å‘¨å‡¡', '3', '1497695635');
INSERT INTO `article` VALUES ('19', 'å‘¨å‡¡çˆ±æˆ‘', 'æˆ‘çˆ±å‘¨å‡¡', '3', '1497695669');
INSERT INTO `article` VALUES ('20', '周凡爱我', '我爱周凡', '3', '1497696759');
INSERT INTO `article` VALUES ('21', 'helldo', 'hello', '5', '1497841020');
INSERT INTO `article` VALUES ('22', '我爱周凡', '周凡嫁给我', '5', '1497841144');
INSERT INTO `article` VALUES ('23', '我爱周凡', '周凡嫁给我', '5', '1497844975');
INSERT INTO `article` VALUES ('24', '我爱周凡', '周凡嫁给我', '5', '1497845079');
INSERT INTO `article` VALUES ('25', '我爱周凡', '周凡嫁给我', '5', '1497845091');
INSERT INTO `article` VALUES ('26', '我爱周凡', '周凡嫁给我', '5', '1497845118');
INSERT INTO `article` VALUES ('27', '我爱周凡', '周凡嫁给我', '5', '1497856744');

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `user_name` varchar(11) NOT NULL COMMENT '用户名',
  `password` char(32) NOT NULL COMMENT '密码',
  `create_time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`),
  KEY `user_name` (`user_name`,`create_time`),
  KEY `user_name_2` (`user_name`),
  KEY `create_time` (`create_time`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='用户表单';

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('2', 'admin2', '2222', '1497663210');
INSERT INTO `user` VALUES ('3', 'zhoufan', 'd1e2348b8e26f6998a6e1e4fababf782', '1497663516');
INSERT INTO `user` VALUES ('4', 'lumin', '4f6421e08f8702c7a630bddb396dcfc6', '1497671581');
INSERT INTO `user` VALUES ('5', 'hello', 'd1e66382eaab8a6dad5f2f205159a394', '1497792569');
INSERT INTO `user` VALUES ('6', 'helldo', 'd1e66382eaab8a6dad5f2f205159a394', '1497794663');
