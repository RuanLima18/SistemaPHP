<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Usuário</title>
    <link rel="stylesheet" href="CSS/cadastro&login.css">
</head>
<body>
    <div>
        <form action="cadastro.php" method="POST">
            <h2>Cadastro de Usuário</h2>
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required><br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required><br>
            <label for="tipo">Tipo de Usuário:</label>
            <select id="tipo" name="tipo" required>
                <option value="admin">Administrador</option>
                <option value="visitante">Visitante</option>
            </select><br><br>
            <input type="submit" value="Cadastrar"><br><br><br>
            <a href="login.php">Faça Login aqui</a>
    </form>
    
    </div>
    
    <?php
    session_start();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
        $tipo = $_POST['tipo'];

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "sistema";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Falha na conexão: " . $conn->connect_error);
        }

        $sql = "INSERT INTO usuarios (nome, email, senha, tipo) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $nome, $email, $senha, $tipo);

        if ($stmt->execute()) {
            $_SESSION['id'] = $stmt->insert_id;
            $_SESSION['nome'] = $nome;
            $_SESSION['tipo'] = $tipo;
            header("Location: crud.php");
            exit;
        } else {
            echo "Erro: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }
    ?>
</body>
</html>
