

-- Creating main database
create database assignment_db;

DROP TABLE IF EXISTS assignment_db.message;

-- Creating first table in the database

create table message(
srcMSISDN VARCHAR(20) NOT NULL,
destMSISDN VARCHAR(20),
receivedDate DATETIME NOT NULL,
bearer VARCHAR(5),
messageRef VARCHAR(20),
id VARCHAR(10),
switch1 INT,
switch2 INT,
switch3 INT,
switch4 INT,
fan INT,
forward INT,
reverse INT,
heater INT,
temperature DECIMAL(5,2),
keypad INT,
CONSTRAINT message_PK PRIMARY KEY(srcMSISDN,receivedDate));


DROP TABLE IF EXISTS assignment_db.users;



create table users(
User_ID INT(100) NOT NULL,
Username VARCHAR(255),
Password VARCHAR(255),
Email VARCHAR(255),
CONSTRAINT users_PK PRIMARY KEY(User_ID));

DROP TABLE IF EXISTS assignment_db.log;

create table log(
ID int NOT NULL AUTO_INCREMENT,
date TIMESTAMP NOT NULL,
userID INT,
msg  VARCHAR(255),
CONSTRAINT log_PK PRIMARY KEY(ID));

-- Optional: Schedule a job to delete logs after 7 days of initialization

-- DELIMITER $$
-- CREATE EVENT delete_event
-- ON SCHEDULE AT CURRENT_TIMESTAMP + INTERVAL 1 DAY
-- ON COMPLETION PRESERVE

-- DO BEGIN
--       DELETE FROM log WHERE date < DATE_SUB(NOW(), INTERVAL 7 DAY);
-- END;
-- $$

-- Create User

CREATE USER 'p14166609_web'@'localhost' IDENTIFIED BY 'sQuat=51';

-- Grant permission to users
-- Run these separately for each table.

GRANT SELECT ON users TO 'p14166609_web'@'localhost';
GRANT INSERT ON users TO 'p14166609_web'@'localhost';
GRANT SELECT ON message TO 'p14166609_web'@'localhost';
GRANT INSERT ON message TO 'p14166609_web'@'localhost';
GRANT SELECT ON log TO 'p14166609_web'@'localhost';
GRANT INSERT ON log TO 'p14166609_web'@'localhost';
GRANT DELETE ON log TO 'p14166609_web'@'localhost';
