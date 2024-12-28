<?php

// Include the connection file
include('connection.php');

// Create an instance of the Connection class
$connection = new Connection();

// Select the "pharmacie" database
$connection->selectDatabase('pharmacie');

// Define a query to create a table (example query)
$query = "
    CREATE TABLE IF NOT EXISTS products (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        price DECIMAL(10, 2) NOT NULL,
        description TEXT
    )
";

// Call the createTable method to create the table
$connection->createTable($query);

?>
