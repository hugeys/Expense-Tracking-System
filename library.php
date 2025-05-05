<?php
include_once("connection.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Library - Anime Style</title>
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
    box-shadow:
      0 0 25px #4a90e2,
      inset 0 0 35px #6fb4ff;
    width: 370px;
    max-width: 90vw;
    padding: 40px 30px;
    text-align: center;
    position: relative;
    overflow: hidden;
  }

  .container::before {
    content: "";
    position: absolute;
    top: -40%;
    left: -25%;
    width: 150%;
    height: 150%;
    background:
      radial-gradient(circle at center, rgba(255, 255, 255, 0.1), transparent 60%);
    animation: floatGlow 8s ease-in-out infinite alternate;
    z-index: 0;
    border-radius: 50%;
  }

  @keyframes floatGlow {
    0% {
      transform: translate(0,0) scale(1);
      opacity: 0.7;
    }
    100% {
      transform: translate(15px,15px) scale(1.15);
      opacity: 0.4;
    }
  }

  h2 {
    font-family: 'Luckiest Guy', cursive;
    font-size: 3rem;
    margin-bottom: 25px;
    text-shadow:
      0 0 7px #4a90e2,
      0 0 12px #6fb4ff;
    z-index: 1;
    position: relative;
  }

  p {
    font-size: 1.1rem;
    line-height: 1.5;
    margin: 0 0 30px 0;
    text-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
    position: relative;
    z-index: 1;
  }

  a {
    display: inline-block;
    padding: 12px 28px;
    background: linear-gradient(45deg, #4a90e2, #335f94);
    color: #d4e9ff;
    font-weight: 700;
    font-size: 1rem;
    border-radius: 25px;
    text-decoration: none;
    box-shadow:
      0 0 8px #4a90e2,
      0 0 16px #335f94;
    transition: background 0.3s ease, box-shadow 0.3s ease;
    position: relative;
    z-index: 1;
  }

  a:hover,
  a:focus {
    background: linear-gradient(45deg, #82b1ff, #5473c1);
    box-shadow:
      0 0 15px #82b1ff,
      0 0 30px #5473c1;
  }

  /* Mobile responsiveness */
  @media (max-width: 400px) {
    .container {
      width: 95vw;
      padding: 30px 20px;
      border-radius: 20px;
    }
    h2 {
      font-size: 2.5rem;
    }
    p {
      font-size: 1rem;
    }
  }
</style>
</head>
<body>
  <div class="container" role="main" aria-label="Library Content">
    <h2>Library</h2>
    <p>This is a placeholder for your library content. You can fill it with books, articles, or other resources.</p>
    <a href="dashboard.php" aria-label="Back to Dashboard">← Back to Dashboard</a>
  </div>
</body>
</html>

