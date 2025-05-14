<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search_q'])) {
    $search_q = trim(strip_tags($_POST['search_q']));

    $conn = new mysqli("localhost", "root", "", "rosinka");

    if ($conn->connect_error) {
        die("Ошибка подключения: " . $conn->connect_error);
    }

    $query = "SELECT * FROM catalog WHERE name LIKE ?";
    $stmt = $conn->prepare($query);
    $search_term = $search_q . '%';
    $stmt->bind_param("s", $search_term);
    $stmt->execute();
    $result = $stmt->get_result();

    echo "<h2>Результаты поиска:</h2>";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<p><strong>{$row['name']}</strong><br>";
            echo "Описание: {$row['description']}<br>";
            echo "Категория: {$row['category']}<br>";
            echo "Цена: {$row['price']} руб.</p><hr>";
        }
    } else {
        echo "Ничего не найдено.";
    }

    $stmt->close();
    $conn->close();
}
?>
<a href="index.html">Назад на главную</a>
