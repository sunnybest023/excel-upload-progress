<?php
// Create a new MySQLi instance to connect to the database
$mysqli = new mysqli('localhost', 'root', '', 'employee');

// Check if the connection was successful
if ($mysqli->connect_error) {
    // If there's a connection error, output the error message and terminate the script
    die("Connection failed: " . $mysqli->connect_error);
}

// Connection was successful, you can now use $mysqli to interact with the database
?>
