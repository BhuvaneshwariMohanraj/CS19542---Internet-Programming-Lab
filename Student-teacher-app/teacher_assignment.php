<?php 
session_start();
@include 'config.php';
$teacher_id=$_SESSION['teacher_id'];
$query="SELECT class_id, class_name FROM classes WHERE teacher_id='$teacher_id'";
$result=mysqli_query($conn,$query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Assignment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa; /* Light background color */
        }

        .container {
            margin-top: 20px;
            padding: 20px;
            border-radius: 10px;
            background-color: #ffffff; /* White background for the form */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
        }

        h2 {
            margin-bottom: 20px; /* Space below the heading */
        }

        .form-label {
            font-weight: bold; /* Bold labels */
        }
    </style>
</head>
<body>
   <div class="container">
       <h2 class="text-center">Post Assignment</h2> 
       <form action="teacher_assignment.php" method="post" enctype="multipart/form-data">
           <div class="mb-3">
               <label for="class_id" class="form-label">Class</label>
               <select name="class_id" id="class_id" class="form-select">
                   <option value="">Select a class</option>
                   <?php
                    while($row=mysqli_fetch_assoc($result)){
                       echo "<option value='".$row['class_id']."'>".$row['class_name']."</option>";
                       echo "<input type='hidden' name='class_name' value='".$row['class_name']."' >";
                    }
                   ?>
               </select>
           </div>
           <div class="mb-3">
               <label for="assignment_name" class="form-label">Assignment Name:</label>
               <input type="text" name="assignment_name" id="assignment_name" class="form-control" required>
           </div>
           <div class="mb-3">
               <label for="description" class="form-label">Description:</label>
               <textarea name="description" id="description" class="form-control" rows="4" required></textarea>
           </div>
           <div class="mb-3">
               <label for="assignment_file" class="form-label">Upload Assignment File:</label>
               <input type="file" name="assignment_file" id="assignment_file" class="form-control" required>
           </div>
           <button type="submit" name="submit_assignment" class="btn btn-primary">Post Assignment</button>
       </form>
   </div>

   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php 
if(isset($_POST['submit_assignment'])){
    $name=$_POST['assignment_name'];
    $description=$_POST['description'];
   $class_name=$_POST['class_name'];
   $file_name=$_FILES['assignment_file']['name'];
   $file_temp=$_FILES['assignment_file']['tmp_name'];
   $upload_dir="assignments/class_$class_name/";
   if(!is_dir($upload_dir)){
    mkdir($upload_dir,0777,true);
   }
   $destination=$upload_dir.$file_name;
   if(move_uploaded_file($file_temp,$destination)){
    echo "<div class='alert alert-success mt-3'>Assignment '$name' uploaded successfully</div>";
   }
    else{
        echo "<div class='alert alert-danger mt-3'>Failed to upload assignment</div>";
    }
}
?>
