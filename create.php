<?php
echo '
<!DOCTYPE html>
<html lang="ru">
    <head>
        <title>Создание новой сессии</title>
        <meta charset="utf-8">
        <style>
            <?php
            require "style.css";
            ?>
            </style>
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700&display=swap" rel="stylesheet">
        </head>
    <body>
    ';
        if (!isset($num))
            $num = 1;

        // выбрать тип вопроса и ввести вопрос
        if (!isset($_POST['add_question']) && !isset($_POST['add_radio']) && !isset($_POST['add_check']))  
            echo '<form method="post">
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
            <input type="submit" name="add_question" value="Добавить"></input>
            </form>';

        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';

        if (isset($_POST['add_question']) && $_POST['add_question'] == 'Добавить')
        {
            $mysqli = mysqli_connect('std-mysql', 'std_940', '12345678', 'std_940');
    
            if (mysqli_connect_errno()) // если не удаётся подключиться выводим сообщение
                return 'Ошибка подключения к БД: '.mysqli_connect_error();
    
            $current_link = substr(str_shuffle($permitted_chars), 0, 12);

            
            
            $sql_res = mysqli_multi_query($mysqli, "INSERT INTO sessions (link, status) VALUES ('".$current_link."', 'open');
                                                INSERT INTO questions (question, type) VALUES ('".$_POST['question']."', '".$_POST['type']."';
                                                UPDATE questions 
                                                SET 
                                                    session_id = (SELECT 
                                                            id
                                                        FROM
                                                            sessions
                                                        WHERE
                                                            link = '".$current_link."')
                                                WHERE
                                                    session_id IS NULL;");

            if (mysqli_errno($mysqli))
                echo '<div class="error">Запись не добавлена: '.mysqli_error($mysqli).'</div>';
            else
                echo '<div class="ok">Запись добавлена</div>';


   
        }
        // если  выбран тип 5
        if (isset($_POST['type']) && $_POST['type'] == 'type5')
        {
            echo '<form method="post">
            <p class="header">Вопрос №'.$num.'</p>
            <label for="radio1">Введите вариант ответа 1: </label> <input required type="text" id="radio1" name="radio1"> </input><br>
            <label for="radio2">Введите вариант ответа 2: </label> <input required type="text" id="radio2" name="radio2"> </input><br>
            <label for="radio3">Введите вариант ответа 3: </label> <input required type="text" id="radio3" name="radio3"> </input><br>
            <label for="radio4">Введите вариант ответа 4: </label> <input required type="text" id="radio4" name="radio4"> </input><br>
            <input type="submit" name="add_radio" value="Добавить варианты ответов с единственным выбором"></input>
            </form>';
        }
        
        // если  выбран тип 6
        if (isset($_POST['type']) && $_POST['type'] == 'type6') // для типа 6 добавить 6 варианов ответов
        {
            echo '<form method="post">
            <p class="header">Вопрос №'.$num.'</p>
            <label for="check1">Введите вариант ответа 1: </label> <input required type="text" id="check1" name="check1"> </input><br>
            <label for="check2">Введите вариант ответа 2: </label> <input required type="text" id="check2" name="check2"> </input><br>
            <label for="check3">Введите вариант ответа 3: </label> <input required type="text" id="check3" name="check3"> </input><br>
            <label for="check4">Введите вариант ответа 4: </label> <input required type="text" id="check4" name="check4"> </input><br>
            <label for="check5">Введите вариант ответа 5: </label> <input required type="text" id="check5" name="check5"> </input><br>
            <label for="check6">Введите вариант ответа 6: </label> <input required type="text" id="check6" name="check6"> </input><br>
            <input type="submit" name="add_check" value="Добавить варианты ответов с множественным выбором"></input>
            </form>';
        }   
        if (isset($_POST['type']))
            switch ($_POST['type']) 
            {
                case 'type1':
                    if (isset($_POST['add_question']))
                        $_POST['question_done'] = 1;
                case 'type2':
                    if (isset($_POST['add_question']))
                        $_POST['question_done'] = 1;
                case 'type3':
                    if (isset($_POST['add_question']))
                        $_POST['question_done'] = 1;
                case 'type4':
                    if (isset($_POST['add_question']))
                        $_POST['question_done'] = 1;
                    break;
                case 'type5':
                    if (isset($_POST['add_radio']))
                        $_POST['question_done'] = 1;
                    break;
                case 'type6':
                    if (isset($_POST['add_check']))
                        $_POST['question_done'] = 1;
            }

        if (isset($_POST['question_done']))
            echo '<form method="post">
            <input type="submit" name="add_more" value="Добавить ещё вопрос"></input>
            <input type="submit" name="finish" value="Закончить добавление вопросов и создать сессию"></input>
            </form>
            ';  
        
        if (isset($_POST['finish']))
            echo '<p>Сессия создана: <a href="/?link='.$current_link.'</a> </p>';
    
    echo '
        </body>
    </html>';
    ?>