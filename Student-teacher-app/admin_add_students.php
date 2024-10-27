<?php
  @include 'config.php';
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Students</title>
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
            box-shadow: 0 0 10px rgba(0, 0.9, 0.9, 0.1);
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
        <h2>Add Students</h2> 
        <form action="admin_add_students.php" method="POST">
            <div class="mb-3">
                <label for="class" class="form-label">Select Class:</label>
                <select name="class_id" id="class" class="form-select">
                    <?php
                      $student = "SELECT id, name FROM user_form WHERE user_type='student'";
                      $class = "SELECT class_id, class_name FROM classes";
                      $class_res = mysqli_query($conn, $class);
                      while($row = mysqli_fetch_assoc($class_res)){
                        echo "<option value='".$row['class_id']."'>".$row['class_name']."</option>";
                      }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Select Students:</label>
                <div class="form-check">
                    <?php
                      $stud_res = mysqli_query($conn, $student);
                      while($row = mysqli_fetch_assoc($stud_res)){
                        echo "<div class='form-check'><input class='form-check-input' type='checkbox' name='student_ids[]' value='".$row['id']."'>
                              <label class='form-check-label'>".$row['name']."</label></div>";
                      }
                    ?>
                </div>
            </div>

            <button type="submit" name="enroll_students" class="btn btn-primary btn-submit">Enroll Students</button>
        </form>

        <?php
           if(isset($_POST['enroll_students'])){
            if (isset($_POST['student_ids']) && is_array($_POST['student_ids'])) {
            $student_ids = $_POST['student_ids'];
            $class_id = $_POST['class_id'];
            foreach($student_ids as $student_id){
              $query = "INSERT INTO student_classes (student_id, class_id) VALUES('$student_id','$class_id')";
              if(mysqli_query($conn, $query)){
                echo "<div class='alert alert-success mt-3'>Students enrolled successfully</div>";
              }
           else{
                 echo "<div class='alert alert-danger mt-3'>Error inserting</div>";
              }
            }
          }
        }
        ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
