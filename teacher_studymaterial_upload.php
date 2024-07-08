<?php
session_start();

if (!isset($_SESSION['name'])) {
    header("Location: login.php");
    exit();
}

$name = isset($_SESSION['name']) ? $_SESSION['name'] : '';

// Set the default timezone to ensure correct upload time
date_default_timezone_set('UTC'); // Change 'UTC' to your desired timezone, e.g., 'America/New_York'

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $file_name = $_FILES['file']['name'];
    $file_tmp = $_FILES['file']['tmp_name'];
    $file_destination = 'uploads/materials/' . $file_name;

    if (move_uploaded_file($file_tmp, $file_destination)) {
        $conn = new mysqli("localhost", "root", "", "college", 3308);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Get current timestamp
        $upload_time = date("Y-m-d H:i:s");

        // Insert into the database
        $sql = "INSERT INTO materials (title, description, file_name, uploaded_by, upload_time) VALUES (?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }

        $stmt->bind_param("sssss", $title, $description, $file_name, $name, $upload_time);

        if ($stmt->execute()) {
            echo "<script>alert('Material successfully uploaded');</script>";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "<script>alert('File upload failed');</script>";
    }
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Teacher: Study Material Upload</title>
    
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
                        <a  href="welcome_teacher.php"><i class="fa fa-home fa-2x"></i> Welcome Page</a>
                    </li>
                    <li>
                        <a href="upload_attendence.php"><i class="fa fa-upload fa-2x"></i> Student Attendance Upload</a>
                    </li>	
                    <li>
                        <a href="#"><i class="fa fa-pencil-square-o fa-2x"></i> Student Performance Details Report</a>
                    </li>
                    <li>
                        <a class="active-menu" href="teacher_studymaterial_upload.php"><i class="fa fa-upload fa-2x"></i> Study Material Upload</a>
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
                <h1>Study Material Upload</h1>
                <!-- Upload form -->
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="title">Title:</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="file">Select File:</label>
                        <input type="file" name="file" id="file" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Upload Material</button>
                </form>
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
</body>
</html>
