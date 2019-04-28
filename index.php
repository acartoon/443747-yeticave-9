<?php
$link = mysqli_connect("localhost", "root", "","yeticave_443747");

if($link == false) {
    $error = mysqli_connect_error();
} else {
    mysqli_set_charset($link, "utf8");

    $sql_categories = "SELECT character_code, name FROM categories"; 
    $result__categories = mysqli_query($link, $sql_categories); 

    if($result__categories) {
        $category = mysqli_fetch_all($result__categories, MYSQLI_ASSOC);
    } else {
        $error = mysqli_error($link);
    }

    $sql_lots = 
    "SELECT l.name as name, c.name as category, initial_price as price, image_link as URL, date_end
    FROM lots l 
    JOIN categories c 
    WHERE category = c.id
    ORDER BY l.date_create ASC"; 
    $result__lots = mysqli_query($link, $sql_lots);

    if($result__lots) {
        $lots = mysqli_fetch_all($result__lots, MYSQLI_ASSOC);
    } else {
        $error = mysqli_error($link);
    }
}







require_once 'helpers.php';
require_once 'functions.php';

$is_auth = rand(0, 1);

$user_name = 'Секрет'; // укажите здесь ваше имя

$main_content = include_template('index.php', ['category' => $category, 'lots' => $lots]);

$index_page = include_template('layout.php', 
['category' => $category, 'main_content' => $main_content, 'title' => 'Главная', 'is_auth' => $is_auth, 'user_name' => $user_name]);


print $index_page;
?>


