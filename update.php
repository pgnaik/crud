<?php
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $student_id = $_POST['id'];
    $rollno = $_POST['rollno'];
    $name = $_POST['name'];
    $division = $_POST['division'];

    // Update the record in the database
    $sql = "UPDATE students SET rollno = '$rollno', name = '$name', division = '$division' WHERE id = $student_id";

    if ($conn->query($sql) === TRUE) {
        // Redirect to index.php after successful update
        header('Location: index.php');
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
