<?php
$servername = "192.168.64.2";
$username = "root";
$password = "";
$dbname = "articles.db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
} 

// sql to create table
$sql = "CREATE TABLE Libelle(
  label       VARCHAR(32)     NOT NULL    PRIMARY KEY,
  category    VARCHAR(32)     NOT NULL
)";

if ($conn->query($sql) === TRUE) {
  echo "Table MyGuests created successfully";
} else {
  echo "Error creating table: " . $conn->error;
}

$conn->close();
?>