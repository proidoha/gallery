-- phpMyAdmin SQL Dump
-- version 4.0.10.10
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Дек 27 2016 г., 23:44
-- Версия сервера: 5.5.45
-- Версия PHP: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `gallery`
--

-- --------------------------------------------------------

--
-- Структура таблицы `gal_comments`
--

CREATE TABLE IF NOT EXISTS `gal_comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `img_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_image_id_idx` (`img_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Дамп данных таблицы `gal_comments`
--

INSERT INTO `gal_comments` (`id`, `content`, `img_id`) VALUES
(17, 'Классная фотка!', 1),
(18, 'Ещё один великолепный комментарий.', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `gal_images`
--

CREATE TABLE IF NOT EXISTS `gal_images` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `src` varchar(255) NOT NULL,
  `mini` varchar(250) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=144 ;

--
-- Дамп данных таблицы `gal_images`
--

INSERT INTO `gal_images` (`id`, `src`, `mini`, `title`, `description`) VALUES
(1, 'upload/0_8dc49_f4fefd1d_XL.jpeg', 'upload/mini/0_8dc49_f4fefd1d_XL.jpeg', '', NULL),
(134, 'upload/dzen.jpg', 'upload/mini/dzen.jpg', '', NULL);

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `gal_comments`
--
ALTER TABLE `gal_comments`
  ADD CONSTRAINT `fk_image_id` FOREIGN KEY (`img_id`) REFERENCES `gal_images` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
