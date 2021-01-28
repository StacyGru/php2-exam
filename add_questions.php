<!DOCTYPE html>
<html lang="ru">
    <head>
        <title>Добавление вопросов</title>
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

        $link = $_GET['link'];

        if (!isset($num))
            $num = 1;
        if (isset($_POST['add']))
            $num++;

        // выбрать тип вопроса и ввести вопрос
        if (!isset($_POST['add']) || isset($_POST['add_more']))  
            echo '<form name="add_question" method="post" action="">
            <p class="header">Вопрос №'.$num.'</p>
            <label for="type">Выберите тип:</label><br>
            <select id="type" name="type">
                <option value="type1">с открытым ответом (число)</option>
                <option value="type2">с открытым ответом (положительное число)</option>
                <option value="type3">с открытым ответом (строка)</option>
                <option value="type4">с открытым ответом (текст)</option>
                <option value="type5">с единственным выбором</option>
                <option value="type6">с множественным выбором</option>
                </select><br>

            <label for="question">Введите вопрос: </label> <input required type="text" id="question" name="question"> </input><br>
            <input type="submit" name="add" value="Добавить"></input>
            </form>';

        if (isset($_POST['add']))
        {
            $mysqli = mysqli_connect('std-mysql', 'std_940_php2_exam', '12345678', 'std_940_php2_exam');    // подключаемся к БД

            if (mysqli_connect_errno()) // если не удаётся подключиться выводим сообщение
                echo 'Ошибка подключения к БД: '.mysqli_connect_error();

            $question = $_POST['question'];
            $type = $_POST['type'];
            $sql_res = mysqli_multi_query($mysqli, "INSERT INTO questions (question, type) VALUES ('".$question."', '".$type."');
            UPDATE questions 
            SET 
                session_id = (SELECT 
                        id
                    FROM
                        sessions
                    WHERE
                        link = '".$link."')
            WHERE
                session_id IS NULL;");


            if (mysqli_errno($mysqli))
                echo '<div class="error">Вопрос не добавлен: '.mysqli_error($mysqli).'</div>';
            else
                echo '<div class="ok">Вопрос добавлен</div>';
                echo '<form method="post" name="add_more" method="post" action="">
                    <input type="submit" name="add_more" value="Добавить ещё вопрос"></input>';
        }
    ?>
        </body>
    </html>