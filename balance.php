<?php
include_once('views/partials/header.php');

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
}

define('BASEPATH', true); //access connection script if you omit this line file will be blank
include './controllers/database/db.php';
$dsn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
$dsn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $pdo->prepare("SELECT * FROM entradas WHERE user_id = :user_id");

// Bind parameters
$stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
$stmt->execute();
$entries = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("SELECT * FROM salidas WHERE user_id = :user_id");

// Bind parameters
$stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
$stmt->execute();
$outs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main class="min-h-[85vh] py-24 max-w-[1300px] flex justify-center flex-col gap-4 w-full items-center mx-auto px-4">
    <div class="grid md:grid-cols-2 gap-2">
        <!-- Table 1 -->
        <div class="w-full">
            <h2 class="text-sm font-bold">Entradas</h2>

            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-2 py-1 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                            Tipo
                        </th>
                        <th class="px-2 py-1 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                            Monto
                        </th>
                        <!-- Add more columns as needed -->
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php
                    $increment = 0;
                    foreach ($entries as $row) {
                        $increment += $row['monto'];
                        echo '<tr>
                        <td class="px-6 py-4 whitespace-no-wrap">' . $row['tipo_entrada'] . '</td>
                        <td class="px-6 py-4 whitespace-no-wrap text-green-700">+$' . number_format($row['monto'], 2, '.', ',') . '</td>
                        </tr>';
                    }
                    echo '<tr>
                        <td class="px-6 py-4 whitespace-no-wrap">Total</td>
                        <td id="totalEntradas" class="px-6 py-4 whitespace-no-wrap text-green-700">+$' . number_format(sprintf("%0.2f", $increment), 2, '.', ',') . '</td>
                        </tr>';
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Table 2 -->
        <div class="w-full">
            <h2 class="text-sm font-bold">Salidas</h2>

            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-2 py-1 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                            Tipo
                        </th>
                        <th class="px-2 py-1 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                            Monto
                        </th>
                        <!-- Add more columns as needed -->
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php
                    $decrement = 0;
                    foreach ($outs as $row) {
                        $decrement += $row['monto'];
                        echo '<tr>
                        <td class="px-6 py-4 whitespace-no-wrap">' . $row['tipo_salida'] . '</td>
                        <td class="px-6 py-4 whitespace-no-wrap text-red-700">-$' . number_format($row['monto'], 2, '.', ',') . '</td>
                        </tr>';
                    }
                    echo '<tr>
                        <td class="px-6 py-4 whitespace-no-wrap">Total</td>
                        <td id="totalSalidas" class="px-6 py-4 whitespace-no-wrap text-red-700">-$' . number_format(sprintf("%0.2f", $decrement), 2, '.', ',') . '</td>
                        </tr>';
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Total -->
    <div class="mt-8 text-sm">
        <p id="total" class="text-lg font-semibold">Total: $<?php echo number_format(sprintf("%0.2f", $increment - $decrement), 2, '.', ',') ?></p>
    </div>
    <canvas id="graficaPastel" class="max-h-[20vh]"></canvas>

    <button id="download-pdf">Descargar PDF</button>

    <?php include_once('views/partials/partials_menu.php') ?>
</main>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Datos de ejemplo
    console.log(document.getElementById('totalEntradas').innerText.replace('$', '').replace('+', '').replace(',', ''))
    var datos = {
        etiquetas: ["Salidas", "Entradas", ],
        valores: [document.getElementById('totalSalidas').innerText.replace('$', '').replace('+', '').replace(',', ''), document.getElementById('totalEntradas').innerText.replace('$', '').replace('+', '').replace(',', '')]
    };

    // Obtén una referencia al elemento canvas
    var canvas = document.getElementById("graficaPastel");

    // Configura la gráfica de pastel
    var ctx = canvas.getContext("2d");
    var graficaPastel = new Chart(ctx, {
        type: "pie", // Tipo de gráfica de pastel
        data: {
            labels: datos.etiquetas,
            datasets: [{
                data: datos.valores,
                backgroundColor: ["#B91C1C", "#10B981"], // Colores de las porciones
            }],
        },
        options: {
            responsive: true, // Hace que la gráfica sea responsive
        },
    });
</script>

<script type="text/javascript">
    btn = document.getElementById("download-pdf")
    btn.addEventListener('click', () => {
        window.print();
    })
</script>