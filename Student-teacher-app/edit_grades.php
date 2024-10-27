<?php
session_start();
include 'config.php'; // DB connection

// Check if student_id, class_id, and cat_type are provided
$student_id = isset($_GET['student_id']) ? $_GET['student_id'] : null;
$class_id = isset($_GET['class_id']) ? $_GET['class_id'] : null;
$cat_type = isset($_GET['cat_type']) ? $_GET['cat_type'] : null;

if ($student_id === null || $class_id === null || $cat_type === null) {
    echo "Missing parameters.";
    exit;
}

// Fetch the current grade for the student
$query = "
    SELECT grade FROM student_grades 
    WHERE student_id = '$student_id' AND class_id = '$class_id' AND cat_type = '$cat_type'
";
$result = mysqli_query($conn, $query);
$current_grade = mysqli_fetch_assoc($result)['grade'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_grade = $_POST['grade'];
    
    // Update the grade in the database
    $update_query = "
        UPDATE student_grades 
        SET grade = '$new_grade' 
        WHERE student_id = '$student_id' AND class_id = '$class_id' AND cat_type = '$cat_type'
    ";
    mysqli_query($conn, $update_query);
    
    // Redirect back to the input grades page
    header("Location: input_grade_teacher.php?class_id=$class_id");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Grade</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
   <br> <h2>Edit Grade for Student ID: <?php echo htmlspecialchars($student_id); ?></h2>
    <form method="POST">
        <div class="mb-3">
            <label for="grade" class="form-label">Current Grade</label>
            <input type="text" class="form-control" id="grade" name="grade" value="<?php echo htmlspecialchars($current_grade); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Grade</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
