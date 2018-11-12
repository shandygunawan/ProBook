-- MySQL dump 10.16  Distrib 10.1.36-MariaDB, for Win32 (AMD64)
--
-- Host: localhost    Database: tubeswbd
-- ------------------------------------------------------
-- Server version	10.1.36-MariaDB

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
-- Table structure for table `book`
--

DROP TABLE IF EXISTS `book`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `book` (
  `BookID` int(11) NOT NULL AUTO_INCREMENT,
  `BookName` text NOT NULL,
  `Author` text NOT NULL,
  `Synopsis` text NOT NULL,
  `PicturePath` text NOT NULL,
  PRIMARY KEY (`BookID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `book`
--

LOCK TABLES `book` WRITE;
/*!40000 ALTER TABLE `book` DISABLE KEYS */;
INSERT INTO `book` VALUES (1,'I Am My Wife','Luànshì yín niáng qiáo g?ngz?','Time reversed, Qiu Yi became a girl, but a male version of himself still exists in this time... ?Am I still myself? Who exactly am I?? What kind of sparks would ignite when he, who is a girl, meets his male self?','/asset/book_img/iammywife.jpg');
INSERT INTO `book` VALUES (2,'One Punch-Man','One','The seemingly ordinary and unimpressive Saitama has a rather unique hobby: being a hero. In order to pursue his childhood dream, he trained relentlessly for three years—and lost all of his hair in the process. Now, Saitama is incredibly powerful, so much so that no enemy is able to defeat him in battle. In fact, all it takes to defeat evildoers with just one punch has led to an unexpected problem—he is no longer able to enjoy the thrill of battling and has become quite bored. This all changes with the arrival of Genos, a 19-year-old cyborg, who wishes to be Saitama\'s disciple after seeing what he is capable of. Genos proposes that the two join the Hero Association in order to become certified heroes that will be recognized for their positive contributions to society, and Saitama, shocked that no one knows who he is, quickly agrees. And thus begins the story of One Punch Man, an action-comedy that follows an eccentric individual who longs to fight strong enemies that can hopefully give him the excitement he once felt and just maybe, he\'ll become popular in the process.','/asset/book_img/opm.jpg');
INSERT INTO `book` VALUES (3,'Shigatsu wa Kimi no Uso','Masaru Yokoyama','Music accompanies the path of the human metronome, the prodigious pianist Kousei Arima. But after the passing of his mother, Saki Arima, Kousei falls into a downward spiral, rendering him unable to hear the sound of his own piano. Two years later, Kousei still avoids the piano, leaving behind his admirers and rivals, and lives a colorless life alongside his friends Tsubaki Sawabe and Ryouta Watari. However, everything changes when he meets a beautiful violinist, Kaori Miyazono, who stirs up his world and sets him on a journey to face music again. Based on the manga series of the same name, Shigatsu wa Kimi no Uso approaches the story of Kousei\'s recovery as he discovers that music is more than playing each note perfectly, and a single melody can bring in the fresh spring air of April.','/asset/book_img/kaorided.jpg');
INSERT INTO `book` VALUES (4,'Youjo Senki','Carlo Zen','Tanya Degurechaff is a young soldier infamous for predatorial-like ruthlessness and an uncanny, tactical aptitude, earning her the nickname of the \"Devil of the Rhine.\" Underneath her innocuous appearance, however, lies the soul of a man who challenged Being X, the self-proclaimed God, to a battle of wits—which resulted in him being reincarnated as a little girl into a world of magical warfare. Hellbent on defiance, Tanya resolves to ascend the ranks of her country\'s military as it slowly plunges into world war, with only Being X proving to be the strongest obstacle in recreating the peaceful life she once knew. But her perceptive actions and combat initiative have an unintended side effect: propelling the mighty Empire into becoming one of the most powerful nations in mankind\'s history.','/asset/book_img/youjosenki.jpg');
INSERT INTO `book` VALUES (5,'Yamada-kun to 7-nin no Majo','Miki Yoshikawa','When Ryuu Yamada entered high school, he wanted to turn over a new leaf and lead a productive school life. That\'s why he chose to attend Suzaku High, where no one would know of his violent delinquent reputation. However, much to Ryuu\'s dismay, he is soon bored; now a second year, Ryuu has reverted to his old ways—lazy with abysmal grades and always getting into fights. One day, back from yet another office visit, Ryuu encounters Urara Shiraishi, a beautiful honors student. A misstep causes them both to tumble down the stairs, ending in an accidental kiss! The pair discover they can switch bodies with a kiss: an ability which will prove to be both convenient and troublesome. Learning of their new power, Toranosuke Miyamura, a student council officer and the single member of the Supernatural Studies Club, recruits them for the club. Soon joined by Miyabi Itou, an eccentric interested in all things supernatural, the group unearths the legend of the Seven Witches of Suzaku High, seven female students who have obtained different powers activated by a kiss. The Supernatural Studies Club embarks on its first quest: to find the identities of all the witches.','/asset/book_img/yamatot.jpg');
/*!40000 ALTER TABLE `book` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bookorder`
--

DROP TABLE IF EXISTS `bookorder`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bookorder` (
  `OrderID` int(11) NOT NULL AUTO_INCREMENT,
  `Amount` int(11) NOT NULL,
  `OrderDate` date NOT NULL,
  `UserID` int(11) NOT NULL,
  `BookID` int(11) NOT NULL,
  PRIMARY KEY (`OrderID`),
  KEY `UserID` (`UserID`),
  KEY `BookID` (`BookID`),
  CONSTRAINT `bookorder_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`),
  CONSTRAINT `bookorder_ibfk_2` FOREIGN KEY (`BookID`) REFERENCES `book` (`BookID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bookorder`
--

LOCK TABLES `bookorder` WRITE;
/*!40000 ALTER TABLE `bookorder` DISABLE KEYS */;
INSERT INTO `bookorder` VALUES (1,10,'0000-00-00',1,5),(2,100,'2010-00-00',1,5);
/*!40000 ALTER TABLE `bookorder` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `review`
--

DROP TABLE IF EXISTS `review`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `review` (
  `Score` float NOT NULL,
  `Comment` text,
  `UserID` int(11) NOT NULL,
  `BookID` int(11) NOT NULL,
  `OrderID` int(11) NOT NULL,
  KEY `BookID` (`BookID`),
  KEY `UserID` (`UserID`),
  KEY `OrderID` (`OrderID`),
  CONSTRAINT `review_ibfk_1` FOREIGN KEY (`BookID`) REFERENCES `book` (`BookID`),
  CONSTRAINT `review_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`),
  CONSTRAINT `review_ibfk_3` FOREIGN KEY (`OrderID`) REFERENCES `bookorder` (`OrderID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `review`
--

LOCK TABLES `review` WRITE;
/*!40000 ALTER TABLE `review` DISABLE KEYS */;
INSERT INTO `review` VALUES (5,'I love Shiraishi <3',1,5,1),(5,'',1,5,2);
/*!40000 ALTER TABLE `review` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `UserID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` text NOT NULL,
  `Username` text NOT NULL,
  `Email` text NOT NULL,
  `Password` text NOT NULL,
  `Address` text NOT NULL,
  `PhoneNumber` text NOT NULL,
  `PicturePath` text NOT NULL,
  PRIMARY KEY (`UserID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'Ihsan M. A.','ihsansaktia','ihsan.saktia@gmail.com','aingbukanwibutq','Jalan Bangbayang',2147483647,'/asset/user_img/ihsansaktia.jpg');
INSERT INTO `user` VALUES (2,'Shandy','higgsfield','shandy.gunawan@rocketmail.com','Ihsan_wibu','Cisitu', 08989898797,'/asset/user_img/higgsfield.jpg');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-10-25 12:57:58
