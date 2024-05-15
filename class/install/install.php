<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
// Get the form data
$db_serwer = $_POST['db_serwer'];
$db_name = $_POST['db_name'];
$db_user = $_POST['db_user'];
$db_pass = $_POST['db_pass'];
$localhost = isset($_POST['localhost'])? 1 : 0;
$db_type = $_POST['db_type'];



// Set the database connection parameters
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
    
// Create a new PDO object
try {
  // Connect to the database server
  $conn = new PDO("{$db_type}:host={$host}", $user, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Check if the database exists
  $stmt = $conn->prepare('SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = :dbname');
  $stmt->bindParam(':dbname', $dbname);
  $stmt->execute();
  if (!$stmt->fetch()) {
    // Database does not exist, create it
    $conn->exec("CREATE DATABASE {$dbname}");
  }

  // Set the database connection parameters
  $host = $localhost? 'localhost' : $db_serwer;
  $user = $localhost? 'root' : $db_user;
  $password = $localhost? '' : $db_pass;
  $dbname = $localhost? 'pdoadmin' : $db_name;


  // Create a new PDO object
  $conn = new PDO("{$db_type}:host={$host};dbname={$dbname}", $user, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


} catch (PDOException $e) {
  die('Connection failed: '. $e->getMessage());
}

$stmt = $conn->prepare('SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = :dbname');
$stmt->bindParam(':dbname', $dbname, PDO::PARAM_STR);
$stmt->execute();
if (!$stmt->fetch()) {
  // Database does not exist, create it
  $conn->exec("CREATE DATABASE {$dbname}");
}

// Set the database connection parameters
$host = $localhost? 'localhost' : $db_serwer;
$user = $localhost? 'root' : $db_user;
$password = $localhost? '' : $db_pass;
$dbname = $localhost? 'pdoadmin' : $db_name;

// Create a new PDO object
$conn = new PDO("{$db_type}:host={$host};dbname={$dbname}", $user, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $conn->prepare('SELECT * FROM information_schema.tables WHERE table_schema = :dbname AND table_name = :tablename');
$stmt->bindParam(':dbname', $dbname, PDO::PARAM_STR);
$stmt->bindParam(':tablename', $tablename, PDO::PARAM_STR);
$stmt->execute();
if (!$stmt->fetch()) {
  // Table does not exist, create it
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


// Check if the user wants to proceed to the main program
if (isset($_POST['proceed'])) {
  // Redirect to the main program
  header('Location: ../../login.php');
  exit;
} else {
  // Display a div asking the user if they want to proceed to the main program
  echo '
    <div class="proceed-div">
      <p>Do you want to proceed to the main program?</p>
      <form action="install.php" method="post">
        <input type="hidden" name="db_serwer" value="'. $db_serwer. '">
        <input type="hidden" name="db_name" value="'. $db_name. '">
        <input type="hidden" name="db_user" value="'. $db_user. '">
        <input type="hidden" name="db_pass" value="'. $db_pass. '">
        <input type="hidden" name="db_type" value="'. $db_type. '">
        <input type="hidden" name="localhost" value="'. $localhost. '">
        <input type="submit" name="proceed" value="Yes">
      </form>
    </div>
  ';
}

// Check if the user wants to delete the cookies
if (isset($_POST['delete_cookies'])) {
  // Delete the cookies
  setcookie('db_serwer', '', time() - 3600, "/");
  setcookie('db_name', '', time() - 3600, "/");
  setcookie('db_user', '', time() - 3600, "/");
  setcookie('db_pass', '', time() - 3600, "/");
  setcookie('db_type', '', time() - 3600, "/");

  // Redirect to the install.php file
  header('Location: install.php');
  exit;
} else {
  // Display a div asking the user if they want to delete the cookies
  echo '
    <div class="delete-cookies-div">
      <p>Do you want to delete the cookies?</p>
      <form action="install.php" method="post">
        <input type="hidden" name="db_serwer" value="'. $db_serwer. '">
        <input type="hidden" name="db_name" value="'. $db_name. '">
        <input type="hidden" name="db_user" value="'. $db_user. '">
        <input type="hidden" name="db_pass" value="'. $db_pass. '">
        <input type="hidden" name="db_type" value="'. $db_type. '">
        <input type="hidden" name="localhost" value="'. $localhost. '">
        <input type="submit" name="delete_cookies" value="Yes">
      </form>
    </div>
  ';
}

// Close the database connection
$conn = null;
?>
<style>
.proceed-div, .delete-cookies-div {
  background-color: #f9f9f9;
  border: 1px solid #ddd;
  border-radius: 5px;
  padding: 10px;
  margin-top: 20px;
  text-align: center;
}

.proceed-div form, .delete-cookies-div form {
  margin-top: 10px;
}
</style>