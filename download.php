<?php
if (isset($_GET['file'])) {
    $file = urldecode($_GET['file']); // Decode the URL-encoded file path

    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "college";
    $conn = new mysqli($servername, $username, $password, $dbname, 3308);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch the file path from the database to verify it exists
    $stmt = $conn->prepare("SELECT file_path FROM assignments WHERE file_path = ?");
    $stmt->bind_param("s", $file);
    $stmt->execute();
    $stmt->bind_result($filePath);
    $stmt->fetch();
    $stmt->close();
    $conn->close();

    if ($filePath && file_exists($filePath)) {
        // Set headers to force download
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));

        // Read the file and output its contents
        readfile($filePath);
        exit;
    } else {
        echo "File not found.";
    }
} else {
    echo "No file specified.";
}
?>
