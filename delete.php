<?php
require 'db.php';

// We expect the ID to be passed via GET or POST
// For this standalone file, we will check for GET ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Check if user exists first (optional, but good practice)
    $check = $conn->prepare("SELECT id FROM users WHERE id = ?");
    $check->bind_param("i", $id);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            echo "<div style='text-align:center; margin-top:50px; font-family:sans-serif;'>
                    <h2 style='color:green;'>User Deleted Successfully</h2>
                    <br><a href='index.php'>Go Back</a>
                  </div>";
        } else {
            echo "Error deleting record: " . $conn->error;
        }
        $stmt->close();
    } else {
        echo "User not found.";
    }
} else {
    echo "No ID specified.";
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete</title>
    <style>
        body { background: #f4f4f9; }
        a { text-decoration: none; color: #3498db; font-weight: bold; }
    </style>
</head>
<body>
</body>
</html>