
--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(2555) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`) VALUES
(1, 'ghulam@xyz.co.uk', '$2y$10$0WkmKjGj3jOQ.OB.X5fJuedzIK9r09o4/1MgpgFxeOESqboo/hA1a'),
(2, 'regina@xyz.co.uk', '$2y$10$7QzWB1Q78yv.4IJj6jJhBO9OgjLpWl1SSdgw85wQCDwKsmsBMXsbO'),
(3, 'olive@xyz.co.uk', '$2y$10$257yyzkHMyjC1TbKBV7nBe5wM5Ymj.21p3Ik4aXDeZE.QAfVg54P.');
COMMIT;
