--
-- Скрипт сгенерирован Devart dbForge Studio 2019 for MySQL, Версия 8.2.23.0
-- Домашняя страница продукта: http://www.devart.com/ru/dbforge/mysql/studio
-- Дата скрипта: 13.01.2021 3:18:40
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
  groupId int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  name varchar(50) NOT NULL,
  PRIMARY KEY (groupId)
)
ENGINE = INNODB,
AUTO_INCREMENT = 3,
AVG_ROW_LENGTH = 8192,
CHARACTER SET utf8,
COLLATE utf8_general_ci;

--
-- Создать таблицу `user`
--
CREATE TABLE IF NOT EXISTS user (
  idUser int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  name varchar(15) NOT NULL,
  surname varchar(15) NOT NULL,
  middlename varchar(15) NOT NULL,
  birthdate date NOT NULL,
  studentNumber int(6) NOT NULL,
  mail varchar(50) NOT NULL,
  password varchar(16) NOT NULL,
  login varchar(15) NOT NULL,
  permissions enum ('0', '1', '2') NOT NULL,
  groupId int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (idUser)
)
ENGINE = INNODB,
AUTO_INCREMENT = 4,
AVG_ROW_LENGTH = 8192,
CHARACTER SET utf8,
COLLATE utf8_general_ci;

--
-- Создать внешний ключ
--
ALTER TABLE user
ADD CONSTRAINT FK_user_group_groupId FOREIGN KEY (groupId)
REFERENCES `group` (groupId) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Создать таблицу `desk`
--
CREATE TABLE IF NOT EXISTS desk (
  deskId int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  name varchar(50) NOT NULL,
  userId int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (deskId)
)
ENGINE = INNODB,
CHARACTER SET utf8,
COLLATE utf8_general_ci;

--
-- Создать внешний ключ
--
ALTER TABLE desk
ADD CONSTRAINT FK_desk_user_idUser FOREIGN KEY (userId)
REFERENCES user (idUser) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Создать таблицу `task`
--
CREATE TABLE IF NOT EXISTS task (
  taskId int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  deskId int(11) UNSIGNED NOT NULL,
  name varchar(50) NOT NULL,
  description varchar(255) DEFAULT NULL,
  date datetime NOT NULL,
  PRIMARY KEY (taskId)
)
ENGINE = INNODB,
CHARACTER SET utf8,
COLLATE utf8_general_ci;

--
-- Создать внешний ключ
--
ALTER TABLE task
ADD CONSTRAINT FK_task_desk_deskId FOREIGN KEY (deskId)
REFERENCES desk (deskId) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Создать таблицу `attachment`
--
CREATE TABLE IF NOT EXISTS attachment (
  attachmentId int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  userId int(11) UNSIGNED NOT NULL,
  taskId int(11) UNSIGNED NOT NULL,
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
REFERENCES task (taskId) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Создать внешний ключ
--
ALTER TABLE attachment
ADD CONSTRAINT FK_attachment_user_idUser FOREIGN KEY (userId)
REFERENCES user (idUser) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Создать таблицу `desk_membership`
--
CREATE TABLE IF NOT EXISTS desk_membership (
  deskMembershipId int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  deskId int(11) UNSIGNED NOT NULL,
  groupId int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (deskMembershipId)
)
ENGINE = INNODB,
CHARACTER SET utf8,
COLLATE utf8_general_ci;

--
-- Создать внешний ключ
--
ALTER TABLE desk_membership
ADD CONSTRAINT FK_desk_membership_desk_deskId FOREIGN KEY (deskId)
REFERENCES desk (deskId) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Создать внешний ключ
--
ALTER TABLE desk_membership
ADD CONSTRAINT FK_desk_membership_group_groupId FOREIGN KEY (groupId)
REFERENCES `group` (groupId) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Создать таблицу `chat`
--
CREATE TABLE IF NOT EXISTS chat (
  chatId int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  creationDate datetime NOT NULL,
  name varchar(50) NOT NULL,
  PRIMARY KEY (chatId)
)
ENGINE = INNODB,
CHARACTER SET utf8,
COLLATE utf8_general_ci;

--
-- Создать таблицу `message`
--
CREATE TABLE IF NOT EXISTS message (
  messageId int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  chatId int(11) UNSIGNED NOT NULL,
  userId int(11) UNSIGNED NOT NULL,
  content varchar(255) NOT NULL,
  date datetime NOT NULL,
  PRIMARY KEY (messageId)
)
ENGINE = INNODB,
CHARACTER SET utf8,
COLLATE utf8_general_ci;

--
-- Создать внешний ключ
--
ALTER TABLE message
ADD CONSTRAINT FK_message_chat_chatId FOREIGN KEY (chatId)
REFERENCES chat (chatId) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Создать внешний ключ
--
ALTER TABLE message
ADD CONSTRAINT FK_message_user_idUser FOREIGN KEY (userId)
REFERENCES user (idUser) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Создать таблицу `chat_membership`
--
CREATE TABLE IF NOT EXISTS chat_membership (
  chatMembershipId int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  userId int(11) UNSIGNED NOT NULL,
  chatId int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (chatMembershipId)
)
ENGINE = INNODB,
CHARACTER SET utf8,
COLLATE utf8_general_ci;

--
-- Создать внешний ключ
--
ALTER TABLE chat_membership
ADD CONSTRAINT FK_chat_membership_chat_chatId FOREIGN KEY (chatId)
REFERENCES chat (chatId) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Создать внешний ключ
--
ALTER TABLE chat_membership
ADD CONSTRAINT FK_chat_membership_user_idUser FOREIGN KEY (userId)
REFERENCES user (idUser) ON DELETE NO ACTION ON UPDATE NO ACTION;

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
-- Создать процедуру `getUserByLogin`
--
CREATE DEFINER = 'root'@'localhost'
PROCEDURE getUserByLogin (IN login varchar(20))
BEGIN
  SELECT
    *
  FROM user
  WHERE user.login = login LIMIT 1;
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
    AND user.permissions <> '2' LIMIT 1;
  ELSEIF paramtype = 'login' THEN
    SELECT
      idUser INTO ack
    FROM user
    WHERE user.login = data
    AND user.password = SUBSTRING(MD5(password), 1, 16)
    AND user.permissions <> '2' LIMIT 1;
  END IF;
  SELECT
    ack;
END
$$

--
-- Создать процедуру `addUser`
--
CREATE DEFINER = 'root'@'localhost'
PROCEDURE addUser (IN name varchar(20), IN surname varchar(20), IN middlename varchar(20), IN birthdate date, IN studentNumber int(6), IN mail varchar(50), IN password varchar(16), IN login varchar(20), IN permissions enum ('0', '1', '2', '3'), IN groupname int(11))
BEGIN
  DECLARE grpid int(11);
  SELECT
    groupId INTO grpid
  FROM sdo_vit.group
  WHERE sdo_vit.group.name = groupname LIMIT 1;
  INSERT INTO user (name, surname, middlename, birthdate, studentNumber, mail, password, login, permissions, groupId)
    VALUES (name, surname, middlename, birthdate, studentNumber, mail, MD5(password), login, permissions, grpid);
  SELECT
    1;
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
(2, 'Иван', 'Цветков', 'Андреевич', '2020-12-24', 123456, 'll@mm.ru', '202cb962ac59075b', 'wau', '1', 1),
(3, 'root', 'root', 'root', '2020-12-17', 0, 'L', '81dc9bdb52d04dc2', 'root', '0', 2);

-- 
-- Вывод данных для таблицы desk
--
-- Таблица sdo_vit.desk не содержит данных

-- 
-- Вывод данных для таблицы chat
--
-- Таблица sdo_vit.chat не содержит данных

-- 
-- Вывод данных для таблицы task
--
-- Таблица sdo_vit.task не содержит данных

-- 
-- Вывод данных для таблицы message
--
-- Таблица sdo_vit.message не содержит данных

-- 
-- Вывод данных для таблицы desk_membership
--
-- Таблица sdo_vit.desk_membership не содержит данных

-- 
-- Вывод данных для таблицы chat_membership
--
-- Таблица sdo_vit.chat_membership не содержит данных

-- 
-- Вывод данных для таблицы attachment
--
-- Таблица sdo_vit.attachment не содержит данных

-- 
-- Восстановить предыдущий режим SQL (SQL mode)
-- 
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;

-- 
-- Включение внешних ключей
-- 
/*!40014 SET FOREIGN_KEY_CHECKS = @OLD_FOREIGN_KEY_CHECKS */;