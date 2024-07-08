<?php
session_start();

// Database connection (adjust with your actual database credentials)
$conn = new mysqli('localhost', 'root', '', 'college', 3308);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = isset($_SESSION['name']) ? $_SESSION['name'] : '';

// Fetch the teacher's subjects
$teacher_subjects = '';
if ($name) {
    $stmt = $conn->prepare("SELECT subject FROM teacher_details WHERE tid = ?");
    $stmt->bind_param("i", $tid);
    $stmt->execute();
    $stmt->bind_result($teacher_subjects);
    $stmt->fetch();
    $stmt->close();
}

// Convert the subjects to an array
$subjects_array = array_map('trim', explode(',', $teacher_subjects));

// Fetch students' data if form is submitted
$students = [];
$exam_type = '';
if (isset($_POST['exam_type'])) {
    $exam_type = $_POST['exam_type'];
    $sql = "SELECT rollno, name FROM students"; // Assuming the table is named 'students' with 'id' and 'name' columns
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $students[] = $row;
        }
    }
}

// Handle form submission to save marks
if (isset($_POST['marks'])) {
    $exam_type = $_POST['exam_type'];
    $marks = $_POST['marks'];
    foreach ($marks as $student_id => $subject_marks) {
        foreach ($subject_marks as $subject => $mark) {
            // Insert marks into the database
            $stmt = $conn->prepare("INSERT INTO marks (rollno, exam_type, subject, marks) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("issi", $student_id, $exam_type, $subject, $mark);
            $stmt->execute();
            $stmt->close();
        }
    }
    // Display success message
    echo '<script>alert("Marks saved successfully!");</script>';
}

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Teacher: Set Exams</title>
    
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
                        <a href="exam_details.php" class="active-menu"><i class="fa fa-pencil-square-o fa-2x"></i> Setting Exams</a>
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

        <!-- Page Content -->
        <div id="page-wrapper">
            <div id="page-inner">
                <h1>Welcome, <?php echo htmlspecialchars($name); ?></h1>
                <h2>Set Exam Marks</h2>
                
                <form method="post" action="">
                    <div class="form-group">
                        <label for="exam_type">Select Exam Type:</label>
                        <select id="exam_type" name="exam_type" class="form-control" required>
                            <option value="CAT1">CAT1</option>
                            <option value="CAT2">CAT2</option>
                            <option value="CAT3">CAT3</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Select</button>
                </form>

                <?php if (isset($exam_type) && !empty($students)): ?>
                    <form method="post" action="save_marks.php">
                        <input type="hidden" name="exam_type" value="<?php echo htmlspecialchars($exam_type); ?>">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Student ID</th>
                                    <th>Student Name</th>
                                    <?php foreach ($subjects_array as $subject): ?>
                                        <th><?php echo htmlspecialchars($subject); ?> Marks</th>
                                    <?php endforeach; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($students as $student): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($student['rollno']); ?></td>
                                        <td><?php echo htmlspecialchars($student['name']); ?></td>
                                        <?php foreach ($subjects_array as $subject): ?>
                                            <td><input type="number" name="marks[<?php echo $student['rollno']; ?>][<?php echo htmlspecialchars($subject); ?>]" class="form-control"></td>
                                        <?php endforeach; ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <button type="submit" class="btn btn-success">Save Marks</button>
                    </form>
                <?php endif; ?>
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

<?php
// Close the database connection
$conn->close();
?>


