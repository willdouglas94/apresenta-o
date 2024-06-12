<?php
session_start();

// Verifica se o arquivo do banco de dados existe e cria um novo caso não exista
if (!is_file('banco/cadastro.sqlite3')) {
    file_put_contents('banco/cadastro.sqlite3', null);
}

// Conectando ao banco de dados
$conn = new PDO('sqlite:banco/cadastro.sqlite3');

// Definindo atributos de conexão
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    try {
        // Consulta para verificar as credenciais do usuário
        $query = $conn->prepare('SELECT * FROM dados WHERE email = :email LIMIT 1');
        $query->bindParam(':email', $email);
        $query->execute();
        $user = $query->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($senha, $user['senha'])) {
            // Credenciais corretas
            $_SESSION['email'] = $user['email'];
            $_SESSION['nome'] = $user['nome']; // Supondo que haja um campo 'nome' no banco de dados
            // Redirecionar para a página inicio.html
            header("Location: inicio.html");
            exit();
        } else {
            // Credenciais incorretas
            echo "<p>Email ou senha incorreta.</p>";
        }
    } catch (PDOException $e) {
        echo "<p>Erro: " . $e->getMessage() . "</p>\n";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="estilo_login.css" type="text/css" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.6.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.6.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Login</title>
</head>
<body>
    <div class="wrapper">
        <div class="logo"></div>
        <div class="text-center mt-4 name">Entrar</div>
        <br>
        <form method="POST" action="login.php" class="p-3 mt-3">
            <div class="form-field d-flex align-items-center">
                <span class="far fa-user"></span>
                <input type="text" name="email" id="email" placeholder="E-mail" required>
            </div>
            <div class="form-field d-flex align-items-center">
                <span class="fas fa-key"></span>
                <input type="password" name="senha" id="senha" placeholder="Senha" required>
            </div>
            <button type="submit" class="btn mt-3">Entrar</button>
        </form>
        <br>
        <div class="text-center fs-6">
            <a href="cad.php">Cadastre-se</a>
        </div>
    </div>
</body>
</html>
