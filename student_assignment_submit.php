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

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $assignmentId = $_POST['assignment_id'];
    $fileName = basename($_FILES["assignmentFile"]["name"]);
    $fileTmp = $_FILES["assignmentFile"]["tmp_name"];
    $fileDestination = 'C:/xampp/htdocs/DBMS/uploads/submitted/' . $fileName; // Adjust the path according to your setup

    // Check if directory exists, if not create it
    if (!is_dir('C:/xampp/htdocs/DBMS/uploads/submitted/')) {
        mkdir('C:/xampp/htdocs/DBMS/uploads/submitted/', 0777, true);
    }

    // Fetch assignment details including deadline
    $query = "SELECT * FROM assignments WHERE id = '$assignmentId'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $assignment = $result->fetch_assoc();
        $deadlineDateTime = strtotime($assignment['deadline']);
        $currentTime = time();

        // Check if the current time is beyond the deadline
        if ($currentTime > $deadlineDateTime) {
            echo '<script>alert("Deadline for submission has passed!");</script>';
        } else {
            // Move file to destination
            if (move_uploaded_file($fileTmp, $fileDestination)) {
                // File moved successfully, update database
                $submissionTime = date("Y-m-d H:i:s");
                $sql = "INSERT INTO submissions (assignment_id, student_id, file_name, submission_time) VALUES ('$assignmentId', '$name', '$fileName', '$submissionTime')";

                if ($conn->query($sql) === TRUE) {
                    // Submission record inserted successfully
                    echo '<script>alert("Assignment submitted successfully!");</script>';
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                echo "File upload failed.";
            }
        }
    } else {
        echo "Assignment not found.";
    }
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
    <title>Assignment Upload</title>
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
                        <a href="view_profile_S.php"><i class="fa fa-user fa-2x"></i> Profile</a>
                    </li>
                    <li>
                        <a href="welcome_student.php"><i class="fa fa-home fa-2x"></i> Welcome Page</a>
                    </li>
                    <li>
                        <a href="student_study_material_download.php"><i class="fa fa-download fa-2x"></i> Study Material Download</a>
                    </li>
                    <li>
                        <a class="active-menu" href="student_assignment_submit.php"><i class="fa fa-upload fa-2x"></i> Assignment Upload</a>
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
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($assignments as $assignment): ?>
                                    <?php 
                                    // Get current date and time
                                    $currentTime = time();

                                    // Extract deadline date and time
                                    $deadlineDateTime = strtotime($assignment['deadline']);

                                    // Check if the current time is beyond the deadline
                                    $deadlinePassed = $currentTime > $deadlineDateTime;

                                    // Check if the file exists
                                    $filePath = 'C:/xampp/htdocs/DBMS/uploads/submitted/' . $assignment['file_path'];
                                    $fileExists = file_exists($filePath);
                                    ?>
                                    <tr>
                                        <td><?php echo $assignment['title']; ?></td>
                                        <td><?php echo $assignment['uploaded_by']; ?></td>
                                        <td><?php echo $assignment['upload_time']; ?></td>
                                        <td><?php echo $assignment['upload_date']; ?></td>
                                        <td><?php echo $assignment['deadline']; ?></td>
                                        <td>
                                            <?php if ($fileExists): ?>
                                                Submitted
                                            <?php elseif ($deadlinePassed): ?>
                                                Deadline Over
                                            <?php else: ?>
                                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                                                    <div class="form-group" style="display: flex;">
                                                        <input type="hidden" name="assignment_id" value="<?php echo $assignment['id']; ?>">
                                                        <input type="file" name="assignmentFile" class="form-control" required style="flex: 1;">
                                                        <button type="submit" name="submit" class="btn btn-primary" style="margin-left: 10px;">Upload</button>
                                                    </div>
                                                </form>
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

