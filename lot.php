<?php
require_once 'helpers.php';

$main_content = include_template('lot.php', ['category' => $category, 'lots' => $lots]);

$index_page = include_template('layout.php', 
['category' => $category, 'main_content' => $main_content, 'title' => 'Карточка товара', 'is_auth' => $is_auth, 'user_name' => $user_name]);



print $index_page;

?>