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
        if (!isset($_GET['password']))
            echo '<form>
                    <label for="password" class="header">Введите пароль администратора ситемы:</label><br><br>
                    <input type="password" id="password" name="password"></input><br>
                    <input type="submit" name="enter" value="Войти">
                    </form>';
            
        if (isset($_GET['password']) && $_GET['password'] == '12345')
                include 'admin.php';
        
        if (isset($_GET['password']) && $_GET['password'] != '12345')
        {
            echo '<form>
                    <label for="password" class="header">Введите пароль администратора ситемы:</label><br><br>
                    <input type="password" id="password" name="password"></input><br>
                    <input type="submit" name="enter" value="Войти">
                    </form>';    
            echo '<span style="color: red;">Неверный пароль!</span>';
        }
        ?>
        
        </body>
    </html>