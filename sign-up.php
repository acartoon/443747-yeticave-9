<?php
require_once 'init.php';
$errors = [];
$user = [];

if (isset($_SESSION['user'])) {
    header("location: /");
    exit();
}

if (($_SERVER['REQUEST_METHOD'] === 'POST') and !isset($_SESSION['user'])) {
    $required_fields = ['email', 'password', 'name', 'message'];

    foreach ($required_fields as $field) {
        if (isset($_POST[$field]) and !empty(trim($_POST[$field]))) {
            $user[$field] = trim($_POST[$field]);
        } else {
            $errors[$field] = 'Поле не заполнено';
        }
    }

    if (isset($user['password']) and strlen($user['password']) > 12) {
        $errors['password'] = 'Слишком длинный пароль. Максимальная длина 12 символов';
    }

    if (isset($user['name']) and strlen($user['name']) > 64) {
        $errors['name'] = 'Слишком длинное имя. Максимальная длинна символов 64';
    }

    if (isset($user['message']) and strlen($user['message']) > 200) {
        $errors['message'] = 'Максимальная длина символов 200';
    }

    if (isset($user['email'])) {
        if (!filter_var($user['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Введите корректный email';
        } else {
            $check_pass = 'SELECT * FROM users WHERE email = ?';
            $stmt = db_get_prepare_stmt($link, $check_pass, [$user['email']]);
            mysqli_stmt_execute($stmt);
            $res = mysqli_stmt_get_result($stmt);
            $total = $res ? mysqli_fetch_assoc($res) : null;
            if ($total) {
                $errors['email'] = 'Такой пользователь уже существует!';
            }
        }
    }

    if (!count($errors)) {
        $pass = password_hash($user['password'], PASSWORD_DEFAULT);
        $sql = 'INSERT INTO users (name, email, pass, contacts)
        VAlUES (?, ?, ?, ?)';
        $stmt = db_get_prepare_stmt($link, $sql, [$user['name'], $user['email'], $pass, $user['message']]);
        $res = mysqli_stmt_execute($stmt);
        $res ? header("location: /login.php") : error(404, '404.php');
    }
}

$main_content = include_template('sign-up.php', ['categories' => $categories, 'errors' => $errors, 'user' => $user]);
$index_page = include_template('layout.php',
    ['categories' => $categories, 'main_content' => $main_content, 'title' => 'Карточка товара']);

print $index_page;