<?php
session_start();
include 'config.php'; 
$class_id = isset($_GET['class_id']) ? $_GET['class_id'] : null;
if ($class_id === null) {
    echo "Class ID not provided.";
    exit;
}
$query = "
    SELECT u.id, u.name 
    FROM student_classes sc
    JOIN user_form u ON sc.student_id = u.id
    WHERE sc.class_id = '$class_id'
";
$result = mysqli_query($conn, $query);

$grades_data = [
    'CAT1' => [],
    'CAT2' => [],
    'CAT3' => []
];

// Fetch existing grades for each CAT type
foreach (['CAT1', 'CAT2', 'CAT3'] as $cat_type) {
    $grade_query = "
        SELECT sg.student_id, sg.grade, u.name 
        FROM student_grades sg
        JOIN user_form u ON sg.student_id = u.id
        WHERE sg.class_id = '$class_id' AND sg.cat_type = '$cat_type'
    ";
    $grade_result = mysqli_query($conn, $grade_query);

    while ($row = mysqli_fetch_assoc($grade_result)) {
        $grades_data[$cat_type][] = $row;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Grades</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        h2 {
            text-align: center;
            margin: 20px 0;
        }
        .table-container {
            margin: 20px auto;
            width: 80%;
        }
        .table-container h3 {
            color: teal;
            font-weight: bold;
            text-align: center;
        }
        .edit-link {
            color: blue;
            text-decoration: underline;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-success">Input Grades for Class ID: <?php echo htmlspecialchars($class_id, ENT_QUOTES, 'UTF-8'); ?></h2>

    <div class="table-container">
        <h3>CAT1 Grades</h3>
        <form action="save_grades.php" method="POST">
            <input type="hidden" name="class_id" value="<?php echo htmlspecialchars($class_id, ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" name="cat_type" value="CAT1">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Grade</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($grades_data['CAT1'] as $grade): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($grade['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($grade['grade'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><a class="edit-link" href="edit_grades.php?student_id=<?php echo $grade['student_id']; ?>&class_id=<?php echo $class_id; ?>&cat_type=CAT1">Edit</a></td>
                    </tr>
                <?php endforeach; ?>
                <?php
                // Reset the result pointer to fetch students again
                mysqli_data_seek($result, 0);
                while ($row = mysqli_fetch_assoc($result)) {
                    $student_id = $row['id'];
                    $has_grade = false;
                    foreach ($grades_data['CAT1'] as $grade) {
                        if ($grade['student_id'] == $student_id) {
                            $has_grade = true;
                            break;
                        }
                    }
                    // Only display input for students without grades
                    if (!$has_grade) {
                        echo '<tr>
                            <td>' . htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') . '</td>
                            <td>
                                <input type="hidden" name="student_ids[]" value="' . htmlspecialchars($student_id, ENT_QUOTES, 'UTF-8') . '">
                                <input type="number" name="grades[]" placeholder="Enter grade" required>
                            </td>
                            <td><button type="submit" class="btn btn-success">Add Grade</button></td>
                        </tr>';
                    }
                }
                ?>
                </tbody>
            </table>
        </form>
    </div>

    <div class="table-container">
        <h3>CAT2 Grades</h3>
        <form action="save_grades.php" method="POST">
            <input type="hidden" name="class_id" value="<?php echo htmlspecialchars($class_id, ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" name="cat_type" value="CAT2">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Grade</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($grades_data['CAT2'] as $grade): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($grade['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($grade['grade'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><a class="edit-link" href="edit_grades.php?student_id=<?php echo $grade['student_id']; ?>&class_id=<?php echo $class_id; ?>&cat_type=CAT2">Edit</a></td>
                    </tr>
                <?php endforeach; ?>

                <!-- Add grades for students without existing grades -->
                <?php
                mysqli_data_seek($result, 0);
                while ($row = mysqli_fetch_assoc($result)) {
                    $student_id = $row['id'];
                    $has_grade = false;
                    foreach ($grades_data['CAT2'] as $grade) {
                        if ($grade['student_id'] == $student_id) {
                            $has_grade = true;
                            break;
                        }
                    }
                    if (!$has_grade) {
                        echo '<tr>
                            <td>' . htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') . '</td>
                            <td>
                                <input type="hidden" name="student_ids[]" value="' . htmlspecialchars($student_id, ENT_QUOTES, 'UTF-8') . '">
                                <input type="number" name="grades[]" placeholder="Enter grade" required>
                            </td>
                            <td><button type="submit" class="btn btn-success">Add Grade</button></td>
                        </tr>';
                    }
                }
                ?>
                </tbody>
            </table>
        </form>
    </div>

    <div class="table-container">
        <h3>CAT3 Grades</h3>
        <form action="save_grades.php" method="POST">
            <input type="hidden" name="class_id" value="<?php echo htmlspecialchars($class_id, ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" name="cat_type" value="CAT3">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Grade</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($grades_data['CAT3'] as $grade): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($grade['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($grade['grade'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><a class="edit-link" href="edit_grades.php?student_id=<?php echo $grade['student_id']; ?>&class_id=<?php echo $class_id; ?>&cat_type=CAT3">Edit</a></td>
                    </tr>
                <?php endforeach; ?>

                <!-- Add grades for students without existing grades -->
                <?php
                mysqli_data_seek($result, 0);
                while ($row = mysqli_fetch_assoc($result)) {
                    $student_id = $row['id'];
                    $has_grade = false;
                    foreach ($grades_data['CAT3'] as $grade) {
                        if ($grade['student_id'] == $student_id) {
                            $has_grade = true;
                            break;
                        }
                    }
                    if (!$has_grade) {
                        echo '<tr>
                            <td>' . htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') . '</td>
                            <td>
                                <input type="hidden" name="student_ids[]" value="' . htmlspecialchars($student_id, ENT_QUOTES, 'UTF-8') . '">
                                <input type="number" name="grades[]" placeholder="Enter grade" required>
                            </td>
                            <td><button type="submit" class="btn btn-success">Add Grade</button></td>
                        </tr>';
                    }
                }
                ?>
                </tbody>
            </table>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
