<?php
 @include 'config.php';
 session_start();

 if(!isset($_SESSION['admin_name'])){
    header('location:login.php');
 }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        .header {
            background-color: #17a2b8;
            padding: 20px;
            text-align: center;
        }

        .header h1, .header h2 {
            color: white;
            margin: 0;
        }

        /* Sidebar */
        .sidebar {
            background-color: #343a40;
            width: 100%;
            height: auto;
            padding: 15px 0;
            position: relative;
        }

        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }

        .sidebar ul li {
            margin: 15px 0;
            text-align: center;
        }

        .sidebar ul li a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            display: block;
            padding: 10px;
            transition: background-color 0.3s;
        }

        .sidebar ul li a:hover {
            background-color: #495057;
        }

        /* Responsive Sidebar */
        @media (min-width: 768px) {
            .sidebar {
                width: 20%;
                float: left;
                height: 100vh;
            }

            .content {
                margin-left: 20%;
            }
        }

        /* Main Content */
        .content {
            padding: 20px;
        }

        .card-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: space-between;
        }

        .card {
            border-radius: 8px;
            padding: 20px;
            position: relative;
            flex: 1 1 calc(33% - 20px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 10px 0;
        }

        .card-icon {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 50px;
            height: 50px;
        }

        .card-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .card-text {
            font-size: 14px;
        }

        /* Announcement and Task Section */
        .announcement-section, .task-section {
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-top: 20px;
            padding: 20px;
            background-color: #ffffff;
        }

        .announcement-title {
            text-transform: uppercase;
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

        .announcement-content ul {
            list-style: none;
            padding-left: 0;
        }

        .announcement-content ul li {
            margin: 10px 0;
            font-size: 14px;
            color: #555;
        }

        /* Responsive Cards */
        @media (max-width: 768px) {
            .card-container {
                flex-direction: column;
            }

            .card {
                flex: 1 1 100%;
            }
        }
    </style>
</head>
<body>
    <div class="header bg-info">
    <h1>Welcome <span class="text-light"><?php echo $_SESSION['admin_name'] ?></span></h1>
        <h2 class="text-dark">You are a Admin</h2>

    </div>

    <!-- Sidebar Section -->
    <div class="sidebar">
        <ul>
            <li><a href="admin.php">Home</a></li>
            <li><a href="admin_add_class.php">Add classes</a></li>
            <li><a href="admin_add_students.php">Add students</a></li>
            <li><a href="admin_management.php">View and Manage Classes</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="content">
        <div class="card-container">
            <div class="card bg-warning">
                <div class="card-title">Attendance</div>
                <img src="images/attendance.png" class="card-icon" alt="Attendance Icon">
                <div class="card-text">Maintain student attendance <br> records</div>
            </div>
            <div class="card bg-success">
                <div class="card-title text-light">Classes</div>
                <img src="images/bell.png" class="card-icon" alt="Classes Icon">
                <div class="card-text text-light">You are teaching<br> in 3 classes</div>
            </div>
            <div class="card bg-danger">
                <div class="card-title text-light">Assignment</div>
                <img src="images/assignment.png" class="card-icon" alt="Assignment Icon">
                <div class="card-text text-light">You have given <br>1 assignment</div>
            </div>
        </div>

        <!-- Announcement Section -->
        <div class="announcement-section">
            <div class="announcement-title">Announcements</div>
            <div class="announcement-content">
                <ul>
                    <li>.</li>
                    <li>.</li>
                </ul>
            </div>
        </div>

        <!-- Task Section -->
        <div class="task-section">
            <div class="announcement-title">Tasks</div>
            <div class="announcement-content">
                <ul>
                    <li>.</li>
                    <li>.</li>

                </ul>
            </div>
        </div>
    </div>
</body>
</html>
