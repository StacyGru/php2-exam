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
    <?php
        
        echo '<a href="/">НА ГЛАВНУЮ</a>';

        // if (!isset($num))
        //     $num = 1;

        // // выбрать тип вопроса и ввести вопрос
        // if (!isset($_POST['add_question']) && !isset($_POST['add_radio']) && !isset($_POST['add_check']))  
        //     echo '<form method="post">
        //     <p class="header">Вопрос №'.$num.'</p>
        //     <label for="type">Выберите тип:</label><br>
        //     <select id="type" name="type">
        //         <option value="type1">с открытым ответом (число)</option>
        //         <option value="type2">с открытым ответом (положительное число)</option>
        //         <option value="type3">с открытым ответом (строка)</option>
        //         <option value="type4">с открытым ответом (текст)</option>
        //         <option value="type5">с единственным выбором</option>
        //         <option value="type6">с множественным выбором</option>
        //         </select><br>

        //     <label for="question">Введите вопрос: </label> <input required type="text" id="question" name="question"> </input><br>
        //     <input type="submit" name="add_question" value="Добавить"></input>
        //     </form>';

        if (!isset($_POST['finish']))
            echo '<form name="create_session" method="post" action="">
                <input type="submit" name="finish" value="Создать сессию"></input>
                </form>';  //   кнопка создать сессию
        
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
        $current_link = substr(str_shuffle($permitted_chars), 0, 12);   // генерация ссылки на сессию

        if (isset($_POST['finish']))    // если нажата кнопка создать сессию
        {
            $mysqli = mysqli_connect('std-mysql', 'std_940_php2_exam', '12345678', 'std_940_php2_exam');    // подключаемся к БД

            if (mysqli_connect_errno()) // если не удаётся подключиться выводим сообщение
                echo 'Ошибка подключения к БД: '.mysqli_connect_error();

            $sql_res = mysqli_multi_query($mysqli, "INSERT INTO sessions (link, status) VALUES ('".$current_link."', 'open');");    // вносим запись о созданной сессии

            if (mysqli_errno($mysqli))
                echo '<div class="error">Сессия не добавлена: '.mysqli_error($mysqli).'</div>';
            else
            {
                $link = '/open_session.php?link='.$current_link;
                echo '<div class="ok">Сессия добавлена: <a href='.$link.'>ссылка</a></div>';
                echo '<a href="/add_questions.php?link='.$current_link.'">Добавить вопросы</a>';
            }
        }
    ?>
        </body>
    </html>