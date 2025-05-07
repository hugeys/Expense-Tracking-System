<?php
include_once("connection.php");
include_once("function.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];
$result = $conn->query("SELECT name FROM Users WHERE user_id = $user_id");
$user = $result->fetch_assoc();


?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Dashboard - Anime Style Navigation</title>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Luckiest+Guy&family=Open+Sans:wght@400;700&display=swap');

  body {
    margin: 0;
    background: linear-gradient(135deg, #c8e7ff 0%, #335f94 100%);
    font-family: 'Open Sans', sans-serif;
    color: #fff;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    overflow: hidden;
  }
  .container {
    background: rgba(10, 37, 75, 0.85);
    border-radius: 30px;
    box-shadow: 0 0 25px #4a90e2, inset 0 0 35px #6fb4ff;
    width: 370px;
    max-width: 90vw;
    padding: 40px 30px;
    text-align: center;
    position: relative;
    overflow: hidden;
  }
  h2 {
    font-family: 'Luckiest Guy', cursive;
    font-size: 2.5rem;
    margin-bottom: 20px;
    text-shadow: 0 0 7px #4a90e2, 0 0 12px #6fb4ff;
  }
  /* Navigation styling */
  nav {
    margin-bottom: 25px;
  }
  nav ul {
    list-style: none;
    padding: 0;
    margin: 0 auto;
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 12px;
  }
  nav li {
    background: rgba(255, 255, 255, 0.15);
    border-radius: 15px;
    box-shadow: 0 0 5px rgba(255,255,255,0.25);
    transition: background 0.3s ease, box-shadow 0.3s ease;
  }
  nav li:hover {
    background: rgba(255, 255, 255, 0.3);
    box-shadow: 0 0 15px #82b1ff;
  }
  nav a {
    color: #d4e9ff;
    text-decoration: none;
    font-weight: 700;
    padding: 10px 18px;
    display: inline-block;
    font-size: 1rem;
    font-family: 'Open Sans', sans-serif;
    letter-spacing: 0.03em;
    user-select: none;
  }
  nav a:focus {
    outline: 2px solid #82b1ff;
    outline-offset: 3px;
  }
  h1 {
    font-size: 2rem;
    margin: 20px 0;
    text-shadow: 0 0 5px #ffd700;
  }
  h3 {
    font-size: 1.5rem;
    margin: 10px 0;
    text-shadow: 0 0 5px #ffca28;
  }
  p {
    font-size: 1rem;
    line-height: 1.5;
    margin: 0 0 20px 0;
    text-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
  }
  /* Mobile responsiveness */
  @media (max-width: 400px) {
    .container {
      width: 95vw;
      padding: 30px 20px;
      border-radius: 20px;
    }
    h2 {
      font-size: 2rem;
    }
    h1 {
      font-size: 1.5rem;
    }
    h3 {
      font-size: 1.2rem;
    }
    p {
      font-size: 0.9rem;
    }
    nav ul {
      gap: 8px;
    }
    nav a {
      font-size: 0.9rem;
      padding: 8px 14px;
    }
  }
</style>
</head>
<body>
  <div class="container">
    <?php
      $result = $conn->query("SELECT name, profile_picture FROM Users WHERE user_id = $user_id");
      $user = $result->fetch_assoc();
      echo "<img src='uploads/" . $user['profile_picture'] . "' width='100' height='100'><br>";
    ?>
    <h2>Welcome, <?php echo htmlspecialchars($user['name']); ?>!</h2>
    <nav aria-label="Main navigation">
      <ul>
        <li><a href="library.php">Library</a></li>
        <li><a href="changepassword.php">Change Password</a></li>
        <li><a href="update_profile.php">Update Profile</a></li>
        <li><a href="logout.php">Logout</a></li>
        <li><a href="Tracking Expenses.php">Go Track</a></li>
        <?php if (isAdmin()): ?>
          <li><a href="manage_users.php">Manage Users</a></li>
        <?php endif; ?>
      </ul>
    </nav>

    <h1>Expense-Tracking-System</h1>

    <h3>Welcome Panel</h3>
    <p>This is a standard dashboard for our website project. You can manage your projects, view the library, and change your password.</p>
  </div>
</body>
</html>

    