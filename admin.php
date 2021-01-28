<?php
    
    echo "<link rel='stylesheet' href='style.css'>";

    if (session_status() != 2)
        session_start();
    
    if (!isset($_SESSION['username']))
    {
        echo 'Необходима авторизация';
        exit;
    }

    echo '<a href="index.php/?logout=">Выход</a><br><br>';

    echo '<a href="/create_session.php" style="color: green;">Создать новую сессию</a><br>';
    echo '<a href="/manage_sessions.php" style="color: blue;">Управление сессиями</a><br>';
?>