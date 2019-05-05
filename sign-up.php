<?php
require_once 'init.php';
$main_content = include_template('sign-up.php', ['categories' => $categories]);

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST['user'];
    $errors = [];

    $required_fields = ['email', 'password', 'name', 'message'];
    
    foreach ($required_fields as $field) {
        if(empty($user[$field])) {
        $errors[$field] = 'Поле не заполнено';
        }
    };

    foreach ($user as $key => $value)  {
        if($key == 'email') {
            if(!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Введите корректиный email';
            }
        };
    };

    $check_pass = 'SELECT NOT EXISTS (SELECT * FROM users WHERE email = ?) AS result';
    $stmt =  db_get_prepare_stmt($link, $check_pass, [$user['email']]);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    if($res) {
        $total = mysqli_fetch_assoc($res);
        if($total['result'] == 0) {
            $errors['email'] = 'Такой адрес уже зарегистрирован!';
        }
    };
    
    if(count($errors)) {
        $main_content = include_template('sign-up.php', ['categories' => $categories, 'errors' => $errors, 'user' => $user]);  
    } else {
        $pass = password_hash($user['password'], PASSWORD_DEFAULT);
        $sql = 'INSERT INTO users (name, day_registration, email, pass, contacts)
        VAlUES (?, NOW(), ?, ?, ?)';
        $stmt = db_get_prepare_stmt($link, $sql, [$user['name'], $user['email'], $pass, $user['message']]);
        $res = mysqli_stmt_execute($stmt);

        if($res) {
            header("location: /");
        } else {
            error_404();  
        };
    };
};

$index_page = include_template('layout.php', 
['categories' => $categories, 'main_content' => $main_content, 'title' => 'Карточка товара', 'is_auth' => $is_auth, 'user_name' => $user_name]);

print $index_page;
?>