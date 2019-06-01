CREATE DATABASE yeticave_443747 character set utf8;
USE yeticave_443747;

CREATE TABLE users (
id INT AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(64) NOT NULL,
day_registration TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
email VARCHAR(64) NOT NULL UNIQUE,
pass VARCHAR(64) NOT NULL,
avatar VARCHAR(200) UNIQUE,
contacts TEXT NOT NULL
);

CREATE TABLE categories (
id INT AUTO_INCREMENT PRIMARY KEY,
character_code VARCHAR(64) NOT NULL UNIQUE,
name VARCHAR(64) NOT NULL UNIQUE
);

CREATE TABLE lots (
id INT AUTO_INCREMENT PRIMARY KEY,
date_create TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
name VARCHAR(64) NOT NULL,
description TEXT NOT NULL,
image_link VARCHAR(200) NOT NULL,
initial_price INT NOT NULL,
date_end TIMESTAMP NOT NULL,
step_rate INT NOT NULL,
category INT NOT NULL,
user INT NOT NULL,
winner INT,
FOREIGN KEY (category) REFERENCES categories(id),
FOREIGN KEY (user) REFERENCES users(id),
FOREIGN KEY (winner) REFERENCES users(id),
FULLTEXT INDEX lots_search (name, description)
);

CREATE TABLE rates (
id INT AUTO_INCREMENT PRIMARY KEY,
date_create TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
price INT NOT NULL,
lot INT NOT NULL,
user INT NOT NULL,
FOREIGN KEY (lot) REFERENCES lots(id),
FOREIGN KEY (user) REFERENCES users(id)
);

