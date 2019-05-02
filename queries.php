<?php
    $sql_lot = 'SELECT l.name, l.initial_price, l.image_link, l.description, 
    IFNULL(MAX(r.price), l.initial_price) AS price, c.NAME AS category, l.date_create, l.date_end
    From lots l
    left JOIN rates r ON r.lot = l.id
    left JOIN categories c ON l.category = c.id
    WHERE l.id = (?) GROUP BY l.id';

?>