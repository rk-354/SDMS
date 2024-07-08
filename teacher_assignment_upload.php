<?php
    // Start session
    session_start();

    // Check if the user is logged in
    // You should have your login logic here to ensure only logged-in users can access this page

    // Assuming you have a database connection established
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

    // Dummy username for testing
    if(isset($_GET['name'])) {
        $_SESSION['name'] = $_GET['name'];
    }

    $name = isset($_SESSION['name']) ? $_SESSION['name'] : '';

    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Handle form submission and update database
        $title = $_POST['title'];
        $deadline_date = $_POST['deadline_date'];
        $deadline_time = $_POST['deadline_time'];
    
        // Combine date and time into a single datetime format
        $deadline = $deadline_date . ' ' . $deadline_time;
    
        // File upload handling
        if (!empty($_FILES["assignment_file"]["name"])) {
            $targetDirectory = "uploads/assignments/"; // Directory where uploaded files will be stored
            $targetFile = $targetDirectory . basename($_FILES["assignment_file"]["name"]); // Path of the uploaded file
            $uploadOk = 1;
            $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION)); // File extension
            
            // Check file size
            if ($_FILES["assignment_file"]["size"] > 5000000) { // 5MB
                echo "Sorry, your file is too large.";
                $uploadOk = 0;
            }
    
            // Allow certain file formats
            if ($fileType != "pdf" && $fileType != "txt" && $fileType != "doc" && $fileType != "docx" && $fileType != "jpg" && $fileType != "jpeg" && $fileType != "png") {
                echo "Sorry, only PDF, TXT, DOC, DOCX, JPG, JPEG & PNG files are allowed.";
                $uploadOk = 0;
            }
    
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["assignment_file"]["tmp_name"], $targetFile)) {
                    // Insert assignment details into the database
                    $insert_sql = "INSERT INTO assignments (title, file_path, deadline, uploaded_by, upload_date) VALUES ('$title', '$targetFile', '$deadline', '$name', NOW())";
                    if ($conn->query($insert_sql) === FALSE) {
                        echo "Error inserting assignment details: " . $conn->error;
                    }
                    $assignment_uploaded = true;
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        }
    }

    // Handle assignment deletion
    // Handle assignment deletion
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_sql = "SELECT file_path FROM assignments WHERE id='$delete_id'";
    $result = $conn->query($delete_sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $file_path = $row['file_path'];
        // Delete the file from the server
        if (unlink($file_path)) {
            // If file deletion is successful, proceed to delete the assignment from the database
            $delete_sql = "DELETE FROM assignments WHERE id='$delete_id'";
            if ($conn->query($delete_sql) === FALSE) {
                echo "Error deleting assignment: " . $conn->error;
            }
        } else {
            echo "Error deleting file.";
        }
    }
}


    // Retrieve assignments from the database
    $sql = "SELECT * FROM assignments";
    $result = $conn->query($sql);

    // Close database connection
    $conn->close();
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Teacher: Upload Assignment</title>
    
    <!-- Bootstrap Styles -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    
    <!-- Font Awesome Styles -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    
    <!-- Custom Styles -->
    <link href="assets/css/custom.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    
    <!-- Google Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    
    <!-- jQuery -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- Bootstrap -->
    <script src="assets/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function(){
            <?php if(isset($assignment_uploaded) && $assignment_uploaded): ?>
                $("#assignmentuploadedModal").modal('show');
            <?php endif; ?>
        });
    </script>
    
    <!-- Custom CSS for Modal -->
    <style>
        .modal-content {
            border-radius: 10px;
            box-shadow: 0px 0px 20px 0px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px; /* Adjust padding */
        }

        .modal-header .close {
            margin-top: -10px; /* Adjust margin to position close button */
        }

        .modal-body {
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
            padding: 20px;
        }

        .modal-footer {
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
        }
    </style>

    <script>
        function confirmDelete(assignmentId) {
            var confirmation = confirm("Are you sure you want to delete this assignment?");
            if (confirmation) {
                window.location.href = "?delete_id=" + assignmentId;
            }
        }
    </script>
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
                        <a class="active-menu" href="teacher_assignment_upload.php"><i class="fa fa-upload fa-2x"></i> Assignments Upload</a>
                    </li>
					<li>
                        <a  href="exam_details.php"><i class="fa fa-pencil-square-o fa-2x"></i> Setting Exams</a>
                    </li>
					<li>
                        <a href="teacher_dashboard.php"><i class="fa fa-users fa-2x"></i> Discussion Forum</a>
                    </li>	
					<li>
                        <a  href="#"><i class="fa fa-plus fa-2x"></i> Add Notice</a>
                    </li>
					<li>
                        <a  href="notice_board_T.php"><i class="fa fa-bell-o fa-2x"></i> View Notice Board</a>
                    </li>	
                </ul>
            </div>
        </nav>  

        <!-- Main Content -->
        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h2>Upload Assignment</h2>
                    </div>
                </div>
                
                <hr />

                <!-- Assignment Upload Form -->
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="title">Title:</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="deadline_date">Deadline Date:</label>
                        <input type="date" class="form-control" id="deadline_date" name="deadline_date" required>
                    </div>
                    <div class="form-group">
                        <label for="deadline_time">Deadline Time:</label>
                        <input type="time" class="form-control" id="deadline_time" name="deadline_time" required>
                    </div>
                    <div class="form-group">
                        <label for="assignment_file">Assignment File:</label>
                        <input type="file" class="form-control-file" id="assignment_file" name="assignment_file" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </form>

                <hr />

                <!-- Assignment List -->
                <div class="row">
                    <div class="col-md-12">
                        <h3>Uploaded Assignments</h3>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>File</th>
                                        <th>Deadline</th>
                                        <th>Uploaded By</th>
                                        <th>Upload Time</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>" . $row["title"] . "</td>";
                                            echo "<td><a href='" . $row["file_path"] . "' download>Download</a></td>";
                                            echo "<td>" . $row["deadline"] . "</td>";
                                            echo "<td>" . $row["uploaded_by"] . "</td>";
                                            echo "<td>" . $row["upload_date"] . "</td>";
                                            echo "<td>";
                                            echo "<a href='" . $row["file_path"] . "' download class='btn btn-info btn-sm'>Download</a> ";
                                            echo "<button class='btn btn-danger btn-sm' onclick='confirmDelete(" . $row["id"] . ")'>Remove</button>";
                                            echo "</td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='6'>No assignments found</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Assignment Uploaded Modal -->
                <div class="modal fade" id="assignmentuploadedModal" tabindex="-1" role="dialog" aria-labelledby="assignmentuploadedModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="assignmentuploadedModalLabel">Assignment Uploaded</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Assignment uploaded successfully!
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- End Page Inner -->
        </div> <!-- End Page Wrapper -->
    </div> <!-- End Wrapper -->
</body>
</html>
