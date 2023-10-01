<?php
session_start();
define('BASEPATH', true); //access connection script if you omit this line file will be blank
include './database/db.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $dsn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $dsn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $file = basename($_FILES["factura"]["name"]);

    if (isset($_FILES["factura"])) {
        $fichero = $_SERVER['DOCUMENT_ROOT'] . "/lis-finance/facturas/";
        $uploadedFile = $fichero . basename($_FILES["factura"]["name"]);
        if (move_uploaded_file($_FILES["factura"]["tmp_name"], $uploadedFile)) {
            echo "La factura se ha subido correctamente.";
        } else {
            $error = error_get_last();
            echo "Hubo un error al subir la factura: " . $error['message'];
        }
    }

    try {
        // Prepare the SQL statement
        $stmt = $pdo->prepare("INSERT INTO salidas (user_id, tipo_salida, monto, fecha, nombre_archivo) VALUES (:user_id, :tipo_salida, :monto, :fecha, :nombre_archivo)");

        $file = "facturas/" . $file;

        // Bind parameters
        $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->bindParam(':tipo_salida', $_POST["tipo_salida"], PDO::PARAM_STR);
        $stmt->bindParam(':monto', $_POST["monto"], PDO::PARAM_STR);
        $stmt->bindParam(':fecha', $_POST["fecha"], PDO::PARAM_STR);
        $stmt->bindParam(':nombre_archivo', $file, PDO::PARAM_STR);

        // Execute the statement
        $stmt->execute();
    } catch (Error $e) {
        var_dump($e);
    } finally {
        header('Location: /lis-finance/dashboard.php');
        exit;
    }
} else {
    // Si se intenta acceder a este script directamente sin enviar el formulario, redirecciona al formulario
    exit;
}
