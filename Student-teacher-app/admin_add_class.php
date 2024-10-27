<?php
@include 'config.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Class</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4ZeJ9cM9h8kLbSxszNsj6unBbIK6sraZ8dbAmYYpHvzeC9cNj/e4Bw5cQdXwnPGk" crossorigin="anonymous">
    <style>
        body {
            margin-top: 40px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            border-radius: 8px;
            background-color: #f9f9f9;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .btn-submit {
            display: block;
            width: 100%;
            color: white;
            background-color: green;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="form-container">
        <h2>Add Class</h2>
        <form action="admin_add_class.php" method="POST">
            <div class="mb-3">
                <label for="class_name" class="form-label">Class Name</label>
                <input type="text" id="class_name" name="class_name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="teacher_id" class="form-label">Select Teacher</label>
                <select name="teacher_id" id="teacher_id" class="form-select" required>
                    <?php
                    $query = "SELECT id, name FROM user_form WHERE user_type='teacher'";
                    $teacher = mysqli_query($conn, $query);
                    while($row = mysqli_fetch_assoc($teacher)){
                        echo "<option value='".$row['id']."'>".$row['name']."</option>";
                    }
                    ?>
                </select>
            </div>
                      <br>
            <button type="submit" name="add_class" class="btn btn-primary btn-submit">Add Class</button>
        </form>

        <?php
        if(isset($_POST['add_class'])){
          $class_name = $_POST['class_name'];
          $teacher_id = $_POST['teacher_id'];
          $insert = "INSERT INTO CLASSES(class_name, teacher_id) VALUES('$class_name', '$teacher_id')";
          if(mysqli_query($conn, $insert)){
            echo "<div class='alert alert-success mt-3'>Class inserted successfully</div>";
          } else {
            echo "<div class='alert alert-danger mt-3'>Error: " . mysqli_error($conn) . "</div>";
          }
        }
        ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
