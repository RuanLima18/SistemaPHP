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
$nome = $descricao = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];

    $sql = "UPDATE itens SET nome = ?, descricao = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $nome, $descricao, $id);

    if ($stmt->execute()) {
        header("Location: crud.php");
        exit;
    } else {
        echo "Erro: " . $stmt->error;
    }

    $stmt->close();
} else {
    $sql = "SELECT nome, descricao FROM itens WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($nome, $descricao);
    $stmt->fetch();
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Curso</title>
    <link rel="stylesheet" href="CSS/editar&adicionar.css">
</head>
<body>
<div>
    
    <form action="editar.php" method="POST">

        <h2>Editar Curso</h2>

        <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">

        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" value="<?php echo $nome; ?>" required><br>

        <label for="descricao">Descrição:</label>
        <textarea id="descricao" name="descricao" required><?php echo $descricao; ?></textarea><br>
         
        <input type="submit" value="Salvar"><br><br><br><br><br><br>

        <a href="crud.php">Voltar</a>

    </form>
   
</div>
</body>
</html>
