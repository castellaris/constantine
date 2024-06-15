<?php
// Get form data
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$gender = $_POST['gender'];
$email = $_POST['email'];
$password = $_POST['password'];
$number = $_POST['number'];

// Connect to SQLite database (create database file if it doesn't exist)
$db = new SQLite3('registration.db');

// Create registration table if it doesn't exist
$query = "CREATE TABLE IF NOT EXISTS registration (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    firstName TEXT NOT NULL,
    lastName TEXT NOT NULL,
    gender TEXT NOT NULL,
    email TEXT NOT NULL,
    password TEXT NOT NULL,
    number TEXT NOT NULL
)";
$db->exec($query);

// Prepare SQL statement to prevent SQL injection
$stmt = $db->prepare('INSERT INTO registration (firstName, lastName, gender, email, password, number) VALUES (:firstName, :lastName, :gender, :email, :password, :number)');
$stmt->bindValue(':firstName', $firstName, SQLITE3_TEXT);
$stmt->bindValue(':lastName', $lastName, SQLITE3_TEXT);
$stmt->bindValue(':gender', $gender, SQLITE3_TEXT);
$stmt->bindValue(':email', $email, SQLITE3_TEXT);
$stmt->bindValue(':password', $password, SQLITE3_TEXT);
$stmt->bindValue(':number', $number, SQLITE3_TEXT);

// Execute the statement and check if it was successful
if ($stmt->execute()) {
    echo "Registration successful.";
} else {
    echo "Registration failed.";
}

// Close the database connection
$db->close();
?>
