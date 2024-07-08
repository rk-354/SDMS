<?php
session_start();

// Database connection (adjust with your actual database credentials)
$conn = new mysqli('localhost', 'root', '', 'college', 3308);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission to save marks
if (isset($_POST['exam_type']) && isset($_POST['marks'])) {
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
    // Close the database connection
    $conn->close();
    // Display success message
    echo '<script>alert("Marks saved successfully!");';
    // Redirect to exam_details.php after 2 seconds
    echo 'setTimeout(function(){ window.location.href = "exam_details.php"; }, 2000);</script>';
} else {
    // Redirect if accessed directly without form submission
    header("Location: exam_details.php");
    exit();
}
?>
