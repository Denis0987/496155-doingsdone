<?php
require_once('functions.php');
// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);
$types = ["Входящие", "Учеба", "Работа", "Домашние дела", "Авто"];
$tasks = [
   [
     "text" => "Собеседование в IT компании",
     "date" => "01.12.2019",
     "type" => "Работа",
     "perf" => "Нет"
   ],
   [
     "text" => "Выполнить тестовое задание",
     "date" => "25.12.2019",
     "type" => "Работа",
     "perf" => "Нет"
   ],
    
   [
     "text" => "Сделать задание первого раздела",
     "date" => "21.12.2019",
     "type" => "Учеба",
     "perf" => "Да"
   ],
   [
     "text" => "Встреча с другом",
     "date" => "22.12.2019",
     "type" => "Входящие",
     "perf" => "Нет"
   ],
   [
     "text" => "Купить корм для кота",
     "date" => "09.02.2019",
     "type" => "Домашние дела",
     "perf" => "Нет"
   ],
   [
     "text" => "Заказать пиццу",
     "date" => "10.02.2019",
     "type" => "Домашние дела",
     "perf" => "Нет"
   ]
];
$connect = mysqli_connect("localhost", "root", "", "doingsdone");
if ($connect === false) {
    $error = mysqli_error($connect);
    print("Ошибка MySQL:" .$error);
    exit();
} else {
    mysqli_set_charset($connect, "utf8");
    //SQL-запрос для получения списка проектов у текущего пользователя
    $sql = "SELECT id, name_project FROM Project  WHERE user_id = " . 1 ;
    $result = mysqli_query($connect, $sql);
    if (!$result) {
        $error = mysqli_error($connect);
        print("Ошибка MySQL:" .$error);
        exit();
    }
    $types = mysqli_fetch_all($result, MYSQLI_ASSOC);
    //SQL-запрос для получения списка из всех задач у текущего пользователя
    $sql =  "SELECT name_task, file_task, done_at, deadline, status, project_id
            FROM Task  where project_id =" . 1;
    $result = mysqli_query($connect, $sql);
    if (!$result) {
        $error = mysqli_error($connect);
        print("Ошибка MySQL:" .$error);
        exit();
    }
    $tasks = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

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
 