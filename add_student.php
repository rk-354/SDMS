<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="	https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    <style>
        *{
            margin: 0px;
            padding: 0px;
        }
        .header{
            background-color: skyblue;
            line-height: 70px;
            padding-left: 30px;
        }
        a{
            text-decoration: none;
        }
        .logout{
            float: right;
            padding-right: 30px;
        }

        ul{
            background-color: #424a5b;
            width: 16%;
            height: 100%;
            position: fixed;
            padding-top: 5%;
            text-align: center;
        }

        ul li{
            list-style: none;
            padding-bottom: 30px;
            font-size: 15px;
        }

        ul li a{
            color: white;
            font-weight: bold;

        }

        ul li a:hover{
            color: skyblue;
            text-decoration: none;
        }

        a,a:hover{
            text-decoration: none!important;
        }

        .add-stud {
            width: 400px;
            padding: 30px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
            margin-left: 550px;
            margin-top: 50px;
            margin-bottom: 50px;
        }

        input[type="int"],
        input[type="text"],
        input[type="password"],
        input[type="tel"]
        select {
            width: calc(100% - 22px); /* Subtracting the padding and border width */
            padding: 10px;
            border: 1px solid #007bff;
            border-radius: 5px;
        }

        button {
            width: 50%;
            padding: 12px;
            padding-right: 30px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            margin-top: 15px;
        }

        button:hover {
            background-color: #0056b3;
        }

        .notification {
            visibility: hidden;
            width: 100%;
            background-color: #4CAF50;
            color: white;
            text-align: center;
            padding: 15px;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1;
        }
        .notification.show {
            visibility: visible;
            animation: fadein 0.5s, fadeout 0.5s 2.5s;
        }
        @keyframes fadein {
            from { top: -50px; opacity: 0; }
            to { top: 0; opacity: 1; }
        }
        @keyframes fadeout {
            from { top: 0; opacity: 1; }
            to { top: -50px; opacity: 0; }
        }
    </style>
</head>
<body>
<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "college";  

$conn = new mysqli($servername, $username, $password, $dbname, 3308);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rollno = $_POST["rollNo"];
    $email = $_POST["email"];
    $name = $_POST["name"];
    $password = $_POST["password"];
    $phone = $_POST["phoneno"];
    $semester = $_POST["semester"];

    $stmt = $conn->prepare("INSERT INTO students (rollno, name, email, pass, phone, semester) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssi", $rollno, $name, $email, $password, $phone, $semester);

    if ($stmt->execute()) {
        http_response_code(200);
    } else {
        http_response_code(500);
    }

    $stmt->close();
    $conn->close();
}
?>

        <header class="header">
            <a href="">Admin Dashboard</a>
            <div class="logout">
                <a href="" class="btn btn-primary">Logout</a>
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

        <div class="add-stud">
            <h1>Please add the following student details</h1>

            <form id="student-form" action="" method="post">
                <div class="form-group">
                    <label for="rollNo">Roll No:</label>
                    <input type="int" id="rollNo" name="rollNo" placeholder="Enter Roll No" required>
                </div>
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" placeholder="Enter Name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="text" id="email" name="email" placeholder="Enter email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" placeholder="Enter password" required>
                </div>
                <div class="form-group">
                    <label for="phoneno">Phone Number:</label>
                    <input type="text" id="phoneno" name="phoneno" placeholder="Enter phone number" required>
                </div>
                <div class="form-group">
                    <label for="semester">Semester:</label>
                    <input type="int" id="semester" name="semester" placeholder="Enter semester" required>
                </div>
                <button type="submit">Submit</button>
            </form>
            <p class="error-message"></p>
        </div>
        <div class="notification" id="notification">
        Successfully added
        </div>
        <script>
            document.getElementById("student-form").onsubmit = async function(event) {
                event.preventDefault(); // Prevent the form from submitting the default way
                const formData = new FormData(this);
                const response = await fetch(this.action, {
                    method: this.method,
                    body: formData
                });
                if (response.ok) {
                    showNotification();
                    this.reset();
                } else {
                    document.querySelector(".error-message").innerText = "Failed to add student.";
                }
            };

            function showNotification() {
                const notification = document.getElementById("notification");
                notification.classList.add("show");
                setTimeout(() => {
                    notification.classList.remove("show");
                }, 3000);
            }
        </script>
</body>
</html>