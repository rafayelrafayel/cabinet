/*
SQLyog Enterprise - MySQL GUI v8.14 
MySQL - 5.5.44-0ubuntu0.14.04.1 : Database - cabinet_log
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`cabinet_log` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;

USE `cabinet_log`;

/*Table structure for table `tracelog` */

DROP TABLE IF EXISTS `tracelog`;

CREATE TABLE `tracelog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `method` varchar(1000) COLLATE utf8_bin DEFAULT NULL,
  `file` varchar(1000) COLLATE utf8_bin DEFAULT NULL,
  `session_id` varchar(1000) COLLATE utf8_bin DEFAULT NULL,
  `in_out` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `data` text COLLATE utf8_bin,
  `dt` datetime DEFAULT NULL,
  `type` varchar(1000) COLLATE utf8_bin DEFAULT NULL,
  `error_flag` int(11) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8635 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `tracelog` */


/*Table structure for table `tracelog_copy` */

DROP TABLE IF EXISTS `tracelog_copy`;

CREATE TABLE `tracelog_copy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `method` varchar(1000) COLLATE utf8_bin DEFAULT NULL,
  `file` varchar(1000) COLLATE utf8_bin DEFAULT NULL,
  `session_id` varchar(1000) COLLATE utf8_bin DEFAULT NULL,
  `in_out` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `data` text COLLATE utf8_bin,
  `dt` datetime DEFAULT NULL,
  `type` varchar(1000) COLLATE utf8_bin DEFAULT NULL,
  `error_flag` int(11) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `tracelog_copy` */

/* Procedure structure for procedure `getLog` */

/*!50003 DROP PROCEDURE IF EXISTS  `getLog` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `getLog`(
in p_d1 datetime,
in p_d2 datetime,
IN p_type varchar(1000),
IN p_in_out VARCHAR(200),
IN p_session VARCHAR(100),
IN p_method varchar(1000),
in p_text VARCHAR(1000))
BEGIN
    
    
		select id,type,method,file file1,session_id,in_out,data,dt
		from tracelog 
		where 
			(dt>=p_d1 or p_d1='0000-00-00 00:00:00' and p_session<>'') and 
			(dt<=p_d2 or p_d2='0000-00-00 00:00:00' and p_session<>'') and 
			(type=p_type or p_type='') and 
			(in_out=p_in_out OR p_in_out='') AND 
			(session_id=p_session or p_session='') AND
			(method=p_method or p_method='') and 
			(data like concat('%',p_text,'%') or p_text='');
END */$$
DELIMITER ;

/* Procedure structure for procedure `setLog` */

/*!50003 DROP PROCEDURE IF EXISTS  `setLog` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `setLog`(IN p_type varchar(1000),
IN p_in_out VARCHAR(200),
IN p_session VARCHAR(100),
						IN p_method varchar(1000),
						in p_file varchar(1000),
						in p_text VARCHAR(1000),in p_error int )
BEGIN
    
    if p_method!='term_status' then
		INSERT INTO tracelog (type,method,FILE,SESSION_id,in_out,data,dt,error_flag)
			VALUES (p_type,p_method,p_file,p_session,p_in_out,p_text,NOW(),p_error);
    end if; 				
END */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;