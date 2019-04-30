<?php
require_once 'helpers.php';
require_once 'functions.php';
require_once 'data.php';
require_once 'bd.php';

$main_content = include_template('lot.php', ['categories' => $categories, 'lots' => $lots]);

$index_page = include_template('layout.php', 
['categories' => $categories, 'main_content' => $main_content, 'title' => 'Карточка товара', 'is_auth' => $is_auth, 'user_name' => $user_name]);



print $index_page;

?>