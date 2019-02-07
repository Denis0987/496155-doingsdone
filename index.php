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
     "date" => "Нет",
     "type" => "Домашние дела",
     "perf" => "Нет"
   ],
   [
     "text" => "Заказать пиццу",
     "date" => "Нет",
     "type" => "Домашние дела",
     "perf" => "Нет"
   ]
];




function project_tasks($tasks, $project_name)
{
  $count = 0;
  foreach ($tasks as $value) {
    if ($value["type"] === $project_name) {
      $count += 1;
    }
  }
  return $count;
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
 