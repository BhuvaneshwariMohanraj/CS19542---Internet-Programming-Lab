<?php 
session_start();
@include 'config.php';
$student_id=$_SESSION['student_id'];
$query= "SELECT c.class_id, c.class_name FROM classes c JOIN student_classes sc ON c.class_id=sc.class_id WHERE sc.student_id='$student_id'";
$classes=mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignment Submission</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 50px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .assignment-box {
            background-color: #17a2b8;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            padding: 20px;
            transition: transform 0.3s;
        }

        .assignment-box:hover {
            transform: scale(1.02);
        }

        .form-label {
            font-weight: bold;
        }

        .upload-btn {
            margin-top: 20px;
            background-color: #17a2b8;
        }

        .upload-btn:hover {
            margin-top: 20px;
            background-color:teal;
            

        .alert {
            margin-top: 20px;
        }

        .bg-primary {
            background-color: #007bff !important;
        }

        .bg-success {
            background-color: #28a745 !important;
        }

        .bg-danger {
            background-color: #dc3545 !important;
        }

        .bg-warning {
            background-color: #ffc107 !important;
        }

        .bg-info {
            background-color: #17a2b8 !important;
        }

        @media (max-width: 576px) {
            .assignment-box {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Assignment Submission</h1>
        </div>

        <div class="row">
            <div class="col-md-6 offset-md-3">
                <?php 
                if (mysqli_num_rows($classes) > 0) {
                    while ($row = mysqli_fetch_assoc($classes)) {
                        $class_id = $row['class_id'];
                        $class_name = $row['class_name'];
                        $assignment_dir = "assignments/class_$class_name/";

                        echo "<div class='assignment-box bg-custom text-white'>";
                        echo "<h2>Assignments for Class: $class_name</h2>";

                        if (is_dir($assignment_dir)) {
                            $assignments = scandir($assignment_dir);
                            if (count($assignments) > 2) {
                                foreach ($assignments as $file) {
                                    if ($file != '.' && $file != '..') {
                                        echo "<p><strong>Download assignment:</strong> <a class='text-white' href='$assignment_dir$file' download>View Assignment</a></p>";
                                    }
                                }
                            } else {
                                echo "<p>No assignments posted for this class</p>";
                            }
                        } else {
                            echo "<p>No assignments for this class</p>";
                        }
                        echo "</div>"; // Close assignment box
                    }
                } else {
                    echo "<p>You are not enrolled in any class</p>";
                }
                mysqli_data_seek($classes, 0);
                ?>
                <h2>Submit your work</h2>
                <form action="student_assignment.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Select class</label>
                        <select name="class_id" class="form-select" required>
                            <?php 
                            while ($row = mysqli_fetch_assoc($classes)) {
                                echo "<option value='" . $row['class_id'] . "'>" . $row['class_name'] . "</option>";
                                echo "<input type='hidden' name='class_name' value='" . $row['class_name'] . "'>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Upload file</label>
                        <input type="file" name="submit_file" class="form-control" required>
                    </div>
                    <button type="submit" name="submit_work" class="btn  upload-btn">Submit Assignment</button>
                </form>

                <?php 
                if (isset($_POST['submit_work'])) {
                    $class_name = $_POST['class_name'];
                    $upload_dir = "submissions/class_$class_name/";

                    if (!is_dir($upload_dir)) {
                        mkdir($upload_dir, 0777, true);
                    }
                    $file_name = $_FILES['submit_file']['name'];
                    $file_path = $_FILES['submit_file']['tmp_name'];
                    $new_file_name = "stud_id_" . $student_id . "_" . $file_name; 
                    $destination = $upload_dir . $new_file_name;
                    if (move_uploaded_file($file_path, $destination)) {
                        echo "<div class='alert alert-success'>Assignments submitted successfully!</div>";
                    } else {
                        echo "<div class='alert alert-danger'>Failed to submit assignment. Please try again.</div>";
                    }
                }
                ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
