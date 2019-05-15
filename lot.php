<?php
require_once 'init.php';
$error = '';
$step = '';
if(!isset($_GET['id'])) {
    error(404, '404.php', 'Такой страницы не существует!', $categories);  
}
$get = [
    $_GET['id']  
];
$lot = get_lot($link, $get);
if($lot['count'] == 0) {
    error(404, '404.php', 'Такой страницы не существует!', $categories);  
}
$rates = get_rates($link, $get);
$rates_count = count($rates);

$add_rate = to_add_rate($lot['lot']['user'], $rates, $lot['lot']['date_end']);
if(($_SERVER['REQUEST_METHOD'] == 'POST') and $_SESSION['user']) {
    if($_POST['cost'] and !empty(trim($_POST['cost']))) {
        $min_price = $lot['lot']['rate'] + $lot['lot']['price'];
        $step = $_POST['cost'];
        if(!is_numeric($step) or (int)$step != $step) {
            $error = 'Шаг ставки должен быть целым числом!';
        }
        if($step < $min_price) {
            $error = 'Шаг ставки должен быть больше минимальной цены!';
        }
    } else {
        $error = 'Введите шаг ставки';
    }
    if(empty($error)) {
        $sql = 'INSERT INTO rates (price, lot, user) VAlUES (?, ?, ?)';
        $stmt = db_get_prepare_stmt($link, $sql, [$step, $lot['lot']['id'], $_SESSION['user']['id']]);
        $res = mysqli_stmt_execute($stmt);
        if($res) {
            $lot_id = mysqli_insert_id($link);
            header("location: lot.php?id=" . $lot['lot']['id']);
            exit();
        } else {
            error(404, '404.php', 'Ошибка при добавлении записи', $categories);  
        }
    }
}
$main_content = include_template('lot.php', ['categories' => $categories, 'lot' => $lot['lot'],
     'error' => $error, 'step' => $step, 'rates' => $rates, 'rates_count' => $rates_count, 'add_rate' => $add_rate]);
$index_page = include_template('layout.php', 
['categories' => $categories, 'main_content' => $main_content, 'title' => 'Карточка товара']);
print $index_page;
?>