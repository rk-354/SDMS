<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['name'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
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

// Initialize $marks with NULL values for all subjects
$marks = [
    'Mathematics' => 'NULL',
    'COA' => 'NULL',
    'DAA' => 'NULL',
    'CN' => 'NULL',
    'FLAT' => 'NULL',
    'OS' => 'NULL'
];

// Check if exam type is selected
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['exam_type'])) {
    $exam_type = $_POST['exam_type'];

    // Fetch exam marks based on the selected exam type and student name
    $query = "SELECT subject, marks FROM marks WHERE rollno = (SELECT rollno FROM students WHERE name = '$name') AND exam_type = '$exam_type'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        // Retrieve marks for each subject
        while ($row = mysqli_fetch_assoc($result)) {
            $marks[$row['subject']] = $row['marks'] !== null ? $row['marks'] : 'NULL';
        }
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Exam Marks</title>
    <!-- Bootstrap Styles -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- Font Awesome Styles -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- Custom Styles -->
    <link href="assets/css/custom.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <!-- Style for form elements -->
    <style>
        form {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        select {
            padding: 8px;
            font-size: 16px;
        }

        input[type="submit"] {
            padding: 8px 20px;
            font-size: 16px;
            background-color: #337ab7;
            color: #fff;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div id="wrapper">
        <!-- Top Navigation -->
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
        
        <!-- Side Navigation -->
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
                        <a href="#"><i class="fa fa-download fa-2x"></i> Study Material Download</a>
                    </li>
                    <li>
                        <a href="student_assignment_submit.php"><i class="fa fa-upload fa-2x"></i> Assignment Upload</a>
                    </li>
                    <li>
                        <a href="student_assignment_download.php"><i class="fa fa-download fa-2x"></i> Assignment Download </a>
                    </li>
                    <li>
                        <a  class="active-menu" href="Exam_fees_check.php"><i class="fa fa-pencil-square-o fa-2x"></i> Giving Exams</a>
                    </li>
                    <li>
                        <a href="student_discussion.php"><i class="fa fa-users fa-2x"></i> Discussion Forum</a>
                    </li>
                    <li>
                        <a href="notice_board_teacher.php"><i class="fa fa-bell-o fa-2x"></i> Notice Board</a>
                    </li>
                </ul>
            </div>
        </nav>
        
        <!-- Page Content -->
        <div id="page-wrapper">
            <div id="page-inner">
                <h1><strong>Welcome, <?php echo htmlspecialchars($name); ?></strong></h1>
                <!-- Exam Marks -->
                <div class="exam-marks">
                    <h2>Exam Marks</h2>
                    <!-- Form to select exam type -->
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <label for="exam_type">Select Exam Type:</label>
                        <select name="exam_type" id="exam_type">
                            <option value="CAT1">CAT1</option>
                            <option value="CAT2">CAT2</option>
                            <option value="CAT3">CAT3</option>
                        </select>
                        <input type="submit" value="Show Marks">
                    </form>
                    <br>
                    <!-- Display exam marks -->
                    <div id="marks-info">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Subject</th>
                                    <th>Marks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                foreach ($marks as $subject => $mark) { ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($subject); ?></td>
                                        <td><?php echo htmlspecialchars($mark); ?></td>
                                    </tr>
                                <?php } ?>
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
    <!-- Metis Menu -->
    <script src="assets/js/jquery.metisMenu.js"></script>
    <!-- Custom -->
    <script src="assets/js/custom.js"></script>
    <!-- JavaScript to keep selected option displayed -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var examTypeSelect = document.getElementById("exam_type");
            var selectedExamType = "<?php echo isset($_POST['exam_type']) ? $_POST['exam_type'] : 'CAT1'; ?>";
            
            for (var i = 0; i < examTypeSelect.options.length; i++) {
                if (examTypeSelect.options[i].value === selectedExamType) {
                    examTypeSelect.selectedIndex = i;
                    break;
                }
            }
        });
    </script>
</body>
</html>
