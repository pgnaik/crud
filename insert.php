<?php
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $rollno = $_POST['rollno'];
    $name = $_POST['name'];
    $division = $_POST['division'];

    // Insert into the database
    $sql = "INSERT INTO students (rollno, name, division) VALUES ('$rollno', '$name', '$division')";
    
    if ($conn->query($sql) === TRUE) {
        // Redirect to index.php after successful insertion
        header('Location: index.php');
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
