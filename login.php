<?php
require_once 'init.php';
$main_content = include_template('login.php');
$errors = [];
$data = [];

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if($_POST['aut']) {
        $post = $_POST['aut'];
        $required_fields = ['email', 'password'];

        foreach($required_fields as $key) {
            if(isset($post[$key])) {
                $data[$key] = trim($post[$key]);
            }
        };

        foreach ($required_fields as $field) {
            if(empty($data[$field])) {
                $errors[$field] = 'Поле не заполнено';
            }
        };
        if(!count($errors)) {
            $email = mysqli_real_escape_string($link, $data['email']);
            $request = "SELECT * FROM users WHERE email = ?";
            $stmt = db_get_prepare_stmt($link, $request, [$email]);
            mysqli_stmt_execute($stmt);
            $res = mysqli_stmt_get_result($stmt);
            print_r($res);
            $user = $res ? mysqli_fetch_array($res, MYSQLI_ASSOC) : null;
            print_r($user);
        
            if (!count($errors) and $user) {
                if (password_verify($data['password'], $user['pass'])) {
                    $_SESSION['user'] = $user;
                }
                else {
                    $errors['password'] = 'Неверный пароль';
                }
            }
            else {
                $errors['email'] = 'Такой пользователь не найден';
                print_r($errors['email']);
            }
        } else {
            print_r($errors);
        }
    };
};



$index_page = include_template('layout.php', 
['categories' => $categories, 'main_content' => $main_content, 'title' => 'Главная', 'is_auth' => $is_auth, 'user_name' => $user_name]);

print $index_page;

?>