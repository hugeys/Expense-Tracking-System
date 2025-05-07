<?php
session_start(); // Ensure session is started

include_once("connection.php");

// Redirect to login if user is not authenticated
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $target_dir = "uploads/";
    $file = $_FILES["profile_picture"];
    $filename = basename($file["name"]);
    $target_file = $target_dir . $filename;

    // Validate file upload
    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        $stmt = $conn->prepare("UPDATE Users SET profile_picture = ? WHERE user_id = ?");
        $stmt->bind_param("si", $filename, $user_id);
        if ($stmt->execute()) {
            echo "<p class='success'>Profile picture updated successfully!</p>";
        } else {
            echo "<p class='error'>Error updating profile picture in database.</p>";
        }
        $stmt->close();
    } else {
        echo "<p class='error'>Upload failed. Please try again.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Upload Profile Picture</title>
    <style>
        body {
            background-color: #f0f4f8;
            font-family: 'Arial', sans-serif;
            color: #333;
            text-align: center;
            padding: 50px;
            margin: 0;
        }
        .container {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            display: inline-block;
            max-width: 400px;
            width: 90%;
        }
        h1 {
            font-size: 2em;
            margin-bottom: 20px;
        }
        label {
            font-size: 1.2em;
        }
        input[type="file"] {
            border: 2px solid #007bff;
            border-radius: 5px;
            padding: 10px;
            background: #e9ecef;
            color: #333;
            width: 100%;
            box-sizing: border-box;
            margin-top: 10px;
        }
        button {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 20px;
            width: 100%;
        }
        button:hover {
            background-color: #0056b3;
        }
        p.success {
            color: green;
            margin-top: 20px;
            font-weight: bold;
        }
        p.error {
            color: red;
            margin-top: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Upload Your Profile Picture</h1>
        <form method="POST" enctype="multipart/form-data">
            <label for="profile_picture">Choose a Profile Picture:</label><br />
            <input type="file" name="profile_picture" id="profile_picture" required /><br />
            <button type="submit">Upload</button>
        </form>
    </div>
</body>
</html>
</content>
</create_file>
