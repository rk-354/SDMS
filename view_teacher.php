<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        * {
            margin: 0px;
            padding: 0px;
        }
        .header {
            background-color: skyblue;
            line-height: 70px;
            padding-left: 30px;
        }
        a {
            text-decoration: none;
        }
        .logout {
            float: right;
            padding-right: 30px;
        }

        ul {
            background-color: #424a5b;
            width: 16%;
            height: 100%;
            position: fixed;
            padding-top: 5%;
            text-align: center;
        }

        ul li {
            list-style: none;
            padding-bottom: 30px;
            font-size: 15px;
        }

        ul li a {
            color: white;
            font-weight: bold;
        }

        ul li a:hover {
            color: skyblue;
            text-decoration: none;
        }

        a, a:hover {
            text-decoration: none!important;
        }

        .text {
            margin-left: 300px;
            margin-top: 40px;
        }
    </style>
</head>
<body>
        <header class="header">
            <a href="#">Admin Dashboard</a>
            <div class="logout">
                <a href="#" class="btn btn-primary">Logout</a>
            </div>
        </header>

        <aside>
            <ul>
                <li>
                    <a href="admin.php">Home</a>
                </li>
                <li>
                    <a href="add_student.php">Add Student</a>
                </li>
                <li>
                    <a href="view_student.php">View Student</a>
                </li>
                <li>
                    <a href="add_teacher.php">Add Teacher</a>
                </li>
                <li>
                    <a href="view_teacher.php">View Teacher</a>
                </li>
                <li>
                    <a href="add_courses.php">Add Courses</a>
                </li>
                <li>
                    <a href="view_courses.php">View Courses</a>
                </li>
            </ul>
        </aside>


        <?php
session_start(); 

// Database connection details
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


    
    // Query to fetch students based on the selected semester
    $sql = "SELECT * FROM teachers";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<div style='margin: 100px 300px;'>"; // Adding margin of 250px from left and right
        echo "<table class='table table-striped'>";
        echo "<thead><tr><th>Teacher ID</th><th>Teacher Name</th><th>Teacher Email</th><th>Teacher Phone Numvber</th><th>Teacher Designation</th></tr></thead>";
        echo "<tbody>";
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["tid"] . "</td><td>" . $row["name"] . "</td><td>" . $row["temail"] . "</td><td>" . $row["tphone"] . "</td><td>" . $row["tdesig"] . "</td></tr>";
        }
        echo "</tbody></table>";
        echo "</div>"; // Close the div
    } else {
        echo "<div style='margin: 50px 250px 0px 250px;'>"; // Adding margin of 250px from left and right
        echo "No teachers found ";
        echo "</div>"; // Close the div
    }
    
    $stmt->close();


// Close the database connection
$conn->close();
?>

        
</body>
</html>
