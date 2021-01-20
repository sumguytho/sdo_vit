--
-- Скрипт сгенерирован Devart dbForge Studio 2019 for MySQL, Версия 8.2.23.0
-- Домашняя страница продукта: http://www.devart.com/ru/dbforge/mysql/studio
-- Дата скрипта: 20.01.2021 11:39:59
-- Версия сервера: 5.5.25
-- Версия клиента: 4.1
--

-- 
-- Отключение внешних ключей
-- 
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;

-- 
-- Установить режим SQL (SQL mode)
-- 
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- 
-- Установка кодировки, с использованием которой клиент будет посылать запросы на сервер
--
SET NAMES 'utf8';

DROP DATABASE IF EXISTS sdo_vit;

CREATE DATABASE IF NOT EXISTS sdo_vit
CHARACTER SET utf8
COLLATE utf8_general_ci;

--
-- Установка базы данных по умолчанию
--
USE sdo_vit;

--
-- Создать таблицу `group`
--
CREATE TABLE IF NOT EXISTS `group` (
  groupId int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  name varchar(50) NOT NULL,
  PRIMARY KEY (groupId)
)
ENGINE = INNODB,
AUTO_INCREMENT = 3,
AVG_ROW_LENGTH = 8192,
CHARACTER SET utf8,
COLLATE utf8_general_ci;

DELIMITER $$

--
-- Создать процедуру `getUserByLogin`
--
CREATE DEFINER = 'root'@'localhost'
PROCEDURE getUserByLogin (IN login varchar(20))
BEGIN
  SELECT
    user.*,
    `group`.name AS groupname
  FROM user
    INNER JOIN `group`
      ON user.groupId = `group`.groupId
  WHERE user.login = login LIMIT 1;
END
$$

DELIMITER ;

--
-- Создать таблицу `user`
--
CREATE TABLE IF NOT EXISTS user (
  idUser int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  name varchar(15) NOT NULL,
  surname varchar(15) NOT NULL,
  middlename varchar(15) NOT NULL,
  birthdate date NOT NULL,
  studentNumber int(11) NOT NULL,
  mail varchar(50) NOT NULL,
  password varchar(16) NOT NULL,
  login varchar(15) NOT NULL,
  permissions enum ('0', '1', '2', '3') NOT NULL COMMENT '
0 - администратор
1 - преподаватель
2 - студент
3 - пользователь без входа',
  groupId int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (idUser)
)
ENGINE = INNODB,
AUTO_INCREMENT = 8,
AVG_ROW_LENGTH = 8192,
CHARACTER SET utf8,
COLLATE utf8_general_ci;

--
-- Создать внешний ключ
--
ALTER TABLE user
ADD CONSTRAINT FK_user_group_groupId FOREIGN KEY (groupId)
REFERENCES `group` (groupId);

--
-- Создать таблицу `desk`
--
CREATE TABLE IF NOT EXISTS desk (
  deskId int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  name varchar(50) NOT NULL,
  userId int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (deskId)
)
ENGINE = INNODB,
AUTO_INCREMENT = 3,
AVG_ROW_LENGTH = 16384,
CHARACTER SET utf8,
COLLATE utf8_general_ci;

--
-- Создать внешний ключ
--
ALTER TABLE desk
ADD CONSTRAINT FK_desk_user_idUser FOREIGN KEY (userId)
REFERENCES user (idUser);

--
-- Создать таблицу `task`
--
CREATE TABLE IF NOT EXISTS task (
  taskId int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  deskId int(10) UNSIGNED NOT NULL,
  name varchar(50) NOT NULL,
  description varchar(255) DEFAULT NULL,
  date datetime NOT NULL,
  PRIMARY KEY (taskId)
)
ENGINE = INNODB,
AUTO_INCREMENT = 9,
AVG_ROW_LENGTH = 16384,
CHARACTER SET utf8,
COLLATE utf8_general_ci;

--
-- Создать внешний ключ
--
ALTER TABLE task
ADD CONSTRAINT FK_task_desk_deskId FOREIGN KEY (deskId)
REFERENCES desk (deskId);

--
-- Создать таблицу `attachment`
--
CREATE TABLE IF NOT EXISTS attachment (
  attachmentId int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  userId int(10) UNSIGNED NOT NULL,
  taskId int(10) UNSIGNED NOT NULL,
  date datetime NOT NULL,
  mark tinyint(1) NOT NULL,
  PRIMARY KEY (attachmentId)
)
ENGINE = INNODB,
CHARACTER SET utf8,
COLLATE utf8_general_ci;

--
-- Создать внешний ключ
--
ALTER TABLE attachment
ADD CONSTRAINT FK_attachment_task_taskId FOREIGN KEY (taskId)
REFERENCES task (taskId);

--
-- Создать внешний ключ
--
ALTER TABLE attachment
ADD CONSTRAINT FK_attachment_user_idUser FOREIGN KEY (userId)
REFERENCES user (idUser);

--
-- Создать таблицу `answer`
--
CREATE TABLE IF NOT EXISTS answer (
  id int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  answer varchar(255) DEFAULT NULL,
  userId int(10) UNSIGNED NOT NULL,
  taskId int(10) UNSIGNED NOT NULL,
  approve tinyint(1) DEFAULT NULL,
  PRIMARY KEY (id)
)
ENGINE = INNODB,
AUTO_INCREMENT = 17,
AVG_ROW_LENGTH = 1260,
CHARACTER SET utf8,
COLLATE utf8_general_ci;

--
-- Создать внешний ключ
--
ALTER TABLE answer
ADD CONSTRAINT FK_answer_user_idUser FOREIGN KEY (userId)
REFERENCES user (idUser) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Создать внешний ключ
--
ALTER TABLE answer
ADD CONSTRAINT FK_file_task_taskId FOREIGN KEY (taskId)
REFERENCES task (taskId) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Создать таблицу `desk_membership`
--
CREATE TABLE IF NOT EXISTS desk_membership (
  deskMembershipId int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  deskId int(10) UNSIGNED NOT NULL,
  groupId int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (deskMembershipId)
)
ENGINE = INNODB,
AUTO_INCREMENT = 3,
AVG_ROW_LENGTH = 16384,
CHARACTER SET utf8,
COLLATE utf8_general_ci;

--
-- Создать внешний ключ
--
ALTER TABLE desk_membership
ADD CONSTRAINT FK_desk_membership_desk_deskId FOREIGN KEY (deskId)
REFERENCES desk (deskId);

--
-- Создать внешний ключ
--
ALTER TABLE desk_membership
ADD CONSTRAINT FK_desk_membership_group_groupId FOREIGN KEY (groupId)
REFERENCES `group` (groupId);

DELIMITER $$

--
-- Создать процедуру `getDesks`
--
CREATE DEFINER = 'root'@'localhost'
PROCEDURE getDesks (IN userId int, IN groupId int)
BEGIN
  SELECT
    *
  FROM desk
  WHERE desk.userId = userId
  OR deskId IN (SELECT
      deskId
    FROM desk_membership dm
    WHERE dm.groupId = groupId);
END
$$

DELIMITER ;

--
-- Создать таблицу `chat`
--
CREATE TABLE IF NOT EXISTS chat (
  chatId int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  creationDate datetime NOT NULL,
  name varchar(50) NOT NULL,
  PRIMARY KEY (chatId)
)
ENGINE = INNODB,
AUTO_INCREMENT = 27,
AVG_ROW_LENGTH = 1170,
CHARACTER SET utf8,
COLLATE utf8_general_ci;

--
-- Создать таблицу `message`
--
CREATE TABLE IF NOT EXISTS message (
  messageId int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  chatId int(10) UNSIGNED NOT NULL,
  userId int(10) UNSIGNED NOT NULL,
  content varchar(255) NOT NULL,
  date datetime NOT NULL,
  PRIMARY KEY (messageId)
)
ENGINE = INNODB,
AUTO_INCREMENT = 53,
AVG_ROW_LENGTH = 512,
CHARACTER SET utf8,
COLLATE utf8_general_ci;

--
-- Создать внешний ключ
--
ALTER TABLE message
ADD CONSTRAINT FK_message_chat_chatId FOREIGN KEY (chatId)
REFERENCES chat (chatId);

--
-- Создать внешний ключ
--
ALTER TABLE message
ADD CONSTRAINT FK_message_user_idUser FOREIGN KEY (userId)
REFERENCES user (idUser);

--
-- Создать таблицу `chat_membership`
--
CREATE TABLE IF NOT EXISTS chat_membership (
  chatMembershipId int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  userId int(10) UNSIGNED NOT NULL,
  chatId int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (chatMembershipId)
)
ENGINE = INNODB,
AUTO_INCREMENT = 55,
AVG_ROW_LENGTH = 1024,
CHARACTER SET utf8,
COLLATE utf8_general_ci;

--
-- Создать внешний ключ
--
ALTER TABLE chat_membership
ADD CONSTRAINT FK_chat_membership_chat_chatId FOREIGN KEY (chatId)
REFERENCES chat (chatId);

--
-- Создать внешний ключ
--
ALTER TABLE chat_membership
ADD CONSTRAINT FK_chat_membership_user_idUser FOREIGN KEY (userId)
REFERENCES user (idUser);

DELIMITER $$

--
-- Создать процедуру `getUserType`
--
CREATE DEFINER = 'root'@'localhost'
PROCEDURE getUserType (IN login varchar(20))
BEGIN
  DECLARE perm int;
  SET perm = 2;
  SELECT
    permissions INTO perm
  FROM sdo_vit.user
  WHERE user.login = login LIMIT 1;
  CASE perm
    WHEN 2 THEN SELECT
          'teacher';
    WHEN 1 THEN SELECT
          'user';
    WHEN 0 THEN SELECT
          'admin';
    ELSE SELECT
        'registered';
  END CASE;
END
$$

--
-- Создать процедуру `authUser`
--
CREATE DEFINER = 'root'@'localhost'
PROCEDURE authUser (IN data varchar(20), IN password varchar(16), IN paramtype varchar(5))
BEGIN
  DECLARE ack int;
  SET ack = 0;
  IF paramtype = 'mail' THEN
    SELECT
      idUser INTO ack
    FROM user
    WHERE user.mail = data
    AND user.password = SUBSTRING(MD5(password), 1, 16)
    AND user.permissions <> '3' LIMIT 1;
  ELSEIF paramtype = 'login' THEN
    SELECT
      idUser INTO ack
    FROM user
    WHERE user.login = data
    AND user.password = SUBSTRING(MD5(password), 1, 16)
    AND user.permissions <> '3' LIMIT 1;
  END IF;
  SELECT
    ack;
END
$$

--
-- Создать процедуру `addUser`
--
CREATE DEFINER = 'root'@'localhost'
PROCEDURE addUser (IN name varchar(20), IN surname varchar(20), IN middlename varchar(20), IN birthdate date, IN studentNumber int(6), IN mail varchar(50), IN password varchar(16), IN login varchar(20), IN permissions enum ('0', '1', '2'), IN groupname varchar(8))
BEGIN
  DECLARE grpid int(11);
  SET grpid = 0;
  SET permissions = '3';
  SELECT
    groupId INTO grpid
  FROM sdo_vit.group
  WHERE sdo_vit.group.name = groupname LIMIT 1;
  IF grpid = 0 THEN
    SELECT
      0 AS res;
  ELSE
    INSERT INTO user (name, surname, middlename, birthdate, studentNumber, mail, password, login, permissions, groupId)
      VALUES (name, surname, middlename, birthdate, studentNumber, mail, MD5(password), login, permissions, grpid);
    SELECT
      1 AS res;
  END IF;
END
$$

DELIMITER ;

-- 
-- Вывод данных для таблицы `group`
--
INSERT INTO `group` VALUES
(1, 'ВИП-408'),
(2, 'ВВТ-406');

-- 
-- Вывод данных для таблицы user
--
INSERT INTO user VALUES
(2, 'Иван', 'Цветков', 'Андреевич', '2020-12-24', 123456, 'll@mm.ru', '81dc9bdb52d04dc2', 'wau', '2', 1),
(3, 'root', 'root', 'root', '2020-12-17', 0, 'L', '81dc9bdb52d04dc2', 'root', '0', 2),
(4, 'Вовен', 'Гериханов', 'Русланович', '2021-01-14', 123123, 'hackermanfromhell@gmail.com', '81dc9bdb52d04dc2', 'prep', '0', 1),
(5, 'Александр', 'Волков', 'Александрович', '2021-01-20', 123123, 'hackermanfromhell@gmail.com', '81dc9bdb52d04dc2', 'qwe', '1', 1),
(6, 'asd', 'asd', 'asd', '2020-12-31', 213123, 'asd', '81dc9bdb52d04dc2', 'zxc', '2', 2),
(7, 'Юрий', 'Мадрасов', 'Викторович', '1999-03-07', 170051, 'dr.cs@ya.ru', '81dc9bdb52d04dc2', 'yurim', '2', 1);

-- 
-- Вывод данных для таблицы desk
--
INSERT INTO desk VALUES
(1, 'доска1', 3),
(2, 'доска2', 5);

-- 
-- Вывод данных для таблицы chat
--
INSERT INTO chat VALUES
(5, '2021-01-13 22:18:29', 'all'),
(7, '2021-01-14 04:03:45', 'gyy'),
(8, '2021-01-14 04:05:33', 'hjggh'),
(10, '2021-01-14 04:12:20', 'fgh'),
(11, '2021-01-14 04:12:32', 'jhgh'),
(13, '2021-01-14 04:13:09', 'asss'),
(14, '2021-01-14 04:42:53', 'ertret'),
(16, '2021-01-14 04:51:41', '65656'),
(19, '2021-01-14 05:00:11', 'первый чат'),
(20, '2021-01-14 05:00:27', 'Второй чаи'),
(21, '2021-01-14 07:37:47', ''),
(22, '2021-01-14 07:38:17', 'новый чат'),
(23, '2021-01-14 08:23:45', ''),
(24, '2021-01-14 08:29:50', 'Somechat'),
(26, '2020-06-01 00:00:00', 'cht1');

-- 
-- Вывод данных для таблицы task
--
INSERT INTO task VALUES
(1, 1, 'название1', 'описание', '2021-01-14 00:00:00'),
(2, 1, 'rytrtyr', 'rtyrty', '2021-01-19 00:00:00'),
(3, 1, 'sdf', 'sdf', '2021-01-16 00:00:00'),
(4, 1, 'xcv', 'xcv', '2021-01-05 00:00:00'),
(5, 1, 'sdf', 'xccv', '2021-01-10 00:00:00'),
(6, 2, 'Задание 1', 'Описание задания', '2021-01-23 00:00:00'),
(7, 1, 'gggh', 'ghj', '2021-01-22 00:00:00'),
(8, 1, 'task', 'new task', '2022-04-07 00:00:00');

-- 
-- Вывод данных для таблицы message
--
INSERT INTO message VALUES
(14, 5, 5, 'etert', '2021-01-14 04:03:23'),
(15, 5, 5, 'etertrtyrt', '2021-01-14 04:03:24'),
(16, 5, 5, 'etertrtyrt', '2021-01-14 04:03:25'),
(18, 11, 5, 'asdasd', '2021-01-14 04:13:23'),
(19, 7, 5, 'asdasd', '2021-01-14 04:13:26'),
(20, 8, 5, 'asdasd', '2021-01-14 04:13:29'),
(21, 8, 5, 'asdasd', '2021-01-14 04:13:29'),
(22, 8, 5, 'asdasd', '2021-01-14 04:13:30'),
(23, 8, 5, 'fgdfg', '2021-01-14 04:17:57'),
(24, 5, 5, 'ssdfsdf', '2021-01-14 04:21:23'),
(25, 5, 5, 'asdasd', '2021-01-14 04:23:23'),
(26, 5, 5, 'asd', '2021-01-14 04:23:30'),
(27, 5, 5, 'asdasd', '2021-01-14 04:24:48'),
(28, 5, 5, 'qweqweqwe', '2021-01-14 04:28:18'),
(29, 5, 5, 'dfgdfg', '2021-01-14 04:28:23'),
(30, 5, 5, 'qweqweqwe', '2021-01-14 04:28:29'),
(31, 5, 5, 'qweqweqwe', '2021-01-14 04:28:31'),
(32, 5, 5, 'dfgdfg', '2021-01-14 04:28:32'),
(33, 5, 5, 'tyrtyrtyrty', '2021-01-14 04:38:49'),
(34, 10, 4, 'sdf', '2021-01-14 04:40:19'),
(35, 13, 4, 'Чат создан!', '2021-01-14 04:51:29'),
(36, 16, 4, 'asd', '2021-01-14 04:51:46'),
(37, 16, 4, 'asdsdf', '2021-01-14 04:51:48'),
(38, 19, 4, 'Чат создан!', '2021-01-14 05:00:11'),
(39, 20, 4, 'Чат создан!', '2021-01-14 05:00:27'),
(40, 20, 5, 'фыв', '2021-01-14 05:00:37'),
(41, 20, 4, 'ываыв', '2021-01-14 05:00:41'),
(42, 21, 5, 'Чат создан!', '2021-01-14 07:37:47'),
(43, 20, 5, 'новый', '2021-01-14 07:38:01'),
(44, 22, 5, 'Чат создан!', '2021-01-14 07:38:17'),
(45, 23, 3, 'Чат создан!', '2021-01-14 08:23:45'),
(46, 24, 4, 'Чат создан!', '2021-01-14 08:29:50'),
(47, 20, 5, 'ggg', '2021-01-14 08:30:02'),
(49, 26, 3, 'Чат создан!', '2020-06-01 00:00:00'),
(50, 26, 3, '1', '2021-01-20 11:09:44'),
(51, 22, 5, 'ye', '2021-01-20 11:47:08'),
(52, 22, 5, '654', '2021-01-20 12:09:52');

-- 
-- Вывод данных для таблицы desk_membership
--
INSERT INTO desk_membership VALUES
(1, 1, 1),
(2, 2, 1);

-- 
-- Вывод данных для таблицы chat_membership
--
INSERT INTO chat_membership VALUES
(37, 2, 19),
(38, 4, 19),
(39, 2, 20),
(40, 4, 20),
(41, 5, 20),
(42, 6, 20),
(43, 2, 21),
(44, 5, 21),
(45, 2, 22),
(46, 5, 22),
(47, 6, 22),
(48, 2, 23),
(49, 3, 23),
(50, 2, 24),
(51, 3, 24),
(52, 4, 24),
(54, 3, 26);

-- 
-- Вывод данных для таблицы attachment
--
-- Таблица sdo_vit.attachment не содержит данных

-- 
-- Вывод данных для таблицы answer
--
INSERT INTO answer VALUES
(1, 'ghghg', 4, 3, NULL),
(2, 'eqwqwe', 4, 5, NULL),
(3, '4564564', 4, 5, NULL),
(4, 'укеуке', 4, 4, NULL),
(5, 'укеукеукеу', 4, 2, NULL),
(6, '', 4, 3, NULL),
(7, '', 4, 1, 1),
(8, 'fghfghfg', 4, 3, NULL),
(9, 'fghfgh', 4, 1, NULL),
(10, 'ропорпоп', 4, 6, NULL),
(11, 'asdasd', 4, 6, 0),
(12, 'asdasd', 4, 6, 0),
(13, 'werwerwer', 4, 6, 0),
(14, 'ррвава', 4, 6, 0),
(15, '1', 5, 1, 0),
(16, '12', 5, 4, 0);

-- 
-- Восстановить предыдущий режим SQL (SQL mode)
-- 
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;

-- 
-- Включение внешних ключей
-- 
/*!40014 SET FOREIGN_KEY_CHECKS = @OLD_FOREIGN_KEY_CHECKS */;