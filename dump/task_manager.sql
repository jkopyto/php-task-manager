-- SQL DUMP
USE task_manager;

-- ALTER DATABASE task_manager DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

SET NAMES 'utf8';

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


CREATE TABLE `tbl_lists` (
  `list_id` int(10) UNSIGNED NOT NULL,
  `list_name` varchar(50) NOT NULL,
  `list_description` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

INSERT INTO `tbl_lists` (`list_id`, `list_name`, `list_description`) VALUES
(1, 'Praca', 'Rzeczy do zrobienia w pracy'),
(2, 'Dom', 'Prace domowe'),
(3, 'Ogród', 'Pielęgnacja ogrodu'),
(7, 'Zakupy', 'Lista zakupów');

CREATE TABLE `tbl_tasks` (
  `task_id` int(10) UNSIGNED NOT NULL,
  `task_name` varchar(150) NOT NULL,
  `task_description` text NOT NULL,
  `list_id` int(11) NOT NULL,
  `priority` varchar(10) NOT NULL,
  `deadline` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;


INSERT INTO `tbl_tasks` (`task_id`, `task_name`, `task_description`, `list_id`, `priority`, `deadline`) VALUES
(2, 'Złożyć zamówienie na papier', 'Bardzo pilne', 1, 'Wysoki', '2021-06-03'),
(3, 'Wyplewić grządki', 'za dużo chwastów', 3, 'Średni', '2021-06-12'),
(4, 'Wystawić fakturę', 'Trzeba za coś żyć :)', 1, 'Średni', '2021-06-11'),
(5, 'Zadzwonić do klienta', 'Zadzwonić w sprawie ubezpieczenia', 1, 'Niski', '2021-07-03'),
(6, 'Pozmywać naczynia', 'Wieczorem przychodzą goście', 2, 'Średni', '2021-06-19'),
(7, 'Przyciąć tuje', 'Są już zbyt wysokie', 3, 'Niski', '2021-06-26'),
(8, 'Przygotować opis projektu', 'Nowy projekt', 1, 'Średni', '2021-06-18');

ALTER TABLE `tbl_lists`
  ADD PRIMARY KEY (`list_id`);

ALTER TABLE `tbl_tasks`
  ADD PRIMARY KEY (`task_id`);

ALTER TABLE `tbl_lists`
  MODIFY `list_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

ALTER TABLE `tbl_tasks`
  MODIFY `task_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;
