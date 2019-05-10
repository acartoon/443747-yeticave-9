<?php
require_once 'init.php';
$errors = [];
$lot = [];

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $required_fields = ['name', 'category', 'description', 'rate', 'step', 'date'];

    foreach($required_fields as $field) {
        if(isset($_POST[$field]) and !empty(trim($_POST[$field]))) {
            $lot[$field] = trim($_POST[$field]);
        } else {
            $errors[$field] = 'Поле не заполнено';
        }
    }

    if(isset($lot['name'])) {
        if(strlen($lot['name']) > 64) {
            $errors['name'] = 'Вашим именем можно вызвать сатану! Придумайте имя короче';
        }
    }
    if(isset($lot['rate'])) {
        if((int)$lot['rate'] <= 0) {
            $errors['rate'] = 'Начальная цена должна быть целым числом больше 0';
        }
    }
    if(isset($lot['category'])) {
        $check_category = 'SELECT * FROM categories WHERE id = ?';
        $stmt =  db_get_prepare_stmt($link, $check_category, [$lot['category']]);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        $total = $res ? mysqli_fetch_assoc($res): null;
        if(!$total) {
            $errors['category'] = 'Выберете существующую категорию';
        }
    }
    if(isset($lot['step'])) {
        if((int)$lot['step'] <= 0) {
            $errors['step'] = 'Шаг ставки должен быть целым числом больше 0';
        }
    }
    if(isset($lot['date'])) {
        if(!is_date_valid($lot['date'])) {
            $errors['date'] = 'Дата завершения должна быть в формате "ГГГГ-ММ-ДД"';
        }
        elseif (check_date($lot['date'])) {
            $errors['date'] = 'Дата окончания должна быть больше текущей хотя бы на один день';
        }
    }

    if(isset($_FILES['img']) && is_uploaded_file($_FILES['img']['tmp_name'])) {
        $tmp_name = $_FILES['img']['tmp_name'];
        $file_type = mime_content_type($tmp_name);
        if(($file_type !== 'image/png') and ($file_type !== 'image/jpeg')){
            $errors['file'] = 'Неверный формат файла';
        }  
    } else {
        $errors['file'] = 'Не загружен файл';
    }

    if(!count($errors)) {
        $file_type = 'png';
        if($file_type === 'image/jpeg') {
            $file_type = 'jpeg';
        }
        $file_unic = uniqid() . '.' . $file_type;
        $file_url = 'uploads/' . $file_unic;
        move_uploaded_file($tmp_name, $file_url);

        $sql = 'INSERT INTO lots (date_create, name, description, 
            image_link, initial_price, date_end, step_rate, category, user)
            VAlUES (NOW(), ?, ?, ?, ?, ?, ?, ?, ?)';
        $stmt = db_get_prepare_stmt($link, $sql, [$lot['name'], $lot['description'], 
            $file_url, $lot['rate'], $lot['date'], $lot['step'], $lot['category'], $id_name]);
        $res = mysqli_stmt_execute($stmt);
        if($res) {
            $lot_id = mysqli_insert_id($link);
            header("location: lot.php?id=" . $lot_id);
            exit();
        } else {
            error_404();  
        }
    }
}
$main_content = isset($_SESSION['user']) ?
include_template('add-lot.php', ['categories' => $categories, 'errors' => $errors, 'lot' => $lot]):
include_template('403.php', ['categories' => $categories]);  

$index_page = include_template('layout.php', 
    ['categories' => $categories, 'main_content' => $main_content, 'title' => 'Карточка товара']);

print $index_page;
?>