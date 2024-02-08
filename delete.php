<?php
include 'includes/db.php';

// Check if 'id' parameter is set in the URL
if (isset($_GET['id'])) {
    // Get the student ID from the URL
    $student_id = $_GET['id'];

    // Delete the record from the database
    $sql = "DELETE FROM students WHERE id = $student_id";

    if ($conn->query($sql) === TRUE) {
        // Redirect to index.php after successful deletion
        header('Location: index.php');
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "Invalid request. Please provide a student ID to delete.";
}

$conn->close();
?>
