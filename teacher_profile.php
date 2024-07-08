<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Teacher Dashboard</title>
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

if (isset($_GET['tid'])) {
    $_SESSION['tid'] = $_GET['tid'];
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

// Assuming teacher is logged in and teacher id is stored in session
$tid = $_SESSION['tid']; // Ensure you have stored tid in session on login

// Fetch teacher basic details
$teacherQuery = "SELECT * FROM teachers WHERE tid = '$tid'";
$teacherResult = $conn->query($teacherQuery);
$teacher = $teacherResult->fetch_assoc();

// Fetch teacher additional details
$detailsQuery = "SELECT * FROM teacher_details WHERE tid = '$tid'";
$detailsResult = $conn->query($detailsQuery);
$details = $detailsResult->fetch_assoc();

// Check if details are empty
$isDetailsEmpty = empty($details);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle form submission for updating details
    $degree = $_POST['degree'];
    $institution = $_POST['institution'];
    $year = $_POST['year'];
    $school = $_POST['school'];
    $subject = $_POST['subject'];
    $years = $_POST['years'];

    if ($isDetailsEmpty) {
        // Insert the additional details
        $insertQuery = "INSERT INTO teacher_details (tid, degree, institution, year, school, subject, years_of_experience) 
                        VALUES ('$tid', '$degree', '$institution', '$year', '$school', '$subject', '$years')";
        
        if ($conn->query($insertQuery) === TRUE) {
            $details = [
                'degree' => $degree,
                'institution' => $institution,
                'year' => $year,
                'school' => $school,
                'subject' => $subject,
                'years' => $years
            ];
            $isDetailsEmpty = false;
        } else {
            echo "Error: " . $insertQuery . "<br>" . $conn->error;
        }
    } else {
        // Update the additional details
        $updateQuery = "UPDATE teacher_details 
                        SET degree = '$degree', institution = '$institution', year = '$year', school = '$school', subject = '$subject', years = '$years'
                        WHERE tid = '$tid'";
        
        if ($conn->query($updateQuery) === TRUE) {
            $details['degree'] = $degree;
            $details['institution'] = $institution;
            $details['year'] = $year;
            $details['school'] = $school;
            $details['subject'] = $subject;
            $details['years'] = $years;
        } else {
            echo "Error: " . $updateQuery . "<br>" . $conn->error;
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Handle form submission and update database
        // Your existing code here...
    
        // File upload handling
        if (!empty($_FILES["profile_photo"]["name"])) {
            $targetDirectory = "uploads/"; // Directory where uploaded files will be stored
            $targetFile = $targetDirectory . basename($_FILES["profile_photo"]["name"]); // Path of the uploaded file
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION)); // File extension
    
            // Check if file is a valid image
            $check = getimagesize($_FILES["profile_photo"]["tmp_name"]);
            if ($check === false) {
                echo "File is not an image.";
                $uploadOk = 0;
            }
    
            // Check file size
            if ($_FILES["profile_photo"]["size"] > 500000) {
                echo "Sorry, your file is too large.";
                $uploadOk = 0;
            }
    
            // Allow certain file formats
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                echo "Sorry, only JPG, JPEG & PNG files are allowed.";
                $uploadOk = 0;
            }
    
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["profile_photo"]["tmp_name"], $targetFile)) {
                    // Update profile photo path in the database
                    $update_sql = "UPDATE teacher_details SET profile_photo='$targetFile' WHERE tid='$tid'";
                    if ($conn->query($update_sql) === FALSE) {
                        echo "Error updating profile photo: " . $conn->error;
                    }
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
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
            <div style="color: white; padding: 15px 50px 5px 50
            px; float: right; font-size: 16px;">
                <a href="login.php" class="btn btn-danger square-btn-adjust">Logout</a>
            </div>
        </nav>   
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
                    <li>
                        <a class="active-menu" href="teacher_dashboard.php"><i class="fa fa-user fa-2x"></i> Profile</a>
                    </li>
                    <!-- Other menu items for teacher dashboard -->
                    <li>
                        <a href="welcome_teacher.php"><i class="fa fa-home fa-2x"></i> Welcome Page</a>
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
                        <a href="teacher_dashboard.php"><i class="fa fa-users fa-2x"></i> Discussion Forum</a>
                    </li>
                    <li>
                        <a href="add_notice.php"><i class="fa fa-plus fa-2x"></i> Add Notice</a>
                    </li>
                    <li>
                        <a href="notice_board_T.php"><i class="fa fa-bell-o fa-2x"></i> View Notice Board</a>
                    </li>
                </ul>
            </div>
        </nav>  
        <!-- Page content -->
        <div id="page-wrapper">
            <div id="page-inner">
                <h1><strong>Welcome, <?php echo $teacher['name']; ?>!</strong></h1>
                <!-- Teacher details -->
                <div class="teacher-details">
                    <h2>Teacher Details</h2>
                    <div id="teacher-info">
                    <div id="teacher-info">
                    <h3>Name: <?php echo $teacher['name']; ?></h3>
                    <h3>Teacher ID: <?php echo $teacher['tid']; ?></h3>

                    
    <!-- Add more details as required -->
</div>

                    </div>
                </div>

                <?php if ($isDetailsEmpty || isset($_GET['edit'])): ?>
                    <h2><?php echo $isDetailsEmpty ? "Complete Your Details" : "Edit Your Details"; ?></h2>
                    <form method="post" action="">
                        <div class="form-group">
                            <label for="degree">Degree:</label>
                            <input type="text" class="form-control" id="degree" name="degree" value="<?php echo $details['degree'] ?? ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="institution">Institution:</label>
                            <input type="text" class="form-control" id="institution" name="institution" value="<?php echo $details['institution'] ?? ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="year">Year:</label>
                            <input type="text" class="form-control" id="year" name="year" value="<?php echo $details['year'] ?? ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="school">School:</label>
                            <input type="text" class="form-control" id="school" name="school" value="<?php echo $details['school'] ?? ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="subject">Subject:</label>
                            <input type="text" class="form-control" id="subject" name="subject" value="<?php echo $details['subject'] ?? ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="years">Years of Experience:</label>
                            <input type="text" class="form-control" id="years" name="years" value="<?php echo $details['years'] ?? ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="profile_photo">Profile Photo:</label>
                            <input type="file" class="form-control-file" id="profile_photo" name="profile_photo" accept=".jpg, .jpeg, .png">
                            <small id="fileHelp" class="form-text text-muted">Please upload a JPG or PNG file.</small>
                        </div>


                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                <?php else: ?>
                    <h2>Additional Details</h2>
                    <div id="additional-info">
                        <h3>Degree: <?php echo $details['degree']; ?></h3>
                        <h3>Institution: <?php echo $details['institution']; ?></h3>
                        <h3>Year: <?php echo $details['year']; ?></h3>
                        <h3>School: <?php echo $details['school']; ?></h3>
                        <h3>Subject: <?php echo $details['subject']; ?></h3>
                        <h3>Years of Experience : <?php echo $details['years_of_experience']; ?></h3>
                        <h3>Profile Pic : <?php echo $details['profile_photo']; ?></h3>
                        <!-- Display other details -->
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

