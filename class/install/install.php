<?php
/**
 * Plik instalacyjny aplikacji.
 *
 * Plik instalacyjny zawiera kod odpowiedzialny za tworzenie bazy danych, tabeli użytkowników oraz obsługę formularzy.
 * Zawiera również funkcje do zapisywania danych logowania do plików cookie oraz przekierowywanie użytkownika do głównego programu.
 *
 * @package UserManagementSystem
 * @subpackage Install
 */

// FILEPATH: /d:/xampp/htdocs/user-management-system-php/class/install/install.php

// Ustaw raportowanie błędów
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

// Pobierz dane z formularza
$db_serwer = $_POST['db_serwer'];
$db_name = $_POST['db_name'];
$db_user = $_POST['db_user'];
$db_pass = $_POST['db_pass'];
$localhost = isset($_POST['localhost'])? 1 : 0;
$db_type = $_POST['db_type'];

// Ustaw parametry połączenia z bazą danych
$host = $localhost? 'localhost' : $db_serwer;
$user = $localhost? 'root' : $db_user;
$password = $localhost? '' : $db_pass;
$dbname = $localhost? 'pdoadmin' : $db_name;

// Zapisz pliki cookie z danymi logowania do bazy danych
setcookie('db_serwer', $host, time() + (86400 * 30), "/");
setcookie('db_name', $dbname, time() + (86400 * 30), "/");
setcookie('db_user', $user, time() + (86400 * 30), "/");
setcookie('db_pass', $password, time() + (86400 * 30), "/");
setcookie('db_type', $db_type, time() + (86400 * 30), "/");

// Utwórz nowy obiekt PDO
try {
  // Połącz się z serwerem bazy danych
  $conn = new PDO("{$db_type}:host={$host}", $user, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Sprawdź, czy baza danych istnieje
  $stmt = $conn->prepare('SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = :dbname');
  $stmt->bindParam(':dbname', $dbname);
  $stmt->execute();
  if (!$stmt->fetch()) {
    // Baza danych nie istnieje, utwórz ją
    $conn->exec("CREATE DATABASE {$dbname}");
  }

  // Ponownie ustaw parametry połączenia z bazą danych
  $host = $localhost? 'localhost' : $db_serwer;
  $user = $localhost? 'root' : $db_user;
  $password = $localhost? '' : $db_pass;
  $dbname = $localhost? 'pdoadmin' : $db_name;

  // Utwórz nowy obiekt PDO
  $conn = new PDO("{$db_type}:host={$host};dbname={$dbname}", $user, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
  die('Connection failed: '. $e->getMessage());
}

$stmt = $conn->prepare('SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = :dbname');
$stmt->bindParam(':dbname', $dbname, PDO::PARAM_STR);
$stmt->execute();
if (!$stmt->fetch()) {
  // Baza danych nie istnieje, utwórz ją
  $conn->exec("CREATE DATABASE {$dbname}");
}

// Ponownie ustaw parametry połączenia z bazą danych
$host = $localhost? 'localhost' : $db_serwer;
$user = $localhost? 'root' : $db_user;
$password = $localhost? '' : $db_pass;
$dbname = $localhost? 'pdoadmin' : $db_name;

// Utwórz nowy obiekt PDO
$conn = new PDO("{$db_type}:host={$host};dbname={$dbname}", $user, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $conn->prepare('SELECT * FROM information_schema.tables WHERE table_schema = :dbname AND table_name = :tablename');
$stmt->bindParam(':dbname', $dbname, PDO::PARAM_STR);
$stmt->bindParam(':tablename', $tablename, PDO::PARAM_STR);
$stmt->execute();
if (!$stmt->fetch()) {
  // Tabela nie istnieje, utwórz ją
  $conn->exec("
  CREATE TABLE IF NOT EXISTS user (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(50) NOT NULL,
    gender ENUM('male', 'female') NOT NULL,
    mobile VARCHAR(50),
    designation VARCHAR(50),
    image VARCHAR(255),
    type VARCHAR(255) NOT NULL,
    status ENUM('active', 'pending','deleted') NOT NULL,
    authtoken VARCHAR(255)
);
  ");
}

// Sprawdź, czy użytkownik chce przejść do głównego programu
if (isset($_POST['proceed'])) {
  // Przekieruj do głównego programu
  header('Location: ../../login.php');
  exit;
} else {
  // Wyświetl div z pytaniem, czy użytkownik chce przejść do głównego programu
  echo '
    <div class="proceed-div">
      <p>Czy chcesz przejść do głównego programu?</p>
      <form action="install.php" method="post">
        <input type="hidden" name="db_serwer" value="'. $db_serwer. '">
        <input type="hidden" name="db_name" value="'. $db_name. '">
        <input type="hidden" name="db_user" value="'. $db_user. '">
        <input type="hidden" name="db_pass" value="'. $db_pass. '">
        <input type="hidden" name="db_type" value="'. $db_type. '">
        <input type="hidden" name="localhost" value="'. $localhost. '">
        <input type="submit" name="proceed" value="Tak">
      </form>
    </div>
  ';
}

// Sprawdź, czy użytkownik chce usunąć pliki cookie
if (isset($_POST['delete_cookies'])) {
  // Usuń pliki cookie
  setcookie('db_serwer', '', time() - 3600, "/");
  setcookie('db_name', '', time() - 3600, "/");
  setcookie('db_user', '', time() - 3600, "/");
  setcookie('db_pass', '', time() - 3600, "/");
  setcookie('db_type', '', time() - 3600, "/");

  // Przekieruj do pliku install.php
  header('Location: install.php');
  exit;
} else {
  // Wyświetl div z pytaniem, czy użytkownik chce usunąć pliki cookie
  echo '
    <div class="delete-cookies-div">
      <p>Czy chcesz usunąć pliki cookie?</p>
      <form action="install.php" method="post">
        <input type="hidden" name="db_serwer" value="'. $db_serwer. '">
        <input type="hidden" name="db_name" value="'. $db_name. '">
        <input type="hidden" name="db_user" value="'. $db_user. '">
        <input type="hidden" name="db_pass" value="'. $db_pass. '">
        <input type="hidden" name="db_type" value="'. $db_type. '">
        <input type="hidden" name="localhost" value="'. $localhost. '">
        <input type="submit" name="delete_cookies" value="Tak">
      </form>
    </div>
  ';
}

// Zamknij połączenie z bazą danych
$conn = null;
