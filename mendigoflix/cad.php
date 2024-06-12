
<?php

// Verifica se o arquivo do banco de dados existe e cria um novo caso não exista
if (!is_file('banco/cadastro.sqlite3')) {
    file_put_contents('banco/cadastro.sqlite3', null);
}

// Conectando ao banco de dados
$conn = new PDO('sqlite:banco/cadastro.sqlite3');

// Definindo atributos de conexão
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Hash da senha

    try {
        // Inserção dos dados no banco de dados
        $insertQuery = $conn->prepare('INSERT INTO dados (nome, cpf, telefone, email, senha) VALUES (:nome, :cpf, :telefone, :email, :senha)');
        $insertQuery->bindParam(':nome', $nome);
        $insertQuery->bindParam(':cpf', $cpf);
        $insertQuery->bindParam(':telefone', $telefone);
        $insertQuery->bindParam(':email', $email);
        $insertQuery->bindParam(':senha', $senha);

        if ($insertQuery->execute()) {
            echo "Cadastrado com sucesso.\n";
        } else {
            echo "Erro ao inserir os dados.\n";
        }

    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage() . "\n";
    }
} 
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="cad.css" >
    <title>Cadastro</title>
</head>

<body>
    <form id="form" method="post" action="cad.php?add=<?php echo uniqid()?>">
    
        <p>Cadastre-se agora e tenha o melhor dos filmes.</p>
     
        <div class="form-group">
           <label for="name">Nome</label>
           <br />
           <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i>
                </div>
                <input type="text" name="nome" placeholder="Seu nome" required/>
            </div>
        </div>

        <div class="form-group">
            <label for="name">CPF</label>
            <br />
            <div class="input-group">
                 <div class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i>
                 </div>
                 <input type="text" name="cpf" placeholder="Seu CPF" required/>
             </div>
         </div>
        
        <div class="form-group">
            <label for="name">Telefone</label>
            <br />
            <div class="input-group">
                 <div class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i>
                 </div>
                 <input type="text" name="telefone" placeholder="Seu Telefone" required/>
             </div>
        </div>
        
        <div class="form-group">
            <label for="name">E-mail</label>
            <br />
            <div class="input-group">
                 <div class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i>
                 </div>
                 <input type="text" name="email" placeholder="Seu E-mail" required/>
             </div>
        </div>
        
        <div class="form-group">
           <label for="password-confirm">Senha</label>
           <br />
           <div class="input-group">
              <div class="input-group-addon"><i class="fa fa-lock" aria-hidden="true"></i>            </div>
              <input type="password" name="senha" placeholder="Uma Senha" required/>
              </div>
           </div>
        </div>
        <br>
        <button type="submit" class="btn btn-danger">Cadastrar</button>
        <button onclick="window.location.href='login.php'" class="btn btn-danger">Login</button>
        
    </form>
</body>
</html>