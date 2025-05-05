<?php
include_once("connection.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_pass = password_hash(trim($_POST['new_password']), PASSWORD_DEFAULT);
    $user_id = $_SESSION["user_id"];

    $stmt = $conn->prepare("UPDATE Users SET password = ? WHERE user_id = ?");
    $stmt->bind_param("si", $new_pass, $user_id);

    if ($stmt->execute()) {
        echo "<script>alert('Password changed successfully.');</script>";
    } else {
        echo "<p style='color:red;'>Failed to update password.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Change Password - Anime Style</title>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Gochi+Hand&family=Montserrat:wght@400;700&display=swap');

  body {
    margin: 0;
    background: linear-gradient(135deg, #fceabb 0%, #f8b500 100%);
    font-family: 'Montserrat', sans-serif;
    color: #fff;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    overflow: hidden;
  }

  .container {
    background: rgba(0, 0, 0, 0.75);
    border-radius: 20px;
    box-shadow:
      0 0 30px #f8b500,
      0 0 40px #f8b500 inset;
    width: 350px;
    padding: 30px 40px;
    text-align: center;
    position: relative;
    overflow: hidden;
  }

  .container::before {
    content: "";
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background:
      radial-gradient(circle at 50% 50%, rgba(255, 255, 255, 0.15), transparent 70%);
    animation: rotateLight 6s linear infinite;
    z-index: 0;
  }

  @keyframes rotateLight {
    0% {transform: rotate(0deg);}
    100% {transform: rotate(360deg);}
  }

  h2 {
    font-family: 'Gochi Hand', cursive;
    font-size: 2.8rem;
    margin-bottom: 25px;
    text-shadow: 0 0 8px #ffd500;
    position: relative;
    z-index: 1;
  }

  form {
    position: relative;
    z-index: 1;
  }

  label {
    display: block;
    font-size: 1.2rem;
    margin-bottom: 15px;
    text-align: left;
    text-shadow: 0 0 5px #ffa700;
  }

  input[type=password] {
    width: 100%;
    padding: 12px 15px;
    border-radius: 12px;
    border: none;
    font-size: 1.1rem;
    font-weight: 600;
    outline: none;
    box-shadow:
      inset 0 0 8px #ffca28,
      0 0 10px #ffa000;
    transition: box-shadow 0.3s ease;
  }

  input[type=password]:focus {
    box-shadow:
      inset 0 0 15px #ffd740,
      0 0 20px #ffb300;
  }

  button {
    margin-top: 25px;
    width: 100%;
    padding: 14px 0;
    border-radius: 14px;
    border: none;
    background: linear-gradient(45deg, #ff6f61, #d84315);
    color: #fff;
    font-size: 1.2rem;
    font-weight: 700;
    cursor: pointer;
    text-shadow: 0 0 6px #ff3d00;
    transition: background 0.3s ease;
    box-shadow: 0 4px 10px #d84315a0;
  }

  button:hover {
    background: linear-gradient(45deg, #d84315, #ff6f61);
    box-shadow: 0 6px 15px #ff3d0033;
  }

  a {
    display: inline-block;
    margin-top: 22px;
    font-size: 1rem;
    color: #ffecb3;
    text-decoration: none;
    font-weight: 600;
    text-shadow: 0 0 5px #ffb300;
    position: relative;
    z-index: 1;
    transition: color 0.3s ease;
  }

  a:hover {
    color: #ffe082;
    text-shadow: 0 0 10px #fff3e0;
  }
</style>
</head>
<body>
  <div class="container" role="main" aria-label="Change Password Form">
    <h2>Change Password</h2>
    <form method="POST" aria-describedby="instructions">
      <label for="new_password">New Password:</label>
      <input type="password" id="new_password" name="new_password" required autocomplete="new-password" aria-required="true" aria-describedby="instructions" />
      <div id="instructions" style="font-size:0.8rem; margin-top:5px; color:#ffecb3;">Enter your new secure password</div>
      <button type="submit">Update Password</button>
    </form>
    <a href="dashboard.php" aria-label="Back to Dashboard">← Back to Dashboard</a>
  </div>
</body>
</html>

