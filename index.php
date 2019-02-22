<?php
require_once('functions.php');

// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);

$error = [];

$error = 'Невозможно подключиться к базе данных: ' . mysqli_connect_error();
$user_id = 2;
$safe_id = intval($user_id);

$sql_projects = "SELECT * FROM projects WHERE user_id = ?";

$tasks = [];
$project_id = intval($_GET['project_id']);
 $sql_tasks = "SELECT * FROM tasks WHERE user_id = ?";

 if (isset($_GET['project_id']) && !$project_id) {
      $error = '404';
} else if ($project_id) {
     $sql_tasks_count = "SELECT COUNT(*) as count FROM tasks WHERE user_id = ? AND project_id = ?";
     $task_count = db_fetch_data($connect, $sql_tasks_count, [$user_id, $project_id]);
   if (!$task_count[0]['count']) {
       $error = '404';
        }
    }
if ($error) {
   http_response_code(404);
    $page_content = include_template('error.php', [
        'error' => $error
    ]);
} else {
    http_response_code(200);
    $page_content = include_template('index.php', [
        'show_complete_tasks' => $show_complete_tasks,
        'tasks' => $tasks
    ]);
}
	
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