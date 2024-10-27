<?php
session_start();
@include 'config.php';
$class_id = $_POST['class_id'];
$query = "SELECT id, name FROM user_form u JOIN student_classes sc ON sc.student_id=u.id WHERE sc.class_id = '$class_id'";
$students = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mark Attendance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 800px;
            margin-top: 50px;
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #343a40;
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
            margin-right: 10px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .student-entry {
            margin-bottom: 10px;
        }
        .btn-custom {
            background-color: #007bff;
            color: white;
            width: 100%;
            padding: 10px;
            border-radius: 5px;
        }
        .btn-custom:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Mark Attendance for Class</h1>
        <form method="POST" action="">
            <input type="hidden" name="class_id" value="<?= $class_id; ?>">
            
            <!-- Attendance Date -->
            <div class="form-group">
                <label for="attendance_date">Date:</label>
                <input type="date" id="attendance_date" name="attendance_date" class="form-control" required>
            </div>
            
            <!-- Students Attendance -->
            <?php
            while ($row = mysqli_fetch_assoc($students)) {
                echo "<div class='form-group student-entry'>";
                echo "<label>" . $row['name'] . ":</label>";
                echo "<div class='form-check form-check-inline'>";
                echo "<input class='form-check-input' type='radio' name='attendance[" . $row['id'] . "]' value='Present' required>";
                echo "<label class='form-check-label'>Present</label>";
                echo "</div>";
                echo "<div class='form-check form-check-inline'>";
                echo "<input class='form-check-input' type='radio' name='attendance[" . $row['id'] . "]' value='Absent' required>";
                echo "<label class='form-check-label'>Absent</label>";
                echo "</div>";
                echo "</div>";
            }
            ?>
            
            <!-- Submit Button -->
            <button type="submit" name="submit_attendance" class="btn btn-custom">Submit Attendance</button>
        </form>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
if (isset($_POST['submit_attendance'])) {
    $attendance_date = $_POST['attendance_date'];
    $attendance = $_POST['attendance'];
    
    foreach ($attendance as $student_id => $status) {
        $insert = "INSERT INTO attendance (student_id, class_id, date, status) VALUES ('$student_id', '$class_id', '$attendance_date', '$status')";
        mysqli_query($conn, $insert);
    }
}
?>
