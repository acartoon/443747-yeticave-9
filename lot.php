<?php
require_once 'init.php';

if(!isset($_GET['id'])) {
    error_404();
}

$get = [
    $_GET['id']  
];

$lot = get_lot($link, $get);

if($lot['count'] == 0) {
    error_404();
};

$main_content = include_template('lot.php', ['categories' => $categories, 'lot' => $lot['lot']]);
$index_page = include_template('layout.php', 
['categories' => $categories, 'main_content' => $main_content, 'title' => 'Карточка товара']);

print $index_page;

?>