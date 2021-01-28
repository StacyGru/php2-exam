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
        
        echo '<form name="add" method="post" action="">
            <input type="submit" name="finish" value="Cоздать сессию"></input>
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
                $link = '/?link='.$current_link;
                echo '<div class="ok">Сессия добавлена: <a href='.$link.'>ссылка</a></div>';
            }
        }



    ?>
        </body>
    </html>