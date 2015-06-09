-- 
-- Tabellenstruktur für Tabelle `products`
-- 

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_code` varchar(60) NOT NULL,
  `product_name` varchar(60) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `product_desc` mediumtext NOT NULL,
  `product_img_name` varchar(60) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_code` (`product_code`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- 
-- Daten für Tabelle `products`
-- 

INSERT INTO `products` VALUES (1, 'woelfli', 0x57c3b66c666c69756e69666f726d, 'Das praktische Wolfsstufen Hemd für Übung und Lager. hajk lässt dieses Hemd durch die bekannte Schweizer Firma Weder-Meier in Europa produzieren. Dank dieser nachhaltigen Produktion entspricht dieses Produkt dem Ökotex Standard 1000.', 'hemd_woelfli.png', 64.00);
INSERT INTO `products` VALUES (2, 'pfadi', 0x5066616469756e69666f726d, 'An einer Legende braucht man nichts zu ändern - das unverwüstliche Langarm-Pfadihemd. hajk lässt dieses Hemd durch die bekannte Schweizer Firma Weder-Meier in Europa produzieren. Dank dieser nachhaltigen Produktion enstpricht dieses Produkt dem Ökotex Standard 1000.', 'hemd_pfadi.png', 64.00);
INSERT INTO `products` VALUES (3, 'leiter', 0x4c6569746572756e69666f726d, 'Langarm-Uniformhemd für Rover, Leiterinnen und Leiter. hajk lässt dieses Hemd durch die bekannte Schweizer Firma Weder-Meier in Europa produzieren. Dank dieser nachhaltigen Produktion enstpricht dieses Produkt dem Ökotex Standard 1000.', 'hemd_leiter.png', 64.00);
INSERT INTO `products` VALUES (4, 'krawatte', 0x41627465696c756e67736b72617761747465, 'Die Abteilungskrawatte der Pfadi Angenstein ist gelb mit einem ca. 2 cm breiten schwarzen Rand.', 'krawatte.png', 20.90);
INSERT INTO `products` VALUES (5, 'pullover', 0x41627465696c756e677370756c6c6f766572, 'Der Pfadi Angenstein-Abteilungspullover!', 'abteilungspullover.png', 50.00);
INSERT INTO `products` VALUES (6, 'pullover alt', 0x616c7465722041627465696c756e677370756c6c6f766572, 'Der alte Abeilungspullover jetzt im Angebot.', 'abteilungspullover_alt.png', 20.00);
INSERT INTO `products` VALUES (7, 'thilo', 0x5468696c6f, 'Der Thilo enthält viel Interessantes und Wissenswertes über die Pfadi und gehört auf das Nachttischchen und ins Täschli jedes Pfadi. Aus dem Inhalt: Die Pfadibewegung, die Welt in der wir leben, Pfaditechnik, Erste Hilfe, Natur und Umwelt, Lagerleben usw.', 'thilo.png', 16.50);
INSERT INTO `products` VALUES (8, 'technix', 0x546563686e6978, 'Von Pfadis für Pfadis, gehört in jeden Rucksack rein! Kompakt, praktisch und ausführlich. Die Kapitel Pionier, Karte, Kompass, Unterwegs, Schätzen &amp; Messen, Übermitteln, Natur, Wetter, Samariter und Kochen lassen fürs Leben und Überleben in der freien Natur keine Wünsche offen.', 'technix.png', 16.80);
INSERT INTO `products` VALUES (10, 'rondo', 0x526f6e646f, 'Beschreibung\r\n\r\n\r\nDas beliebte Rondo Liederbuch im Taschenformat (105 x 145 mm) ist in einer total überarbeiteten Auflage (2011) erhältlich: Darin finden sich 103 Lieder aus dem "alten" Rondo, 27 Lieder, die erstmals für das "Contura Rondo" gestaltet wurden, sowie nochmals 29 neue Lieder. Eine attraktive Grundlage, das Singen und Musizieren populär zu gestalten.', 'rondo.png', 17.90);
INSERT INTO `products` VALUES (9, 'gueti jagd', 0x4775657469204a616764, 'Das persönliche Begleitbüchlein für jeden Wolf.', 'guetijagd.png', 5.00);
