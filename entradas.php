<?php
include_once('views/partials/header.php');
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
}
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<main class="min-h-[85vh] my-24 max-w-[1300px] flex justify-center flex-col gap-4 w-full items-center mx-auto px-4">
    <?php
    define('BASEPATH', true); //access connection script if you omit this line file will be blank
    include './controllers/database/db.php';
    $dsn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $dsn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("SELECT * FROM entradas WHERE user_id = :user_id");

    // Bind parameters
    $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt->execute();
    $values = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo '<table class="min-w-full divide-y divide-gray-200">
    <thead>
        <tr>
            <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                Tipo de entrada
            </th>
            <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                Monto
            </th>
            <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                Fecha
            </th>
            <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                Factura (Foto)
            </th>
        </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">';

    foreach ($values as $row) {
        echo '<tr>
                <td class="px-6 py-4 whitespace-no-wrap">' . $row['tipo_entrada'] . '</td>
                <td class="px-6 py-4 whitespace-no-wrap text-green-700">+' . $row['monto'] . '</td>
                <td class="px-6 py-4 whitespace-no-wrap">' . $row['fecha'] . '</td>
                <td class="px-6 py-4 whitespace-no-wrap">
                    <img src="' . $row['nombre_archivo'] . '" data-image-src="' . $row['nombre_archivo'] . '" alt="Factura" class="w-16 h-16 clickable-image">
                </td>
            </tr>';
    }

    echo '</tbody>
    </table>';

    // var_dump($values);

    ?>
    <?php
    include_once('views/partials/partials_menu.php')
    ?>
    <div id="imageModal" class="modal hidden fixed inset-0 overflow-y-auto flex justify-center items-center z-50">
        <div class="modal-content bg-white w-full max-w-lg p-4 rounded-lg shadow-lg">
            <span class="close absolute top-0 right-0 p-4 cursor-pointer" id="closeModal">&times;</span>
            <img src="" id="modalImage" alt="Image Preview" class="w-full h-auto">
        </div>
    </div>
</main>

<script>
    console.log("HI!")
    // Get the modal and image elements
    var modal = document.getElementById("imageModal");
    var modalImage = document.getElementById("modalImage");

    // Get all clickable images in the table
    var clickableImages = document.querySelectorAll(".clickable-image");

    // Attach click event listeners to each clickable image
    clickableImages.forEach(function(image) {
        image.addEventListener("click", function() {
            modal.style.display = "flex";
            modalImage.src = this.getAttribute("data-image-src");
        });
    });

    // Close the modal when the "x" button is clicked
    var closeModal = document.getElementById("closeModal");
    closeModal.addEventListener("click", function() {
        modal.style.display = "none";
    });

    // Close the modal when clicking outside of it (optional)
    window.addEventListener("click", function(event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    });
</script>

<?php
include_once('views/partials/footer.php');
?>