-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 28, 2018 at 07:20 AM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `quizseed`
--

-- --------------------------------------------------------

--
-- Table structure for table `answer`
--

CREATE TABLE IF NOT EXISTS `answer` (
  `qid` text NOT NULL,
  `ansid` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `answer`
--

INSERT INTO `answer` (`qid`, `ansid`) VALUES
('55892169bf6a7', '55892169d2efc'),
('5589216a3646e', '5589216a48722'),
('558922117fcef', '5589221195248'),
('55892211e44d5', '55892211f1fa7'),
('558922894c453', '558922895ea0a'),
('558922899ccaa', '55892289aa7cf'),
('558923538f48d', '558923539a46c'),
('55892353f05c4', '55892354051be'),
('558973f4389ac', '558973f462e61'),
('558973f4c46f2', '558973f4d4abe'),
('558973f51600d', '558973f526fc5'),
('558973f55d269', '558973f57af07'),
('558973f5abb1a', '558973f5e764a'),
('5589751a63091', '5589751a81bf4'),
('5589751ad32b8', '5589751adbdbd'),
('5589751b304ef', '5589751b3b04d'),
('5589751b749c9', '5589751b9a98c');

-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

CREATE TABLE IF NOT EXISTS `faq` (
  `sno` int(11) NOT NULL,
  `ques` varchar(256) NOT NULL,
  `ans` varchar(1024) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `faq`
--

INSERT INTO `faq` (`sno`, `ques`, `ans`) VALUES
(1, 'What is Quizseed ?', 'Quizseed  is a professional, internet based Testing Platform, using which you can conduct tests for your aspirants (students or employees). A fast yet easy approach that lets you store your questions and tests on an online testing platform seamlessly. Simple procedure involved in the creation and assignment of tests with the smooth development of reports.'),
(2, 'Can I insert my organization logo for branding purposes?', 'No. will be add this feature soon'),
(3, 'What does Add Student mean?', 'In the application, only examiner and the admin have rights to add or register students for conducting exams\r\n\r\nFor security resons, student cant register them selves in the website'),
(4, 'How can i become examiner?', 'if you want to become examiner you can contact us via mail or address or phone n. that is provided .\r\n'),
(5, 'May I reappear for the same test ?', 'No.'),
(6, 'Can i register as student myself ?', 'yes. there is registration link provided on home page.'),
(7, 'can i update my profile myself?', 'yes.');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE IF NOT EXISTS `feedback` (
`id` int(11) NOT NULL,
  `name` varchar(52) NOT NULL,
  `email` varchar(52) NOT NULL,
  `mobile` varchar(16) NOT NULL,
  `subject` varchar(128) NOT NULL,
  `msg` varchar(140) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `name`, `email`, `mobile`, `subject`, `msg`) VALUES
(16, 'apurva gupta', 'gapurva1@gmail.com', '8279735538', 'quiz', 'hey....nice user interface'),
(17, 'jasneet dua', 'jasneetdua96@gmail.com', '7906965767', 'questions', 'good job .....'),
(18, 'dheerendra', 'dheerendra@gmail.com', '9878675456', 'register', 'how can i become examiner on your website ?'),
(19, 'ayush raj sharma ', 'er.ayush@gmail.com', '89767876554', 'quiz related', 'can i re-appear the same test ?');

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE IF NOT EXISTS `history` (
  `uname` varchar(50) NOT NULL,
  `eid` text NOT NULL,
  `score` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `correct` int(11) NOT NULL,
  `wrong` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`uname`, `eid`, `score`, `level`, `correct`, `wrong`, `date`) VALUES
('Admin@admin.com', '5589741f9ed52', 2, 1, 1, 0, '2018-04-06 13:45:58'),
('Admin@admin.com', '558922ec03021', 4, 2, 2, 0, '2018-04-06 13:48:25'),
('gapurva', '5589741f9ed52', -2, 5, 1, 4, '2018-04-15 11:27:41'),
('gapurva', '55897338a6659', 1, 5, 2, 3, '2018-04-15 12:44:35'),
('jasneet', '5589741f9ed52', -5, 5, 0, 5, '2018-04-15 12:46:22'),
('jasneet', '55897338a6659', -2, 5, 1, 4, '2018-04-15 12:46:58'),
('jasneet', '558922ec03021', 4, 2, 2, 0, '2018-04-15 12:47:26'),
('jasneet', '5589222f16b93', 1, 2, 1, 1, '2018-04-15 12:48:26'),
('jasneet', '558921841f1ec', 4, 2, 2, 0, '2018-04-15 12:48:54'),
('dheeru', '558920ff906b8', -1, 1, 0, 1, '2018-04-16 10:04:22'),
('ambrishsha', '558920ff906b8', -2, 2, 0, 2, '2018-04-16 10:24:29'),
('dheeru', '558921841f1ec', 1, 2, 1, 1, '2018-04-25 07:08:27');

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE IF NOT EXISTS `options` (
  `qid` varchar(50) NOT NULL,
  `option` varchar(5000) NOT NULL,
  `optionid` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`qid`, `option`, `optionid`) VALUES
('55892169bf6a7', 'usermod', '55892169d2efc'),
('55892169bf6a7', 'useradd', '55892169d2f05'),
('55892169bf6a7', 'useralter', '55892169d2f09'),
('55892169bf6a7', 'groupmod', '55892169d2f0c'),
('5589216a3646e', '751', '5589216a48713'),
('5589216a3646e', '752', '5589216a4871a'),
('5589216a3646e', '754', '5589216a4871f'),
('5589216a3646e', '755', '5589216a48722'),
('558922117fcef', 'echo', '5589221195248'),
('558922117fcef', 'print', '558922119525a'),
('558922117fcef', 'printf', '5589221195265'),
('558922117fcef', 'cout', '5589221195270'),
('55892211e44d5', 'int a', '55892211f1f97'),
('55892211e44d5', '$a', '55892211f1fa7'),
('55892211e44d5', 'long int a', '55892211f1fb4'),
('55892211e44d5', 'int a$', '55892211f1fbd'),
('558922894c453', 'cin>>a;', '558922895ea0a'),
('558922894c453', 'cin<<a;', '558922895ea26'),
('558922894c453', 'cout>>a;', '558922895ea34'),
('558922894c453', 'cout<a;', '558922895ea41'),
('558922899ccaa', 'cout', '55892289aa7cf'),
('558922899ccaa', 'cin', '55892289aa7df'),
('558922899ccaa', 'print', '55892289aa7eb'),
('558922899ccaa', 'printf', '55892289aa7f5'),
('558923538f48d', '255.0.0.0', '558923539a46c'),
('558923538f48d', '255.255.255.0', '558923539a480'),
('558923538f48d', '255.255.0.0', '558923539a48b'),
('558923538f48d', 'none of these', '558923539a495'),
('55892353f05c4', '192.168.1.100', '5589235405192'),
('55892353f05c4', '172.168.16.2', '55892354051a3'),
('55892353f05c4', '10.0.0.0.1', '55892354051b4'),
('55892353f05c4', '11.11.11.11', '55892354051be'),
('558973f4389ac', 'containing root file-system required during bootup', '558973f462e44'),
('558973f4389ac', ' Contains only scripts to be executed during bootup', '558973f462e56'),
('558973f4389ac', ' Contains root-file system and drivers required to be preloaded during bootup', '558973f462e61'),
('558973f4389ac', 'None of the above', '558973f462e6b'),
('558973f4c46f2', 'Kernel', '558973f4d4abe'),
('558973f4c46f2', 'Shell', '558973f4d4acf'),
('558973f4c46f2', 'Commands', '558973f4d4ad9'),
('558973f4c46f2', 'Script', '558973f4d4ae3'),
('558973f51600d', 'Boot Loading', '558973f526f9d'),
('558973f51600d', ' Boot Record', '558973f526fb9'),
('558973f51600d', ' Boot Strapping', '558973f526fc5'),
('558973f51600d', ' Booting', '558973f526fce'),
('558973f55d269', ' Quick boot', '558973f57aef1'),
('558973f55d269', 'Cold boot', '558973f57af07'),
('558973f55d269', ' Hot boot', '558973f57af17'),
('558973f55d269', ' Fast boot', '558973f57af27'),
('558973f5abb1a', 'bash', '558973f5e7623'),
('558973f5abb1a', ' Csh', '558973f5e7636'),
('558973f5abb1a', ' ksh', '558973f5e7640'),
('558973f5abb1a', ' sh', '558973f5e764a'),
('5589751a63091', 'q', '5589751a81bd6'),
('5589751a63091', 'wq', '5589751a81be8'),
('5589751a63091', ' both (a) and (b)', '5589751a81bf4'),
('5589751a63091', ' none of the mentioned', '5589751a81bfd'),
('5589751ad32b8', ' moves screen down one page', '5589751adbdbd'),
('5589751ad32b8', 'moves screen up one page', '5589751adbdce'),
('5589751ad32b8', 'moves screen up one line', '5589751adbdd8'),
('5589751ad32b8', ' moves screen down one line', '5589751adbde2'),
('5589751b304ef', ' yy', '5589751b3b04d'),
('5589751b304ef', 'yw', '5589751b3b05e'),
('5589751b304ef', 'yc', '5589751b3b069'),
('5589751b304ef', ' none of the mentioned', '5589751b3b073'),
('5589751b749c9', 'X', '5589751b9a98c'),
('5589751b749c9', 'x', '5589751b9a9a5'),
('5589751b749c9', 'D', '5589751b9a9b7'),
('5589751b749c9', 'd', '5589751b9a9c9'),
('5589751bd02ec', 'autoindentation is not possible in vi editor', '5589751bdadaa');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE IF NOT EXISTS `questions` (
  `eid` text NOT NULL,
  `qid` text NOT NULL,
  `qns` text NOT NULL,
  `choice` int(10) NOT NULL,
  `sn` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`eid`, `qid`, `qns`, `choice`, `sn`) VALUES
('558920ff906b8', '55892169bf6a7', 'what is command for changing user information??', 4, 1),
('558920ff906b8', '5589216a3646e', 'what is permission for view only for other??', 4, 2),
('558921841f1ec', '558922117fcef', 'what is command for print in php??', 4, 1),
('558921841f1ec', '55892211e44d5', 'which is a variable of php??', 4, 2),
('5589222f16b93', '558922894c453', 'what is correct statement in c++??', 4, 1),
('5589222f16b93', '558922899ccaa', 'which command is use for print the output in c++?', 4, 2),
('558922ec03021', '558923538f48d', 'what is correct mask for A class IP???', 4, 1),
('558922ec03021', '55892353f05c4', 'which is not a private IP??', 4, 2),
('55897338a6659', '558973f4389ac', 'On Linux, initrd is a file', 4, 1),
('55897338a6659', '558973f4c46f2', 'Which is loaded into memory when system is booted?', 4, 2),
('55897338a6659', '558973f51600d', ' The process of starting up a computer is known as', 4, 3),
('55897338a6659', '558973f55d269', ' Bootstrapping is also known as', 4, 4),
('55897338a6659', '558973f5abb1a', 'The shell used for Single user mode shell is:', 4, 5),
('5589741f9ed52', '5589751a63091', ' Which command is used to close the vi editor?', 4, 1),
('5589741f9ed52', '5589751ad32b8', ' In vi editor, the key combination CTRL+f', 4, 2),
('5589741f9ed52', '5589751b304ef', ' Which vi editor command copies the current line of the file?', 4, 3),
('5589741f9ed52', '5589751b749c9', ' Which command is used to delete the character before the cursor location in vi editor?', 4, 4),
('5589741f9ed52', '5589751bd02ec', ' Which one of the following statement is true?', 4, 5);

-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

CREATE TABLE IF NOT EXISTS `quiz` (
  `eid` text NOT NULL,
  `title` varchar(100) NOT NULL,
  `correct` int(11) NOT NULL,
  `wrong` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `time` bigint(20) NOT NULL,
  `intro` text NOT NULL,
  `tag` varchar(100) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `examiner` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `quiz`
--

INSERT INTO `quiz` (`eid`, `title`, `correct`, `wrong`, `total`, `time`, `intro`, `tag`, `date`, `examiner`) VALUES
('558920ff906b8', 'Linux : File Managment', 2, 1, 2, 5, '', 'linux', '2018-04-13 18:30:00', ''),
('558921841f1ec', 'Php Coding', 2, 1, 2, 5, '', 'PHP', '2018-04-13 18:30:00', ''),
('5589222f16b93', 'C++ Coding', 2, 1, 2, 5, '', 'c++', '2018-04-13 18:30:00', ''),
('558922ec03021', 'Networking', 2, 1, 2, 5, '', 'networking', '2018-04-13 18:30:00', ''),
('55897338a6659', 'Linux:startup', 2, 1, 5, 10, '', 'linux', '2018-04-13 18:30:00', ''),
('5589741f9ed52', 'Linux :vi Editor', 2, 1, 5, 10, '', 'linux', '2018-04-13 18:30:00', '');

-- --------------------------------------------------------

--
-- Table structure for table `rank`
--

CREATE TABLE IF NOT EXISTS `rank` (
  `uname` varchar(50) NOT NULL,
  `score` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rank`
--

INSERT INTO `rank` (`uname`, `score`, `time`) VALUES
('gapurva', 1, '2018-04-15 12:44:35'),
('jasneet', 2, '2018-04-15 12:48:54'),
('ambrishsha', -2, '2018-04-16 10:24:29'),
('dheeru', 1, '2018-04-25 07:08:27');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `uname` varchar(50) NOT NULL COMMENT 'User Name',
  `pass` varchar(50) NOT NULL COMMENT 'Password',
  `cat` varchar(15) NOT NULL COMMENT 'Category',
  `fname` varchar(15) NOT NULL COMMENT 'First Name',
  `lname` varchar(16) NOT NULL COMMENT 'Last Name',
  `email` varchar(50) NOT NULL COMMENT 'E Mail',
  `phn` varchar(16) NOT NULL COMMENT 'Phone Number',
  `gender` varchar(2) NOT NULL COMMENT 'Gender',
  `dob` date NOT NULL COMMENT 'Date of Birth',
  `pic` varchar(6) NOT NULL COMMENT 'Picture Extension'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`uname`, `pass`, `cat`, `fname`, `lname`, `email`, `phn`, `gender`, `dob`, `pic`) VALUES
('abhinav', 'abhinav123', 'examiner', 'Abhinav', 'gupta', 'abhinavguptaji@gmail.com', '9898878988', 'M', '0000-00-00', 'jpg'),
('admin', 'admin123', 'admin', 'Jasneet', 'Dua', 'jasneetdua96@gmail.com', '9997563959', 'M', '1996-10-03', 'jpg'),
('ambrishsha', 'admin123', 'student', 'Ambrish', 'Sharma', 'ambrishsha@gmail.com', '9457352127', 'M', '1999-12-12', 'png'),
('apurva', 'apurva123', 'admin', 'Apurva', 'Gupta', 'gapurva1@gmail.com', '8279735538', 'F', '1997-12-04', 'jpg'),
('ayush', 'ayush123', 'examiner', 'Ayush', 'Raj', 'erayush@gmail.com', '8789878976', 'M', '0000-00-00', 'jpg'),
('dheeru', 'dheeru123', 'student', 'Dheerendra', 'pratap', 'dheerendra@gmail.com', '6765654656', 'M', '0000-00-00', 'jpg'),
('exam', 'exam123', 'examiner', 'Jasneet', 'Dua', 'jasneetdua96@gmail.com', '9997563959', 'M', '0000-00-00', 'jpg'),
('gapurva', 'gapurva123', 'student', 'apurva ', 'gupta', 'gapurva1@gmail.com', '8279735538', 'F', '1997-12-04', 'jpg'),
('jasneet', 'jasneet123', 'student', 'Mr.', 'jazzy', 'jasneetdua96@gmail.com', '9997563959', 'M', '0000-00-00', 'jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `faq`
--
ALTER TABLE `faq`
 ADD PRIMARY KEY (`sno`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`uname`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
