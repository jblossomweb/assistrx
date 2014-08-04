# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.1.44)
# Database: arx_test
# Generation Time: 2013-05-15 20:17:11 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table patients
# ------------------------------------------------------------

DROP TABLE IF EXISTS `patients`;

CREATE TABLE `patients` (
  `patient_id` bigint(11) unsigned NOT NULL AUTO_INCREMENT,
  `patient_name` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `patient_phone` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `patient_age` int(3) NOT NULL,
  `favorite_song_id` bigint(11) DEFAULT NULL COMMENT 'this will house the patient''s song id',
  PRIMARY KEY (`patient_id`),
  KEY `song_id_index` (`favorite_song_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `patients` WRITE;
/*!40000 ALTER TABLE `patients` DISABLE KEYS */;

INSERT INTO `patients` (`patient_id`, `patient_name`, `patient_phone`, `patient_age`, `favorite_song_id`)
VALUES
	(1,'Kamal Small','532-498-9040',5,1),
	(2,'Gray Stein','117-694-4940',5,NULL),
	(3,'Elijah Galloway','507-183-4163',1,NULL),
	(4,'Lev Gutierrez','574-854-0319',74,NULL),
	(5,'Keegan Terry','259-583-4643',100,NULL),
	(6,'Reece Lambert','615-359-9985',42,NULL),
	(7,'Tad Stevens','586-177-6625',9,NULL),
	(8,'Melvin Duffy','502-358-4019',4,NULL),
	(9,'Burke Washington','863-758-5193',93,NULL),
	(10,'Lucian Baker','221-846-8793',61,NULL),
	(11,'Fritz Horton','834-933-6601',57,NULL),
	(12,'Murphy Greer','502-204-3128',80,NULL),
	(13,'Armando Maddox','741-189-4387',73,NULL),
	(14,'Isaac Hickman','869-505-5366',74,NULL),
	(15,'Avram Sanchez','996-142-4633',59,NULL),
	(16,'Rahim Potts','554-992-6976',45,NULL),
	(17,'Ethan Weeks','296-276-1366',69,NULL),
	(18,'Buckminster Evans','158-823-3623',98,NULL),
	(19,'Simon Donovan','746-148-0108',80,NULL),
	(20,'Chase Deleon','589-619-1973',29,NULL),
	(21,'Cade Beasley','540-477-8483',25,NULL),
	(22,'Wayne Jordan','382-507-3934',92,NULL),
	(23,'Hiram Hartman','786-882-3860',69,NULL),
	(24,'Jackson Howard','686-539-3543',33,NULL),
	(25,'Richard Gonzalez','722-269-9388',54,NULL),
	(26,'Cairo Patton','213-669-4347',33,NULL),
	(27,'Samson Hahn','826-653-8845',83,NULL),
	(28,'Harlan Shields','623-895-0316',32,NULL),
	(29,'Lawrence Albert','833-671-8474',84,NULL),
	(30,'Marsden Gardner','311-708-0469',92,NULL),
	(31,'Macon Frederick','136-734-0618',82,NULL),
	(32,'Aaron Gallagher','641-384-4924',77,NULL),
	(33,'Dalton Thornton','428-158-3157',61,NULL),
	(34,'Lionel Gregory','741-787-1909',45,NULL),
	(35,'Jason Watkins','707-991-1716',61,NULL),
	(36,'Joshua Shelton','224-861-2780',57,NULL),
	(37,'Aquila Baxter','605-291-1710',84,NULL),
	(38,'Drake Richards','193-585-7233',42,NULL),
	(39,'Lawrence Cline','377-473-3253',45,NULL),
	(40,'Lyle Bright','669-949-8846',37,NULL),
	(41,'Darius Weiss','763-386-0597',97,NULL),
	(42,'Galvin Alvarado','574-280-8892',74,NULL),
	(43,'Reuben Bruce','254-541-1849',49,NULL),
	(44,'Ishmael Mayo','525-820-6714',78,NULL),
	(45,'Wayne Floyd','720-532-0875',99,NULL),
	(46,'Stewart Gill','588-943-2914',100,NULL),
	(47,'Raja Combs','229-156-3626',87,NULL),
	(48,'Dale King','674-509-3997',23,NULL),
	(49,'Brady Pickett','457-278-4790',43,NULL),
	(50,'Denton Nunez','695-941-6967',91,NULL),
	(51,'Ulysses Munoz','868-942-5143',98,NULL),
	(52,'Wallace Bates','904-261-1206',37,NULL),
	(53,'Luke Mccall','934-903-5929',21,NULL),
	(54,'Preston Bryan','700-610-6623',73,NULL),
	(55,'Garth Marquez','709-459-7087',40,NULL),
	(56,'Garrett Patterson','639-445-4526',59,NULL),
	(57,'Slade Delacruz','819-276-2608',60,NULL),
	(58,'Ray Tanner','452-839-1236',81,NULL),
	(59,'Scott Conrad','147-875-0678',34,NULL),
	(60,'Yoshio Larson','471-265-7920',90,NULL),
	(61,'Hashim Foster','301-121-5002',63,NULL),
	(62,'Bernard Walls','492-446-1588',9,NULL),
	(63,'Lucian Schmidt','477-809-8101',28,NULL),
	(64,'Lionel Cook','398-482-3158',80,NULL),
	(65,'Philip Harding','664-348-0160',14,NULL),
	(66,'Kareem Copeland','274-897-7715',95,NULL),
	(67,'Josiah Petersen','535-371-9243',7,NULL),
	(68,'Isaac Little','756-378-0279',2,NULL),
	(69,'Henry Moses','205-771-1248',45,NULL),
	(70,'Garrison Berg','971-428-9916',84,NULL),
	(71,'Caldwell Tyson','509-971-0388',48,NULL),
	(72,'Abbot Bradford','985-394-0083',92,NULL),
	(73,'Porter Gilliam','141-337-3270',44,NULL),
	(74,'Paul Greer','358-367-1200',65,NULL),
	(75,'Cade Carpenter','550-381-7030',77,NULL),
	(76,'Marsden Guzman','578-301-8944',67,NULL),
	(77,'Louis Norman','773-988-4902',8,NULL),
	(78,'Preston Gamble','480-125-7088',17,NULL),
	(79,'Logan Richard','614-371-0108',92,NULL),
	(80,'Howard Sharp','979-703-6148',75,NULL),
	(81,'Colt Stout','600-286-3291',46,NULL),
	(82,'Wade Crawford','581-961-7587',92,NULL),
	(83,'Hyatt Watts','436-612-6245',92,NULL),
	(84,'Price Santana','882-807-6273',33,NULL),
	(85,'Honorato Thomas','228-611-9871',16,NULL),
	(86,'George Herman','693-471-2093',78,NULL),
	(87,'Lucius Mcconnell','599-980-2674',83,NULL),
	(88,'Neville Garcia','684-920-8646',82,NULL),
	(89,'Phelan Merrill','813-579-4692',71,NULL),
	(90,'Brody Wiggins','557-283-0333',47,NULL),
	(91,'Castor Wilkins','977-746-8805',74,NULL),
	(92,'Jameson Collins','688-773-3552',92,NULL),
	(93,'Kasimir Mendez','290-480-1676',29,NULL),
	(94,'Lars Hodges','411-837-6254',62,NULL),
	(95,'Tyrone York','219-771-5854',91,NULL),
	(96,'Odysseus Carson','634-377-4968',74,NULL),
	(97,'Elliott Bradford','377-378-3651',80,NULL),
	(98,'Brennan Barker','469-176-4181',99,NULL),
	(99,'Emmanuel Bush','618-921-7944',80,NULL),
	(100,'Ralph Cannon','399-502-0938',56,NULL);

/*!40000 ALTER TABLE `patients` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table songs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `songs`;

CREATE TABLE `songs` (
  `song_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `song_name` varchar(300) NOT NULL,
  `song_artist` varchar(100) DEFAULT NULL,
  `song_data` text NOT NULL,
  `song_hash` varchar(32) NOT NULL DEFAULT '',
  PRIMARY KEY (`song_id`),
  KEY `song_hash_index` (`song_hash`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `songs` WRITE;
/*!40000 ALTER TABLE `songs` DISABLE KEYS */;

INSERT INTO `songs` (`song_id`, `song_name`, `song_artist`, `song_data`, `song_hash`)
VALUES
	(1,'I Knew You Were Trouble','Taylor Swift','{\"wrapperType\":\"track\",\"kind\":\"song\",\"artistId\":\"159260351\",\"collectionId\":\"571445253\",\"trackId\":\"571445453\",\"artistName\":\"Taylor Swift\",\"collectionName\":\"Red\",\"trackName\":\"I Knew You Were Trouble\",\"collectionCensoredName\":\"Red\",\"trackCensoredName\":\"I Knew You Were Trouble\",\"artistViewUrl\":\"https:\\/\\/itunes.apple.com\\/us\\/artist\\/taylor-swift\\/id159260351?uo=4\",\"collectionViewUrl\":\"https:\\/\\/itunes.apple.com\\/us\\/album\\/i-knew-you-were-trouble\\/id571445253?i=571445453&uo=4\",\"trackViewUrl\":\"https:\\/\\/itunes.apple.com\\/us\\/album\\/i-knew-you-were-trouble\\/id571445253?i=571445453&uo=4\",\"previewUrl\":\"http:\\/\\/a1689.phobos.apple.com\\/us\\/r1000\\/120\\/Music\\/v4\\/b3\\/b1\\/01\\/b3b101c5-0afd-a536-394d-962b7012e8e1\\/mzaf_2968645385761922805.aac.m4a\",\"artworkUrl30\":\"http:\\/\\/a5.mzstatic.com\\/us\\/r1000\\/103\\/Music\\/v4\\/eb\\/bc\\/02\\/ebbc0219-a3a1-7c77-42ed-706251b98136\\/UMG_cvrart_00843930007134_01_RGB72_1200x1200_12UMDIM01007.30x30-50.jpg\",\"artworkUrl60\":\"http:\\/\\/a4.mzstatic.com\\/us\\/r1000\\/103\\/Music\\/v4\\/eb\\/bc\\/02\\/ebbc0219-a3a1-7c77-42ed-706251b98136\\/UMG_cvrart_00843930007134_01_RGB72_1200x1200_12UMDIM01007.60x60-50.jpg\",\"artworkUrl100\":\"http:\\/\\/a3.mzstatic.com\\/us\\/r1000\\/103\\/Music\\/v4\\/eb\\/bc\\/02\\/ebbc0219-a3a1-7c77-42ed-706251b98136\\/UMG_cvrart_00843930007134_01_RGB72_1200x1200_12UMDIM01007.100x100-75.jpg\",\"collectionPrice\":\"14.99\",\"trackPrice\":\"1.29\",\"releaseDate\":\"2012-10-22T07:00:00Z\",\"collectionExplicitness\":\"notExplicit\",\"trackExplicitness\":\"notExplicit\",\"discCount\":\"1\",\"discNumber\":\"1\",\"trackCount\":\"16\",\"trackNumber\":\"4\",\"trackTimeMillis\":\"219721\",\"country\":\"USA\",\"currency\":\"USD\",\"primaryGenreName\":\"Country\"}','d9f122d0e92830935350994e6538b522');

/*!40000 ALTER TABLE `songs` ENABLE KEYS */;
UNLOCK TABLES;

DELIMITER ;;
/*!50003 SET SESSION SQL_MODE="" */;;
/*!50003 CREATE */ /*!50017 DEFINER=`root`@`localhost` */ /*!50003 TRIGGER `get_song_hash` BEFORE INSERT ON `songs` FOR EACH ROW BEGIN 
	SET new.song_hash = md5(new.song_data);
END */;;
DELIMITER ;
/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
