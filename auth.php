<?php
require_once('init.php');
require_once('functions.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $form = $_POST;
    $required = ['email', 'password'];
    $errors = [];
    foreach ($required as $field) {
        if (empty($form[$field])) {
            $errors[$field] = 'Это поле надо заполнить';
        }
    }
    $email = mysqli_real_escape_string($connect, $form['email']);
    $sql = "SELECT * FROM users WHERE email = '" . $email . "'";
    $res = mysqli_query($connect, $sql);
    $user = $res ? mysqli_fetch_array($res, MYSQLI_ASSOC) : NULL;
    if (empty($errors) && $user) {
        if (password_verify($form['password'], $user['password'])) {
            $_SESSION['user'] = $user;
        } else {
            $errors['password'] = 'Неверный пароль';
        }
    } elseif (empty($errors) && !$user) {
        $errors['email'] = 'Такой пользователь не найден';
    }
    if (count($errors)) {
        $page_content = include_template('join.php', [
            'form' => $form,
            'errors' => $errors
        ]);
    } else {
        header("Location: /index.php");
        exit();
    }
} else {
    $page_content = include_template('join.php', []);
}
$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'tasks' => [],
    'tasks_count' => [],
    'projects' => [],
    'user_name' => "",
    'title' => 'Дела в порядке | Вход'
]);
print($layout_content);