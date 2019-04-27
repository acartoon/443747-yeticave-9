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
VALUES ('2014 Rossignol District Snowboard', 'видавший виды сноуборд', 'img/lot-1.jpg', '10999', '2019.05.14', '500', '1', '1'),
('DC Ply Mens 2016/2017 Snowboard', 'сноуборд с большой дыркой посередине', 'img/lot-2.jpg', '159999', '2019.04.28', '1000', '1', '3'),
('Крепления Union Contact Pro 2015 года размер L/XL', 'новые блестящие крепления', 'img/lot-3.jpg', '8000', '2019.08.15', '150', '2', '2'),
('Ботинки для сноуборда DC Mutiny Charocal', 'видавший виды сноуборд', 'img/lot-4.jpg', '10999', '2019.04.12', '100', '3', '2'),
('Куртка для сноуборда DC Mutiny Charocal', 'видавший виды сноуборд', 'img/lot-5.jpg', '7800', '2019.04.27', '50', '4', '3'),
('Маска Oakley Canopy', 'невидимая маска', 'img/lot-6.jpg', '5400', '2019.05.12', '500', '6', '2');

INSERT INTO rates 
(price, lot, user)
VALUES ('179999', '2', '2'),
('4900', '6', '1'),
('169999', '2', '3'),
('10899', '4', '3');

SELECT * FROM categories;

SELECT l.NAME, l.initial_price, l.image_link, IFNULL(MAX(r.price), l.initial_price) AS price, c.NAME, l.date_create, l.date_end
From rates r
right JOIN lots l ON r.lot = l.id
JOIN categories c ON l.category = c.id
WHERE l.date_end > CURDATE()
GROUP BY l.NAME, l.initial_price, l.image_link, c.NAME, l.date_create, l.date_end
ORDER BY l.date_create DESC;

SELECT lots.name, categories.name
FROM lots JOIN categories ON category = categories.id
WHERE lots.id = 2;

UPDATE lots SET name = '2049 Rossignol District Snowboard'
WHERE id = 1;

SELECT price, lots.name, users.name
FROM rates RIGHT JOIN lots ON lot = lots.id
JOIN users ON rates.user = users.id
WHERE lots.id = 2
ORDER BY lots.date_create DESC;
