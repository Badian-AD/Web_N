<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rosinka";

// Создание соединения
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка соединения
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}
?>
