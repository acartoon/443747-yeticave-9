INSERT INTO categories 
(character_code, name)
VALUES ('boards', 'Доски и лыжи'),
('attachment', 'Крепления'),
('boots', 'Ботинки'),
('clothing', 'Одежда'),
('tools', 'Инструменты'),
('other', 'Разное');

INSERT INTO users 
(name, email, pass, contacts)
VALUES ('Иван', 'misha@mail.ru', 'pass', 'номер телефона' ),
('Миша Иванов', 'ivan@mail.ru', 'pass1', 'номер телефона' ),
('Кролик роджер', 'rodger@mail.ru', 'pass12', 'номер телефона мамы...' );


INSERT INTO lots 
(name, description, image_link, initial_price, date_end, step_rate, category, user)
VALUES ('2014 Rossignol District Snowboard', 'видавший виды сноуборд', 'img/lot-1.jpg', '10999', '14.05.2019', '500', '1', '1'),
('DC Ply Mens 2016/2017 Snowboard', 'сноуборд с большой дыркой посередине', 'img/lot-2.jpg', '159999', '04.05.2019', '1000', '1', '3'),
('Крепления Union Contact Pro 2015 года размер L/XL', 'новые блестящие крепления', 'img/lot-3.jpg', '8000', '14.08.2019', '150', '2', '2'),
('Ботинки для сноуборда DC Mutiny Charocal', 'видавший виды сноуборд', 'img/lot-4.jpg', '10999', '28.04.2019', '100', '3', '2'),
('Куртка для сноуборда DC Mutiny Charocal', 'видавший виды сноуборд', 'img/lot-5.jpg', '7800', '25.04.2019', '50', '4', '3'),
('Маска Oakley Canopy', 'невидимая маска', 'img/lot-6.jpg', '5400', '14.05.2019', '500', '6', '2');

INSERT INTO rates 
(price, lot, user)
VALUES ('149999', '2', '2'),
('4900', '6', '1'),
('10899', '4', '3');

SELECT * FROM categories;

SELECT lots.name, initial_price, image_link, categories.name, price
FROM lots JOIN categories ON category = categories.id 
LEFT JOIN rates ON lot = lots.id
WHERE date_end > CURDATE();

SELECT lots.name, categories.name
FROM lots JOIN categories ON category = categories.id
WHERE lots.id = 2;

UPDATE lots SET name = '2049 Rossignol District Snowboard'
WHERE id = 1;

SELECT price, lots.name, users.name
FROM rates RIGHT JOIN lots ON lot = lots.id
JOIN users ON rates.user = users.id
WHERE rates.id = 2;
