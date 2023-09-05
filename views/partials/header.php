<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        fontFamily: {
          sans: ['Inter', 'sans-serif'],
        },
      }
    }
  </script>

  <?php
  // creates the database!
  require('./controllers/database/Database.php');
  $connection = new ConnectionMysql();
  $connection->create_database();
  ?>
</head>

<body class="font-inter">
  <header class="text-xl">
    <a href="dashboard.php">Dashboard</a>
  </header>