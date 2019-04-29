<?php
require_once 'helpers.php';
require_once 'functions.php';

$link = mysqli_connect("localhost", "root", "","yeticave_443747");

if($link == false) {
    $error = mysqli_connect_error();
    print 'Сайт находится на технических работах. Зайдите позже';
    exit();
} else {
    mysqli_set_charset($link, "utf8");

    $sql_categories = "SELECT character_code, name FROM categories"; 
    $sql_lots = 
    "SELECT l.name as name, c.name as category, initial_price as price, image_link as URL, date_end
    FROM lots l 
    JOIN categories c 
    WHERE category = c.id
    ORDER BY l.date_create DESC"; 
    $categories = getData($sql_categories, $link);
    $lots = getData($sql_lots, $link);
};

$is_auth = rand(0, 1);

$user_name = 'Секрет';

$main_content = include_template('index.php', ['categories' => $categories, 'lots' => $lots]);

$index_page = include_template('layout.php', 
['categories' => $categories, 'main_content' => $main_content, 'title' => 'Главная', 'is_auth' => $is_auth, 'user_name' => $user_name]);


print $index_page;
?>


