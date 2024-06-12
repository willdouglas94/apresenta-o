<?php
	//verifica se o arquivo do banco de dados existe e cria um novo caso não
	if(!is_file('banco/cadastro.sqlite3')){
		file_put_contents('banco/cadastro.sqlite3', null);
	}
	
	//conectando o banco de dados
	$conn = new PDO('sqlite:banco/cadastro.sqlite3');
	
	//Definindo atributos de conexão
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	//Consulta para criação da tabela membro no banco de dados caso ainda não exista.
	$query = "CREATE TABLE IF NOT EXISTS dados (
		id INTEGER PRIMARY KEY AUTOINCREMENT,
		nome TEXT NOT NULL,
		cpf TEXT NOT NULL UNIQUE,
		telefone TEXT,
		email TEXT NOT NULL UNIQUE,
		senha TEXT NOT NULL
	)";
        
	//Executando a consulta
	$conn->exec($query);

	

	
?>