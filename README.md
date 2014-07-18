Web Application for tele-prospection

-----------------------------------------------------------

To add an access protection, modify .htaccess and add id and passwd 

DataBase parametres connexion have to be add in connexion-sql.php

-- --------------------------------------------------------

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

-------------------------------------------------------------

csv file for import :

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


