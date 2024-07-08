<?php
session_start();

// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION['name'])) {
    header("Location: login.php");
    exit();
}

$name = $_SESSION['name'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "college";

$conn = new mysqli($servername, $username, $password, $dbname, 3308);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch assignments from the database
$query = "SELECT * FROM assignments";
$result = $conn->query($query);

$assignments = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $assignments[] = $row;
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Assignment Download</title>
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
                <a href="logout.php" class="btn btn-danger square-btn-adjust">Logout</a>
            </div>
        </nav>   
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
                    <li>
                        <a href="student_dashboard.php"><i class="fa fa-user fa-2x"></i> Profile</a>
                    </li>
                    <li>
                        <a href="student_welcome.html"><i class="fa fa-home fa-2x"></i> Welcome Page</a>
                    </li>
                    <li>
                        <a href="student_study_material_download.php"><i class="fa fa-download fa-2x"></i> Study Material Download</a>
                    </li>
                    <li>
                        <a href="student_assignment_submit.php"><i class="fa fa-upload fa-2x"></i> Assignment Submit</a>
                    </li>
                    <li>
                        <a class="active-menu" href="student_assignment_download.php"><i class="fa fa-download fa-2x"></i> Assignment Download </a>
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
                <h2>All Assignments</h2>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Uploaded By</th>
                                    <th>Upload Time</th>
                                    <th>Upload Date</th>
                                    <th>Deadline</th>
                                    <th>Download</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($assignments as $assignment): ?>
                                    <tr>
                                        <td><?php echo $assignment['title']; ?></td>
                                        <td><?php echo $assignment['uploaded_by']; ?></td>
                                        <td><?php echo $assignment['upload_time']; ?></td>
                                        <td><?php echo $assignment['upload_date']; ?></td>
                                        <td><?php echo $assignment['deadline']; ?></td>
                                        <td>
                                            <?php if (!empty($assignment['file_path'])): ?>
                                                <a href="download.php?file=<?php echo urlencode($assignment['file_path']); ?>" class="btn btn-primary">Download</a>
                                            <?php else: ?>
                                                No file available
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- jQuery -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- Bootstrap -->
    <script src="assets/js/bootstrap.min.js"></script>
</body>
</html>
