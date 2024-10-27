<?php
@include 'config.php';
session_start();
$student_id = $_SESSION['student_id'];
$query = "SELECT c.class_name, a.date, a.status FROM attendance a JOIN classes c ON a.class_id = c.class_id WHERE a.student_id='$student_id'";
$attendance = mysqli_query($conn, $query);
$current_class = null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Attendance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 800px;
            margin-top: 30px;
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #343a40;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #dee2e6;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        td {
            background-color: #f8f9fa;
        }
        h3 {
            color: #007bff;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Your Attendance</h2>
        <?php 
        if (mysqli_num_rows($attendance) > 0) {
            while ($row = mysqli_fetch_assoc($attendance)) {
                if ($row['class_name'] !== $current_class) {
                    if ($current_class !== null) {
                        echo "</table>";
                    }
                    
                    $current_class = $row['class_name'];
                    echo "<h3 class='text-dark text-center'>Class: " . $current_class . "</h3>";
                    echo "<table class='table table-bordered'>
                            <thead>
                                <tr>
                                    <th class='text-primary'>Date</th>
                                    <th class='text-primary'>Status</th>
                                </tr>
                            </thead>
                            <tbody>";
                }
        
                // Display the attendance record for the current row
                echo "<tr>
                        <td>" . $row['date'] . "</td>
                        <td>" . $row['status'] . "</td>
                      </tr>";
            }
        
            // Close the last table
            echo "</tbody></table>";
        } else {
            echo "<p>No attendance records found.</p>";
        }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
