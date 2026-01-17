<?php
require 'db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Prepared Statement
if (!preg_match('/^\d{10}$/', $phone)) {
    $message = "Phone number must be  10 digits!";
} else {
    $stmt = $conn->prepare("INSERT INTO users (name, email, phone) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $phone);

    if ($stmt->execute()) {
        $message = "User added successfully!";
        $name = $email = $phone = "";
    } else {
        $message = "Error: " . $stmt->error;
    }
    $stmt->close();
}

}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container form-container">
    <h2>Add New User</h2>
    
    <?php if($message): ?>
        <div class="alert"><?php echo $message; ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="form-group">
            <label>Name:</label>
            <input type="text" name="name" required>
        </div>
        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" required>
        </div>
        <div class="form-group">
            <label>Phone:</label>
<input type="text" name="phone" required minlength="10" maxlength="10" pattern="[0-9]{10}" title="Enter 10 digits">
        </div>
        <div class="actions">
            <button type="submit" class="btn btn-success">Save</button>
            <a href="index.php" class="btn">Cancel</a>
        </div>
    </form>
</div>

</body>
</html>