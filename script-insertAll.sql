
--
-- Dumping data for table `topics`
--

INSERT INTO `topics` (`TOPIC_ID`, `NAME`, `DESCRIPTION`) VALUES
(0, 'Memes', 'Pour rigoler !'),
(1, 'Cuisine', 'De l''art tout simplement.'),
(2, 'Abeilles', NULL),
(3, 'Porte', 'Une porte, c''est toujours bien dans la vie.'),
(4, 'Test', 'Hello world !'),
(5, 'Testing', 'Bonjour'),
(6, 'Test2', 'moup'),
(7, 'AAAA', 'a aa aaa aaaa'),
(8, 'BBBB', 'b bb bbb bbbb'),
(9, 'CCCC', 'c cc ccc cccc'),
(10, 'DDDD', 'd dd ddd dddd'),
(11, 'EEEE', 'e ee eee eeee'),
(12, 'FFFF', 'f ff fff ffff'),
(13, 'GGGG', 'g gg ggg gggg'),
(14, 'HHHH', 'h hh hhh hhhh'),
(15, 'IIII', 'i ii iii iiii'),
(16, 'JJJJ', 'j jj jjj jjjj'),
(17, 'KKKK', 'k kk kkk kkkk');

-- --------------------------------------------------------

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`USER_ID`, `USERNAME`, `USER_EMAIL`, `USER_PWD`, `IS_ACTIVATED`, `IS_ADMIN`, `USER_CREATED`, `USER_LAST_CONNECTION`, `USER_PROFIL_PIC`, `USER_BIO`) VALUES
(0, 'Utilisateur 2', '2utili@mail.net', 'PWD', 1, 1, '2023-09-02', '2023-10-01', NULL, 'Je suis admin.'),
(1, 'Utilisateur 1', 'utili1@mail.net', 'MDP', 1, 1, '2023-09-21', '2023-10-02', NULL, 'Je suis moi.'),
(2, 'Utilisateur 4', 'utilisateur_4@mail.net', 'Password', 1, 0, '2023-09-21', '2023-09-24', NULL, 'Je suis utilisateur.'),
(3, 'Utilisateur 6', 'utilisat6@mail.net', 'PassageMot', 1, 0, '2023-10-06', '2023-10-06', NULL, 'Je remplit la table.'),
(4, 'Utilisateur 5', 'utili.5@mail.net', 'pwd', 0, 1, '2023-09-30', '2023-10-01', NULL, 'Je suis un admin pour tester la suppression impossible d''admin par d''autres.'),
(5, 'Utilisateur 3', 'utilisateur3@mail.net', 'Mot de passe', 0, 0, '2023-10-06', '2023-10-06', NULL, 'Je suis là pour tester la suppression en cascade des posts.'),
(6, 'Utilisateur 7', 'util7@mail.net', 'AAAA', 1, 0, '2023-09-30', '2023-10-02', NULL, 'Je suis là pour tester la supression en cascade des commentaires.'),
(7, 'Utilisateur 8', '8utilisateur@mail.net', 'BBBB', 1, 0, '2023-10-06', '2023-10-06', NULL, 'Je remplit la table.'),
(8, 'Utilisateur 9', 'utilisateur9@mail.net', 'CCCC', 1, 0, '2023-10-07', '2023-10-06', NULL, 'Je remplit la table.'),
(9, 'Utilisateur 10', 'utili10@mail.net', 'DDDD', 0, 0, '2023-10-07', '2023-10-06', NULL, 'Je remplit la table.'),
(10, 'Utilisateur 11', 'utilisateur11@mail.net', 'EEEE', 1, 0, '2023-10-09', '2023-10-06', NULL, 'Je remplit la table.'),
(11, 'Utilisateur 12', '12@mail.net', 'FFFF', 1, 0, '2023-10-09', '2023-10-11', NULL, 'Je remplit la table.'),
(12, 'Utilisateur 13', 'util1sat3ur@mail.net', 'GGGG', 1, 0, '2023-10-11', '2023-10-06', NULL, 'Je remplit la table.'),
(13, 'Utilisateur 14', 'utilisateur@gmail.com', 'HHHH', 1, 0, '2023-10-13', '2023-10-13', NULL, 'Je remplit la table.'),
(14, 'Utilisateur 15', 'utilisateur@yahoo.fr', 'IIII', 0, 0, '2023-10-13', '2023-10-06', NULL, 'Je remplit la table.');

-- --------------------------------------------------------

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`POST_ID`, `USER_ID`, `TITLE`, `CONTENT`, `DATE_POSTED`) VALUES
(0, 1, 'Test', 'Hello world !', '2023-09-30'),
(1, 0, 'Bonjour', 'Moi c''est le testeur.', '2023-09-29'),
(2, 1, NULL, 'Test de post sans titre.', '2023-09-30'),
(3, 5, 'Test Cascade User', 'Je suis un post de test de la suppr en cascade avec les utilisateurs.', '2023-09-30'),
(4, 0, 'Test Cascade Comments', 'Je suis un post de test de la suppr en cascade avec les commentaires.', '2023-09-30'),
(5, 4, 'Remplissage', 'Je suis un post / billet de remplissage de la table.', '2023-09-30'),
(6, 7, 'Remplissage', 'Je suis un post / billet de remplissage de la table.', '2023-09-30'),
(7, 3, '', 'Je suis un post avec titre vide.', '2023-09-30'),
(8, 4, 'Remplissage', 'Je suis un post / billet de remplissage de la table.', '2023-09-30'),
(9, 4, 'Remplissage', 'Je suis un post / billet de remplissage de la table.', '2023-09-30'),
(10, 12, 'Remplissage', 'Je suis un post / billet de remplissage de la table.', '2023-09-30'),
(11, 8, 'Remplissage', 'Je suis un post / billet de remplissage de la table.', '2023-09-30'),
(12, 10, 'Remplissage', '', '2023-09-30'),
(13, 11, 'Remplissage', 'Je suis un post / billet de remplissage de la table.', '2023-09-30'),
(14, 13, 'Remplissage', 'Je suis un post / billet de remplissage de la table.', '2023-09-30'),
(15, 8, 'Remplissage', 'Je suis un post / billet de remplissage de la table.', '2023-09-30'),
(16, 8, 'Remplissage', 'Je suis un post / billet de remplissage de la table.', '2023-09-30'),
(17, 7, 'Remplissage', 'Je suis un post / billet de remplissage de la table.', '2023-09-30'),
(18, 8, 'Remplissage', 'Je suis un post / billet de remplissage de la table.', '2023-09-30'),
(19, 10, 'Remplissage', 'Je suis un post / billet de remplissage de la table.', '2023-09-30'),
(20, 11, 'Remplissage', 'Je suis un post / billet de remplissage de la table.', '2023-09-30'),
(21, 5, 'Remplissage', 'Je suis un post / billet de remplissage de la table.', '2023-09-30');

-- --------------------------------------------------------

--
-- Dumping data for table `belongs_to`
--

INSERT INTO `belongs_to` (`POST_ID`, `TOPIC_ID`) VALUES
(0, 0),
(0, 1),
(0, 2),
(1, 0),
(2, 0),
(3, 0),
(3, 1),
(4, 0),
(4, 1),
(5, 0),
(5, 1),
(6, 0),
(6, 1),
(7, 0),
(8, 0),
(9, 0),
(10, 2),
(15, 2),
(17, 2),
(18, 3);

-- --------------------------------------------------------

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`COMMENT_ID`, `POST_ID`, `USER_ID`, `CONTENT`, `DATE_POSTED`) VALUES
(0, 0, 1, 'Hello back !', '2023-09-30'),
(1, 0, 1, 'Hello again', '2023-09-30'),
(3, 4, 1, 'Test suppr cascade post', '2023-09-30'),
(4, 0, 1, 'Blue da ba dee', '2023-09-30');

-- --------------------------------------------------------

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`POST_ID`, `USER_ID`) VALUES
(0, 0),
(0, 8),
(0, 9),
(1, 1),
(2, 6),
(2, 7),
(2, 8),
(5, 0),
(5, 1),
(5, 2),
(5, 3),
(5, 4),
(5, 5),
(12, 10),
(12, 11),
(15, 10),
(20, 10);

-- --------------------------------------------------------

--
-- Dumping data for table `follows`
--

INSERT INTO `follows` (`USER_ID_FOLLOWER`, `USER_ID_FOLLOWED`, `SINCE_WHEN`) VALUES
(0, 1, '2023-10-06'),
(1, 0, '2023-10-06'),
(2, 0, '2023-10-06'),
(3, 0, '2023-10-06'),
(3, 4, '2023-10-06'),
(4, 1, '2023-10-06'),
(8, 2, '2023-10-06'),
(9, 0, '2023-10-06'),
(9, 4, '2023-10-06'),
(10, 1, '2023-10-06'),
(11, 1, '2023-10-06');

-- --------------------------------------------------------

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`POST_ID`, `USER_ID`) VALUES
(0, 0),
(2, 0),
(6, 0),
(7, 0),
(8, 0),
(9, 0),
(10, 0),
(11, 0),
(12, 0),
(14, 0),
(0, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(8, 2),
(9, 2),
(10, 2),
(11, 2),
(7, 3),
(10, 3),
(7, 4),
(10, 4),
(7, 5),
(10, 5),
(6, 6),
(10, 6);

-- --------------------------------------------------------
