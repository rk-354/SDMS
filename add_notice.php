<?php
session_start();

if(isset($_GET['name'])) {
    $_SESSION['name'] = $_GET['name'];
}

$name = isset($_SESSION['name']) ? $_SESSION['name'] : '';

// Database connection
$servername = "localhost";
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$dbname = "college"; // Your MySQL database name

$conn = new mysqli($servername, $username, $password, $dbname, 3308);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Alert message variables
$alertMessage = "";
$alertType = "";

// Form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['noticeTitle'];
    $content = $_POST['noticeContent'];
    $notice_by = $name; // Assuming notice is submitted by the logged-in user
    $notice_time = date("Y-m-d H:i:s"); // Current date and time

    // File upload handling
    $target_dir = "uploads/notices/";
    $target_file = $target_dir . basename($_FILES["attachment"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Check if file already exists
    if (file_exists($target_file)) {
        $alertMessage = "Sorry, file already exists.";
        $alertType = "danger";
        $uploadOk = 0;
    }

    // Check file size (adjust as needed)
    if ($_FILES["attachment"]["size"] > 5000000) { // 5MB limit
        $alertMessage = "Sorry, your file is too large.";
        $alertType = "danger";
        $uploadOk = 0;
    }

    // Allow only certain file formats (you can expand this list)
    if($imageFileType != "pdf" && $imageFileType != "doc" && $imageFileType != "docx" && $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        $alertMessage = "Sorry, only PDF, DOC, DOCX, JPG, JPEG, PNG files are allowed.";
        $alertType = "danger";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $alertMessage = "Sorry, your file was not uploaded.";
        $alertType = "danger";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["attachment"]["tmp_name"], $target_file)) {
            $alertMessage = "Notice added successfully.";
            $alertType = "success";
            
            // Insert notice into database
            $sql = "INSERT INTO notices (title, content, notice_by, notice_time, attachment) VALUES ('$title', '$content', '$notice_by', '$notice_time', '$target_file')";
            if ($conn->query($sql) !== TRUE) {
                $alertMessage = "Error: " . $sql . "<br>" . $conn->error;
                $alertType = "danger";
            }
        } else {
            $alertMessage = "Sorry, there was an error uploading your file.";
            $alertType = "danger";
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Teacher: Add Notice</title>
    
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
                        <a href="welcome_teacher.php"><i class="fa fa-home fa-2x"></i> Welcome Page</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-upload fa-2x"></i> Student Performance Marks Upload</a>
                    </li>
                    <li>
                        <a href="upload_attendence.php"><i class="fa fa-upload fa-2x"></i> Student Attendance Upload</a>
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
                        <a href="teacher_dashboard.php"><i class="fa fa-users fa-2x"></i> Discussion Forum</a>
                    </li>
                    <li>
                        <a class="active-menu" href="add_notice.php"><i class="fa fa-plus fa-2x"></i> Add Notice</a>
                    </li>
                    <li>
                        <a href="notice_board.php"><i class="fa fa-bell-o fa-2x"></i> View Notice Board</a>
                    </li>
                </ul>
            </div>
        </nav>  

        <!-- Page Content -->
        <div id="page-wrapper">
            <div id="page-inner">
                <h1>Add Notice</h1>
                <?php if (!empty($alertMessage)): ?>
                    <div class="alert alert-<?php echo $alertType; ?>" role="alert">
                        <?php echo $alertMessage; ?>
                    </div>
                <?php endif; ?>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="noticeTitle">Title:</label>
                        <input type="text" class="form-control" id="noticeTitle" name="noticeTitle" required>
                    </div>
                    <div class="form-group">
                        <label for="noticeContent">Content:</label>
                        <textarea class="form-control" id="noticeContent" name="noticeContent" rows="5" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="attachment">Attachment:</label>
                        <input type="file" class="form-control-file" id="attachment" name="attachment">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Notice</button>
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

