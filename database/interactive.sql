-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 01, 2025 at 09:28 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `interactive`
--

-- --------------------------------------------------------

--
-- Table structure for table `choices`
--

CREATE TABLE `choices` (
  `id` int(11) NOT NULL,
  `story_id` int(11) NOT NULL,
  `choice_text` varchar(255) NOT NULL,
  `next_part` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `choices`
--

INSERT INTO `choices` (`id`, `story_id`, `choice_text`, `next_part`) VALUES
(1, 1, 'go left', 1),
(2, 1, 'go right', 2),
(3, 1, 'monster', 1),
(4, 1, 'devil', 1);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `username`, `message`, `timestamp`) VALUES
(1, 'ss', 'hii', '2025-06-21 03:22:37'),
(2, 'Jimmy', 'I am happy', '2025-06-21 04:42:14');

-- --------------------------------------------------------

--
-- Table structure for table `page_names`
--

CREATE TABLE `page_names` (
  `id` int(11) NOT NULL,
  `page_name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `parts`
--

CREATE TABLE `parts` (
  `id` int(11) NOT NULL,
  `story_id` int(11) NOT NULL,
  `dialogue` text NOT NULL,
  `next_part` int(11) DEFAULT NULL,
  `is_end` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stories`
--

CREATE TABLE `stories` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `creator_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stories`
--

INSERT INTO `stories` (`id`, `title`, `description`, `creator_id`) VALUES
(1, 'world war', 'soilder fighting ', 1),
(2, 'fairy tale', 'hjddwhkdwkdwkjd', 1),
(3, 'fairy', 'jkdsjdjkjsdkjd', 1);

-- --------------------------------------------------------

--
-- Table structure for table `story_options`
--

CREATE TABLE `story_options` (
  `id` int(11) NOT NULL,
  `story_id` int(11) DEFAULT NULL,
  `option_text` varchar(255) DEFAULT NULL,
  `next_story_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `story_options`
--

INSERT INTO `story_options` (`id`, `story_id`, `option_text`, `next_story_id`) VALUES
(1, 1, 'go left', 1),
(2, 1, 'go right', 2),
(3, 1, 'no go', 1);

-- --------------------------------------------------------

--
-- Table structure for table `unlocked_characters`
--

CREATE TABLE `unlocked_characters` (
  `id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `character_image` varchar(100) DEFAULT NULL,
  `character_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `unlocked_characters`
--

INSERT INTO `unlocked_characters` (`id`, `username`, `character_image`, `character_name`) VALUES
(1, 'adu', 'character1.png', 'Adarsh'),
(2, 'adu', 'character2.png', 'Vikash'),
(3, 'mota', 'character2.png', 'Vikash'),
(4, 'ok', 'character1.png', 'Adarsh'),
(5, 'ok', 'character2.png', 'Vikash'),
(6, 'chota', 'character1.png', 'Adarsh'),
(7, 'chota', 'character2.png', 'vikash'),
(8, 'chota', 'kane.png', 'kane'),
(9, 'vk', 'character1.png', 'Adarsh'),
(10, 'vk', 'character2.png', 'vikash'),
(11, 'vk', 'kane.png', 'kane'),
(12, 'vk', 'Queen.png', 'Queen Gladrial'),
(13, 'ABCD', 'character2.png', 'Rodrick'),
(14, 'ABCD', 'overview2.png', 'Adam: The Sorcerer'),
(15, 'ABCD', 'character1.png', 'Valen'),
(16, 'qaz', 'character2.png', 'Rodrick'),
(17, 'qaz', 'overview2.jpeg', 'Adam: The Sorcerer'),
(18, 'qaz', 'character1.png', 'Valen'),
(19, 'qaz', 'Kane.png', 'Kane'),
(20, 'qaz', 'Goblin.png', 'Goblin King'),
(21, 'vk', 'Goblin.png', 'Goblin King'),
(22, 'qaz', 'wizardOrin.png', 'Orin'),
(23, 'qaz', 'Queen.png', 'Queen Gladrial'),
(24, 'pk', 'character2.png', 'Rodrick'),
(25, 'pk', 'overview2.jpeg', 'Adam: The Sorcerer'),
(26, 'pk', 'character1.png', 'Valen'),
(27, 'pk', 'Kane.png', 'Kane'),
(28, 'ss', 'character2.png', 'Rodrick'),
(29, 'ss', 'overview2.jpeg', 'Adam: The Sorcerer'),
(30, 'ss', 'character1.png', 'Valen'),
(31, 'ss', 'Kane.png', 'Kane'),
(32, 'Jimmy', 'character2.png', 'Rodrick'),
(33, 'Jimmy', 'overview2.jpeg', 'Adam: The Sorcerer'),
(34, 'Jimmy', 'character1.png', 'Valen'),
(35, 'Jimmy', 'Kane.png', 'Kane'),
(36, 'Jimmy', 'Goblin.png', 'Goblin King');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `page_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`, `page_name`) VALUES
(1, 'adarsh', 'AK@GMAIL.COM', '$2y$10$iqDB/j65JVppYIeI7ANuoeRdlIu5yq1WG5NzcIFY5DOqCzqlUi1NO', '2025-01-03 11:22:38', 'scene1.php'),
(3, 'star', 'star@gmail.com', '$2y$10$gkNDfxTuiMD9pmFf837fu.5kwmvPBnZ6wf.3UlEAAA0ztImokQ1Wy', '2025-01-09 06:14:45', 'scene1.php'),
(4, 'Larry', 'larry@gmail.com', '$2y$10$LpkB74o6b1fceZ8Fqb.qRueTbZxjLD0bWCV8bW8Bst/IwuyVovUNK', '2025-01-09 06:33:42', NULL),
(5, 'starPrince', 'vikashmahto192@gmail.com', '$2y$10$2VE63MrIghnfrKNzwvDmR.aKoEgL/LQSvDWtXuxpeo33pH8aWc00m', '2025-01-09 14:19:55', 'scene1.php'),
(6, 'Star Prince', 'starprince999@gmail.com', '$2y$10$ldoCtzjZHQ0TK9.31t.BouJk1v9EQE0FfWyArhXc7CaJKYltGDxNi', '2025-04-27 08:58:25', 'scene3.1.php'),
(7, 'Sujoyde', 'sujoy@gmail.com', '$2y$10$14DI.tpNfCVN7Nn1QOXBTe35f0A3KFZX2ZR9ytwUaLETLGxQYsy7S', '2025-05-14 07:18:09', 'scene3.2.php'),
(8, 'Star Prince', 'xyz@gmail.com', '$2y$10$DfZ/VVrM298djG3BBUYpnOruPNfi5VyeL1ABO/Zk9RaoLK3rnPyim', '2025-05-16 14:50:47', NULL),
(10, 'Vikash', 'xyz123@gmail.com', '$2y$10$YOYWCk9iOJ7iDYU/uYGcM.kc/kCfAsnWvBtWGaoKCnlf3dZ73aRru', '2025-05-16 14:51:31', NULL),
(11, 'Ankit', 'animerocking@gmail.com', '$2y$10$O8sHBGbxR3O7QDy4AjYZa.DRSjeDa3QW/CPkPkdeeEb1Pbwr1kPtS', '2025-06-03 13:54:02', 'scene3.1.php'),
(13, 'John', 'xyz1@gmail.com', '$2y$10$Twvvn6oMDcyvrLfqp3hfee3cXUuOcW5PqA0JBTIsXOy873Ffe7uGW', '2025-06-17 08:03:32', NULL),
(14, 'adu', 'adu@gmail.com', '$2y$10$9/fnHNB0qmV1PQhw8hO0Ue8XnTsGyoVsf/E25kcnbdvL2mcmAsD8q', '2025-06-20 10:50:10', 'scene2.1.php'),
(15, 'mota', 'mota@gmail.com', '$2y$10$iOuQre/S4ATeJLV19tTDruKHj7pFrXjhCFuLUQ4JncrBvVF0FQ61i', '2025-06-20 11:20:30', 'scene2.1.php'),
(16, 'ok', 'ok@gmail.com', '$2y$10$yR9P2.yXPNd8XO/SQomqXeqKunsruANqqxFcEbn.X0rTFNKfceyRK', '2025-06-20 11:35:53', 'scene2.1.php'),
(17, 'chota', 'c@gmail.com', '$2y$10$RgPkoZQ2TO6Bwgs8wfTUtuUH9oi5fwoB/9etSvo738Tc3AWLhiCiq', '2025-06-20 11:43:23', 'scene2.1.php'),
(18, 'vk', 'v@gmail.com', '$2y$10$RouAgMmFi.LOs1X625gwWekPJJ6RQw9Os06oIr3pR/HYVSQgXS/g.', '2025-06-20 13:01:41', 'scene2.1.php'),
(19, 'ABCD', 'abc@gmail.com', '$2y$10$Gh0q91h6xfGcxpWTIfYSv.VPyMxKxr.TbBw2MCMVmPQ98yqT43SaG', '2025-06-20 15:33:12', 'scene1.php'),
(20, 'qaz', 'qaz@gmail.com', '$2y$10$7SNeEoaj40PrJ84lWFCgX.F2VgeVWmqiXOxmeQQV9IRDj1bxiSJl.', '2025-06-20 15:34:57', 'scene2.2.php'),
(21, 'pk', 'pk@gmail.com', '$2y$10$OoHWtqtxLLM.B5SddJPZpOjDKWL/7kBAXHYJvoM5Bd6mKm23v1zIS', '2025-06-20 16:14:15', 'scene3.2.php'),
(23, 'ss', 's@gmail.com', '$2y$10$aQO2tJq4UKSLBPfVZm6Uvespug6wyAEOiwWISmBRHgJARYnlKzITi', '2025-06-21 03:01:12', 'scene3.2.php'),
(24, 'wwe', 'wwe@gmail.com', '$2y$10$oZYucrtCKaqlCdU4AAW.Fu7j//gLKmdHLWQ4WJcjV50HjKW7qH9Bm', '2025-06-21 04:38:46', NULL),
(25, 'Jimmy', 'jimmy@gmail.com', '$2y$10$y5ZRCNO2G55LwdidbSU/Re9YtDJ6kObre/PX1PGMvcbfOHxD9sJf2', '2025-06-21 04:41:41', 'scene2.1.php');

-- --------------------------------------------------------

--
-- Table structure for table `user_stories`
--

CREATE TABLE `user_stories` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `story_title` varchar(255) DEFAULT NULL,
  `story_text` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_stories`
--

INSERT INTO `user_stories` (`id`, `user_id`, `story_title`, `story_text`) VALUES
(1, 1, 'fairy', 'kgukgdhkfwkwkfkhwefkh');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `choices`
--
ALTER TABLE `choices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `story_id` (`story_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `page_names`
--
ALTER TABLE `page_names`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parts`
--
ALTER TABLE `parts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `story_id` (`story_id`);

--
-- Indexes for table `stories`
--
ALTER TABLE `stories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `story_options`
--
ALTER TABLE `story_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `story_id` (`story_id`);

--
-- Indexes for table `unlocked_characters`
--
ALTER TABLE `unlocked_characters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_stories`
--
ALTER TABLE `user_stories`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `choices`
--
ALTER TABLE `choices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `page_names`
--
ALTER TABLE `page_names`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `parts`
--
ALTER TABLE `parts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stories`
--
ALTER TABLE `stories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `story_options`
--
ALTER TABLE `story_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `unlocked_characters`
--
ALTER TABLE `unlocked_characters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `user_stories`
--
ALTER TABLE `user_stories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `choices`
--
ALTER TABLE `choices`
  ADD CONSTRAINT `choices_ibfk_1` FOREIGN KEY (`story_id`) REFERENCES `stories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `parts`
--
ALTER TABLE `parts`
  ADD CONSTRAINT `parts_ibfk_1` FOREIGN KEY (`story_id`) REFERENCES `stories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `story_options`
--
ALTER TABLE `story_options`
  ADD CONSTRAINT `story_options_ibfk_1` FOREIGN KEY (`story_id`) REFERENCES `user_stories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
