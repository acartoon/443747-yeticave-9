<?php
require_once 'connection.php';
    $main_content = include_template('add-lot.php', ['categories' => $categories]);
    
$index_page = include_template('layout.php', 
['categories' => $categories, 'main_content' => $main_content, 'title' => 'Карточка товара', 'is_auth' => $is_auth, 'user_name' => $user_name]);

print $index_page;
?>