

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

$query = "SELECT * FROM teachers WHERE name = '$name'";

$result = mysqli_query($conn, $query);

if ($result) {
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $name = $row['name'];
        $tid = $row['tid'];
        $_SESSION['tid'] = $tid;
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
    <title>Discussion Forum</title>
    
    <!-- Bootstrap Styles -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    
    <!-- Font Awesome Styles -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    
    <!-- Custom Styles -->
    <link href="assets/css/custom.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    
    <!-- Google Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
    <div id="wrapper">
        <!-- Top Navigation Bar -->
        <nav class="navbar navbar-default navbar-cls-top" role="navigation" style="margin-bottom: 0">
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
                <a href="logout.php" class="btn btn-danger square-btn-adjust"><font color="white">Logout</font></a>
            </div>
        </nav>   
        
        <!-- Sidebar Navigation -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
                    <li>
                        <a href="teacher_profile.php"><i class="fa fa-user fa-2x"></i> Profile</a>
                    </li>
                    <li>
                        <a class="active-menu" href="welcome_teacher.php"><i class="fa fa-home fa-2x"></i> Welcome Page</a>
                    </li>
                    <li>
                        <a href="upload_attendence.php"><i class="fa fa-upload fa-2x"></i> Student Attendance Upload</a>
                    </li>	
                    <li>
                        <a href="#"><i class="fa fa-pencil-square-o fa-2x"></i> Student Performance Details Report</a>
                    </li>
                    <li>
                        <a href="teacher_studymaterial_upload.php"><i class="fa fa-upload fa-2x"></i> Study Material Upload</a>
                    </li>
                    <li>
                        <a href="teacher_assignment_upload.php"><i class="fa fa-upload fa-2x"></i> Assignment Upload</a>
                    </li>
                    <li>
                        <a href="exam_details.php"><i class="fa fa-pencil-square-o fa-2x"></i> Setting Exams</a>
                    </li>
                    <li>
                        <a class="discussion_forum" href="teacher_dashboard.php"><i class="fa fa-users fa-2x"></i> Discussion Forum</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-plus fa-2x"></i> Add Notice</a>
                    </li>
                    <li>
                        <a href="notice_board_T.php"><i class="fa fa-bell-o fa-2x"></i> View Notice Board</a>
                    </li>
                </ul>
            </div>
        </nav>  

        <!-- Page Content -->
        <div id="page-wrapper">
            <div id="page-inner">
                <h1>Welcome, <?php echo $name; ?></h1>
                <p>This is the dashboard for teachers. You can manage your classes, assignments, and other activities from here.</p>
                <p>Feel free to navigate through the menu to access various features.</p>
                
                <!-- Discussion Forum Section -->
                <script type="text/javascript" src="discussion_forum_T/s1.js"></script>
            </div>
        </div>
    </div>
    
    <!-- jQuery -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- Bootstrap -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- Metis Menu -->
    <script src="assets/js/jquery.metisMenu.js"></script>
    <!-- Custom Scripts -->
    <script src="assets/js/custom.js"></script>
    <script>
        $(document).ready(function() {
            // Handle click event on Discussion Forum link
            $("teacher_dashboard.php").click(function(e) {
                e.preventDefault(); // Prevent default link behavior
                window.location.href = $(this).attr("href"); // Redirect to discussion forum page
            });
        });
    </script>
</body>
</html>
