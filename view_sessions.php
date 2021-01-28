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
                $link = '/view_sessions.php?link='.$row['link'];
                echo '<tr><td>'.$i.'</td>
                    <td>'.$row['link'].'</td>
                    <td>'.$row['status'].'</td>
                    <td><a href="'.$link.'">Просмотр ответов</a></td>
                    <td><a href="'.$link.'&status=close">Закрыть сессию</a></td>
                    <td><a href="'.$link.'&delete=yes">Удалить сессию</a></td>
                    <td><a href="'.$link.'">Редактировать вопросы</a></td></tr>';
                $i++;
            }

            echo '</table>';

            if (isset($_GET['delete']) && $_GET['delete'] == 'yes')
            {
                $mysqli = mysqli_connect('std-mysql', 'std_940_php2_exam', '12345678', 'std_940_php2_exam');    // подключаемся к БД

                if (mysqli_connect_errno()) // если не удаётся подключиться выводим сообщение
                    echo 'Ошибка подключения к БД: '.mysqli_connect_error();

                $link = $_GET['link'];

                $sql = "DELETE FROM sessions WHERE link = '$link'";

                $sql_res = mysqli_query($mysqli, $sql);

                if (mysqli_errno($mysqli))
                    echo '<div class="error">Сессия не удалена: '.mysqli_error($mysqli).'</div>';
                else    
                {
                    header( "Location: view_sessions.php" );
                }                
            }
        

    ?>
        </body>
    </html>