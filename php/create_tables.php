<?php
$servername = "127.0.0.1";
$username = "root";
$password = "amandine";
$dbname = "articles";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
} 

// sql to create table
$sql = "CREATE TABLE IF NOT EXISTS Libelle(
  label       VARCHAR(32)     NOT NULL    PRIMARY KEY   COMMENT'Label of the libelle',
  category    VARCHAR(32)     NOT NULL    COMMENT'Category of the label'
);";
if ($conn->query($sql) === TRUE) {
  echo "Table Libelle created successfully";
} else {
  echo "Error creating table: " . $conn->error;
}

// sql to create table
$sql = "CREATE TABLE IF NOT EXISTS Article(
  id              INTEGER         AUTO_INCREMENT    PRIMARY KEY   COMMENT'Artile identification.',
  title           VARCHAR(50)     NOT NULL          COMMENT'Article identification',
  descrip         VARCHAR(300)    NOT NULL          COMMENT'Article description',
  label           VARCHAR(32)     NOT NULL          COMMENT'Article label',
  img_path        VARCHAR(50)                       COMMENT'Article image',
  content         VARCHAR(50)     NOT NULL          COMMENT'Article content',
  author          VARCHAR(32)                       COMMENT'Article author',
  date_creation   DATETIME        NOT NULL          COMMENT'Article date creation'
) AUTO_INCREMENT = 1;";
if ($conn->query($sql) === TRUE) {
  echo "<br/>Table Article created successfully";
} else {
  echo "<br/>Error creating table: " . $conn->error;
}

// sql to create foreign key constraint
$sql = "ALTER TABLE Article ADD CONSTRAINT FK_libelle FOREIGN KEY(label) REFERENCES Libelle(label);";
if ($conn->query($sql) === TRUE) {
  echo "<br/>Foreign key 'Libelle' created successfully";
} else {
  echo "<br/>Error creating foreign key --> libelle : " . $conn->error;
}

$conn->close();
?>