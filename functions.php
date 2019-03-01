<?php
date_default_timezone_set('Europe/Moscow');

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
}

//функция подсчета задач
function count_tasks($connect, $project_id) {
    $sql = "SELECT id FROM tasks WHERE project_id = '$project_id'";
    $result = mysqli_query($connect, $sql);
    return mysqli_num_rows($result);
}

function fetch_data($connect, $sql) {
    $result = mysqli_query($connect, $sql);
    if(!$result) {
        $error = mysqli_error($connect);
        print("Ошибка MySQL: " . $error);
        exit();
    }
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $data;
}

function db_get_prepare_stmt($link, $sql, $data = []) {
    $stmt = mysqli_prepare($link, $sql);
     if ($data) {
        $types = '';
        $stmt_data = [];
         foreach ($data as $value) {
            $type = null;
             if (is_int($value)) {
                $type = 'i';
            }
            else if (is_string($value)) {
                $type = 's';
            }
            else if (is_double($value)) {
                $type = 'd';
            }
             if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }
        $values = array_merge([$stmt, $types], $stmt_data);
        $func = 'mysqli_stmt_bind_param';
        $func(...$values);
		
    }
    return $stmt;
}

function correct_format_day ($date) {
    $array = explode(".", $date);
    if (count($array) == 3) {
        $day = $array[0];
        $month = $array[1];
        $year = $array[2];
        if (strlen($day) == 2 && strlen($month) == 2 && strlen($year) == 4) {
            $correct = checkdate($month, $day, $year);
        }
    } else {
        $correct = 0;
    }
    return $correct;
}
