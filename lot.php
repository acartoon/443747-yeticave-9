<?php
require_once 'connection.php';

if(isset($_GET['id'])) {

    $get = [
        $_GET['id']  
      ];

    $lot = getlot($link, $get);

    if($lot['count'] > 0) {
        $main_content = include_template('lot.php', ['categories' => $categories, 'lot' => $lot['lot']]);
    } else {
        http_response_code(404);
        $main_content = include_template('404.php'); 
    };
  
} else {
    http_response_code(404);
    $main_content = include_template('404.php');
};

$index_page = include_template('layout.php', 
['categories' => $categories, 'main_content' => $main_content, 'title' => 'Карточка товара', 'is_auth' => $is_auth, 'user_name' => $user_name]);

print $index_page;

?>