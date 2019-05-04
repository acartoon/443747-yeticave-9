<?php
require_once 'init.php';

$main_content = include_template('add-lot.php', ['categories' => $categories]);
    
$index_page = include_template('layout.php', 
['categories' => $categories, 'main_content' => $main_content, 'title' => 'Карточка товара', 'is_auth' => $is_auth, 'user_name' => $user_name]);

print $index_page;

if (isset($_FILES['img'])) {
    $file_name = $_FILES['img']['name'];
    $file_path = __DIR__ . '/uploads/';
    $file_url = '/uploads/' . $file_name;
    move_uploaded_file($_FILES['img']['tmp_name'], $file_path . $file_name);
    print("<a href='$file_url'>$file_name</a>");
    }

    if($_SERVER['REQUEST_METHOD'])
?>