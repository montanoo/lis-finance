<?php
include_once('views/partials/header.php');

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
}
?>

<main class="min-h-[85vh] max-w-[1300px] flex justify-center w-full items-center mx-auto px-4">
    <?php
    include_once('views/partials/partials_menu.php')
    ?>
</main>

<?php
include_once('views/partials/footer.php');
?>