-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 17 May 2025, 09:59:59
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `obs_veritabani`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `absences`
--

CREATE TABLE `absences` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `type` enum('tam','yarim','ozurlu') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `absences`
--

INSERT INTO `absences` (`id`, `student_id`, `date`, `type`) VALUES
(3, 3, '2025-01-01', 'tam'),
(6, 8, '2025-05-10', 'yarim'),
(8, 10, '2025-05-11', 'tam'),
(11, 10, '2025-05-11', 'ozurlu'),
(15, 10, '2025-05-17', 'tam');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `class`
--

CREATE TABLE `class` (
  `id` int(11) NOT NULL,
  `class_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `class`
--

INSERT INTO `class` (`id`, `class_name`) VALUES
(1, '4-B');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `grades`
--

CREATE TABLE `grades` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `exam1` int(11) DEFAULT NULL,
  `exam2` int(11) DEFAULT NULL,
  `performance` int(11) DEFAULT NULL,
  `average` float GENERATED ALWAYS AS ((`exam1` + `exam2` + `performance`) / 3) STORED,
  `teacher_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `grades`
--

INSERT INTO `grades` (`id`, `student_id`, `subject`, `exam1`, `exam2`, `performance`, `teacher_id`) VALUES
(12, 8, 'Türkçe', 33, 27, 82, 8),
(14, 10, 'Türkçe', 100, 50, 50, 8),
(19, 10, 'Fizik', 50, 20, 15, 8),
(20, 10, 'Kimya', 70, 50, NULL, 8),
(27, 3, 'Türkçe', 50, 50, 50, 8);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `student_no` varchar(20) NOT NULL,
  `class` varchar(10) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `students`
--

INSERT INTO `students` (`id`, `user_id`, `name`, `student_no`, `class`, `class_id`) VALUES
(3, 8, 'Öğrenci 1', '100', '1-B', 1),
(8, 13, 'Öğrenci 2', '105', '1-C', NULL),
(10, 22, 'Ögrenci 3 ', '106', '1-A', NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `teachers`
--

CREATE TABLE `teachers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `branch` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `teachers`
--

INSERT INTO `teachers` (`id`, `user_id`, `name`, `branch`) VALUES
(8, 17, 'Öğretmen 1', 'Türkçe');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('mudur','ogretmen','ogrenci') NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'burak', '$2y$10$vnn2omE7OskEZKvJLo4SuO5EZ7Hzmxw4V6OpZgs3YLAEpBRJGLmIC', 'mudur', '2025-05-17 00:52:11'),
(8, 'ör1', '$2y$10$W0BDLC27xX0ktV2DFsPKd./TJPUnlDnp3QJGc4DhqVyv5IkeIMEwO', 'ogrenci', '2025-05-17 00:52:11'),
(13, 'ör2', '$2y$10$H1fFpp.LriAzb.37Npr.I.IIM6P6qipNUEiIi0wXd6LwI/DG7Scty', 'ogrenci', '2025-05-17 00:52:11'),
(17, 'ögr1', '$2y$10$QBafEtFS3SAPUL9QkpLQAufz3modQs0S974aJDxMTIPlxvnxE6vFm', 'ogretmen', '2025-05-17 00:52:11'),
(22, 'ör3', '$2y$10$g8QiuQFHhvcgenVwxHNBp.oYJ9eKVzh4efnks5FLb/BZsoHoTbWdG', 'ogrenci', '2025-05-17 00:52:11');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `absences`
--
ALTER TABLE `absences`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Tablo için indeksler `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Tablo için indeksler `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_no` (`student_no`),
  ADD KEY `user_id` (`user_id`);

--
-- Tablo için indeksler `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `absences`
--
ALTER TABLE `absences`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Tablo için AUTO_INCREMENT değeri `class`
--
ALTER TABLE `class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `grades`
--
ALTER TABLE `grades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Tablo için AUTO_INCREMENT değeri `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Tablo için AUTO_INCREMENT değeri `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `absences`
--
ALTER TABLE `absences`
  ADD CONSTRAINT `absences_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `grades_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `grades_ibfk_2` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE SET NULL;

--
-- Tablo kısıtlamaları `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `teachers`
--
ALTER TABLE `teachers`
  ADD CONSTRAINT `teachers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
