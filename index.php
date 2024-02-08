<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student CRUD Application</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .action-icons {
            font-size: 1.2rem;
            margin-right: 5px;
        }

        .editable-cell input {
            width: 100%;
        }
    </style>
</head>

<body>

    <div class="container mt-5">
        <div class="text-center mb-4">
            <h2 class="bg-primary text-white rounded-pill p-3">Student CRUD Application</h2>
        </div>
       
        
        <?php
         include 'includes/db.php';
// Fetch total number of records for pagination
$totalRecordsQuery = $conn->query("SELECT COUNT(*) as total FROM students");
$totalRecords = $totalRecordsQuery->fetch_assoc()['total'];

// Count students in different divisions
$divisionACountQuery = $conn->query("SELECT COUNT(*) as count FROM students WHERE division = 'A'");
$divisionACount = $divisionACountQuery->fetch_assoc()['count'];

$divisionBCountQuery = $conn->query("SELECT COUNT(*) as count FROM students WHERE division = 'B'");
$divisionBCount = $divisionBCountQuery->fetch_assoc()['count'];

$divisionCCountQuery = $conn->query("SELECT COUNT(*) as count FROM students WHERE division = 'C'");
$divisionCCount = $divisionCCountQuery->fetch_assoc()['count'];
?>

<!-- Display Total Students -->

<!-- Total Students Badge -->
Total Students: <span class="badge badge-primary"><?php echo $totalRecords; ?></span><br>

<!-- Students in Different Divisions Badges -->
Division A: <span class="badge badge-secondary"><?php echo $divisionACount; ?></span><br>
Division B: <span class="badge badge-secondary"><?php echo $divisionBCount; ?></span><br>
Division C: <span class="badge badge-secondary"><?php echo $divisionCCount; ?></span><br>
<!-- Add more badges for other divisions if needed -->
<br>

<!-- Add more badges for other divisions if needed -->

        <a href="create.php" class="btn btn-success mb-3">Add New Student</a>

        <?php
       

        // Pagination
        $resultsPerPage = 5; // You can change this as per your preference
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $startFrom = ($currentPage - 1) * $resultsPerPage;

        // Fetch total number of records for pagination
        $totalRecordsQuery = $conn->query("SELECT COUNT(*) as total FROM students");
        $totalRecords = $totalRecordsQuery->fetch_assoc()['total'];

        // Sorting logic
        $orderBy = isset($_GET['orderBy']) ? $_GET['orderBy'] : 'id';
        $orderType = isset($_GET['orderType']) ? $_GET['orderType'] : 'ASC';

        // Fetch records from the database with sorting and pagination
        $result = $conn->query("SELECT * FROM students ORDER BY $orderBy $orderType LIMIT $startFrom, $resultsPerPage");

        if ($result) {
            if ($result->num_rows > 0) {
                echo '<table class="table table-striped table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th><a href="?page=' . $currentPage . '&orderBy=rollno&orderType=' . ($orderBy == 'rollno' && $orderType == 'ASC' ? 'DESC' : 'ASC') . '">Roll No</a></th>
                                <th><a href="?page=' . $currentPage . '&orderBy=name&orderType=' . ($orderBy == 'name' && $orderType == 'ASC' ? 'DESC' : 'ASC') . '">Name</a></th>
                                <th><a href="?page=' . $currentPage . '&orderBy=division&orderType=' . ($orderBy == 'division' && $orderType == 'ASC' ? 'DESC' : 'ASC') . '">Division</a></th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>';

                while ($row = $result->fetch_assoc()) {
                    echo '<tr>
                            <td class="editable-cell" data-field="rollno" data-id="' . $row['id'] . '">' . $row['rollno'] . '</td>
                            <td class="editable-cell" data-field="name" data-id="' . $row['id'] . '">' . $row['name'] . '</td>
                            <td class="editable-cell" data-field="division" data-id="' . $row['id'] . '">' . $row['division'] . '</td>
                            <td>
                                <button class="btn btn-primary btn-sm action-icons edit-btn" data-id="' . $row['id'] . '"><i class="fas fa-edit"></i> Edit</button>
                                <button class="btn btn-success btn-sm action-icons save-btn" data-id="' . $row['id'] . '" style="display:none;"><i class="fas fa-check"></i> OK</button>
                                <button class="btn btn-secondary btn-sm action-icons cancel-btn" data-id="' . $row['id'] . '" style="display:none;"><i class="fas fa-times"></i> Cancel</button>
                                <a href="delete.php?id=' . $row['id'] . '" class="btn btn-danger btn-sm action-icons" onclick="return confirm(\'Are you sure you want to delete this student?\')"><i class="fas fa-trash"></i> Delete</a>
                            </td>
                        </tr>';
                }

                echo '</tbody></table>';

                // Pagination links
                $totalPages = ceil($totalRecords / $resultsPerPage);
                echo '<nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">';

                for ($i = 1; $i <= $totalPages; $i++) {
                    echo '<li class="page-item ' . ($i == $currentPage ? 'active' : '') . '"><a class="page-link" href="?page=' . $i . '&orderBy=' . $orderBy . '&orderType=' . $orderType . '">' . $i . '</a></li>';
                }

                echo '</ul>
                    </nav>';
            } else {
                echo '<p>No records found</p>';
            }
        } else {
            echo '<p>Error fetching records: ' . $conn->error . '</p>';
        }

        $conn->close();
        ?>

        <!-- Learn More Button with Tooltip -->
<button type="button" class="btn btn-primary" data-toggle="collapse" data-target="#learnMore" data-toggle="tooltip" data-placement="top" title="Program Features">Learn More</button>

<!-- Help Button with Tooltip - Opens Modal -->
<button type="button" class="btn btn-info" data-toggle="modal" data-target="#helpModal" data-toggle="tooltip" data-placement="top" title="Program Features">Help</button>

        <div id="learnMore" class="collapse mt-3">
            <p><font color='blue'>Features of the Application:</font></p>
            <ul>
                <li>Sorting of records</li>
                <li>Pagination for easy navigation</li>
                <li>In-place editing of student information</li>
            </ul>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="helpModal" tabindex="-1" role="dialog" aria-labelledby="helpModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="helpModalLabel">Help</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Information about the application's features goes here -->
                        <p>Sorting, pagination, and in-place editing are some of the key features of this application.</p>
                        <p>...</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>

    <script>
        $(document).ready(function () {
            $(".edit-btn").click(function () {
                var id = $(this).data("id");
                $(".editable-cell[data-id='" + id + "']").each(function () {
                    var field = $(this).data("field");
                    var value = $(this).text();
                    $(this).html('<input type="text" class="form-control" name="' + field + '" value="' + value + '">');
                });
                $(this).hide();
                $(".save-btn[data-id='" + id + "']").show();
                $(".cancel-btn[data-id='" + id + "']").show();
            });

            $(".cancel-btn").click(function () {
                var id = $(this).data("id");
                $(".editable-cell[data-id='" + id + "']").each(function () {
                    var value = $(this).find("input").val();
                    $(this).html(value);
                });
                $(".edit-btn[data-id='" + id + "']").show();
                $(".save-btn[data-id='" + id + "']").hide();
                $(this).hide();
            });

            $(".save-btn").click(function () {
                var id = $(this).data("id");
                var data = {};
                $(".editable-cell[data-id='" + id + "']").each(function () {
                    var field = $(this).data("field");
                    var value = $(this).find("input").val();
                    $(this).html(value);
                    data[field] = value;
                });
                $(".edit-btn[data-id='" + id + "']").show();
                $(".cancel-btn[data-id='" + id + "']").hide();
                $(".save-btn[data-id='" + id + "']").hide();
                $.ajax({
                    type: "POST",
                    url: "update.php",
                    data: { id: id, data: data },
                    success: function (response) {
                        console.log(response);
                    }
                });
            });
        });
    </script>

</body>

</html>
