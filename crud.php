<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$tipo_usuario = $_SESSION['tipo'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sistema";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$sql = "SELECT id, nome, descricao FROM itens";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gerenciamento de Curso</title>
    <link rel="stylesheet" href="CSS/crud.css">
</head>
<body>
    <div class="container">
        <h2>Gerenciamento de Curso</h2>
        <a href="logout.php">Sair</a>
        <?php if ($tipo_usuario == 'admin') : ?>
            <a href="adicionar.php">Adicionar Curso</a>
        <?php endif; ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Curso</th>
                    <th>Descrição</th>
                    <?php if ($tipo_usuario == 'admin') : ?>
                        <th>Ações</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["nome"] . "</td>";
                        echo "<td>" . $row["descricao"] . "</td>";
                        if ($tipo_usuario == 'admin') {
                            echo "<td><a href='editar.php?id=" . $row["id"] . "'>Editar</a> | <a href='excluir.php?id=" . $row["id"] . "'>Excluir</a></td>";
                        }
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>Nenhum item encontrado</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
