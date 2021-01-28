<!DOCTYPE html>
<html lang="ru">
    <head>
        <title>Управление вопросами сессии</title>
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

            $link = $_GET['link'];

            $sql = "SELECT * FROM questions WHERE session_id = (SELECT id FROM sessions WHERE link = '".$link."')"; // запрос для БД

            $sql_res = mysqli_query($mysqli, $sql);

            echo '<table rules="all">';

            echo '<tr><th>Номер</th>
                <th>Вопрос</th>
                <th>Тип</th>
                <th>Редактировать вопрос</th>
                <th>Удалить вопрос</th></tr>';

            $i = 1;

            while ($row = mysqli_fetch_assoc($sql_res)) // пока есть записи
            {                                           // выводим каждую запись как строку таблицы
                echo '<tr><td>'.$i.'</td>
                    <td>'.$row['question'].'</td>
                    <td>'.$row['type'].'</td>
                    <td><a href="/edit_question.php?link='.$link.'&question_id='.$row['id'].'">Редактировать вопрос</a></td>
                    <td><a href="/manage_questions.php?link='.$link.'&question_id='.$row['id'].'&delete=yes">Удалить вопрос</a></td></tr>';
                $i++;
            }

            echo '</table>';

            echo '<a href="/edit_question.php?link='.$link.'">Добавить вопросы</a>';

            if (isset($_GET['delete']) && $_GET['delete'] == 'yes')
            {
                $mysqli = mysqli_connect('std-mysql', 'std_940_php2_exam', '12345678', 'std_940_php2_exam');    // подключаемся к БД

                if (mysqli_connect_errno()) // если не удаётся подключиться выводим сообщение
                    echo 'Ошибка подключения к БД: '.mysqli_connect_error();

                $question_id = $_GET['question_id'];

                $sql = "DELETE FROM questions WHERE id = '$question_id'";

                $sql_res = mysqli_query($mysqli, $sql);

                if (mysqli_errno($mysqli))
                    echo '<div class="error">Вопрос не удалён: '.mysqli_error($mysqli).'</div>';
                else
                    echo '<meta http-equiv=Refresh content="0;url=manage_questions.php?link='.$link.'&reload=1">';
            }

        ?>
        </body>
    </html>