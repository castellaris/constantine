<?php
try {
    // Получение данных из формы
    $firstName = $_POST['firstName'] ?? null;
    $lastName = $_POST['lastName'] ?? null;
    $gender = $_POST['gender'] ?? null;
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;
    $number = $_POST['number'] ?? null;

    if (!$firstName || !$lastName || !$gender || !$email || !$password || !$number) {
        throw new Exception('Все поля обязательны для заполнения.');
    }

    // Подключение к базе данных SQLite (создание файла базы данных, если он не существует)
    $db = new SQLite3('registration.db');

    // Создание таблицы registration, если она не существует
    $query = "CREATE TABLE IF NOT EXISTS registration (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        firstName TEXT NOT NULL,
        lastName TEXT NOT NULL,
        gender TEXT NOT NULL,
        email TEXT NOT NULL,
        password TEXT NOT NULL,
        number TEXT NOT NULL
    )";
    if (!$db->exec($query)) {
        throw new Exception('Не удалось создать таблицу.');
    }

    // Подготовка SQL-запроса для предотвращения SQL-инъекций
    $stmt = $db->prepare('INSERT INTO registration (firstName, lastName, gender, email, password, number) VALUES (:firstName, :lastName, :gender, :email, :password, :number)');
    if (!$stmt) {
        throw new Exception('Не удалось подготовить запрос.');
    }

    $stmt->bindValue(':firstName', $firstName, SQLITE3_TEXT);
    $stmt->bindValue(':lastName', $lastName, SQLITE3_TEXT);
    $stmt->bindValue(':gender', $gender, SQLITE3_TEXT);
    $stmt->bindValue(':email', $email, SQLITE3_TEXT);
    $stmt->bindValue(':password', $password, SQLITE3_TEXT);
    $stmt->bindValue(':number', $number, SQLITE3_TEXT);

    // Выполнение запроса и проверка успешности выполнения
    if (!$stmt->execute()) {
        throw new Exception('Не удалось выполнить запрос.');
    }

    echo "Регистрация успешна.";
} catch (Exception $e) {
    echo 'Ошибка: ' . $e->getMessage();
}
?>
