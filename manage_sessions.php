<!DOCTYPE html>
<html lang="ru">
    <head>
        <title>Управление сессиями</title>
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
            echo '<a href="/">НА ГЛАВНУЮ</a>';

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
                $link = '/manage_sessions.php?link='.$row['link'];
                echo '<tr><td>'.$i.'</td>
                    <td><a href="/open_session.php?link='.$row['link'].'">'.$row['link'].'</a></td>
                    <td>'.$row['status'].'</td>
                    <td><a href="'.$link.'">Просмотр ответов</a></td>
                    <td><a href="'.$link.'&status=close">Закрыть сессию</a></td>
                    <td><a href="'.$link.'&delete=yes">Удалить сессию</a></td>
                    <td><a href="manage_questions.php?link='.$row['link'].'">Редактировать вопросы</a></td></tr>';
                    // edit_question.php?link='.$row['link']. - добавление вопросов
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
                    echo '<meta http-equiv=Refresh content="0;url=manage_sessions.php?reload=1">';
            }

            if (isset($_GET['status']) && $_GET['status'] == 'close')
            {
                $mysqli = mysqli_connect('std-mysql', 'std_940_php2_exam', '12345678', 'std_940_php2_exam');    // подключаемся к БД

                if (mysqli_connect_errno()) // если не удаётся подключиться выводим сообщение
                    echo 'Ошибка подключения к БД: '.mysqli_connect_error();

                $link = $_GET['link'];

                $sql = "UPDATE sessions SET status = 'close' WHERE link = '".$link."';";

                $sql_res = mysqli_query($mysqli, $sql);

                if (mysqli_errno($mysqli))
                    echo '<div class="error">Сессия не закрыта: '.mysqli_error($mysqli).'</div>';
                else
                    echo '<meta http-equiv=Refresh content="0;url=manage_sessions.php?reload=1">';
            }
?>
        </body>
    </html>