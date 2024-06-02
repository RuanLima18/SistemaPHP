<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['tipo'] != 'admin') {
    header("Location: login.php");
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sistema";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$id = $_GET['id'];

$sql = "DELETE FROM itens WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: crud.php");
    exit;
} else {
    echo "Erro: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
