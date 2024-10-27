<?php 
session_start();
@include 'config.php';
$query = "SELECT c.class_id, c.class_name, u.name AS teacher_name FROM classes c 
          JOIN user_form u ON c.teacher_id = u.id";
$classes = mysqli_query($conn, $query);


$class_studs = "SELECT sc.class_id, u.id, u.name 
                FROM student_classes sc 
                JOIN user_form u ON sc.student_id = u.id";
$query_studs = mysqli_query($conn, $class_studs);

$class_students = [];
while($row = mysqli_fetch_assoc($query_studs)) {
    $class_students[$row['class_id']][] = ['id' => $row['id'], 'name' => $row['name']];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Classes and Students</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            margin-top: 20px;
        }
        th, td {
            text-align: center;
            vertical-align: middle;
        }
        .container {
            margin-top: 30px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Manage Classes and Students</h2>

    <?php while ($row = mysqli_fetch_assoc($classes)): ?>
        <div class="card mb-3">
            <div class="card-body">
                <h3 class="card-title"><?php echo $row['class_name']; ?></h3>
                <p class="card-text"><strong>Teacher:</strong> <?php echo $row['teacher_name']; ?></p>
                
                <table class="table table-bordered">
                    <thead>
                        <tr class="table-primary">
                            <th>Students</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if (!empty($class_students[$row['class_id']])) {
                            foreach ($class_students[$row['class_id']] as $student): ?>
                                <tr>
                                    <td><?php echo $student['name']; ?></td>
                                    <td>
                                        <form method="POST" action="admin_management.php" class="d-inline">
                                            <input type="hidden" name="class_id" value="<?php echo $row['class_id']; ?>">
                                            <input type="hidden" name="student_id" value="<?php echo $student['id']; ?>">
                                            <button type="submit" name="remove_student" class="btn btn-danger btn-sm">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; 
                        } else { ?>
                            <tr>
                                <td colspan="2">No students enrolled.</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <form method="POST" action="admin_management.php" class="mt-3">
                    <input type="hidden" name="class_id" value="<?php echo $row['class_id']; ?>">
                    <button type="submit" name="delete_class" class="btn btn-danger">Delete Class</button>
                </form>
            </div>
        </div>
    <?php endwhile; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
if (isset($_POST['remove_student'])) {
    $class_id = $_POST['class_id'];
    $student_id = $_POST['student_id'];
    
    $query = "DELETE FROM student_classes WHERE student_id = '$student_id' AND class_id = '$class_id'";
    if (mysqli_query($conn, $query)) {
        echo "<div class='alert alert-success'>Student removed successfully.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error removing student: " . mysqli_error($conn) . "</div>";
    }
}

if (isset($_POST['delete_class'])) {
    $class_id = $_POST['class_id'];
    $query_students = "DELETE FROM student_classes WHERE class_id = '$class_id'";
    mysqli_query($conn, $query_students);
    
    $query_class = "DELETE FROM classes WHERE class_id = '$class_id'";
    if (mysqli_query($conn, $query_class)) {
        echo "<div class='alert alert-success'>Class deleted successfully.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error deleting class: " . mysqli_error($conn) . "</div>";
    }
}
?>
