<?php
session_start();

// Retrieve the username from the URL or session
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

// Fetch study materials
$materials = [];
$query = "SELECT * FROM materials ORDER BY upload_time DESC";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $materials[] = $row;
    }
}

$conn->close();
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
                        <a href="welcome_student.php"><i class="fa fa-home fa-2x"></i> Welcome Page</a>
                    </li>
                    <li>
                        <a class="active-menu" href="student_study_material_download.php"><i class="fa fa-download fa-2x"></i> Study Material Download</a>
                    </li>  
                    <li>
                        <a href="student_assignment_submit.php"><i class="fa fa-upload fa-2x"></i> Assignment Upload</a>
                    </li>
                    <li>
                        <a href="student_assignment_download.php"><i class="fa fa-download fa-2x"></i> Assignment Download </a>
                    </li>               
                    <li>
                        <a href="Exam_fees_check.php"><i class="fa fa-pencil-square-o fa-2x"></i> Giving Exams</a>
                    </li>   
                    <li>
                        <a href="student_discussion.php"><i class="fa fa-users fa-2x"></i> Discussion Forum</a>
                    </li>   
                    <li>
                        <a href="notice_board.php"><i class="fa fa-bell-o fa-2x"></i> Notice Board</a>
                    </li>       
                </ul>
            </div>
        </nav>  
        <!-- Page content -->
        <div id="page-wrapper">
            <div id="page-inner">
                <h1><strong>Study Material Download</strong></h1>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Uploaded By</th>
                                <th>Upload Date</th>
                                <th>Upload Time</th>
                                <th>File</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($materials)) { ?>
                                <?php foreach ($materials as $material) { ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($material['title']); ?></td>
                                        <td><?php echo htmlspecialchars($material['description']); ?></td>
                                        <td><?php echo htmlspecialchars($material['uploaded_by']); ?></td>
                                        <td><?php echo date("Y-m-d", strtotime($material['upload_time'])); ?></td>
                                        <td><?php echo date("H:i:s", strtotime($material['upload_time'])); ?></td>
                                        <td>
                                            <a class="btn btn-primary" href="uploads/materials/<?php echo htmlspecialchars($material['file_name']); ?>" download>
                                                Download
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php } else { ?>
                                <tr>
                                    <td colspan="6">No study materials found.</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
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
