<?php
    $error_sql = 'Невозможно подключиться к базе данных: ' . mysqli_connect_error();
    $connect = mysqli_connect("localhost", "root", "", "doingsdone");
    if(!$connect) {
        print('Ошибка подключения: ' . mysqli_connect_error());
        exit();
    }
    mysqli_set_charset($connect, "utf8");
