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
<?php
session_start();

if (isset($_GET['rollno'])) {
    $_SESSION['rollno'] = $_GET['rollno'];
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "college";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, 3308);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assuming student is logged in and student id is stored in session
$rollno = $_SESSION['rollno']; // Ensure you have stored rollno in session on login

// Fetch student basic details
$studentQuery = "SELECT * FROM students WHERE rollno = '$rollno'";
$studentResult = $conn->query($studentQuery);
$student = $studentResult->fetch_assoc();

// Fetch student additional details
$detailsQuery = "SELECT * FROM student_details WHERE rollno = '$rollno'";
$detailsResult = $conn->query($detailsQuery);
$details = $detailsResult->fetch_assoc();

// Check if details are empty
$isDetailsEmpty = empty($details);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle form submission for updating details
    $astu_rollno = $_POST['astu_rollno'];
    $blood_group = $_POST['blood_group'];
    $permanent_addr = $_POST['permanent_addr'];
    $local_addr = $_POST['local_addr'];
    $branch = $_POST['branch'];

    if ($isDetailsEmpty) {
        // Insert the additional details
        $insertQuery = "INSERT INTO student_details (rollno, astu, blood_group, Permanent_Address, Local_address, branch) 
                        VALUES ('$rollno', '$astu_rollno', '$blood_group', '$permanent_addr', '$local_addr', '$branch')";
        
        if ($conn->query($insertQuery) === TRUE) {
            $details = [
                'astu' => $astu_rollno,
                'blood_group' => $blood_group,
                'Permanent_Address' => $permanent_addr,
                'Local_address' => $local_addr,
                'branch' => $branch
            ];
            $isDetailsEmpty = false;
        } else {
            echo "Error: " . $insertQuery . "<br>" . $conn->error;
        }
    } else {
        // Update the additional details
        $updateQuery = "UPDATE student_details 
                        SET astu = '$astu_rollno', blood_group = '$blood_group', Permanent_Address = '$permanent_addr', Local_address = '$local_addr', branch = '$branch' 
                        WHERE roll_no = '$rollno'";
        
        if ($conn->query($updateQuery) === TRUE) {
            $details['astu'] = $astu_rollno;
            $details['blood_group'] = $blood_group;
            $details['Permanent_Address'] = $permanent_addr;
            $details['Local_address'] = $local_addr;
            $details['branch'] = $branch;
        } else {
            echo "Error: " . $updateQuery . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>

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
                        <a class="active-menu" href="student_dashboard.php"><i class="fa fa-user fa-2x"></i> Profile</a>
                    </li>
                    <li>
                        <a href="welcome_student.php"><i class="fa fa-home fa-2x"></i> Welcome Page</a>
                    </li>
                    <li>
                        <a href="student_study_material_download.php"><i class="fa fa-download fa-2x"></i> Study Material Download</a>
                    </li> 
                    <li>
                        <a href="student_assignment_upload.php"><i class="fa fa-upload fa-2x"></i> Assignment Upload</a>
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
                <h1><strong>Welcome, <?php echo $student['name']; ?>!</strong></h1>
                <!-- Student details -->
                <div class="student-details">
                    <h2>Student Details</h2>
                    <div id="student-info">
                        <h3>Name: <?php echo $student['name']; ?></h3>
                        <h3>College Roll Number: <?php echo $student['rollno']; ?></h3>
                        <h3>Current Semester: <?php echo $student['semester']; ?></h3>
                        <!-- Add more details as required -->
                    </div>
                </div>

                <?php if ($isDetailsEmpty || isset($_GET['edit'])): ?>
                    <h2><?php echo $isDetailsEmpty ? "Complete Your Details" : "Edit Your Details"; ?></h2>
                    <form method="post" action="">
                        <div class="form-group">
                            <label for="astu_rollno">ASTU Roll No:</label>
                            <input type="text" class="form-control" id="astu_rollno" name="astu_rollno" value="<?php echo $details['astu_rollno'] ?? ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="blood_group">Blood Group:</label>
                            <input type="text" class="form-control" id="blood_group" name="blood_group" value="<?php echo $details['blood_group'] ?? ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="permanent_addr">Permanent Address:</label>
                            <input type="text" class="form-control" id="permanent_addr" name="permanent_addr" value="<?php echo $details['permanent_addr'] ?? ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="local_addr">Local Address:</label>
                            <input type="text" class="form-control" id="local_addr" name="local_addr" value="<?php echo $details['local_addr'] ?? ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="branch">Branch:</label>
                            <input type="text" class="form-control" id="branch" name="branch" value="<?php echo $details['branch'] ?? ''; ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                <?php else: ?>
                    <h2>Additional Details</h2>
                    <div id="additional-info">
                        <h3>ASTU Roll No: <?php echo $details['astu']; ?></h3>
                        <h3>Blood Group: <?php echo $details['blood_group']; ?></h3>
                        <h3>Permanent Address: <?php echo $details['Permanent_Address']; ?></h3>
                        <h3>Local Address: <?php echo $details['Local_address']; ?></h3>
                        <h3>Branch: <?php echo $details['branch']; ?></h3>
                        <a href="?edit=true" class="btn btn-warning">Edit</a>
                    </div>
                <?php endif; ?>
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
