<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['search_q'])) {
    $search_q = trim(strip_tags($_POST['search_q']));

    // Подключение к БД
    $db = new mysqli("localhost", "root", "", "anastasiia");

    if ($db->connect_error) {
        die("Ошибка подключения: " . $db->connect_error);
    }

    $stmt = $db->prepare("SELECT * FROM catalog WHERE name LIKE CONCAT(?, '%')");
    $stmt->bind_param("s", $search_q);
    $stmt->execute();
    $result = $stmt->get_result();

    echo "<h2>Результаты поиска:</h2>";

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<p><strong>Название:</strong> " . htmlspecialchars($row["name"]) . "<br>";
            echo "<strong>Описание:</strong> " . htmlspecialchars($row["description"]) . "<br>";
            echo "<strong>Категория:</strong> " . htmlspecialchars($row["category"]) . "<br>";
            echo "<strong>Цена:</strong> " . htmlspecialchars($row["price"]) . " руб.</p><hr>";
        }
    } else {
        echo "<p>Ничего не найдено.</p>";
    }

    $stmt->close();
    $db->close();
} else {
    echo "<p>Введите поисковый запрос.</p>";
}
?>
