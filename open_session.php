<!DOCTYPE html>
<html lang="ru">
    <head>
        <title>Просмотр сессии</title>
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
        echo '<a href="/">НА ГЛАВНУЮ</a><br>';
        
        if (isset($_GET['link']))
        {
            $mysqli = mysqli_connect('std-mysql', 'std_940_php2_exam', '12345678', 'std_940_php2_exam');    // подключаемся к БД

            if (mysqli_connect_errno()) // если не удаётся подключиться выводим сообщение
                echo 'Ошибка подключения к БД: '.mysqli_connect_error();

            $link = $_GET['link'];

            $sql = "SELECT * FROM questions WHERE session_id = (SELECT id FROM sessions WHERE link = '".$link."')"; // запрос для БД

            $sql_res = mysqli_query($mysqli, $sql);

            echo '<h1>Сессия</h1>
            <form name="submit_answer" method="post" action="">';

            $i = 1;
            while ($row = mysqli_fetch_assoc($sql_res)) // пока есть записи
            {                                           // выводим каждую запись как строку таблицы
                echo '<p class="header">Вопрос №'.$i.'</p>';
                echo '<label for="'.$row['id'].'"><b>'.$row['question'].'</b></label><br>';
                echo '<input id="'.$row['id'].'" name="'.$row['id'].'" type="text">';
                $i++;
            }

            echo '<br><br><input type="submit" name="submit_answer" value="Отправить ответ"></input>
            </form>';

            if (isset($_POST['submit_answer']))
            {
                $mysqli = mysqli_connect('std-mysql', 'std_940_php2_exam', '12345678', 'std_940_php2_exam');    // подключаемся к БД

                if (mysqli_connect_errno()) // если не удаётся подключиться выводим сообщение
                    echo 'Ошибка подключения к БД: '.mysqli_connect_error();

                // $answer = $_POST[$row['id']];
                // $question = 
                // $sql = "INSERT INTO answers (answer, question_id) VALUES ('".$current_link."', 'open')"; // запрос для БД
                
            }
        }
    ?>
        </body>
    </html>