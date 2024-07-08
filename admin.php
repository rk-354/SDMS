<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Student Management System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        * {
            margin: 0px;
            padding: 0px;
        }
        .header {
            background-color: skyblue;
            line-height: 70px;
            padding-left: 30px;
            position: relative;
        }
        a {
            text-decoration: none;
        }
        .logout {
            position: absolute;
            right: 30px;
            top: 2px;
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
        input[type="tel"],
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
    <header class="header">
        <a href="admin.php">Admin Dashboard</a>
        <div class="logout">
            <a href="login_admin.php" class="btn btn-primary">Logout</a>
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
                <a href="view_student.php">View Students</a>
            </li>
            <li>
                <a href="add_teacher.php">Add Teacher</a>
            </li>
            <li>
                <a href="view_teacher.php">View Teachers</a>
            </li>
            <li>
                <a href="add_courses.php">Add Courses</a>
            </li>
            <li>
                <a href="view_courses.php">View Courses</a>
            </li>
        </ul>
    </aside>

    <div class="content" style="margin-left: 18%; padding: 20px;">
        <h2>Welcome to the Admin Dashboard</h2>
        <p>Use the sidebar to navigate through different management options.</p>
        
        <div class="row">
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-header">Students</div>
                    <div class="card-body">
                        <h5 class="card-title">Manage Students</h5>
                        <p class="card-text">Add new students, view existing students, and update their details.</p>
                        <a href="add_student.php" class="btn btn-light">Add Student</a>
                        <a href="view_student.php" class="btn btn-light">View Students</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-success mb-3">
                    <div class="card-header">Teachers</div>
                    <div class="card-body">
                        <h5 class="card-title">Manage Teachers</h5>
                        <p class="card-text">Add new teachers, view existing teachers, and update their details.</p>
                        <a href="add_teacher.php" class="btn btn-light">Add Teacher</a>
                        <a href="view_teacher.php" class="btn btn-light">View Teachers</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-info mb-3">
                    <div class="card-header">Courses</div>
                    <div class="card-body">
                        <h5 class="card-title">Manage Courses</h5>
                        <p class="card-text">Add new courses, view existing courses, and update their details.</p>
                        <a href="add_courses.php" class="btn btn-light">Add Course</a>
                        <a href="view_courses.php" class="btn btn-light">View Courses</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="notification" id="notification">
        Successfully added
    </div>

    <script>
        document.getElementById("course-form").onsubmit = async function(event) {
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
                document.querySelector(".error-message").innerText = "Failed to add course.";
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
