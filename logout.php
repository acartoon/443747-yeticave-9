<?php
require_once 'init.php';
$_SESSION = [];

$main_content = include_template('index.php', ['categories' => $categories, 'lots' => $lots]);

$index_page = include_template('layout.php', 
    ['categories' => $categories, 'main_content' => $main_content, 'title' => 'Главная', 'is_auth' => $is_auth, 'user_name' => $user_name]);

print $index_page;


?>