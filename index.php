<?php
include_once('views/partials/header.php');
?>

<div class="bg-red-500 relative">
  <img src="./assets/images/bg_main.jpg" alt="" class="bg-cover object-cover w-full min-h-[800px] md:h-[600px] brightness-[0.4]">
  <div class="absolute top-0 h-full w-full text-white z-10">
    <div class="flex flex-col h-full text-center md:text-left max-w-[1300px] mx-auto px-4 justify-center font-bold">
      <p class="text-5xl max-w-[600px]">Descubre el potencial que tienen tus inversiones</p>
      <div class="flex items-center justify-center w-full md:block">
        <div class="bg-[#4d6f62] h-2 w-[300px] my-4 rounded-xl"></div>
      </div>
      <p class="text-xl">No te quedes atrás.</p>
      <div class="flex mt-4">
        <?php
        if (isset($_SESSION['user'])) {
          echo '<a href="dashboard.php" class="bg-[#4d6f62] rounded-xl py-2 px-4 flex text-black hover:bg-[#4d6f7F] hover:text-white transition-all duration-500">Ve a tu dashboard</a>';
        } else {
          echo '<a href="login.php" class="bg-[#4d6f62] rounded-xl py-2 px-4 flex text-black hover:bg-[#4d6f7F] hover:text-white transition-all duration-500">Inicia sesion</a>';
        }
        ?>
      </div>
    </div>
  </div>
</div>

<?php
include_once('views/partials/footer.php');
?>