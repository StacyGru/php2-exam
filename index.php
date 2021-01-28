<!DOCTYPE html>
<html lang="ru">
    <head>
        <title>Авторизация администратора системы</title>
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

        session_start();

        if (isset($_GET['logout']))
        {
            session_destroy();  // удаляем инфу о пользователе
            header('Location: /'); // перенаправление на главную страницу
            exit();
        }

        if (!isset($_SESSION['username']) && !isset($_POST['password']))   // ЕСЛИ ВХОД ЕЩЁ НЕ ПРОИЗОШЁЛ И ДАННЫЕ ДЛЯ ВХОДА НЕ ПЕРЕДАНЫ
        {
            echo '<form name="auth" method="post" action="">
                <label for="password" class="header">Введите пароль администратора ситемы:</label><br><br>
                <input type="password" id="password" name="password"></input><br>
                <input type="submit" name="enter" value="Войти">
                </form>';   // выводим форму для входа
        }

        if (!isset($_SESSION['username']) && isset($_POST['password']))  // ЕСЛИ ВХОД ЕЩЁ НЕ ПРОИЗОШЁЛ, НО ДАННЫЕ ДЛЯ ВХОДА БЫЛИ ПЕРЕДАНЫ
        {
            if ($_POST['password'] == '12345')  // если пароль верный
            {
                $_SESSION['username'] = 'admin';
                $_SESSION['password'] = '12345'; // начинаем сессию
            }
            else    // если пароль не верный
            {
                echo '<form name="auth" method="post" action="">
                    <label for="password" class="header">Введите пароль администратора ситемы:</label><br><br>
                    <input type="password" id="password" name="password"></input><br>
                    <input type="submit" name="enter" value="Войти">
                    </form>';    // выводим форму
                echo '<span style="color: red;">Неверный пароль!</span>';   // и сообщение об ошибке
            }
        }

        if (isset($_SESSION['username']))
        {
            include 'admin.php';    // подключаем функции администратора
        }

    ?>
        
        </body>
    </html>