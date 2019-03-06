<?php
require_once('init.php');
require_once('functions.php');

// показывать или нет выполненные задачи
$show_complete_tasks = intval($_GET['show_completed']);

$error = [];
$user_id = 2;
$safe_id = intval($user_id);

$sql = "SELECT * FROM users WHERE id = '$safe_id'";
$user = fetch_data($connect, $sql);

$sql_projects = "SELECT * FROM projects WHERE user_id = '$safe_id'";
$projects = fetch_data($connect, $sql_projects);

$sql_tasks = "SELECT * FROM tasks WHERE user_id = '$safe_id'";
if(isset($_GET['task_date'])) {
    if($_GET['task_date'] == 'day') {
        $sql_tasks .= " AND DAY(deadline) = DAY(NOW())";
    }
    if($_GET['task_date'] == 'tomorrow') {
        $sql_tasks .= " AND DAY(deadline) = DAY(DATE_ADD(NOW(), INTERVAL 1 DAY))";
    }
    if($_GET['task_date'] == 'dead') {
        $sql_tasks .= " AND deadline < NOW() ORDER BY deadline ASC";
    }
}
if(isset($_GET['project'])) {
    $project_id = intval($_GET['project']);
    $sql_tasks .= " AND project_id = '$project_id'";
}
$tasks = fetch_data($connect, $sql_tasks);

// выполнение задачи
if(isset($_GET['task_id'])) {
    $task_id = intval($_GET['task_id']);
    $upd = "UPDATE ";
}
// выполнение заканчивается

if (!empty($error)) {
    http_response_code(404);
    $index_content = include_template('error.php', [
        'error' => $error
    ]);
}
else {
    http_response_code(200);
    $index_content = include_template('index.php', [
        'show_complete_tasks' => $show_complete_tasks,
        'tasks' => $tasks
    ]);
}

$layout_content = include_template('layout.php', [
    'title' => 'Дела в порядке',
    'connect' => $connect,
    'projects' => $projects,
    'content' => $index_content,
    'user_name' => $user[0]['name']
]);
print ($layout_content);
?>
