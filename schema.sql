CREATE DATABASE yeticave;
USE yeticave;

CREATE TABLE users (
id INT AUTO_INCREMENT PRIMARY KEY,
name CHAR NOT NULL,
day_registration TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
email CHAR(128) NOT NULL UNIQUE,
pass CHAR(64),
avatar TEXT,
contacts TEXT
);

CREATE TABLE categories (
id INT AUTO_INCREMENT PRIMARY KEY,
character_code CHAR NOT NULL,
name_category CHAR(128) NOT NULL
);

CREATE TABLE lots (
id INT AUTO_INCREMENT PRIMARY KEY,
date_create TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
name_lot CHAR NOT NULL,
description_lot TEXT,
link TEXT,
initial_price DECIMAL,
date_end TIMESTAMP,
step_rate INT,
id_category INT,
id_user INT,
id_winner INT
);

CREATE TABLE rates (
id INT AUTO_INCREMENT PRIMARY KEY,
date_create TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
price DECIMAL,
id_lot INT,
id_user INT
);

CREATE INDEX name_lot ON lots(name_lot);
CREATE INDEX id_category ON lots(id_category);