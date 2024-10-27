<?php
@include 'config.php';
if(isset($_POST['submit'])){
    $name=$_POST['name'];
    $email=$_POST['email'];
    $pass=md5($_POST['password']);
    $cpass=md5($_POST['cpassword']);
    $user_type=$_POST['user_type'];
    $sql="SELECT * FROM user_form  WHERE email='$email' AND password='$pass'";
    $result=mysqli_query($conn,$sql);
    if(mysqli_num_rows($result)>0){
        $error[]="user already exists";
    }
    else if($pass!=$cpass){
        $error[]="passwords don't match";
    }
   else{
    $insert="INSERT INTO user_form(name,email,password,user_type) VALUES('$name','$email','$pass','$user_type')";
    mysqli_query($conn,$insert);
    header("location:login.php");
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
    <title>Register form</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-container">
        <form action="" method="post">
            <h3>register now</h3>
            <input type="text" name="name"  placeholder="Enter your name">
            <input type="text" name="email" placeholder="Enter your email">
            <input type="password" name="password" placeholder="Enter your password">
            <input type="password" name="cpassword" placeholder="Confirm your password">
            <select name="user_type">
                <option value="admin">admin</option>
                <option value="teacher">teacher</option>
                <option value="student">student</option>
            </select>
            <input type="submit" name="submit" value="register" class="form-btn">
            <p>already have an account<a href="login.php"> login</a></p>
        </form>
    </div>
</body>
</html>