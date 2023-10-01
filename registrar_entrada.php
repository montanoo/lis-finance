<?php
include_once('views/partials/header.php');
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
}
?>

<main class="bg-gray-100 min-h-screen flex items-center justify-center flex-col gap-4">
    <div class="bg-white p-8 rounded-lg shadow-md w-96">
        <form action="./controllers/procesar_registro.php" method="POST" enctype="multipart/form-data">
            <!-- Tipo de Entrada -->
            <div class="mb-4">
                <label for="tipo_entrada" class="block text-gray-700 font-bold mb-2">Tipo de Entrada:</label>
                <input type="text" name="tipo_entrada" placeholder="Salario septiembre" id="tipo_entrada" class="border rounded-lg px-3 py-2 w-full focus:outline-none focus:border-blue-500">
            </div>

            <!-- Monto -->
            <div class="mb-4">
                <label for="monto" class="block text-gray-700 font-bold mb-2">Monto:</label>
                <input type="number" min="0" name="monto" id="monto" class="border rounded-lg px-3 py-2 w-full focus:outline-none focus:border-blue-500" placeholder="Ingrese el monto">
            </div>

            <!-- Fecha -->
            <div class="mb-4">
                <label for="fecha" class="block text-gray-700 font-bold mb-2">Fecha:</label>
                <input type="date" name="fecha" id="fecha" class="border rounded-lg px-3 py-2 w-full focus:outline-none focus:border-blue-500">
            </div>

            <!-- Factura (Foto) -->
            <div class="mb-4">
                <label for="factura" class="block text-gray-700 font-bold mb-2">Factura (Foto):</label>
                <input type="file" name="factura" id="factura" accept="image/*" class="border rounded-lg px-3 py-2 w-full focus:outline-none focus:border-blue-500">
            </div>

            <!-- Botón de Enviar -->
            <div class="mb-4">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded w-full">Registrar</button>
            </div>
        </form>
    </div>
    <?php
    include_once('views/partials/partials_menu.php')
    ?>
</main>

<?php
include_once('views/partials/footer.php');
?>