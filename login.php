<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="CSS/cadastro&login.css">
</head>
<body>
    <div>
         <form action="login.php" method="POST">
            <h2>Login</h2>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required><br><br>
            <input type="submit" value="Entrar"><br><br><br><br><br><br> 
            <a href="cadastro.php">Cadastre-se aqui</a>
          </form>
    </div>
   
    <?php
    session_start();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "sistema";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Falha na conexão: " . $conn->connect_error);
        }

        $sql = "SELECT id, nome, senha, tipo FROM usuarios WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $nome, $hashed_senha, $tipo);
            $stmt->fetch();

            if (password_verify($senha, $hashed_senha)) {
                $_SESSION['id'] = $id;
                $_SESSION['nome'] = $nome;
                $_SESSION['tipo'] = $tipo;
                header("Location: crud.php");
                exit;
            } else {
                echo "Senha incorreta.";
            }
        } else {
            echo "Nenhum usuário encontrado com esse email.";
        }

        $stmt->close();
        $conn->close();
    }
    ?>
</body>
</html>
