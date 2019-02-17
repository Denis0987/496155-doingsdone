<?php
require_once('functions.php');

// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);

$user_id = 2;
$safe_id = intval($user_id);

$connect = mysqli_connect("localhost", "root", "", "doingsdone");
mysqli_set_charset($connect, "utf8");

$sql = "SELECT * FROM users WHERE id = " . $safe_id;
$user = fetch_data($connect, $sql);

$sql = "SELECT * FROM projects WHERE user_id = " . $safe_id;
$projects = fetch_data($connect, $sql);

$sql = "SELECT * FROM tasks WHERE user_id = " . $safe_id;
$tasks = fetch_data($connect, $sql);



$index_content = include_template('index.php',
    ['tasks' => $tasks,
    'show_complete_tasks' =>  $show_complete_tasks]);
$layout_content = include_template('layout.php',
    ['title' => 'Дела в порядке',
    'types' => $types,
    'tasks' => $tasks,
    'content' => $index_content
    ]);
print ($layout_content);
?>
 