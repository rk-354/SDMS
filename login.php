<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSE Department | Login</title>
    
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .background-image {
            position: absolute;
            width: 100%;
            height: 100%;
            background-image: url('assets/images/college.jpg'); /* Provide your background image */
            background-size: cover;
            opacity: 0.7;
            z-index: -1;
        }

        .login-form {
            width: 400px;
            padding: 30px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
            margin-left: 950px;
        }

        h1 {
            text-align: center;
            color: #007bff;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            color: #007bff;
            display: block;
        }

        input[type="text"],
        input[type="password"],
        select {
            width: calc(100% - 22px); /* Subtracting the padding and border width */
            padding: 10px;
            border: 1px solid #007bff;
            border-radius: 5px;
        }

        button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .additional-options {
            text-align: center;
        }

        .forgot-password {
            color: #007bff;
            text-decoration: none;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .error-message {
            color: red;
            text-align: center;
            margin-top: 10px;
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
        
        $email = $_POST["email"];
        $usertype = $_POST["usertype"];
        $password = $_POST["password"];

        
        if($usertype === 'student'){
            $query = "SELECT * FROM students WHERE email = '$email'";
        } else if($usertype === 'teacher'){
            $query = "SELECT * FROM teachers WHERE temail = '$email'";
        } else {
            echo "<script>alert('Invalid user type'); window.location.href = 'login.php';</script>";
            exit;
        }

        
        $result = mysqli_query($conn, $query);

        
        if ($result) {
           
            if (mysqli_num_rows($result) > 0) {
                
                $row = mysqli_fetch_assoc($result);

                
                $stored_password = $row['pass'];
                $name = $row['name'];

                
                if ($password === $stored_password) {
                    
                    if($usertype === 'student'){
                        header("Location: welcome_student.php?name=".urlencode($name));
                        exit;
                    } else {
                        header("Location: welcome_teacher.php?name=".urlencode($name));
                        // echo "$name";
                        exit;
                    }
                } else {
                    
                    echo "<script>alert('Incorrect password'); window.location.href = 'login.php';</script>";
                    exit;
                }
            } else {
                
                echo "<script>alert('User does not exist'); window.location.href = 'login.php';</script>";
                exit;
            }
        } else {
            
            echo "Query execution failed: " . mysqli_error($conn);
        }
    }
?>

    <div class="container">
        <div class="background-image"></div> 
        <div class="login-form">
            <h1>CSE Department Login</h1>

            <form id="login-form" action="" method="post">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="text" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="form-group">
                    <label for="usertype">User Type:</label>
                    <select id="usertype" name="usertype" required>
                        <option value="student">Student</option>
                        <option value="teacher">Teacher</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>
                <button type="submit">Login</button>
            </form>
            <div class="additional-options">
                <a href="#" class="forgot-password">Forgot Password?</a>
            </div>
            <p class="error-message"></p>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>


