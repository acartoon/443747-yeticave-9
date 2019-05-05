<?php
require_once 'init.php';

$main_content = include_template('add-lot.php', ['categories' => $categories]);    
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $lot = $_POST['lot'];
        // print '<pre>';
        // print_r($lot);
        // print '</pre>';
        $errors = [];

        foreach ($lot as $key => $value)  {
            if($key == 'rate') {
                if(!is_numeric($value) and $value <= 0) {
                    $errors[$key] = 'Начальная цена должна быть числом больше 0';
                };
            }
            elseif($key == 'category') {
                if($value == 'Выберите категорию') {
                    $errors[$key] = 'Выберите категорию';
                };
            }
            elseif($key == 'step') {
                if((int)$value <= 0) {
                    $errors[$key] = 'Шаг ставки должен быть целым числом больше 0';
                };
            }
            elseif($key == 'date') {
                if(!is_date_valid($value)) {
                    $errors[$key] = 'Дата завершения должна быть в формате "ГГГГ-ММ-ДД"';
                }
                elseif (check_date($value)) {
                    $errors[$key] = 'Дата окончания должна быть больше текущей хотя бы на один день';
                }
            }
        };

        $required_fields = ['name', 'category', 'description', 'rate', 'step', 'date'];

        foreach ($required_fields as $field) {
            if(empty($lot[$field])) {
            $errors[$field] = 'Поле не заполнено';
            }
        };

        if(isset($_FILES['img'])) {
            $tmp_name = $_FILES['img']['tmp_name']; //временное имя файла
            $file_type = mime_content_type($tmp_name);

            if($file_type == 'image/jpeg' or $file_type == 'image/png') {
                $file_name = $_FILES['img']['name'];
                $file_name_arr = explode('.', $file_name);
                $file_name_arr_count = count($file_name_arr);
                $file_type = $file_name_arr[$file_name_arr_count-1];
                $file_unic = uniqid() .'.' .$file_type;
                $file_path = __DIR__ . '/uploads/';
                $file_url = '../uploads/'. $file_unic;
                move_uploaded_file($tmp_name, $file_path .$file_unic);  
            } else {
                $errors['img'] = 'Неверный формат файла';
            }
        }
        
        if(count($errors)) {

            $main_content = include_template('add-lot.php', ['categories' => $categories, 'errors' => $errors, 'lot' => $lot]);  
        }
        else {
            $sql = 'INSERT INTO lots (date_create, name, description, image_link, initial_price, date_end, step_rate, category, user)
            VAlUES (NOW(), ?, ?, ?, ?, ?, ?, ?, 1)';
            $stmt = db_get_prepare_stmt($link, $sql, [$lot['name'], $lot['description'], $file_url, $lot['rate'], $lot['date'], $lot['step'], $lot['category']]);
            $res = mysqli_stmt_execute($stmt);
    
            if($res) {
                $lot_id = mysqli_insert_id($link);
                header("location: lot.php?id=" . $lot_id);
            } else {
                error_404();  
            };
        }
    };
    
$index_page = include_template('layout.php', 
['categories' => $categories, 'main_content' => $main_content, 'title' => 'Карточка товара', 'is_auth' => $is_auth, 'user_name' => $user_name]);

print $index_page;
?>