<?php
@include 'config.php';
session_start();
$teacher_id= $_SESSION['teacher_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Class - Attendance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 600px;
            margin-top: 50px;
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
        select {
            padding: 10px;
            border-radius: 5px;
        }
        .form-group {
            margin-bottom: 20px;
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
        <?php
            $query = "SELECT class_id, class_name FROM classes WHERE teacher_id='$teacher_id'";
            $select = mysqli_query($conn, $query);
        ?>
        <form action="teacher_attendance_mark.php" method="POST">
            <h2>Select Class</h2>
            <div class="form-group">
                <select name="class_id" id="class_id" class="form-control">
                    <?php
                        while ($row = mysqli_fetch_assoc($select)) {
                            echo "<option value='" . $row['class_id'] . "'>" . $row['class_name'] . "</option>";
                        }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-custom">Mark Attendance</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
