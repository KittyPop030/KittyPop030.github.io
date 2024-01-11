<?php
define("DB_HOST", "sql12.freesqldatabase.com");
define("DB_NAME", "sql12676163");
define("DB_USER", "sql12676163");
define("DB_PASS", "1jDXz8GGxx");

try {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
} catch (mysqli_sql_exception $ex) {
    // Something went wrong...
    echo "<p>Error: Unable to connect to the database.</p>";
    echo "<p>Debugging errno: " . $ex->getCode() . "</p>";
    echo "<p>Debugging error: " . $ex->getMessage() . "</p>";
    exit;
}
?>
