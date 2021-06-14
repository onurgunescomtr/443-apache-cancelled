SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+03:00";

CREATE DATABASE IF NOT EXISTS `vsdbos1001` DEFAULT CHARACTER SET utf8 COLLATE utf8_turkish_ci;
USE `vsdbos1001`;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `vs_iletisim`
--

DROP TABLE IF EXISTS `vs_iletisim`;
CREATE TABLE IF NOT EXISTS `vs_iletisim` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `tid` varchar(32) COLLATE utf8_turkish_ci DEFAULT NULL,
  `did` tinyint(4) DEFAULT NULL,
  `userid` int(10) DEFAULT NULL,
  `name` text COLLATE utf8_turkish_ci DEFAULT NULL,
  `email` text CHARACTER SET utf8 DEFAULT NULL,
  `ilanno` varchar(64) COLLATE utf8_turkish_ci DEFAULT NULL,
  `telefon` varchar(32) COLLATE utf8_turkish_ci DEFAULT NULL,
  `date` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `message` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `notes` text COLLATE utf8_turkish_ci DEFAULT NULL,
  `ip` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `browser` text CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;



-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `vs_kategori`
--

DROP TABLE IF EXISTS `vs_kategori`;
CREATE TABLE IF NOT EXISTS `vs_kategori` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `katno` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `adi` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `reklamgrubu` varchar(255) COLLATE utf8_turkish_ci DEFAULT NULL,
  `reklamno` smallint(6) DEFAULT NULL,
  `grupadi` varchar(255) COLLATE utf8_turkish_ci DEFAULT NULL,
  `katozeti` text COLLATE utf8_turkish_ci DEFAULT NULL,
  `katfoto` text COLLATE utf8_turkish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `vs_kilit`
--

DROP TABLE IF EXISTS `vs_kilit`;
CREATE TABLE IF NOT EXISTS `vs_kilit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adres` varchar(32) COLLATE utf8_turkish_ci NOT NULL,
  `kapalianahtar` varchar(255) COLLATE utf8_turkish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------


-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `vs_logsistekler`
--

DROP TABLE IF EXISTS `vs_logsistekler`;
CREATE TABLE IF NOT EXISTS `vs_logsistekler` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `tarihsaat` varchar(25) COLLATE utf8_turkish_ci NOT NULL,
  `tipi` varchar(10) COLLATE utf8_turkish_ci DEFAULT '202',
  `tanim` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `hesapno` varchar(255) COLLATE utf8_turkish_ci DEFAULT NULL,
  `ip` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `raporseviyesi` varchar(30) COLLATE utf8_turkish_ci NOT NULL,
  `onemderecesi` varchar(30) COLLATE utf8_turkish_ci NOT NULL,
  `yonlendiren` text COLLATE utf8_turkish_ci DEFAULT NULL,
  `islem` text COLLATE utf8_turkish_ci DEFAULT NULL,
  `ekislem` text COLLATE utf8_turkish_ci DEFAULT NULL,
  `sorgu` text COLLATE utf8_turkish_ci DEFAULT NULL,
  `useragent` text COLLATE utf8_turkish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `vs_logskilit`
--

DROP TABLE IF EXISTS `vs_logskilit`;
CREATE TABLE IF NOT EXISTS `vs_logskilit` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `tarihsaat` varchar(25) COLLATE utf8_turkish_ci NOT NULL,
  `tipi` varchar(32) COLLATE utf8_turkish_ci DEFAULT '202',
  `tanim` varchar(511) COLLATE utf8_turkish_ci NOT NULL,
  `ip` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `yonlendiren` text COLLATE utf8_turkish_ci DEFAULT NULL,
  `uri` text COLLATE utf8_turkish_ci DEFAULT NULL,
  `iletim` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;



-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `vs_modul_dergi`
--

DROP TABLE IF EXISTS `vs_modul_dergi`;
CREATE TABLE IF NOT EXISTS `vs_modul_dergi` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `sayfano` varchar(64) COLLATE utf8_turkish_ci DEFAULT NULL,
  `statik` tinyint(4) DEFAULT NULL,
  `durumu` tinyint(4) DEFAULT 1,
  `modelno` varchar(64) COLLATE utf8_turkish_ci DEFAULT NULL,
  `manset` tinyint(4) NOT NULL DEFAULT 0,
  `mansetno` tinyint(4) DEFAULT NULL,
  `mansetlink` varchar(255) COLLATE utf8_turkish_ci DEFAULT NULL,
  `adi` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `yazi` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `goruntulenme` int(10) NOT NULL DEFAULT 0,
  `ozelyazi` tinyint(4) DEFAULT 0,
  `anahtarkelime` varchar(255) COLLATE utf8_turkish_ci DEFAULT NULL,
  `baslik` text CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `tanim` text CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `gorunenadi` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `katno` varchar(2048) COLLATE utf8_turkish_ci DEFAULT NULL,
  `benzerleri` varchar(2048) COLLATE utf8_turkish_ci DEFAULT NULL,
  `foto` varchar(255) COLLATE utf8_turkish_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `gorunenadi` (`gorunenadi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;



--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `vs_modul_dergi`
--
ALTER TABLE `vs_modul_dergi` ADD FULLTEXT KEY `title` (`adi`,`yazi`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
