-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 07, 2020 at 11:56 PM
-- Server version: 5.7.23-23
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `betpoolt_adminpage`
--

-- --------------------------------------------------------

--
-- Table structure for table `app_user`
--

CREATE TABLE `app_user` (
  `id` int(10) UNSIGNED NOT NULL,
  `userAvatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instance_id` int(11) DEFAULT NULL,
  `role` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `isOwner` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `app_user`
--

INSERT INTO `app_user` (`id`, `userAvatar`, `name`, `email`, `password`, `instance_id`, `role`, `isOwner`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'https://betpool.tech/adminserver/file_storage/1601883917612223.970.jpg', 'testuser', 'asflkad@begrfdas.com', 'qewr', 1, 'admin', 1, 1, NULL, '2020-10-03 13:18:42', '2020-10-05 15:25:03'),
(2, NULL, 'super', 'super@admin.com', 'e10adc3949ba59abbe56e057f20f883e', 0, 'super administrator', 0, 1, NULL, '2020-10-03 22:05:13', '2020-10-03 22:05:13'),
(3, 'https://betpool.tech/adminserver/file_storage/1601883286f5.jpg', 'Oleg', 'info@germeda.de', '123456', 2, 'admin', 1, 1, NULL, '2020-10-05 20:34:46', '2020-10-05 20:51:52'),
(4, 'https://betpool.tech/adminserver/file_storage/1602059743Lea.png', 'Ann', 'ann@germeda.de', '123456', 2, 'Nutzer', 0, 1, NULL, '2020-10-07 21:35:43', '2020-10-07 21:35:43');

-- --------------------------------------------------------

--
-- Table structure for table `carefolders`
--

CREATE TABLE `carefolders` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `documents` longtext COLLATE utf8mb4_unicode_ci,
  `service` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instance_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carefolders`
--

INSERT INTO `carefolders` (`id`, `title`, `documents`, `service`, `instance_id`, `created_at`, `updated_at`) VALUES
(2, 'service1', '[2,3,4,5]', 'LK 19 Grundpflege', '0', '2020-10-05 11:35:13', '2020-10-07 08:01:32'),
(3, 'Deckblatt 2', '[6]', 'Medikamentengabe', '2', '2020-10-06 12:51:51', '2020-10-06 21:55:59');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumbnail` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quick` tinyint(4) DEFAULT '0',
  `limit_questions` int(11) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `paid` tinyint(4) DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(10) UNSIGNED NOT NULL,
  `orderId` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comment` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `instance_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contentHeight` int(11) DEFAULT NULL,
  `contentWidth` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `title`, `content`, `instance_id`, `contentHeight`, `contentWidth`, `created_at`, `updated_at`) VALUES
(2, 'Documentreload', '<p><span class=\'street\'>[street]</span></p><p>9. Document management (super admin)9.1.</p><p>9.4. Create new documentAdd document titleselect document type (Selection search field. If not available show add newfunction and save in the database)vailable for care folder (yes/no)Add sequence numberShow database id9.5. 9.6.Show editor to add, edit and design contentselect service (relation to service 5.1.1.5) for this document (Multiselectsearch field. If not available show add newfunction and save in the database)9.9. Create document flow, for e.g. the flow is: if user create and order for anpatient, than email notification id=x with a document id=x, should be send toreceiver1 (for e.g. selected pharmacy), add receiver 2 (for e.g. family doctor)and copy to user who created a order.10. Care folder function (instance)10.1.10.2. Care folder function is available in patient detail pageBy click on care folder a modal opens and all available documents (titles)should be shown with checkboxes function</p><p>in modal it should be possible to select services (5.1.1.5)by select a all service (5.1.1.5) related documents (titles) should checked inmodaluser can also activate or deactivate checkboxes for other documentsafter that user can click on “Generate Care Folder” and a PDF document withmultiple pages will be generated and downloaded (download time should befast)1</p><p><br></p><p>9. Document management (super admin)9.1.</p><p>9.4. Create new documentAdd document titleselect document type (Selection search field. If not available show add newfunction and save in the database)vailable for care folder (yes/no)Add sequence numberShow database id9.5. 9.6.Show editor to add, edit and design contentselect service (relation to service 5.1.1.5) for this document (Multiselectsearch field. If not available show add newfunction and save in the database)9.9. Create document flow, for e.g. the flow is: if user create and order for anpatient, than email notification id=x with a document id=x, should be send toreceiver1 (for e.g. selected pharmacy), add receiver 2 (for e.g. family doctor)and copy to user who created a order.10. Care folder function (instance)10.1.10.2. Care folder function is available in patient detail pageBy click on care folder a modal opens and all available documents (titles)should be shown with checkboxes function</p><p>in modal it should be possible to select services (5.1.1.5)by select a all service (5.1.1.5) related documents (titles) should checked inmodaluser can also activate or deactivate checkboxes for other documentsafter that user can click on “Generate Care Folder” and a PDF document withmultiple pages will be generated and downloaded (download time should befast)1</p><p>9. Document management (super admin)9.1.</p><p><br></p><p>9.4. Create new documentAdd document titleselect document type (Selection search field. If not available show add newfunction and save in the database)vailable for care folder (yes/no)Add sequence numberShow database id9.5. 9.6.Show editor to add, edit and design contentselect service (relation to service 5.1.1.5) for this document (Multiselectsearch field. If not available show add newfunction and save in the database)9.9. Create document flow, for e.g. the flow is: if user create and order for anpatient, than email notification id=x with a document id=x, should be send toreceiver1 (for e.g. selected pharmacy), add receiver 2 (for e.g. family doctor)and copy to user who created a order.10. Care folder function (instance)10.1.10.2. Care folder function is available in patient detail pageBy click on care folder a modal opens and all available documents (titles)should be shown with checkboxes function</p><p>in modal it should be possible to select services (5.1.1.5)by select a all service (5.1.1.5) related documents (titles) should checked inmodaluser can also activate or deactivate checkboxes for other documentsafter that user can click on “Generate Care Folder” and a PDF document withmultiple pages will be generated and downloaded (download time should befast)1</p><p><span class=\'zip\'>[zip]</span></p>', '1', 415, 800, '2020-10-05 11:34:29', '2020-10-06 07:51:32'),
(3, 'Document2', '<p>The contractor assures to develop the platform according to the latest knowledge standardsand stable and secure development methods. The data security is connected with very highpriority.The platform is to be extended for a very large number of users and data, which is to beimmediately secured with appropriate performance. This refers to the fast loading and</p><p>reaction times of the softwareThe contractor assures to create all technical prerequisites for future development in order to</p><p>avoid difficulties with the development of new functions in the future.The client intends a long-term cooperation and can employ the contractor for a long period of time. The contractor assures that he will be available to the project with support and</p><p>sufficient time for further development.The first stage of the project will be realized with an agreed budget, the payments will be</p><p>spread over several milestones. Further project stages can also be handled by freelancers.If a faulty development is found, the contractor is liable for the entire project value. Possiblesoftware errors should be corrected by the contractor immediately, even after  the development has been completed. For this purpose a support contract can be negotiated.The contractor is obliged to inform the customer about the status of the development and to ask questions immediately if different functions are unclear in order to maintain the correct development direction and to avoid errors in the future.</p>', '1', 418, 798, '2020-10-05 11:34:56', '2020-10-05 15:26:14'),
(4, 'asdfsadf', '<h3><span class=\"ql-size-small\">adfadsf <span class=\'name\'>[name]</span>, adfsadfadsf <span class=\'birthday\'>[birthday]</span></span></h3><p><span class=\"ql-size-small\">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</span></p><p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p><p><br></p><p><strong>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum.</strong> Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>', '1', 418, 798, '2020-10-05 15:38:57', '2020-10-05 17:37:48'),
(5, 'Soorprophylaxe', '<p>Für den Patienten<strong> <span class=\'name\'>[name]</span>, </strong>geboren am<strong> <span class=\'birthday\'>[birthday]</span></strong></p><p><br></p><p><strong>Soor und Parotitis</strong></p><p><br></p><p>Soor ist eine Pilzinfektion von Haut und Schleimhäuten. Sie tritt häufig dann auf, wenn das Immunsystem geschwächt ist, die Mundpflege nicht ausreicht und Antibiotika verabreicht wurden. Auch Flüssigkeitsmangel, der Verzicht auf Nahrung und Diabetes mellitus verursachen die Entzündung, die im Mund harmlos ist, im Verdauungstrakt oder in den Atemwegen erhebliche Beschwerden auslösen kann. Die Parotitis ist eine Entzündung der Ohrspeicheldrüse, die durch mangelnde Kautätigkeit und dadurch fehlenden Speichelfluss begünstigt wird. Die vor dem Ohr liegenden Drüse schwillt in diesem Fall an, was der Klient als sehr schmerzhaft empfindet.</p><p>&nbsp;</p><p>Wie lassen sich Soor und Parotitis verhindern?:</p><p><br></p><p><strong>Ausreichende Mundhygiene</strong></p><p>Es ist sinnvoll, die Mundhöhle regelmäßig auf typische weiße Beläge, wie sie Soor verursacht, zu untersuchen. Damit Soor erst gar nicht entsteht, müssen alte Speisereste sorgfältig entfernt werden. Mundspülungen mit Wasser oder Tee unterstützen die Mundhygiene. Generell gilt: Viel trinken.</p><p><br></p><p><strong>Anregung des Speichelflusses</strong></p><p>Kauen und Lutschen regen den Speichelfluss an. Gute Möglickeiten den Speichelfluss in Gang zu setzen, sind zuckerfreie Bonbons und Kaugummis, Eiswürfel oder gefrorene Früchte. Zusätzlich empfiehlt es sich, die Ohr – und Kieferspeicheldrüse zu massieren und Kaubewegungen durchzuführen. Mundspülungen mit Zitronensaft, Traubensaft oder sauren Tees wirken außerdem anregend.</p><p><br></p><p><strong>Belägen aktiv vorbeugen</strong></p><p>Eine wirksame Maßnahme gegen Soor ist es, die Mundhöhle mit geeigneten Lösungen auszuwischen und Mundspülungen zu intensivieren. Eine Borkenbildung können Sie durch Einfetten der Lippen und regelmäßige Pflege vermeiden. Besteht dennoch der Verdacht auf Soor, hilft ein vom Arzt verordnetes Antimykotikum.</p><p><br></p><p><br></p><p>Individuelles Aufklärungsprotokoll zur Soorprophylaxe&nbsp;</p><p><br></p><p>Name: 				_______________________</p><p>Geburtsdatum:	_______________________</p><p>Ort, Datum:			_______________________</p><p><br></p><p><br></p><p>__________________________				__________________________</p><p>Unterschrift Pflegefachkraft							Unterschrift Patient / ges. Betreuer</p>', '1', 416, 815, '2020-10-05 16:02:11', '2020-10-05 17:09:59'),
(6, 'Deckblatt', '<p><br></p><p><span class=\"ql-size-large\">Pflegemappe von <span class=\'name\'>[name]</span></span></p><p><span class=\'birthday\'>[birthday]</span></p><p><br></p><p><span class=\'street\'>[street]</span></p><p><span class=\'zip\'>[zip]</span> <span class=\'city\'>city]</span></p><p><br></p><p><span class=\'phone\'>[phone]</span></p><p><br></p><p><br></p><p>GERMEDA GmbH</p><p>Ambulante Pflege und Betreuung</p><p>Jürgensplatz 60, 40219 Düsseldorf</p><p><br></p><p>Telefon: 0211 959 858 00</p><p>Bürozeiten: 08:00 - 16:00 Uhr</p><p>Rufbereitschaft: 24 Stunden</p><p><br></p><p>Notfallnummer</p><p>Feuerwehr, Rettungsdienst, Notarzt: 112</p><p>Ärztlicher Notdienst: 116117</p><p>Polizei: 110</p><p><br></p><p>Ihre Ziele und Bedürfnisse sind für uns handlungsweisend, um Ihre Eigenständigkeit und damit die Lebensqualität in Ihrem gewohnten Umfeld zu erhalten und zu fördern. </p><ul><li>Nur fachlich ausgebildetes und qualifiziertes Stammpersonal</li><li>Kontinuität bei Ihrem Betreuerteam (Bezugspflege)</li><li>Individuelle Einsatzzeiten, angepasst an Ihre Bedürfnisse</li><li>Enge Zusammenarbeit mit Ärzten, Krankenhäusern, Therapeuten etc.</li></ul>', '2', 416, 815, '2020-10-05 20:59:31', '2020-10-05 20:59:31'),
(7, 'document1', '<p><span class=\'street\'>[street]</span></p><p>9. Document management (super admin)9.1.</p><p>9.4. Create new documentAdd document titleselect document type (Selection search field. If not available show <span style=\"color: rgb(230, 0, 0);\">add newfunction and save in the database)vailable for care folder (yes/no)Add sequence numberShow database id9.5. 9.6.Show editor to add, edit and design contentselect service (relation to service 5.1.1.5) for this document (Multiselectsearch field. If not available show add newfunction and save in the database)9.9. Create document </span>flow, for e.g. the flow is: if user create and order for anpatient, than email notification id=x with a document id=x, should be send toreceiver1 (for e.g. selected pharmacy), add receiver 2 (for e.g. family doctor)and copy to user who created a order.10. Care folder function (instance)10.1.10.2. Care folder function is available in patient detail pageBy click on care folder a modal opens and all available documents (titles)should be shown with checkboxes function</p><p>in modal it should be possible to select services (5.1.1.5)by select a all service (5.1.1.5) related documents (titles) should checked inmodaluser can also activate or deactivate checkboxes for other documentsafter that user can click on “Generate Care Folder” and a PDF document withmultiple pages will be generated and downloaded (download time should befast)1</p><p><br></p><p>9. Document management (super admin)9.1.</p><p>9.4. Create new documentAdd document titleselect document type (Selection search field. If not available show add newfunction and save in the database)vailable for care folder (yes/no)Add sequence numberShow database id9.5. 9.6.Show editor to add, edit and design contentselect service (relation to service 5.1.1.5) for this document (Multiselectsearch field. If not available show add newfunction and save in the database)9.9. Create document flow, for e.g. the flow is: if user create and order for anpatient, than email notification id=x with a document id=x, should be send toreceiver1 (for e.g. selected pharmacy), add receiver 2 (for e.g. family doctor)and copy to user who created a order.10. Care folder function (instance)10.1.10.2. Care folder function is available in patient detail pageBy click on care folder a modal opens and all available documents (titles)should be shown with checkboxes function</p><p>in modal it should be possible to select services (5.1.1.5)by select a all service (5.1.1.5) related documents (titles) should checked inmodaluser can also activate or deactivate checkboxes for other documentsafter that user can click on “Generate Care Folder” and a PDF document withmultiple pages will be generated and downloaded (download time should befast)1</p><p>9. Document management (super admin)9.1.</p><p><br></p><p>9.4. Create new documentAdd document titleselect document type (Selection search field. If not available show add newfunction and save in the database)vailable for care folder (yes/no)Add sequence numberShow database id9.5. 9.6.Show editor to add, edit and design contentselect service (relation to service 5.1.1.5) for this document (Multiselectsearch field. If not available show add newfunction and save in the database)9.9. Create document flow, for e.g. the flow is: if user create and order for anpatient, than email notification id=x with a document id=x, should be send toreceiver1 (for e.g. selected pharmacy), add receiver 2 (for e.g. family doctor)and copy to user who created a order.10. Care folder function (instance)10.1.10.2. Care folder function is available in patient detail pageBy click on care folder a modal opens and all available documents (titles)should be shown with checkboxes function</p><p>in modal it should be possible to select services (5.1.1.5)by select a all service (5.1.1.5) related documents (titles) should checked inmodaluser can also activate or deactivate checkboxes for other documentsafter that user can click on “Generate Care Folder” and a PDF document withmultiple pages will be generated and downloaded (download time should befast)1</p><p><span class=\'zip\'>[zip]</span></p>', '1', 415, 800, '2020-10-06 07:52:16', '2020-10-06 07:52:16');

-- --------------------------------------------------------

--
-- Table structure for table `emailtemplates`
--

CREATE TABLE `emailtemplates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `instance_id` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `emailtemplates`
--

INSERT INTO `emailtemplates` (`id`, `title`, `body`, `type`, `instance_id`, `created_at`, `updated_at`) VALUES
(1, 'qwerqwer', '<p>qwerqwerqwer[Birthday Date]qwerqwer</p><p><br></p><p>sdfasdfasdf sdfasdfasdf asd</p>', 'Every year on birthdays', '2', '2020-10-03 06:31:41', '2020-10-06 18:01:14'),
(2, 'test test', '<p>werqwerqwerew[patient insurance]</p><p>[patient address]qwerqwer</p><p>asd</p><p><br></p><p><br></p><p>dsaf asdfas</p>', 'Every year on birthdays', '2', '2020-10-03 06:31:57', '2020-10-06 21:02:05'),
(3, 'Herzlichen Glückwunsch', '<p><span class=\'name\'>[Name]</span> hat heute Geburtstag, bitte nicht vergessen zu gratulieren.</p><p><br></p><p><span class=\'birthday\'>[Birthday Date]</span></p><p><span class=\'address\'>[Address]</span></p><p><span class=\'phone\'>[Phone]</span></p>', 'Every year on birthdays', '0', '2020-10-03 22:16:19', '2020-10-03 22:16:19'),
(4, 'Neue Bestellung', '<p><strong class=\"ql-size-large\">Medikamentenbestellung</strong></p><p><br></p><p>Es wurde eine neue Bestellung für <strong>[patient firstname] [patient lastname]</strong> erzeugt.</p><p><br></p><p>Patient ist versichert bei: [patient insurance]</p><p>Geboren am: [patient birthday]</p><p>Adresse: [patient address]</p><p>Telefon: [patient phone]</p><p><br></p><p>Ihr Service von GRM</p>', 'User create an Order', '2', '2020-10-03 22:19:53', '2020-10-06 12:59:40'),
(5, 'test', '<p>test</p><p><br></p><p>dsf</p>', 'Every year on birthdays', '2', '2020-10-06 18:01:43', '2020-10-06 18:01:59'),
(6, 'Neue Bestellung - [order_id]', '<p>Eine neue Bestellung für [patient firstname] [patient lastname]</p><p>Hier können Sie die Bestellung einsehen: [order_public_link]</p><p>Bitte die Bestellung bis zum [order_duedate] bearbeiten.</p><p><br></p><p>Ihr Service von GERMEDA</p>', 'User create an Order', '2', '2020-10-07 20:55:04', '2020-10-07 21:08:48');

-- --------------------------------------------------------

--
-- Table structure for table `family_doctors`
--

CREATE TABLE `family_doctors` (
  `id` int(10) UNSIGNED NOT NULL,
  `practiceName` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `doctorName` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `streetNr` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zipcode` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fax` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notifications` tinyint(1) NOT NULL DEFAULT '0',
  `instance_id` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `family_doctors`
--

INSERT INTO `family_doctors` (`id`, `practiceName`, `doctorName`, `streetNr`, `zipcode`, `city`, `phone`, `fax`, `email`, `password`, `notifications`, `instance_id`, `created_at`, `updated_at`) VALUES
(1, 'Praxis Dr. Marina Becker', 'Dr. Marina Becker', 'Volksgartenstraße 1', '40227', 'Düsseldorf', '0211 726464', '0211 7213111', 'vladimir.bognar.1979@gmail.com', '123456', 1, 0, '2020-10-03 10:42:58', '2020-10-03 10:42:58'),
(2, 'Praxis Dr. Meier', 'Dr. Meier', 'Berger Str. 10', '40211', 'Düsseldorf', '0211949492', '021149492', 'meier@germeda.de', '123456', 0, 2, '2020-10-06 18:04:48', '2020-10-06 18:04:48');

-- --------------------------------------------------------

--
-- Table structure for table `ingredients`
--

CREATE TABLE `ingredients` (
  `id` int(10) UNSIGNED NOT NULL,
  `ingredients` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ingredients`
--

INSERT INTO `ingredients` (`id`, `ingredients`, `created_at`, `updated_at`) VALUES
(1, 'Insulin glargin', '2020-10-03 10:41:21', '2020-10-03 10:41:21'),
(2, 'Alfacalcidol', '2020-10-05 20:04:14', '2020-10-05 20:04:14'),
(3, 'Amlodipin besilat', '2020-10-05 20:04:24', '2020-10-05 20:04:24');

-- --------------------------------------------------------

--
-- Table structure for table `instances`
--

CREATE TABLE `instances` (
  `id` int(10) UNSIGNED NOT NULL,
  `instanceLogo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instanceName` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `instances`
--

INSERT INTO `instances` (`id`, `instanceLogo`, `instanceName`, `created_at`, `updated_at`) VALUES
(1, 'https://betpool.tech/adminserver/file_storage/1601883917612223.970.jpg', 'IBM', '2020-10-03 13:18:42', '2020-10-05 20:45:17'),
(2, 'https://betpool.tech/adminserver/file_storage/1601884420germeda-logo.png', 'GRM', '2020-10-05 20:34:46', '2020-10-05 20:53:40');

-- --------------------------------------------------------

--
-- Table structure for table `insurances`
--

CREATE TABLE `insurances` (
  `id` int(10) UNSIGNED NOT NULL,
  `insurances` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `insurances`
--

INSERT INTO `insurances` (`id`, `insurances`, `created_at`, `updated_at`) VALUES
(2, 'AOK', '2020-10-05 20:02:28', '2020-10-05 20:02:28'),
(3, 'DAK', '2020-10-05 20:02:34', '2020-10-05 20:02:34');

-- --------------------------------------------------------

--
-- Table structure for table `medications`
--

CREATE TABLE `medications` (
  `id` int(10) UNSIGNED NOT NULL,
  `medicationName` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ingredients` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `packaging` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `orders` int(11) DEFAULT NULL,
  `patients` int(11) DEFAULT NULL,
  `instance_id` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `medications`
--

INSERT INTO `medications` (`id`, `medicationName`, `ingredients`, `packaging`, `orders`, `patients`, `instance_id`, `created_at`, `updated_at`) VALUES
(1, 'ACTRAPID FlexPen 100 I.E./ml Inj.-Lsg.i.Fertigpen', 'Insulin glargin', 'n.A.', NULL, NULL, 0, '2020-10-03 10:44:06', '2020-10-05 20:09:33'),
(2, 'ALFACALCIDOL Aristo 0,25 Mikrogramm Weichkapseln', 'Alfacalcidol', '100 Kapseln', NULL, NULL, 0, '2020-10-05 20:10:16', '2020-10-05 20:10:16'),
(3, 'med 122', 'Insulin glargin', '100 St.', NULL, NULL, 2, '2020-10-07 08:28:41', '2020-10-07 08:28:41'),
(4, 'med 108', 'Alfacalcidol', '50 St.', NULL, NULL, 2, '2020-10-07 08:28:54', '2020-10-07 08:28:54');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `delivered` enum('YES','NO') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NO',
  `date_string` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `send_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `receivers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `title`, `body`, `delivered`, `date_string`, `send_date`, `receivers`, `created_at`, `updated_at`) VALUES
(1, 'qwerqwerqwerwer', '<p>werqwerqwerew<span class=\'insurance\'>[patient insurance]</span></p><p><span class=\'address\'>[patient address]</span>qwerqwer</p>', 'YES', NULL, '2020-10-03 12:38:54', '[\"gumeni79@gmail.com\",\"Maxsim474747@yandex.com\"]', '2020-10-03 12:38:54', '2020-10-03 12:38:54'),
(2, 'qwerqwerqwerwer', '<p>werqwerqwerew<span class=\'insurance\'>[patient insurance]</span></p><p><span class=\'address\'>[patient address]</span>qwerqwer</p>', 'YES', NULL, '2020-10-03 12:39:19', '[\"gumeni79@gmail.com\",\"Maxsim474747@yandex.com\"]', '2020-10-03 12:39:19', '2020-10-03 12:39:19'),
(3, 'qwerqwerqwerwer', '<p>werqwerqwerew<span class=\'insurance\'>[patient insurance]</span></p><p><span class=\'address\'>[patient address]</span>qwerqwer</p>', 'YES', NULL, '2020-10-03 12:39:48', '[\"gumeni79@gmail.com\",\"Maxsim474747@yandex.com\"]', '2020-10-03 12:39:48', '2020-10-03 12:39:48'),
(4, 'qwerqwerqwerwer', '<p>werqwerqwerew<span class=\'insurance\'>[patient insurance]</span></p><p><span class=\'address\'>[patient address]</span>qwerqwer</p>', 'YES', NULL, '2020-10-03 12:40:49', '[\"gumeni79@gmail.com\",\"Maxsim474747@yandex.com\"]', '2020-10-03 12:40:49', '2020-10-03 12:40:49'),
(5, 'qwerqwerqwerwer', '<p>werqwerqwerew<span class=\'insurance\'>[patient insurance]</span></p><p><span class=\'address\'>[patient address]</span>qwerqwer</p>', 'YES', NULL, '2020-10-03 12:43:56', '[\"gumeni79@gmail.com\",\"Maxsim474747@yandex.com\"]', '2020-10-03 12:43:56', '2020-10-03 12:43:56'),
(6, 'qwerqwerqwerwer', '<p>werqwerqwerew<span class=\'insurance\'>[patient insurance]</span></p><p><span class=\'address\'>[patient address]</span>qwerqwer</p>', 'YES', NULL, '2020-10-03 12:44:13', '[\"gumeni79@gmail.com\",\"Maxsim474747@yandex.com\"]', '2020-10-03 12:44:13', '2020-10-03 12:44:13'),
(7, 'qwerqwerqwerwer', '<p>werqwerqwerew<span class=\'insurance\'>[patient insurance]</span></p><p><span class=\'address\'>[patient address]</span>qwerqwer</p>', 'YES', NULL, '2020-10-03 12:45:26', '[\"gumeni79@gmail.com\",\"Maxsim474747@yandex.com\"]', '2020-10-03 12:45:26', '2020-10-03 12:45:26'),
(8, 'qwerqwerqwerwer', '<p>werqwerqwerew<span class=\'insurance\'>[patient insurance]</span></p><p><span class=\'address\'>[patient address]</span>qwerqwer</p>', 'YES', NULL, '2020-10-03 12:45:37', '[\"gumeni79@gmail.com\",\"Maxsim474747@yandex.com\"]', '2020-10-03 12:45:37', '2020-10-03 12:45:37'),
(9, 'qwerqwerqwerwer', '<p>werqwerqwerew<span class=\'insurance\'>[patient insurance]</span></p><p><span class=\'address\'>[patient address]</span>qwerqwer</p>', 'YES', NULL, '2020-10-03 12:46:08', '[\"gumeni79@gmail.com\",\"Maxsim474747@yandex.com\"]', '2020-10-03 12:46:08', '2020-10-03 12:46:08'),
(10, 'qwerqwerqwerwer', '<p>werqwerqwerew<span class=\'insurance\'>[patient insurance]</span></p><p><span class=\'address\'>[patient address]</span>qwerqwer</p>', 'YES', NULL, '2020-10-03 12:53:01', '[\"gumeni79@gmail.com\",\"Maxsim474747@yandex.com\"]', '2020-10-03 12:53:01', '2020-10-03 12:53:01'),
(11, 'qwerqwerqwerwer', '<p>werqwerqwerew<span class=\'insurance\'>[patient insurance]</span></p><p><span class=\'address\'>[patient address]</span>qwerqwer</p>', 'YES', NULL, '2020-10-03 12:56:19', '[\"gumeni79@gmail.com\",\"Maxsim474747@yandex.com\"]', '2020-10-03 12:56:19', '2020-10-03 12:56:19'),
(12, 'qwerqwerqwerwer', '<p>werqwerqwerew<span class=\'insurance\'>[patient insurance]</span></p><p><span class=\'address\'>[patient address]</span>qwerqwer</p>', 'YES', NULL, '2020-10-03 12:57:29', '[\"gumeni79@gmail.com\",\"Maxsim474747@yandex.com\"]', '2020-10-03 12:57:29', '2020-10-03 12:57:29'),
(13, 'qwerqwerqwerwer', '<p>werqwerqwerew<span class=\'insurance\'>[patient insurance]</span></p><p><span class=\'address\'>[patient address]</span>qwerqwer</p>', 'YES', NULL, '2020-10-03 12:58:17', '[\"gumeni79@gmail.com\",\"Maxsim474747@yandex.com\"]', '2020-10-03 12:58:17', '2020-10-03 12:58:17'),
(14, 'qwerqwerqwerwer', '<p>werqwerqwerew<span class=\'insurance\'>[patient insurance]</span></p><p><span class=\'address\'>[patient address]</span>qwerqwer</p>', 'YES', NULL, '2020-10-03 13:00:09', '[\"gumeni79@gmail.com\",\"Maxsim474747@yandex.com\"]', '2020-10-03 13:00:09', '2020-10-03 13:00:09'),
(15, 'qwerqwerqwerwer', '<p>werqwerqwerew<span class=\'insurance\'>[patient insurance]</span></p><p><span class=\'address\'>[patient address]</span>qwerqwer</p>', 'YES', NULL, '2020-10-03 13:05:08', '[\"gumeni79@gmail.com\",\"Maxsim474747@yandex.com\"]', '2020-10-03 13:05:08', '2020-10-03 13:05:08'),
(16, 'qwerqwerqwerwer', '<p>werqwerqwerew<span class=\'insurance\'>[patient insurance]</span></p><p><span class=\'address\'>[patient address]</span>qwerqwer</p>', 'YES', NULL, '2020-10-03 13:05:28', '[\"gumeni79@gmail.com\",\"Maxsim474747@yandex.com\"]', '2020-10-03 13:05:28', '2020-10-03 13:05:28'),
(17, 'qwerqwerqwerwer', '<p>werqwerqwerew<span class=\'insurance\'>[patient insurance]</span></p><p><span class=\'address\'>[patient address]</span>qwerqwer</p>', 'YES', NULL, '2020-10-03 13:07:40', '[\"gumeni79@gmail.com\",\"Maxsim474747@yandex.com\"]', '2020-10-03 13:07:40', '2020-10-03 13:07:40'),
(18, 'qwerqwerqwerwer', '<p>werqwerqwerew<span class=\'insurance\'>[patient insurance]</span></p><p><span class=\'address\'>[patient address]</span>qwerqwer</p>', 'YES', NULL, '2020-10-03 13:08:06', '[\"gumeni79@gmail.com\",\"Maxsim474747@yandex.com\"]', '2020-10-03 13:08:06', '2020-10-03 13:08:06'),
(19, 'qwerqwerqwerwer', '<p>werqwerqwerew<span class=\'insurance\'>[patient insurance]</span></p><p><span class=\'address\'>[patient address]</span>qwerqwer</p>', 'YES', NULL, '2020-10-03 13:08:32', '[\"gumeni79@gmail.com\",\"Maxsim474747@yandex.com\"]', '2020-10-03 13:08:32', '2020-10-03 13:08:32'),
(20, 'qwerqwerqwerwer', '<p>werqwerqwerew<span class=\'insurance\'>[patient insurance]</span></p><p><span class=\'address\'>[patient address]</span>qwerqwer</p>', 'YES', NULL, '2020-10-03 13:08:53', '[\"gumeni79@gmail.com\",\"Maxsim474747@yandex.com\"]', '2020-10-03 13:08:53', '2020-10-03 13:08:53'),
(21, 'qwerqwerqwerwer', '<p>werqwerqwerew<span class=\'insurance\'>[patient insurance]</span></p><p><span class=\'address\'>[patient address]</span>qwerqwer</p>', 'YES', NULL, '2020-10-03 13:10:20', '[\"gumeni79@gmail.com\",\"Maxsim474747@yandex.com\"]', '2020-10-03 13:10:20', '2020-10-03 13:10:20'),
(22, 'qwerqwerqwerwer', '<p>werqwerqwerew<span class=\'insurance\'>[patient insurance]</span></p><p><span class=\'address\'>[patient address]</span>qwerqwer</p>', 'YES', NULL, '2020-10-03 13:10:29', '[\"gumeni79@gmail.com\",\"Maxsim474747@yandex.com\"]', '2020-10-03 13:10:29', '2020-10-03 13:10:29'),
(23, 'qwerqwerqwerwer', '<p>werqwerqwerew<span class=\'insurance\'>[patient insurance]</span></p><p><span class=\'address\'>[patient address]</span>qwerqwer</p>', 'YES', NULL, '2020-10-03 13:26:49', '[\"gumeni79@gmail.com\",\"Maxsim474747@yandex.com\"]', '2020-10-03 13:26:49', '2020-10-03 13:26:49'),
(24, 'qwerqwerqwerwer', '<p>werqwerqwerew<span class=\'insurance\'>[patient insurance]</span></p><p><span class=\'address\'>[patient address]</span>qwerqwer</p>', 'YES', NULL, '2020-10-03 13:30:52', '[\"gumeni79@gmail.com\",\"Maxsim474747@yandex.com\"]', '2020-10-03 13:30:52', '2020-10-03 13:30:52'),
(25, 'qwerqwerqwerwer', '<p>werqwerqwerew<span class=\'insurance\'>[patient insurance]</span></p><p><span class=\'address\'>[patient address]</span>qwerqwer</p>', 'YES', NULL, '2020-10-03 13:36:06', '[\"gumeni79@gmail.com\",\"Maxsim474747@yandex.com\"]', '2020-10-03 13:36:06', '2020-10-03 13:36:06'),
(26, 'qwerqwerqwerwer', '<p>werqwerqwerew<span class=\'insurance\'>[patient insurance]</span></p><p><span class=\'address\'>[patient address]</span>qwerqwer</p>', 'YES', NULL, '2020-10-03 13:47:21', '[\"gumeni79@gmail.com\",\"Maxsim474747@yandex.com\"]', '2020-10-03 13:47:21', '2020-10-03 13:47:21'),
(27, 'qwerqwerqwerwer', '<p>werqwerqwerew<span class=\'insurance\'>[patient insurance]</span></p><p><span class=\'address\'>[patient address]</span>qwerqwer</p>', 'YES', NULL, '2020-10-03 13:53:50', '[\"gumeni79@gmail.com\",\"Maxsim474747@yandex.com\"]', '2020-10-03 13:53:50', '2020-10-03 13:53:50'),
(28, 'qwerqwerqwerwer', '<p>werqwerqwerew<span class=\'insurance\'>[patient insurance]</span></p><p><span class=\'address\'>[patient address]</span>qwerqwer</p>', 'YES', NULL, '2020-10-03 13:54:48', '[\"gumeni79@gmail.com\",\"Maxsim474747@yandex.com\"]', '2020-10-03 13:54:48', '2020-10-03 13:54:48'),
(29, 'qwerqwerqwerwer', '<p>werqwerqwerew<span class=\'insurance\'>[patient insurance]</span></p><p><span class=\'address\'>[patient address]</span>qwerqwer</p>', 'YES', NULL, '2020-10-03 13:56:19', '[\"gumeni79@gmail.com\",\"Maxsim474747@yandex.com\"]', '2020-10-03 13:56:19', '2020-10-03 13:56:19'),
(30, 'qwerqwerqwerwer', '<p>werqwerqwerew<span class=\'insurance\'>[patient insurance]</span></p><p><span class=\'address\'>[patient address]</span>qwerqwer</p>', 'YES', NULL, '2020-10-03 13:57:21', '[\"gumeni79@gmail.com\",\"Maxsim474747@yandex.com\"]', '2020-10-03 13:57:21', '2020-10-03 13:57:21'),
(31, 'qwerqwerqwerwer', '<p>werqwerqwerew<span class=\'insurance\'>[patient insurance]</span></p><p><span class=\'address\'>[patient address]</span>qwerqwer</p>', 'YES', NULL, '2020-10-03 22:06:09', '[\"gumeni79@gmail.com\",\"Maxsim474747@yandex.com\"]', '2020-10-03 22:06:09', '2020-10-03 22:06:09'),
(32, 'Neue Bestellung', '<p>Es wurde eine neue Bestellung für <strong><span class=\'firstname\'>[patient firstname]</span> <span class=\'lastname\'>[patient lastname]</span></strong> erzeugt.</p><p><br></p><p>Patient ist versichert bei: <span class=\'insurance\'>[patient insurance]</span></p><p>Geboren am: <span class=\'birthday\'>[patient birthday]</span></p><p>Adresse: <span class=\'address\'>[patient address]</span></p><p>Telefon: <span class=\'phone\'>[patient phone]</span></p><p><br></p><p>Ihr Service von <strong>base</strong></p>', 'YES', NULL, '2020-10-03 22:22:23', '[\"vladimir.bognar.1979@gmail.com\",\"germedagmbh@gmail.com\",\"stratector@gmail.com\"]', '2020-10-03 22:22:23', '2020-10-03 22:22:23'),
(33, 'Neue Bestellung', '<p>Es wurde eine neue Bestellung für <strong><span class=\'firstname\'>werq</span> <span class=\'lastname\'>werqwe</span></strong> erzeugt.</p><p><br></p><p>Patient ist versichert bei: <span class=\'insurance\'>reqwr</span></p><p>Geboren am: <span class=\'birthday\'>2020-10-03</span></p><p>Adresse: <span class=\'address\'>324234</span></p><p>Telefon: <span class=\'phone\'>341234</span></p><p><br></p><p>Ihr Service von <strong>base</strong></p>', 'YES', NULL, '2020-10-03 22:41:59', '[\"vladimir.bognar.1979@gmail.com\",\"germedagmbh@gmail.com\",\"stratector@gmail.com\"]', '2020-10-03 22:41:59', '2020-10-03 22:41:59'),
(34, 'Neue Bestellung', '<p>Es wurde eine neue Bestellung für <strong><span class=\'firstname\'>werq</span> <span class=\'lastname\'>werqwe</span></strong> erzeugt.</p><p><br></p><p>Patient ist versichert bei: <span class=\'insurance\'>reqwr</span></p><p>Geboren am: <span class=\'birthday\'>2020-10-03</span></p><p>Adresse: <span class=\'address\'>Hansastr 35</span></p><p>Telefon: <span class=\'phone\'>341234</span></p><p><br></p><p>Ihr Service von <strong>base</strong></p>', 'YES', NULL, '2020-10-03 23:36:56', '[\"vladimir.bognar.1979@gmail.com\",\"germedagmbh@gmail.com\",\"stratector@gmail.com\"]', '2020-10-03 23:36:56', '2020-10-03 23:36:56'),
(35, 'info test', '<p>hier ist ein Info Test</p>', 'YES', NULL, '2020-10-04 09:10:33', '[\"2\"]', '2020-10-04 09:10:33', '2020-10-04 09:10:33'),
(36, 'Herzlichen Glückwunsch', '<p><span class=\'name\'>werq werqwe</span> hat heute Geburtstag, bitte nicht vergessen zu gratulieren.</p><p><br></p><p><span class=\'birthday\'>2016-10-04</span></p><p><span class=\'address\'>Hansastr 35</span></p><p><span class=\'phone\'>341234</span></p>', 'YES', NULL, '2020-10-04 16:14:06', '[\"vladimir.bognar.1979@gmail.com\",\"Maxsim474747@yandex.com\",\"stratector@gmail.com\"]', '2020-10-04 16:14:06', '2020-10-04 16:14:06'),
(37, 'Neue Bestellung', '<p>Es wurde eine neue Bestellung für <strong><span class=\'firstname\'>werq</span> <span class=\'lastname\'>werqwe</span></strong> erzeugt.</p><p><br></p><p>Patient ist versichert bei: <span class=\'insurance\'>reqwr</span></p><p>Geboren am: <span class=\'birthday\'>2016-10-04</span></p><p>Adresse: <span class=\'address\'>Hansastr 35</span></p><p>Telefon: <span class=\'phone\'>341234</span></p><p><br></p><p>Ihr Service von <strong>base</strong></p>', 'YES', NULL, '2020-10-04 16:39:26', '[\"vladimir.bognar.1979@gmail.com\",\"Maxsim474747@yandex.com\",\"stratector@gmail.com\"]', '2020-10-04 16:39:26', '2020-10-04 16:39:26'),
(38, 'Herzlichen Glückwunsch', '<p><span class=\'name\'>werq werqwe</span> hat heute Geburtstag, bitte nicht vergessen zu gratulieren.</p><p><br></p><p><span class=\'birthday\'>2016-10-04</span></p><p><span class=\'address\'>Hansastr 35</span></p><p><span class=\'phone\'>341234</span></p>', 'YES', NULL, '2020-10-04 16:46:12', '[\"vladimir.bognar.1979@gmail.com\",\"Maxsim474747@yandex.com\",\"stratector@gmail.com\"]', '2020-10-04 16:46:12', '2020-10-04 16:46:12'),
(39, 'Herzlichen Glückwunsch', '<p><span class=\'name\'>werq werqwe</span> hat heute Geburtstag, bitte nicht vergessen zu gratulieren.</p><p><br></p><p><span class=\'birthday\'>2016-10-04</span></p><p><span class=\'address\'>Hansastr 35</span></p><p><span class=\'phone\'>341234</span></p>', 'YES', NULL, '2020-10-04 16:48:03', '[\"vladimir.bognar.1979@gmail.com\",\"Maxsim474747@yandex.com\",\"stratector@gmail.com\"]', '2020-10-04 16:48:03', '2020-10-04 16:48:03'),
(40, 'Herzlichen Glückwunsch', '<p><span class=\'name\'>werq werqwe</span> hat heute Geburtstag, bitte nicht vergessen zu gratulieren.</p><p><br></p><p><span class=\'birthday\'>2016-10-04</span></p><p><span class=\'address\'>Hansastr 35</span></p><p><span class=\'phone\'>341234</span></p>', 'YES', NULL, '2020-10-04 16:49:03', '[\"vladimir.bognar.1979@gmail.com\",\"Maxsim474747@yandex.com\",\"stratector@gmail.com\"]', '2020-10-04 16:49:03', '2020-10-04 16:49:03'),
(41, 'Herzlichen Glückwunsch', '<p><span class=\'name\'>werq werqwe</span> hat heute Geburtstag, bitte nicht vergessen zu gratulieren.</p><p><br></p><p><span class=\'birthday\'>2016-10-04</span></p><p><span class=\'address\'>Hansastr 35</span></p><p><span class=\'phone\'>341234</span></p>', 'YES', NULL, '2020-10-04 16:50:03', '[\"vladimir.bognar.1979@gmail.com\",\"Maxsim474747@yandex.com\",\"stratector@gmail.com\"]', '2020-10-04 16:50:03', '2020-10-04 16:50:03'),
(42, 'Herzlichen Glückwunsch', '<p><span class=\'name\'>werq werqwe</span> hat heute Geburtstag, bitte nicht vergessen zu gratulieren.</p><p><br></p><p><span class=\'birthday\'>2016-10-04</span></p><p><span class=\'address\'>Hansastr 35</span></p><p><span class=\'phone\'>341234</span></p>', 'YES', NULL, '2020-10-04 16:51:04', '[\"vladimir.bognar.1979@gmail.com\",\"germedagmbh@gmail.com\",\"stratector@gmail.com\"]', '2020-10-04 16:51:04', '2020-10-04 16:51:04'),
(43, 'Herzlichen Glückwunsch', '<p><span class=\'name\'>werq werqwe</span> hat heute Geburtstag, bitte nicht vergessen zu gratulieren.</p><p><br></p><p><span class=\'birthday\'>2016-10-04</span></p><p><span class=\'address\'>Hansastr 35</span></p><p><span class=\'phone\'>341234</span></p>', 'YES', NULL, '2020-10-04 16:52:03', '[\"vladimir.bognar.1979@gmail.com\",\"germedagmbh@gmail.com\",\"stratector@gmail.com\"]', '2020-10-04 16:52:03', '2020-10-04 16:52:03'),
(44, 'Herzlichen Glückwunsch', '<p><span class=\'name\'>werq werqwe</span> hat heute Geburtstag, bitte nicht vergessen zu gratulieren.</p><p><br></p><p><span class=\'birthday\'>2016-10-04</span></p><p><span class=\'address\'>Hansastr 35</span></p><p><span class=\'phone\'>341234</span></p>', 'YES', NULL, '2020-10-04 17:22:04', '[\"vladimir.bognar.1979@gmail.com\",\"germedagmbh@gmail.com\",\"stratector@gmail.com\"]', '2020-10-04 17:22:04', '2020-10-04 17:22:04'),
(45, 'Herzlichen Glückwunsch', '<p><span class=\'name\'>werq werqwe</span> hat heute Geburtstag, bitte nicht vergessen zu gratulieren.</p><p><br></p><p><span class=\'birthday\'>2016-10-04</span></p><p><span class=\'address\'>Hansastr 35</span></p><p><span class=\'phone\'>341234</span></p>', 'YES', NULL, '2020-10-04 17:23:03', '[\"vladimir.bognar.1979@gmail.com\",\"germedagmbh@gmail.com\",\"stratector@gmail.com\"]', '2020-10-04 17:23:03', '2020-10-04 17:23:03'),
(46, 'Herzlichen Glückwunsch', '<p><span class=\'name\'>werq werqwe</span> hat heute Geburtstag, bitte nicht vergessen zu gratulieren.</p><p><br></p><p><span class=\'birthday\'>2016-10-04</span></p><p><span class=\'address\'>Hansastr 35</span></p><p><span class=\'phone\'>341234</span></p>', 'YES', NULL, '2020-10-04 17:24:03', '[\"vladimir.bognar.1979@gmail.com\",\"germedagmbh@gmail.com\",\"stratector@gmail.com\"]', '2020-10-04 17:24:03', '2020-10-04 17:24:03'),
(47, 'Herzlichen Glückwunsch', '<p><span class=\'name\'>werq werqwe</span> hat heute Geburtstag, bitte nicht vergessen zu gratulieren.</p><p><br></p><p><span class=\'birthday\'>2016-10-04</span></p><p><span class=\'address\'>Hansastr 35</span></p><p><span class=\'phone\'>341234</span></p>', 'YES', NULL, '2020-10-04 17:25:02', '[\"vladimir.bognar.1979@gmail.com\",\"germedagmbh@gmail.com\",\"stratector@gmail.com\"]', '2020-10-04 17:25:02', '2020-10-04 17:25:02'),
(48, 'Herzlichen Glückwunsch', '<p><span class=\'name\'>werq werqwe</span> hat heute Geburtstag, bitte nicht vergessen zu gratulieren.</p><p><br></p><p><span class=\'birthday\'>2016-10-04</span></p><p><span class=\'address\'>Hansastr 35</span></p><p><span class=\'phone\'>341234</span></p>', 'YES', NULL, '2020-10-04 17:26:02', '[\"vladimir.bognar.1979@gmail.com\",\"germedagmbh@gmail.com\",\"stratector@gmail.com\"]', '2020-10-04 17:26:02', '2020-10-04 17:26:02'),
(49, 'Herzlichen Glückwunsch', '<p><span class=\'name\'>werq werqwe</span> hat heute Geburtstag, bitte nicht vergessen zu gratulieren.</p><p><br></p><p><span class=\'birthday\'>2016-10-04</span></p><p><span class=\'address\'>Hansastr 35</span></p><p><span class=\'phone\'>341234</span></p>', 'YES', NULL, '2020-10-04 17:27:02', '[\"vladimir.bognar.1979@gmail.com\",\"germedagmbh@gmail.com\",\"stratector@gmail.com\"]', '2020-10-04 17:27:02', '2020-10-04 17:27:02'),
(50, 'Herzlichen Glückwunsch', '<p><span class=\'name\'>werq werqwe</span> hat heute Geburtstag, bitte nicht vergessen zu gratulieren.</p><p><br></p><p><span class=\'birthday\'>1992-10-05</span></p><p><span class=\'address\'>Hansastr 35</span></p><p><span class=\'phone\'>341234</span></p>', 'YES', NULL, '2020-10-05 07:00:10', '[\"vladimir.bognar.1979@gmail.com\",\"germedagmbh@gmail.com\",\"stratector@gmail.com\"]', '2020-10-05 07:00:10', '2020-10-05 07:00:10'),
(51, 'Herzlichen Glückwunsch', '<p><span class=\'name\'>werq werqwe</span> hat heute Geburtstag, bitte nicht vergessen zu gratulieren.</p><p><br></p><p><span class=\'birthday\'>1992-10-05</span></p><p><span class=\'address\'>Hansastr 35</span></p><p><span class=\'phone\'>341234</span></p>', 'YES', NULL, '2020-10-05 15:56:15', '[\"vladimir.bognar.1979@gmail.com\",\"germedagmbh@gmail.com\",\"stratector@gmail.com\"]', '2020-10-05 15:56:15', '2020-10-05 15:56:15'),
(52, 'Herzlichen Glückwunsch', '<p><span class=\'name\'>werq werqwe</span> hat heute Geburtstag, bitte nicht vergessen zu gratulieren.</p><p><br></p><p><span class=\'birthday\'>1992-10-05</span></p><p><span class=\'address\'>Hansastr 35</span></p><p><span class=\'phone\'>341234</span></p>', 'YES', NULL, '2020-10-05 18:15:20', '[\"vladimir.bognar.1979@gmail.com\",\"vladimir.bognar.1979@gmail.com\",\"stratector@gmail.com\"]', '2020-10-05 18:15:20', '2020-10-05 18:15:20'),
(53, 'Herzlichen Glückwunsch', '<p><span class=\'name\'>werq werqwe</span> hat heute Geburtstag, bitte nicht vergessen zu gratulieren.</p><p><br></p><p><span class=\'birthday\'>1992-10-05</span></p><p><span class=\'address\'>Hansastr 35</span></p><p><span class=\'phone\'>341234</span></p>', 'YES', NULL, '2020-10-05 18:18:12', '[\"vladimir.bognar.1979@gmail.com\",\"vladimir.bognar.1979@gmail.com\",\"stratector@gmail.com\"]', '2020-10-05 18:18:12', '2020-10-05 18:18:12'),
(54, 'Neue Bestellung', '<p>Es wurde eine neue Bestellung für <strong>werq werqwe</strong> erzeugt.</p><p><br></p><p>Patient ist versichert bei: reqwr</p><p>Geboren am: 1992-10-05</p><p>Adresse: Hansastr 35</p><p>Telefon: 341234</p><p><br></p><p>Ihr Service von <strong>base</strong></p>', 'YES', NULL, '2020-10-05 18:20:59', '[\"vladimir.bognar.1979@gmail.com\",\"vladimir.bognar.1979@gmail.com\",\"stratector@gmail.com\"]', '2020-10-05 18:20:59', '2020-10-05 18:20:59'),
(55, 'Neue Bestellung', '<p>Es wurde eine neue Bestellung für <strong>werq werqwe</strong> erzeugt.</p><p><br></p><p>Patient ist versichert bei: reqwr</p><p>Geboren am: 1992-10-05</p><p>Adresse: Hansastr 35</p><p>Telefon: 341234</p><p><br></p><p>Ihr Service von <strong>base</strong></p>', 'YES', NULL, '2020-10-05 18:24:37', '[\"vladimir.bognar.1979@gmail.com\",\"vladimir.bognar.1979@gmail.com\",\"stratector@gmail.com\"]', '2020-10-05 18:24:37', '2020-10-05 18:24:37'),
(56, 'Neue Bestellung', '<p>Es wurde eine neue Bestellung für <strong>werq werqwe</strong> erzeugt.</p><p><br></p><p>Patient ist versichert bei: reqwr</p><p>Geboren am: 1992-10-05</p><p>Adresse: Hansastr 35</p><p>Telefon: 341234</p><p><br></p><p>Ihr Service von <strong>base</strong></p>', 'YES', NULL, '2020-10-05 18:26:42', '[\"vladimir.bognar.1979@gmail.com\",\"vladimir.bognar.1979@gmail.com\",\"stratector@gmail.com\"]', '2020-10-05 18:26:42', '2020-10-05 18:26:42'),
(57, 'Neue Bestellung', '<p>Es wurde eine neue Bestellung für <strong>Ursula Müller</strong> erzeugt.</p><p><br></p><p>Patient ist versichert bei: AOK</p><p>Geboren am: 1952-03-19</p><p>Adresse: Rotkelchenweg 1</p><p>Telefon: 0211/429282</p><p><br></p><p>Ihr Service von <strong>base</strong></p>', 'YES', NULL, '2020-10-05 23:26:04', '[\"stratector@gmail.com\",\"kleeblatt@germeda.de\",\"mbecker@germeda.de\"]', '2020-10-05 23:26:04', '2020-10-05 23:26:04'),
(58, 'Neue Bestellung', '<p>Es wurde eine neue Bestellung für <strong>Ursula Müller</strong> erzeugt.</p><p><br></p><p>Patient ist versichert bei: AOK</p><p>Geboren am: 1952-03-19</p><p>Adresse: Rotkelchenweg 1</p><p>Telefon: 0211/429282</p><p><br></p><p>Ihr Service von <strong>base</strong></p>', 'YES', NULL, '2020-10-06 11:05:13', '[\"stratector@gmail.com\",\"kleeblatt@germeda.de\",\"mbecker@germeda.de\"]', '2020-10-06 11:05:13', '2020-10-06 11:05:13'),
(59, 'Neue Bestellung', '<p>Es wurde eine neue Bestellung für <strong>Ursula Müller</strong> erzeugt.</p><p><br></p><p>Patient ist versichert bei: AOK</p><p>Geboren am: 1952-03-19</p><p>Adresse: Rotkelchenweg 1</p><p>Telefon: 0211/429282</p><p><br></p><p>Ihr Service von <strong>base</strong></p>', 'YES', NULL, '2020-10-06 11:21:17', '[\"stratector@gmail.com\",\"kleeblatt@germeda.de\",\"mbecker@germeda.de\"]', '2020-10-06 11:21:17', '2020-10-06 11:21:17'),
(60, 'Neue Bestellung', '<p>Es wurde eine neue Bestellung für <strong>Ursula Müller</strong> erzeugt.</p><p><br></p><p>Patient ist versichert bei: AOK</p><p>Geboren am: 1952-03-19</p><p>Adresse: Rotkelchenweg 1</p><p>Telefon: 0211/429282</p><p><br></p><p>Ihr Service von <strong>base</strong></p>', 'YES', NULL, '2020-10-06 11:22:38', '[\"stratector@gmail.com\",\"kleeblatt@germeda.de\",\"vladimir.bognar.1979@gmail.com\"]', '2020-10-06 11:22:38', '2020-10-06 11:22:38'),
(61, 'Neue Bestellung', '<p><strong class=\"ql-size-large\">Medikamentenbestellung</strong></p><p><br></p><p>Es wurde eine neue Bestellung für <strong>Hans-Willi Meuter</strong> erzeugt.</p><p><br></p><p>Patient ist versichert bei: AOK</p><p>Geboren am: 1968-02-03</p><p>Adresse: Cyriakusstr. 43</p><p>Telefon: </p><p><br></p><p>Ihr Service von GRM</p>', 'YES', NULL, '2020-10-06 16:50:16', '[null,\"kleeblatt@germeda.de\",\"vladimir.bognar.1979@gmail.com\"]', '2020-10-06 16:50:16', '2020-10-06 16:50:16'),
(62, 'Neue Bestellung', '<p><strong class=\"ql-size-large\">Medikamentenbestellung</strong></p><p><br></p><p>Es wurde eine neue Bestellung für <strong>Hans-Willi Meuter</strong> erzeugt.</p><p><br></p><p>Patient ist versichert bei: AOK</p><p>Geboren am: 1968-02-03</p><p>Adresse: Cyriakusstr. 43</p><p>Telefon: </p><p><br></p><p>Ihr Service von GRM</p>', 'YES', NULL, '2020-10-06 16:53:44', '[\"kleeblatt@germeda.de\",\"vladimir.bognar.1979@gmail.com\"]', '2020-10-06 16:53:44', '2020-10-06 16:53:44'),
(63, 'Neue Bestellung', '<p><strong class=\"ql-size-large\">Medikamentenbestellung</strong></p><p><br></p><p>Es wurde eine neue Bestellung für <strong>Hans-Willi Meuter</strong> erzeugt.</p><p><br></p><p>Patient ist versichert bei: AOK</p><p>Geboren am: 1968-02-03</p><p>Adresse: Cyriakusstr. 43</p><p>Telefon: </p><p><br></p><p>Ihr Service von GRM</p>', 'YES', NULL, '2020-10-06 18:34:01', '[\"o1eg@gmx.de\",\"kleeblatt@germeda.de\",\"vladimir.bognar.1979@gmail.com\"]', '2020-10-06 18:34:01', '2020-10-06 18:34:01'),
(64, 'Neue Bestellung', '<p><strong class=\"ql-size-large\">Medikamentenbestellung</strong></p><p><br></p><p>Es wurde eine neue Bestellung für <strong>Hans-Willi Meuter</strong> erzeugt.</p><p><br></p><p>Patient ist versichert bei: AOK</p><p>Geboren am: 1968-02-03</p><p>Adresse: Cyriakusstr. 43</p><p>Telefon: </p><p><br></p><p>Ihr Service von GRM</p>', 'YES', NULL, '2020-10-06 18:36:10', '[\"o1eg@gmx.de\",\"kleeblatt@germeda.de\",\"vladimir.bognar.1979@gmail.com\"]', '2020-10-06 18:36:10', '2020-10-06 18:36:10'),
(65, 'Neue Bestellung', '<p><strong class=\"ql-size-large\">Medikamentenbestellung</strong></p><p><br></p><p>Es wurde eine neue Bestellung für <strong>Ursula Müller</strong> erzeugt.</p><p><br></p><p>Patient ist versichert bei: AOK</p><p>Geboren am: 1952-03-19</p><p>Adresse: Rotkelchenweg 1</p><p>Telefon: 0211/429282</p><p><br></p><p>Ihr Service von GRM</p>', 'YES', NULL, '2020-10-06 18:36:48', '[\"vladimir.bognar.1979@gmail.com\",\"kleeblatt@germeda.de\",\"vladimir.bognar.1979@gmail.com\"]', '2020-10-06 18:36:48', '2020-10-06 18:36:48'),
(66, 'Neue Bestellung', '<p><strong class=\"ql-size-large\">Medikamentenbestellung</strong></p><p><br></p><p>Es wurde eine neue Bestellung für <strong>Ursula Müller</strong> erzeugt.</p><p><br></p><p>Patient ist versichert bei: AOK</p><p>Geboren am: 1952-03-19</p><p>Adresse: Rotkelchenweg 1</p><p>Telefon: 0211/429282</p><p><br></p><p>Ihr Service von GRM</p>', 'YES', NULL, '2020-10-06 18:43:18', '[\"vladimir.bognar.1979@gmail.com\",\"kleeblatt@germeda.de\",\"vladimir.bognar.1979@gmail.com\"]', '2020-10-06 18:43:18', '2020-10-06 18:43:18'),
(67, 'Neue Bestellung', '<p><strong class=\"ql-size-large\">Medikamentenbestellung</strong></p><p><br></p><p>Es wurde eine neue Bestellung für <strong>Ursula Müller</strong> erzeugt.</p><p><br></p><p>Patient ist versichert bei: AOK</p><p>Geboren am: 1952-03-19</p><p>Adresse: Rotkelchenweg 1</p><p>Telefon: 0211/429282</p><p><br></p><p>Ihr Service von GRM</p>', 'YES', NULL, '2020-10-06 18:47:09', '[\"vladimir.bognar.1979@gmail.com\",\"kleeblatt@germeda.de\",\"vladimir.bognar.1979@gmail.com\"]', '2020-10-06 18:47:09', '2020-10-06 18:47:09'),
(68, 'Neue Bestellung', '<p><strong class=\"ql-size-large\">Medikamentenbestellung</strong></p><p><br></p><p>Es wurde eine neue Bestellung für <strong>Ursula Müller</strong> erzeugt.</p><p><br></p><p>Patient ist versichert bei: AOK</p><p>Geboren am: 1952-03-19</p><p>Adresse: Rotkelchenweg 1</p><p>Telefon: 0211/429282</p><p><br></p><p>Ihr Service von GRM</p>', 'YES', NULL, '2020-10-06 18:52:36', '[\"vladimir.bognar.1979@gmail.com\",\"kleeblatt@germeda.de\",\"vladimir.bognar.1979@gmail.com\"]', '2020-10-06 18:52:36', '2020-10-06 18:52:36'),
(69, 'Neue Bestellung', '<p><strong class=\"ql-size-large\">Medikamentenbestellung</strong></p><p><br></p><p>Es wurde eine neue Bestellung für <strong>Ursula Müller</strong> erzeugt.</p><p><br></p><p>Patient ist versichert bei: AOK</p><p>Geboren am: 1952-03-19</p><p>Adresse: Rotkelchenweg 1</p><p>Telefon: 0211/429282</p><p><br></p><p>Ihr Service von GRM</p>', 'YES', NULL, '2020-10-06 18:55:02', '[\"vladimir.bognar.1979@gmail.com\",\"kleeblatt@germeda.de\",\"vladimir.bognar.1979@gmail.com\"]', '2020-10-06 18:55:02', '2020-10-06 18:55:02'),
(70, 'Neue Bestellung', '<p><strong class=\"ql-size-large\">Medikamentenbestellung</strong></p><p><br></p><p>Es wurde eine neue Bestellung für <strong>Ursula Müller</strong> erzeugt.</p><p><br></p><p>Patient ist versichert bei: AOK</p><p>Geboren am: 1952-03-19</p><p>Adresse: Rotkelchenweg 1</p><p>Telefon: 0211/429282</p><p><br></p><p>Ihr Service von GRM</p>', 'YES', NULL, '2020-10-06 20:17:45', '[\"vladimir.bognar.1979@gmail.com\",\"kleeblatt@germeda.de\",\"vladimir.bognar.1979@gmail.com\"]', '2020-10-06 20:17:45', '2020-10-06 20:17:45'),
(71, 'Neue Bestellung', '<p><strong class=\"ql-size-large\">Medikamentenbestellung</strong></p><p><br></p><p>Es wurde eine neue Bestellung für <strong>Ursula Müller</strong> erzeugt.</p><p><br></p><p>Patient ist versichert bei: AOK</p><p>Geboren am: 19.03.1952</p><p>Adresse: Rotkelchenweg 1</p><p>Telefon: 0211/429282</p><p><br></p><p>Ihr Service von GRM</p>', 'YES', NULL, '2020-10-06 20:32:54', '[\"vladimir.bognar.1979@gmail.com\",\"kleeblatt@germeda.de\",\"vladimir.bognar.1979@gmail.com\"]', '2020-10-06 20:32:54', '2020-10-06 20:32:54'),
(72, 'Neue Bestellung', '<p><strong class=\"ql-size-large\">Medikamentenbestellung</strong></p><p><br></p><p>Es wurde eine neue Bestellung für <strong>Ursula Müller</strong> erzeugt.</p><p><br></p><p>Patient ist versichert bei: AOK</p><p>Geboren am: 19.03.1952</p><p>Adresse: Rotkelchenweg 1</p><p>Telefon: 0211/429282</p><p><br></p><p>Ihr Service von GRM</p>', 'YES', NULL, '2020-10-07 07:59:04', '[\"vladimir.bognar.1979@gmail.com\",\"kleeblatt@germeda.de\",\"vladimir.bognar.1979@gmail.com\"]', '2020-10-07 07:59:04', '2020-10-07 07:59:04'),
(73, 'Neue Bestellung', '<p><strong class=\"ql-size-large\">Medikamentenbestellung</strong></p><p><br></p><p>Es wurde eine neue Bestellung für <strong>Hans-Willi Meuter</strong> erzeugt.</p><p><br></p><p>Patient ist versichert bei: AOK</p><p>Geboren am: 03.02.1968</p><p>Adresse: Cyriakusstr. 43</p><p>Telefon: </p><p><br></p><p>Ihr Service von GRM</p>', 'YES', NULL, '2020-10-07 08:29:21', '[\"kleeblatt@germeda.de\",\"vladimir.bognar.1979@gmail.com\"]', '2020-10-07 08:29:21', '2020-10-07 08:29:21'),
(74, 'Neue Bestellung - [order_id]', '<p>Eine neue Bestellung für Hans-Willi Meuter</p><p>Hier können Sie die Bestellung einsehen: ZHZ-080-TYZ</p><p>Bitte die Bestellung bis zum 2020-10-10 bearbeiten.</p><p><br></p><p>Ihr Service von GERMEDA</p><p><br></p>', 'YES', NULL, '2020-10-07 21:01:58', '[\"o1eg@gmx.de\",\"kleeblatt@germeda.de\",\"vladimir.bognar.1979@gmail.com\"]', '2020-10-07 21:01:58', '2020-10-07 21:01:58'),
(75, 'Neue Bestellung - [order_id]', '<p>Eine neue Bestellung für Hans-Willi Meuter</p><p>Hier können Sie die Bestellung einsehen: https://bettingapp-d9b53.web.app/order-detail/XGV-275-EQI</p><p>Bitte die Bestellung bis zum 2020-10-11 bearbeiten.</p><p><br></p><p>Ihr Service von GERMEDA</p>', 'YES', NULL, '2020-10-07 21:09:39', '[\"o1eg@gmx.de\",\"kleeblatt@germeda.de\",\"vladimir.bognar.1979@gmail.com\"]', '2020-10-07 21:09:39', '2020-10-07 21:09:39'),
(76, 'Neue Bestellung - [order_id]', '<p>Eine neue Bestellung für Hans-Willi Meuter</p><p>Hier können Sie die Bestellung einsehen: https://bettingapp-d9b53.web.app/order-detail/YHW-129-CWJ</p><p>Bitte die Bestellung bis zum 2020-10-12 bearbeiten.</p><p><br></p><p>Ihr Service von GERMEDA</p>', 'YES', NULL, '2020-10-07 21:40:20', '[\"o1eg@gmx.de\",\"kleeblatt@germeda.de\",\"vladimir.bognar.1979@gmail.com\"]', '2020-10-07 21:40:20', '2020-10-07 21:40:20');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2017_12_28_130024_create_categories_table', 1),
(4, '2017_12_28_130058_create_questions_table', 1),
(5, '2018_05_30_134303_create_tutorials_table', 1),
(6, '2020_09_03_134241_app_user', 1),
(7, '2020_09_04_083452_family_doctors', 1),
(8, '2020_09_10_031029_pharmacies', 1),
(9, '2020_09_10_105716_patients', 1),
(10, '2020_09_11_031950_medications', 1),
(11, '2020_09_11_095810_resources', 1),
(12, '2020_09_11_100329_insurances', 1),
(13, '2020_09_11_100350_services', 1),
(14, '2020_09_12_110706_ingredients', 1),
(15, '2020_09_13_012652_instances', 1),
(16, '2020_09_13_121916_permissions', 1),
(17, '2020_09_13_122007_roles', 1),
(18, '2020_09_15_024402_orders', 1),
(19, '2020_09_19_051405_comments', 1),
(20, '2020_09_21_135043_documents', 1),
(21, '2020_09_22_092134_carefolders', 1),
(22, '2020_09_29_133413_messages', 1),
(23, '2020_10_02_044442_emailtemplates', 1),
(24, '2020_10_03_044041_triggers', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `orderMedications` longtext COLLATE utf8mb4_unicode_ci,
  `orderId` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `patient` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pharmacy` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `doctor` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `orderMedications`, `orderId`, `patient`, `pharmacy`, `doctor`, `date`, `note`, `user_id`, `status`, `created_at`, `updated_at`) VALUES
(10, '[\"med 108\"]', 'YHW-129-CWJ', '2', 'Kleeblatt Apotheke', 'Dr. Marina Becker', '2020-10-12', 'Die Bestellung von Ann', '2', 0, '2020-10-07 21:40:19', '2020-10-07 21:40:19');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` int(10) UNSIGNED NOT NULL,
  `salutation` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `firstName` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastName` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `streetNr` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zipCode` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birthday` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone1` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone2` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `picture` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `resources` longtext COLLATE utf8mb4_unicode_ci,
  `insurance` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `insuranceNr` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `services` longtext COLLATE utf8mb4_unicode_ci,
  `familyDoctor` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keyNumber` int(11) DEFAULT NULL,
  `floor` int(11) DEFAULT NULL,
  `degreeCare` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pharmacy` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `userGroup` longtext COLLATE utf8mb4_unicode_ci,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `instance_id` int(11) NOT NULL DEFAULT '0',
  `serviceplan` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `salutation`, `firstName`, `lastName`, `streetNr`, `zipCode`, `city`, `birthday`, `phone1`, `phone2`, `email`, `picture`, `resources`, `insurance`, `insuranceNr`, `services`, `familyDoctor`, `keyNumber`, `floor`, `degreeCare`, `pharmacy`, `userGroup`, `status`, `instance_id`, `serviceplan`, `created_at`, `updated_at`) VALUES
(1, 'Frau', 'Ursula', 'Müller', 'Rotkelchenweg 1', '40468', 'Düsseldorf', '1952-03-19', '0211/429282', '1', 'vladimir.bognar.1979@gmail.com', 'https://betpool.tech/adminserver/file_storage/1601882479Lea.png', '[\"Ambulant\"]', 'AOK', 'D4949239933 ', '[\"LK 19 Grundpflege\",\"Medikamentengabe\"]', 'Dr. Marina Becker', 82, 3, '1', 'Kleeblatt Apotheke', '[\"super\"]', 'Aktiv', 0, 1, '2020-10-03 10:45:32', '2020-10-03 10:45:32'),
(2, 'Herr', 'Hans-Willi', 'Meuter', 'Cyriakusstr. 43', '41468', 'Neuss', '1968-02-03', NULL, NULL, 'o1eg@gmx.de', 'https://betpool.tech/adminserver/file_storage/1601985348einkauf.png', '[\"Ambulant\"]', 'AOK', 'D4923929323', '[\"Medikamentengabe\"]', 'Dr. Marina Becker', 2, 3, '2', 'Kleeblatt Apotheke', '[\"Oleg\"]', 'Aktiv', 2, 1, '2020-10-06 12:55:48', '2020-10-06 12:55:48');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `permissions` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `permissions`, `created_at`, `updated_at`) VALUES
(5, 'patients_access', '2020-09-14 07:04:41', '2020-09-14 07:04:41'),
(14, 'users_access', '2020-09-16 17:05:22', '2020-09-16 17:05:22'),
(15, 'order_access', '2020-09-16 17:06:10', '2020-09-16 17:06:10'),
(18, 'emailtrigers_access', '2020-10-05 21:18:34', '2020-10-05 21:18:34'),
(19, 'emailtemplates_access', '2020-10-05 21:18:46', '2020-10-05 21:18:46'),
(20, 'carefolders_access', '2020-10-05 21:19:41', '2020-10-05 21:19:41'),
(21, 'documents_access', '2020-10-05 21:20:00', '2020-10-05 21:20:00');

-- --------------------------------------------------------

--
-- Table structure for table `pharmacies`
--

CREATE TABLE `pharmacies` (
  `id` int(10) UNSIGNED NOT NULL,
  `pharmacyLogo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pharmacyName` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `streetNr` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zipcode` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fax` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notifications` tinyint(1) NOT NULL DEFAULT '0',
  `instance_id` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pharmacies`
--

INSERT INTO `pharmacies` (`id`, `pharmacyLogo`, `pharmacyName`, `streetNr`, `zipcode`, `city`, `phone`, `fax`, `email`, `password`, `notifications`, `instance_id`, `created_at`, `updated_at`) VALUES
(1, 'https://betpool.tech/adminserver/file_storage/1601881736bawigd.png', 'Kleeblatt Apotheke', 'Schiessstraße 31', '40549', 'Düsseldorf', '0211 78173690', '0211 78173691', 'kleeblatt@germeda.de', '123456', 1, 0, '2020-10-03 10:43:56', '2020-10-03 10:43:56');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(10) UNSIGNED NOT NULL,
  `category_id` int(11) NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `question_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'regular',
  `thumbnail` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `number_of_answer` int(11) NOT NULL DEFAULT '4',
  `choice_a` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `choice_b` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `choice_c` text COLLATE utf8mb4_unicode_ci,
  `choice_d` text COLLATE utf8mb4_unicode_ci,
  `choice_e` text COLLATE utf8mb4_unicode_ci,
  `answer` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `explanation` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `resources`
--

CREATE TABLE `resources` (
  `id` int(10) UNSIGNED NOT NULL,
  `resources` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `resources`
--

INSERT INTO `resources` (`id`, `resources`, `created_at`, `updated_at`) VALUES
(2, 'Ambulant', '2020-10-05 20:02:01', '2020-10-05 20:02:01'),
(3, 'Intensiv', '2020-10-05 20:02:11', '2020-10-05 20:02:11');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `role` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `permissions` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role`, `permissions`, `created_at`, `updated_at`) VALUES
(1, 'super administrator', '[\"order_access\",\"ingredients_access\",\"doctors_access\",\"services_access\",\"patients_access\",\"medication_access\",\"resources_access\",\"emailtemplates_access\",\"roles_access\",\"permissions_access\",\"pharmacies_access\",\"instances_access\",\"insurances_access\"]', NULL, '2020-10-07 11:23:24'),
(2, 'admin', '[\"documents_access\",\"emailtemplates_access\",\"carefolders_access\",\"emailtrigers_access\",\"order_access\",\"users_access\",\"patients_access\"]', '2020-10-07 11:23:14', '2020-10-07 11:23:14'),
(3, 'Nutzer', '[\"order_access\"]', '2020-10-07 21:34:46', '2020-10-07 21:34:46');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(10) UNSIGNED NOT NULL,
  `services` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `services`, `created_at`, `updated_at`) VALUES
(1, 'Medikamentengabe', '2020-10-03 10:41:15', '2020-10-03 10:41:15'),
(2, 'LK 19 Grundpflege', '2020-10-05 20:03:01', '2020-10-05 20:03:01');

-- --------------------------------------------------------

--
-- Table structure for table `triggers`
--

CREATE TABLE `triggers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `template` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `usergroup` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `instance_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `triggers`
--

INSERT INTO `triggers` (`id`, `template`, `type`, `usergroup`, `instance_id`, `created_at`, `updated_at`) VALUES
(1, 'Herzlichen Glückwunsch', 'Every year on birthdays', '[\"Family doctors\",\"Patients\",\"Pharmacies\"]', '0', '2020-10-03 06:54:52', '2020-10-04 15:51:46'),
(4, 'Neue Bestellung', 'User create an Order', '[\"Family doctors\",\"Pharmacies\",\"Patients\",\"Instance Admin\"]', '0', '2020-10-03 10:40:15', '2020-10-03 22:20:51'),
(5, 'Neue Bestellung - [order_id]', 'User create an Order', '[\"Family doctors\",\"Pharmacies\",\"Instance User\",\"Patients\"]', '2', '2020-10-07 08:27:24', '2020-10-07 21:00:55');

-- --------------------------------------------------------

--
-- Table structure for table `tutorials`
--

CREATE TABLE `tutorials` (
  `id` int(10) UNSIGNED NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `app_user`
--
ALTER TABLE `app_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `app_user_email_unique` (`email`);

--
-- Indexes for table `carefolders`
--
ALTER TABLE `carefolders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emailtemplates`
--
ALTER TABLE `emailtemplates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `family_doctors`
--
ALTER TABLE `family_doctors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ingredients`
--
ALTER TABLE `ingredients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `instances`
--
ALTER TABLE `instances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `insurances`
--
ALTER TABLE `insurances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medications`
--
ALTER TABLE `medications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pharmacies`
--
ALTER TABLE `pharmacies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `resources`
--
ALTER TABLE `resources`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `services_services_unique` (`services`);

--
-- Indexes for table `triggers`
--
ALTER TABLE `triggers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tutorials`
--
ALTER TABLE `tutorials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `app_user`
--
ALTER TABLE `app_user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `carefolders`
--
ALTER TABLE `carefolders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `emailtemplates`
--
ALTER TABLE `emailtemplates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `family_doctors`
--
ALTER TABLE `family_doctors`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ingredients`
--
ALTER TABLE `ingredients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `instances`
--
ALTER TABLE `instances`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `insurances`
--
ALTER TABLE `insurances`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `medications`
--
ALTER TABLE `medications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `pharmacies`
--
ALTER TABLE `pharmacies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `resources`
--
ALTER TABLE `resources`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `triggers`
--
ALTER TABLE `triggers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tutorials`
--
ALTER TABLE `tutorials`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
