<?php
function include_template($name, $data) {
    $name = 'templates/' . $name;
    $result = '';
    if (!is_readable($name)) {
        return $result;
    }
    ob_start();
    extract($data);
    require $name;
    $result = ob_get_clean();
    return $result;
};
// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);
//функция подсчета задач
function count_item($task_list, $project) {
    $i = 0;
    foreach ($task_list as $key => $types) {
        if ($types['category_task'] == $project && !$types['complete_task']) {
            $i++;
        }
    }
    return $i;
}
//функция фильтрации задач
function esc($str) {
	$text = htmlspecialchars($str);
	//$text = strip_tags($str);
	return $text;
}

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

