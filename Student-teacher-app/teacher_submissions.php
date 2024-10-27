<?php 
session_start();
@include 'config.php';

$teacher_id = $_SESSION['teacher_id'];

$query = "SELECT class_id, class_name FROM classes WHERE teacher_id='$teacher_id'";
$classes = mysqli_query($conn, $query);
if (!$classes) {
    die("Query failed: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submissions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa; 
        }
        .container {
            margin-top: 20px;
            padding: 20px;
            border-radius: 10px;
            background-color: #ffffff; /* White background for the form */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
        }
        h2 {
            margin-bottom: 20px; /* Space below the heading */
        }
        table {
            width: 100%;
            margin-bottom: 20px;
        }
        th, td {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        if(mysqli_num_rows($classes) > 0) {
            while($row = mysqli_fetch_assoc($classes)) {
                $class_id = $row['class_id'];
                $class_name = $row['class_name'];
                $submission_dir = "submissions/class_$class_name/";

                echo "<h2>Submissions for Class: $class_name</h2>";

                if(is_dir($submission_dir)) {
                    $submissions = scandir($submission_dir);

                    if(count($submissions) > 2) { 
                        echo "<table class='table table-bordered'>
                              <thead class='table-light'>
                                  <tr>
                                      <th>Student ID</th>
                                      <th>Student Name</th>
                                      <th>File Name</th>
                                      <th>Download</th>
                                  </tr>
                              </thead>
                              <tbody>";

                        foreach($submissions as $file) {
                            if($file != '.' && $file != '..') {
                                if (preg_match('/^stud_id_(\d+)_(.*)$/', $file, $matches)) {
                                    $student_id = $matches[1];  
                                    $stud_name = "SELECT name FROM user_form WHERE id='$student_id'";
                                    $query1 = mysqli_query($conn, $stud_name);
                                    $original_file_name = $matches[2];  
                                    $row = mysqli_fetch_assoc($query1);
                                    $name_of_std = $row['name'];

                                    echo "<tr>
                                            <td>$student_id</td>
                                            <td>$name_of_std</td>
                                            <td>$original_file_name</td>
                                            <td><a href='$submission_dir$file' class='btn btn-success' download>Download</a></td>
                                          </tr>";
                                }
                            }
                        }

                        echo "</tbody>
                              </table>";
                    } else {
                        echo "<p>No submissions found for this class.</p>";
                    }
                } else {
                    echo "<p>No submissions directory found for this class.</p>";
                }
            }
        } else {
            echo "<p>You are not assigned to any classes.</p>";
        }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
