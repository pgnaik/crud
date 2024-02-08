<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <div class="text-center mb-4">
        <h2 class="bg-danger text-white rounded-pill p-3">Edit Student</h2>
    </div>

    <?php
    include 'includes/db.php';

    // Check if 'id' parameter is set in the URL
    if (isset($_GET['id'])) {
        // Get the student ID from the URL
        $student_id = $_GET['id'];

        // Fetch existing student details from the database
        $result = $conn->query("SELECT * FROM students WHERE id = $student_id");

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            ?>
            <form action="update.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <div class="form-group">
                    <label for="rollno">Roll No:</label>
                    <input type="text" class="form-control" id="rollno" name="rollno" value="<?php echo $row['rollno']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $row['name']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="division">Division:</label>
                    <input type="text" class="form-control" id="division" name="division" value="<?php echo $row['division']; ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Update Student</button>
            </form>
            <?php
        } else {
            echo "Student not found.";
        }
    } else {
        echo "Invalid request. Please provide a student ID to edit.";
    }

    $conn->close();
    ?>

</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
