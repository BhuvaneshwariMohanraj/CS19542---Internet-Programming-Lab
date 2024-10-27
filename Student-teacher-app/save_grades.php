<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['class_id'], $_POST['cat_type'])) {
    $class_id = $_POST['class_id'];
    $cat_type = $_POST['cat_type'];
    $student_ids = $_POST['student_ids'];
    $grades = $_POST['grades'];

    foreach ($student_ids as $index => $student_id) {
        $grade = $grades[$index];
        $check_query = "
            SELECT * FROM student_grades 
            WHERE class_id = '$class_id' AND student_id = '$student_id' AND cat_type = '$cat_type'
        ";
        $check_result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            // Update existing grade
            $update_query = "
                UPDATE student_grades 
                SET grade = '$grade' 
                WHERE class_id = '$class_id' AND student_id = '$student_id' AND cat_type = '$cat_type'
            ";
            mysqli_query($conn, $update_query);
        } else {
            // Insert new grade
            $insert_query = "
                INSERT INTO student_grades (class_id, student_id, cat_type, grade) 
                VALUES ('$class_id', '$student_id', '$cat_type', '$grade')
            ";
            mysqli_query($conn, $insert_query);
        }
    }

    header("Location: input_grade_teacher.php?class_id=$class_id");
    exit();
} else {
    echo "Invalid request.";
}
?>
