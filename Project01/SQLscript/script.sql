# root

CREATE DATABASE mywebsite;

GRANT ALL ON mywebsite.* TO 'nhatnguyen'@'localhost' IDENTIFIED BY 'minhnhat';

# nhatnguyen

USE mywebsite;

CREATE TABLE users(
    id       INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email    VARCHAR(255) NOT NULL,
    fullname VARCHAR(255) NOT NULL,
    gender   CHAR(1) NOT NULL
) ENGINE InnoDB;