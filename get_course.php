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

if(isset($_GET['semester'])) {
    $semester = intval($_GET['semester']);
    // Query to fetch students based on the selected semester
    $sql = "SELECT * FROM courses WHERE semester = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $semester);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<div style='margin: 0px 300px;'>"; // Adding margin of 250px from left and right
        echo "<table class='table table-striped'>";
        echo "<thead><tr><th>Subject Code</th><th>Subject Name</th><th>Credit</th></tr></thead>";
        echo "<tbody>";
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["subcode"] . "</td><td>" . $row["subname"] . "</td><td>" . $row["credit"] . "</td></tr>";
        }
        echo "</tbody></table>";
        echo "</div>"; // Close the div
    } else {
        echo "<div style='margin: 50px 250px 0px 250px;'>"; // Adding margin of 250px from left and right
        echo "No course found for semester " . $semester;
        echo "</div>"; // Close the div
    }
    
    $stmt->close();
} else {
    // If semester parameter is not set
    echo "Please select a semester.";
}

// Close the database connection
$conn->close();
?>
