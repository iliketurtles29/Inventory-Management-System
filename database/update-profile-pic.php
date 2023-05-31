<?php
// Establish database connection
$servername = "localhost";
$username = "Alvni Rubiales";
$password = "pass";
$dbname = "inventory";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Handle file upload
$targetDirectory = "uploads/";  // Directory to store the uploaded files
$targetFile = $targetDirectory . basename($_FILES["profilePic"]["name"]);
$uploadedFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

// Generate a unique filename for the uploaded file
$newFileName = uniqid() . '.' . $uploadedFileType;
$destination = $targetDirectory . $newFileName;

// Save the uploaded file
if (move_uploaded_file($_FILES["profilePic"]["tmp_name"], $destination)) {
  // File uploaded successfully, save the file path in the database
  $filePath = $destination;

  // Get user ID or any unique identifier for the user
  $userId = $_SESSION["user_id"]; // Example: Retrieve the user ID from session or any other authentication mechanism

  // Perform necessary database operations, e.g., updating user's profile picture
  $sql = "UPDATE users SET profile_picture = '$filePath' WHERE id = $userId";
  if ($conn->query($sql) === true) {
    echo "Profile picture updated successfully.";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
} else {
  echo "Error uploading the file.";
}

// Close database connection
$conn->close();
?>