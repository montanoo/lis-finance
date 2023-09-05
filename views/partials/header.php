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
  <header class="bg-black/50 fixed top-0 w-full z-20">
    <div class="max-w-[1300px] px-4 mx-auto py-4 flex justify-between items-center">
      <a href="index.php" class="font-bold text-white text-lg">finance.</a>
      <div class="flex gap-3 items-center max-h-[2rem] overflow-hidden">
        <a href="" class="text-white hover:border-b transition-all px-2 py-1 hover:font-bold">Log In</a>
        <a href="" class="text-white hover:border-b transition-all px-2 py-1 hover:font-bold">Sign Up</a>
      </div>
    </div>
  </header>