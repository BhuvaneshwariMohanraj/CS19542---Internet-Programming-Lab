<?php
session_start();
include 'config.php';

if (!isset($_SESSION['student_id'])) {
    echo "Student ID not found in session.";
    exit;
}

$student_id = $_SESSION['student_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Grades</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }
        h2 {
            text-align: center;
            margin: 20px 0;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 30px;
        }
        th, td {
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        
        tr:hover {
            background-color: #e0f7fa;
        }
        .table-container {
            margin: 20px auto;
            width: 80%;
        }
        .student-info {
            margin: 20px; 
            padding: 10px;
            font-size: 1.1rem;
            border: 1px solid #ddd; 
            background-color: #f2f2f2;
            border-radius: 5px;
        }
        .table-container h3 {
            color: teal;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="student-info">
            Logged in as Student ID: <?php echo htmlspecialchars($student_id, ENT_QUOTES, 'UTF-8'); ?>
        </div>

        <h2 class="text-success">Your Grades</h2>

        <?php
        $query = "
            SELECT c.class_name, sg.cat_type, sg.grade 
            FROM student_grades sg
            JOIN classes c ON sg.class_id = c.class_id
            WHERE sg.student_id = '$student_id'
        ";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) === 0) {
            echo '<p class="text-center text-danger">No grades available at this time.</p>';
        } else {
            $grades = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $class_name = $row['class_name'];
                $cat_type = $row['cat_type'];
                $grade = $row['grade'];

                if (!isset($grades[$class_name])) {
                    $grades[$class_name] = [];
                }
                $grades[$class_name][$cat_type] = $grade;
            }

            foreach ($grades as $class_name => $cat_grades) {
                echo '<div class="table-container">';
                echo '<h3 class=" text-center">' . htmlspecialchars($class_name, ENT_QUOTES, 'UTF-8') . '</h3>';
                echo '<table class="table table-bordered table-hover">';
                echo '<thead>';
                echo '<tr><th>CAT Type</th><th>Grade</th></tr>';
                echo '</thead>';
                echo '<tbody>';

                if (isset($cat_grades['CAT1'])) {
                    echo '<tr><td>CAT1</td><td>' . htmlspecialchars($cat_grades['CAT1'], ENT_QUOTES, 'UTF-8') . '</td></tr>';
                }
                if (isset($cat_grades['CAT2'])) {
                    echo '<tr><td>CAT2</td><td>' . htmlspecialchars($cat_grades['CAT2'], ENT_QUOTES, 'UTF-8') . '</td></tr>';
                }
                if (isset($cat_grades['CAT3'])) {
                    echo '<tr><td>CAT3</td><td>' . htmlspecialchars($cat_grades['CAT3'], ENT_QUOTES, 'UTF-8') . '</td></tr>';
                }

                echo '</tbody></table></div>';
            }
        }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
