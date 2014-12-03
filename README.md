
/*
***---------------------------------------------------------**
**       SETUP  Web Application for tele-prospection        **
***---------------------------------------------------------**

STEP 1 : Download the files to your server
STEP 2 : Create a database and add the tables declared below 
STEP 3 : DataBase parametres connexion and URL of the application have to be added in the ** constantes.php ** file
STEP 4 : If you need Restricted acces, Modify .htaccess file (decomment lines and add replace the url) and add password and id in : repertoire_protege/.htpasswd file

*/
-- ***--------------------**
-- **       DATABASE      **
-- ***--------------------**
--
-- Table structure for table `echange`
--

CREATE TABLE IF NOT EXISTS `echange` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `date_echange` datetime NOT NULL,
  `type_echange` enum('telephone','physique','email') NOT NULL,
  `id_societe` int(8) NOT NULL,
  `appele` tinyint(1) NOT NULL,
  `commentaire` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=875 ;

INSERT INTO `echange` (`id`, `date_echange`, `type_echange`, `id_societe`, `appele`, `commentaire`) VALUES
(875, '2014-12-03 14:00:00', 'telephone', 20708, 0, 'We had a one hour call to check the needs');

-- --------------------------------------------------------

--
-- Table structure for table `rencontre`
--

CREATE TABLE IF NOT EXISTS `rencontre` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `date_rencontre` datetime NOT NULL,
  `type_rencontre` enum('telephone','physique','email') NOT NULL DEFAULT 'telephone',
  `id_societe` int(8) NOT NULL,
  `commentaire` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=324 ;

INSERT INTO `rencontre` (`id`, `date_rencontre`, `type_rencontre`, `id_societe`, `commentaire`) VALUES
(324, '2015-05-22 10:30:00', 'telephone', 20708, 'Call back Gaëlle');

-- --------------------------------------------------------

--
-- Table structure for table `societe`
--

CREATE TABLE IF NOT EXISTS `societe` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `nom` varchar(300) NOT NULL,
  `adresse` varchar(300) NOT NULL,
  `cp` varchar(8) NOT NULL,
  `ville` varchar(50) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `email` varchar(60) NOT NULL,
  `site_web` varchar(150) NOT NULL,
  `nom_contact` varchar(50) NOT NULL,
  `prenom_contact` varchar(50) NOT NULL,
  `tel_contact` varchar(20) NOT NULL,
  `portable_contact` varchar(20) NOT NULL,
  `email_contact` varchar(60) NOT NULL,
  `temperature` enum('chaud','tiede','froid','indetermine') NOT NULL DEFAULT 'indetermine',
  `dirigeant` varchar(200) NOT NULL,
  `naf` varchar(200) NOT NULL,
  `autre` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20708 ;

INSERT INTO `societe` (`id`, `nom`, `adresse`, `cp`, `ville`, `telephone`, `email`, `site_web`, `nom_contact`, `prenom_contact`, `tel_contact`, `portable_contact`, `email_contact`, `temperature`, `dirigeant`, `naf`, `autre`) VALUES
(20708, 'Tarabusk.net', '1519 Hyde Street', '94109', 'San Franciso', '', '', 'http://tarabusk.net', 'Tara', '', '4153122664', '', 'tarabusk@gmail.com', 'chaud', '', '', '');


/*
***-----------------------------------**
**  structure of csv file for import  **
***-----------------------------------**


Colonne 1 : RAISON SOCIALE | 
Colonne 2 :  DIRIGEANT | 
Colonne 3 : ADRESSE | 
Colonne 4 : CP | 
Colonne 5 : VILLE | 
Colonne 6 : TELEPHONE | 
Colonne 7 : EMAIL | 
Colonne 8 : CODE NAF | 
Colonne 9 : LIBELLE NAF | 
Colonne 10 : RUBRIQUE PROFESSIONNELLE | 
Colonne 11 : FORME JURIDIQUE | 
Colonne 12 : STATUT ETS | 
Colonne 13 : EFFECTIF | 
Colonne 14 : DEBUT ACTIVITE
*/

