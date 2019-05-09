<?php
require_once 'init.php';
$errors = [];
$lot = [];

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if($_POST['lot']) {
        $post = $_POST['lot'];
        $required_fields = ['name', 'category', 'description', 'rate', 'step', 'date'];

        foreach($required_fields as $key) {
            if(isset($post[$key])) {
                $lot[$key] = trim($post[$key]);
            }
        };
        foreach ($lot as $key => $value)  {
            if($key === 'rate') {
                if((int)$value <= 0) {
                    $errors[$key] = 'Начальная цена должна быть целым числом больше 0';
                };
            }
            elseif($key === 'category') {
                $check_category = 'SELECT NOT EXISTS (SELECT * FROM categories WHERE id = ?) AS result';
                $stmt =  db_get_prepare_stmt($link, $check_category, [$lot['category']]);
                mysqli_stmt_execute($stmt);
                $res = mysqli_stmt_get_result($stmt);
                if($res) {
                    $total = mysqli_fetch_assoc($res);
                    if($total['result'] == 1) {
                        $errors['category'] = 'Выберете существующую категорию';
                    }
                };
            }
            elseif($key === 'step') {
                if((int)$value <= 0) {
                    $errors[$key] = 'Шаг ставки должен быть целым числом больше 0';
                };
            }
            elseif($key === 'name') {
                if(strlen($value) > 64) {
                    $errors[$key] = 'Вашим именем можно вызвать сатану! Придумайте имя короче';
                };
            }
            elseif($key === 'date') {
                if(!is_date_valid($value)) {
                    $errors[$key] = 'Дата завершения должна быть в формате "ГГГГ-ММ-ДД"';
                }
                elseif (check_date($value)) {
                    $errors[$key] = 'Дата окончания должна быть больше текущей хотя бы на один день';
                }
            }
        };

        foreach ($required_fields as $field) {
            if(empty($lot[$field])) {
            $errors[$field] = 'Поле не заполнено';
            }
        };

        if (isset($_FILES['img']) && is_uploaded_file($_FILES['img']['tmp_name'])) {
            $tmp_name = $_FILES['img']['tmp_name'];
            $file_type = mime_content_type($tmp_name);
            if(($file_type !== 'image/png') and ($file_type !== 'image/jpeg')){
                $errors['file'] = 'Неверный формат файла';
            }  
        } else {
            $errors['file'] = 'Не загружен файл';
        };
    
        if(!count($errors)) {
            if($file_type === 'image/jpeg') {
                $file_type = 'jpeg';
            } elseif($file_type === 'image/png') {
                $file_type = 'png';
            };
            $file_unic = uniqid() .'.' .$file_type;
            $file_url = 'uploads/' .$file_unic;
            move_uploaded_file($tmp_name, $file_url);

            $sql = 'INSERT INTO lots (date_create, name, description, 
                image_link, initial_price, date_end, step_rate, category, user)
                VAlUES (NOW(), ?, ?, ?, ?, ?, ?, ?, ?)';
            $stmt = db_get_prepare_stmt($link, $sql, [$lot['name'], $lot['description'], 
                $file_url, $lot['rate'], $lot['date'], $lot['step'], $lot['category'], $name]);
            $res = mysqli_stmt_execute($stmt);

            if($res) {
                $lot_id = mysqli_insert_id($link);
                header("location: lot.php?id=" . $lot_id);
            } else {
                error_404();  
            };
        } else {
            // print_r($errors);
        };
    };
};
$main_content = include_template('add-lot.php', ['categories' => $categories, 'errors' => $errors, 'lot' => $lot]);      
$index_page = include_template('layout.php', 
    ['categories' => $categories, 'main_content' => $main_content, 'title' => 'Карточка товара', 'is_auth' => $is_auth, 'user_name' => $user_name]);

print $index_page;
?>