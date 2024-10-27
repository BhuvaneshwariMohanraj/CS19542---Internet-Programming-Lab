<?php
@include 'config.php';
session_start();
if(isset($_POST['submit'])){
    $name=$_POST['name'];
    $email=$_POST['email'];
    $pass=md5($_POST['password']);
    $sql="SELECT * FROM user_form WHERE email='$email' AND password='$pass'";
    $result=mysqli_query($conn,$sql);
    if(mysqli_num_rows($result)>0){
        $row=mysqli_fetch_array($result);
        if($row['user_type']=='admin'){
            $_SESSION['admin_name']=$row['name'];
            header("location:admin.php");

        }
        else if($row['user_type']=='student'){
            $_SESSION['student_name']=$row['name'];
            $_SESSION['student_id']=$row['id'];
            header("location:student.php");
        }
        else{
            $_SESSION['teacher_name']=$row['name'];
            $_SESSION['teacher_id']=$row['id'];
            header(header: "location:teacher.php");

        }
    }
    else{
         $error[]='incorrect email or password';
    
    }
    if (!empty($error)) {
        foreach ($error as $err) {
            echo '<div class="error-message">' . $err . '</div>';
        }
    }

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login form</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-container">
        <form action="" method="post">
            <h3>login now</h3>
            <input type="text" name="name"  placeholder="Enter your name">
            <input type="text" name="email" placeholder="Enter your email">
            <input type="password" name="password" placeholder="Enter your password">
            <input type="submit" name="submit" value="login" class="form-btn">
            <p>don't have an account<a href="register.php"> register</a></p>
        </form>
    </div>
</body>
</html>