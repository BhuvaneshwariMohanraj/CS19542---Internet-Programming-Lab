<?php
session_start();
include 'config.php'; // DB connection

$teacher_id = $_SESSION['teacher_id'];

// Fetch courses taught by the teacher
$query = "SELECT class_id, class_name FROM classes WHERE teacher_id = '$teacher_id'";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher's Courses</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 50px;
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }
        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            border: none;
            padding: 20px;
        }
        .list-group-item {
            background-color: #fdfdfd;
            border: none;
        }
        .list-group-item a {
            text-decoration: none;
            color: primary;
            font-weight: bold;
        }
        .list-group-item a:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <h2><strong>Courses</strong></h2>
                    <ul class="list-group list-group-flush">
                        <?php while ($row = mysqli_fetch_assoc(result: $result)): ?>
                            <li class="list-group-item">
                                <a href="input_grade_teacher.php?class_id=<?php echo $row['class_id']; ?>">
                                    <?php echo $row['class_name']; ?>
                                </a>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
