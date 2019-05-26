<?php
require_once 'init.php';

$id = [$_SESSION['user']['id']];
$rates = get_rates_by_user($link, $id);

$main_content = include_template('my-bets.php', ['categories' => $categories, 'rates' => $rates]);

$index_page = include_template('layout.php', 
    ['categories' => $categories, 'main_content' => $main_content, 'title' => 'Главная']);

print $index_page;