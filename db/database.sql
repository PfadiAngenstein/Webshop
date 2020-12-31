--
-- Tabellenstruktur für Tabelle `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_code` varchar(60) CHARACTER SET latin1 NOT NULL,
  `product_name` varchar(60) COLLATE utf8_bin NOT NULL,
  `product_desc` mediumtext CHARACTER SET latin1 NOT NULL,
  `product_img_name` varchar(60) CHARACTER SET latin1 NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_code` (`product_code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Daten für Tabelle `products`
--

INSERT INTO `products` (`id`, `product_code`, `product_name`, `product_desc`, `product_img_name`, `price`) VALUES
(1, 'u_woelfli', 'W&ouml;lfliuniform', 'Das praktische Wolfsstufen Hemd f&uuml;r &Uuml;bung und Lager. hajk l&auml;sst dieses Hemd durch die bekannte Schweizer Firma Weder-Meier in Europa produzieren. Dank dieser nachhaltigen Produktion entspricht dieses Produkt dem &Ouml;kotex Standard 1000.', 'hemd_woelfli.png', '62.00'),
(2, 'u_pfadi', 'Pfadiuniform', 'An einer Legende braucht man nichts zu &auml;ndern - das unverw&uuml;stliche Langarm-Pfadihemd. hajk l&auml;sst dieses Hemd durch die bekannte Schweizer Firma Weder-Meier in Europa produzieren. Dank dieser nachhaltigen Produktion enstpricht dieses Produkt dem &Ouml;kotex Standard 1000.', 'hemd_pfadi.png', '64.00'),
(3, 'u_leiter', 'Leiteruniform', 'Langarm-Uniformhemd f&uuml;r Rover, Leiterinnen und Leiter. hajk l&auml;sst dieses Hemd durch die bekannte Schweizer Firma Weder-Meier in Europa produzieren. Dank dieser nachhaltigen Produktion enstpricht dieses Produkt dem &Ouml;kotex Standard 1000.', 'hemd_leiter.png', '64.00'),
(4, 'krawatte', 'Abteilungskrawatte', 'Die Abteilungskrawatte der Pfadi Angenstein ist gelb mit einem ca. 2 cm breiten schwarzen Rand.', 'krawatte.png', '22.00'),
(8, 'pullover', 'Abteilungspullover', 'Der Pfadi Angenstein-Abteilungspullover!<br>\r\nDer Pullover ist nicht mehr in allen Gr&ouml;ssen erh&auml;ltlich.', 'abteilungspullover.png', '30.00'),
(7, 'pullover_alt', 'alter Abteilungspullover', 'Der alte Abeilungspullover jetzt im Angebot.', 'abteilungspullover_alt.png', '20.00'),
(10, 'l_thilo', 'Thilo', 'Der Thilo enth&auml;lt viel Interessantes und Wissenswertes &uuml;ber die Pfadi und geh&ouml;rt auf das Nachttischchen und ins T&auml;schli jedes Pfadi. Aus dem Inhalt: Die Pfadibewegung, die Welt in der wir leben, Pfaditechnik, Erste Hilfe, Natur und Umwelt, Lagerleben usw.', 'thilo.png', '17.00'),
(11, 'l_technix', 'Technix', 'Von Pfadis f&uuml;r Pfadis, geh&ouml;rt in jeden Rucksack rein! Kompakt, praktisch und ausf&uuml;hrlich. Die Kapitel Pionier, Karte, Kompass, Unterwegs, Sch&auml;tzen &amp; Messen, &Uuml;bermitteln, Natur, Wetter, Samariter und Kochen lassen f&uuml;rs Leben und &Uuml;berleben in der freien Natur keine W&uuml;nsche offen.', 'technix.png', '19.00'),
(12, 'l_rondo', 'Rondo', 'Das beliebte Rondo Liederbuch im Taschenformat (105 x 145 mm) ist in einer total &uuml;berarbeiteten Auflage (2011) erh&auml;ltlich: Darin finden sich 103 Lieder aus dem &quot;alten&quot; Rondo, 27 Lieder, die erstmals f&uuml;r das &quot;Contura Rondo&quot; gestaltet wurden, sowie nochmals 29 neue Lieder. Eine attraktive Grundlage, das Singen und Musizieren popul&auml;r zu gestalten.', 'rondo.png', '17.00'),
(6, 'k_pfadi', 'Krawattenring Pfadi', 'Der obligatorische Krawattenring f&uuml;r die Krawatte', 'krawattenring_pfadi.png', '5.00'),
(9, 'pullover_neu', 'Neuer Abteilungspullover', 'Der neue Abteilungspullover jetzt im Angebot!', 'abteilungspullover_neu.png', '50.00'),
(5, 'k_woelfli', 'Krawattenring W&ouml;lfli', 'Der obligatorische Krawattenring f&uuml;r die Krawatte', 'krawattenring_woelfli.png', '5.00');