<?php

session_start();

if (isset($_GET['name'])) {
    $_SESSION['name'] = $_GET['name'];
}

$name = isset($_SESSION['name']) ? $_SESSION['name'] : '';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "college"; 

$conn = new mysqli($servername, $username, $password, $dbname, 3308);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = "SELECT * FROM students WHERE name = '$name'";

$result = mysqli_query($conn, $query);

if ($result) {
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $name = $row['name'];
        $rollno = $row['rollno'];
        $semester = $row['semester'];
        $_SESSION['rollno'] = $rollno;
        // $gpa = $row['gpa']; // Assume there's a GPA column in the table
        $upcoming_events = [
            "Exam on May 30",
            "Assignment 3 due on June 5",
            "Summer Break starts on June 15"
        ]; // You might fetch this data from a table in the database
    }
} else {
    echo "Query execution failed: " . mysqli_error($conn);
}

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Student Dashboard</title>
    <!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONTAWESOME STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLES-->
    <link href="assets/css/custom.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html"><img src="assets/images/logo.png" alt="logo"></a> 
            </div>
            <div style="color: white; padding: 15px 50px 5px 50px; float: right; font-size: 16px;">
                <a href="login.php" class="btn btn-danger square-btn-adjust">Logout</a>
            </div>
        </nav>   
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
                    <li>
                        <a href="student_dashboard.php"><i class="fa fa-user fa-2x"></i> Profile</a>
                    </li>
                    <li>
                        <a class="active-menu" href="student_dashboard.html"><i class="fa fa-home fa-2x"></i> Welcome Page</a>
                    </li>
                    <li>
                        <a href="student_study_material_download.php"><i class="fa fa-download fa-2x"></i> Study Material Download</a>
                    </li>   
                    <li>
                        <a href="student_assignment_submit.php"><i class="fa fa-upload fa-2x"></i> Assignment Upload</a>
                    </li>
                    <li>
                        <a href="student_view_assignment.php"><i class="fa fa-download fa-2x"></i> Assignment Download </a>
                    </li>               
                    <li>
                        <a href="Exam_fees_check.php"><i class="fa fa-pencil-square-o fa-2x"></i> Giving Exams</a>
                    </li>   
                    <li>
                        <a href="student_discussion.php"><i class="fa fa-users fa-2x"></i> Discussion Forum</a>
                    </li>   
                    <li>
                        <a href="#"><i class="fa fa-bell-o fa-2x"></i> Notice Board</a>
                    </li>       
                </ul>
            </div>
        </nav>  
        <!-- Page content -->
        <div id="page-wrapper">
            <div id="page-inner">
                <h1><strong>Welcome, <?php echo $name; ?></strong></h1>
                <p class="lead">Good <?php echo date("A") == "AM" ? "Morning" : "Evening"; ?>, <?php echo $name; ?>!</p>
                
                <!-- Student details -->
                <div class="student-details">
                    <h2>Student Details</h2>
                    <div id="student-info">
                        <h3>Name: <?php echo $name; ?></h3>
                        <h3>College Roll Number: <?php echo $rollno; ?></h3>
                        <h3>Current Semester: <?php echo $semester; ?></h3>
                        <!-- <h3>GPA: <?php echo $gpa; ?></h3> -->
                    </div>
                </div>

                <!-- Academic Performance Summary -->
                <div class="academic-performance">
                    <h2>Academic Performance</h2>
                    <!-- <p>Your current GPA is <?php echo $gpa; ?>.</p> -->
                    <!-- Additional academic details can be added here -->
                </div>

                <!-- Upcoming Events and Deadlines -->
                <div class="upcoming-events">
                    <h2>Upcoming Events and Deadlines</h2>
                    <ul>
                        <?php foreach ($upcoming_events as $event) {
                            echo "<li>$event</li>";
                        } ?>
                    </ul>
                </div>

                <!-- Notifications -->
                <div class="notifications">
                    <h2>Notifications</h2>
                    <ul>
                        <li>No new notifications.</li>
                        <!-- Notifications will be dynamically populated here -->
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- JQUERY SCRIPTS -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="assets/js/jquery.metisMenu.js"></script>
    <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>
</body>
</html>
