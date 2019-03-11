<?php
require_once('init.php');
require_once('functions.php');



$user_id = 2;
$safe_id = intval($user_id);

$sql = "SELECT * FROM users WHERE id = " . $user_id;
$user = fetch_data($connect, $sql);

$sql = "SELECT * FROM projects WHERE user_id = " . $user_id;
$projects = fetch_data($connect, $sql);

$page_content = include_template('add.php', [
    'projects' => $projects
]);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $task = $_POST;

    if (empty($task['name'])) {
        $errors['name'] = 'Поле обязательно для заполнения';
    }

    $count = 0;
    foreach ($projects as $value) {
       if ($value['id'] === $task['project_id']) {
          $count++;
       }
    }

    if (!$count) {
        $errors['project'] = "Выбран несуществующий проект";
    }

    if (!correct_format_day($task['date'])) {
        $errors['date'] = "Введите дату в формате ДД.ММ.ГГГГ";
    }

    elseif (strtotime($task['date']) <= strtotime("now")) {
        $errors['date'] = "Дата должна быть больше или равна текущей";
    }

    if (!($task['date'])) {
        unset($errors['date']);
    }

    if (is_uploaded_file($_FILES['preview']['tmp_name'])) {
        $file_name = $_FILES['preview']['name'];
        $file_path = $_FILES['preview']['tmp_name'];
        move_uploaded_file($file_path, __DIR__ . '/' . $file_name);
        $task['file'] = $file_name;
    }
    else {
        $task['file'] = "";
    }

    if (empty($errors)) {
        $sql = 'INSERT INTO tasks (creation_at, deadline, title_task, file_task, user_id, project_id) VALUES (NOW(), ?, ?, ?, ?, ?)';
        $stmt = db_get_prepare_stmt($connect, $sql, [ $task['date'], $task['name'], $task['file'], $safe_id, $task['project_id'] ]);
        $res = mysqli_stmt_execute($stmt);

        if ($res) {
            header("Location: index.php");
			 exit();
        }
        $page_content = include_template('add.php', [
            'projects' => $projects,
            'user' => $user[0]
        ]);
     }
     else {
        $page_content = include_template('add.php', [
            'projects' => $projects,
            'errors' => $errors,
            'user' => $user[0]
        ]);
    }
	
	
}
 $layout_content = include_template('layout.php', [
    'title' => 'Дела в порядке',
    'connect' => $connect,
    'projects' => $projects,
    'content' => $page_content,
    'user_name' => $user[0]['name']
]);
 print($layout_content);
