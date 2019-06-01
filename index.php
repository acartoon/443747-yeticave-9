<?php
require_once 'init.php';
require_once 'getwinner.php';

$lots = get_lots($link);

$main_content = include_template('index.php', ['categories' => $categories, 'lots' => $lots]);

$index_page = include_template('layout.php',
    ['categories' => $categories, 'main_content' => $main_content, 'title' => 'Главная']);

print $index_page;