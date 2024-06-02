<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['tipo'] != 'admin') {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "sistema";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Falha na conexão: " . $conn->connect_error);
    }

    $sql = "INSERT INTO itens (nome, descricao) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $nome, $descricao);

    if ($stmt->execute()) {
        header("Location: crud.php");
        exit;
    } else {
        echo "Erro: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Adicionar Curso</title>
    <link rel="stylesheet" href="CSS/editar&adicionar.css">
</head>
<body>
<div>
   
    <form action="adicionar.php" method="POST">

         <h2>Adicionar Curso</h2>

        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required><br>

        <label for="descricao">Descrição:</label>
        <textarea id="descricao" name="descricao" required></textarea><br>

        <input type="submit" value="Salvar"><br><br><br><br><br><br>

        <a href="crud.php">Voltar</a>

    </form>
   
</div>
</body>
</html>
