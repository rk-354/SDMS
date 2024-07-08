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

        <div class="text">
            <h6>Please select semester</h6>
            <label for="semester">Semester:</label>
            <select id="semester" name="semester" required>
                <option value="">Select Semester</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
            </select>
        </div>

        <div id="student-table"></div>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                document.getElementById("semester").addEventListener("change", function() {
                    var semester = this.value;
                    console.log("Semester selected:", semester); // Check the value of semester
                    if (semester !== "") {
                        console.log("semester is not empty"); // Check if this message appears
                        // Send an AJAX request to fetch students for the selected semester
                        var xhr = new XMLHttpRequest();
                        xhr.open("GET", "get_student.php?semester=" + semester, true);
                        xhr.onload = function() {
                            if (xhr.status === 200) {
                                console.log("AJAX request successful");
                                document.getElementById("student-table").innerHTML = xhr.responseText;
                            } else {
                                console.error("AJAX request failed with status:", xhr.status);
                            }
                        };
                        xhr.onerror = function() {
                            console.error("AJAX request encountered an error");
                        };
                        xhr.send();
                    } else {
                        console.log("semester is empty");
                        document.getElementById("student-table").innerHTML = "";
                    }
                });
            });
        </script>
</body>
</html>
