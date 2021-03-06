<?php
require_once 'init.php';
$errors = [];
$data = [];

if (isset($_SESSION['user'])) {
    header("location: /");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' and !isset($_SESSION['user'])) {
    $required_fields = ['email', 'password'];

    foreach ($required_fields as $field) {
        if (isset($_POST[$field]) and !empty(trim($_POST[$field]))) {
            $data[$field] = trim($_POST[$field]);
        } else {
            $errors[$field] = 'Поле не заполнено';
        }
    }

    if (isset($data['email'])) {
        $check_pass = 'SELECT * FROM users WHERE email = ?';
        $stmt = db_get_prepare_stmt($link, $check_pass, [$_POST['email']]);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        $user = $res ? mysqli_fetch_assoc($res) : null;
        if (!$user) {
            $errors['email'] = 'Такого пользователя не существует!';
        }
    }

    if (isset($data['password']) and isset($user)) {
        if (!password_verify($data['password'], $user['pass'])) {
            $errors['password'] = 'Неверный пароль';
        }
    }

    if (!count($errors)) {
        $_SESSION['user'] = $user;
        header("location: /");
        exit();
    }
}

$main_content = include_template('login.php', ['categories' => $categories, 'data' => $data, 'errors' => $errors]);

$index_page = include_template('layout.php',
    ['categories' => $categories, 'main_content' => $main_content, 'title' => 'Главная']);

print $index_page;