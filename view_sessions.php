<!DOCTYPE html>
<html lang="ru">
    <head>
        <title>Просмотр всех сессий</title>
        <meta charset="utf-8">
        <style>
            <?php
            require "style.css";
            ?>
            </style>
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700&display=swap" rel="stylesheet">
        </head>
    <body>
    <?php

            $mysqli = mysqli_connect('std-mysql', 'std_940_php2_exam', '12345678', 'std_940_php2_exam');    // подключаемся к БД

            if (mysqli_connect_errno()) // если не удаётся подключиться выводим сообщение
                echo 'Ошибка подключения к БД: '.mysqli_connect_error();

            $sql = 'SELECT * FROM sessions;'; // запрос для БД

            $sql_res = mysqli_query($mysqli, $sql);

            echo '<table rules="all">';

            echo '<tr><th>Номер</th>
                <th>Ссылка</th>
                <th>Статус</th>
                <th>Просмотр ответов</th>
                <th>Закрыть сессию</th>
                <th>Удалить сессию</th>
                <th>Редактировать вопросы</th></tr>';

            $i = 1;

            while ($row = mysqli_fetch_assoc($sql_res)) // пока есть записи
            {                                           // выводим каждую запись как строку таблицы
                echo '<tr><td>'.$i.'</td>
                    <td>'.$row['link'].'</td>
                    <td>'.$row['status'].'</td>
                    <td><a href="">Просмотр ответов</a></td>
                    <td><a href="">Закрыть сессию</a></td>
                    <td><a href="">Удалить сессию</a></td>
                    <td><a href="">Редактировать вопросы</a></td></tr>';
                $i++;
            }

            echo '</table>';
        

    ?>
        </body>
    </html>