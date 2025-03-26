
<?php
// Configuração do banco de dados
$host = "localhost"; // Servidor do banco
$user = "root";      // Usuário do banco (altere se necessário)
$pass = "";          // Senha do banco (altere se necessário)
$dbname = "meubanco"; // Nome do banco de dados

// Criando a conexão
$conn = new mysqli($host, $user, $pass, $dbname);

// Verificando a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Recebendo os dados do formulário
$usuario = isset($_POST['usu']) ? trim($_POST['usu']) : '';
$senha = isset($_POST['sen']) ? trim($_POST['sen']) : '';

// Validando os dados
if (empty($usuario) || empty($senha)) {
    die("Usuário e senha são obrigatórios!");
}

// Criptografando a senha antes de salvar
$senhaHash = password_hash($senha, PASSWORD_DEFAULT);

// Preparando a query para evitar SQL Injection
$stmt = $conn->prepare("INSERT INTO usuarios (usuario, senha) VALUES (?, ?)");
$stmt->bind_param("ss", $usuario, $senhaHash);

// Executando a query
if ($stmt->execute()) {
    echo "Usuário cadastrado com sucesso!";
} else {
    echo "Erro ao cadastrar: " . $stmt->error;
}

// Fechando a conexão
$stmt->close();
$conn->close();
?>