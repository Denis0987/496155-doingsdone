<?php
require_once('init.php');
require_once('functions.php');
require_once('index.php');
$page_content = include_template('join.php', []);
$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'tasks' => [],
    'tasks_count' => [],
    'projects' => [],
    'user_name' => "",
    'title' => 'Дела в порядке | Вход'
]);
print($layout_content);