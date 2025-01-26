<?php
// Iniciar a sessão
session_start();

// Configuração do banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$database = "mercearia";

// Conectar ao banco de dados
$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Habilitar logs de erro
ini_set('log_errors', 1);
ini_set('error_log', 'error_log.txt');
error_reporting(E_ALL);

// Verificar se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = trim($_POST['username']);
        $password = $_POST['password'];
    
        // Verificar se os campos não estão vazios
        if (empty($username) || empty($password)) {
            header("Location: login.html?error=" . urlencode("Preencha todos os campos."));
            exit();
        }
    
        // Consulta para verificar o usuário
        $sql = "SELECT id, username, senha, is_admin FROM usuarios WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
    
            // Verificar a senha
            if (password_verify($password, $user['senha'])) {
                // Se o usuário for admin, exibe a mensagem de login na área de Administrador
                if ($user['is_admin'] == 1) {
                    header("Location: loginUser.php?error=" . urlencode("Faça o login na área de Administrador!"));
                    exit();
                }
    
                // Login bem-sucedido para usuário normal
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['is_admin'] = $user['is_admin'];
    
                header("Location: index-user.php");
                exit();
            } else {
                // Senha incorreta
                header("Location: loginUser.php?error=" . urlencode("Senha ou Usuário incorretos!"));
                exit();
            }
        } else {
            // Usuário não encontrado
            header("Location: loginUser.php?error=" . urlencode("Senha ou Usuário incorretos!"));
            exit();
        }
    }
    
    

    if (isset($_POST['new-username'], $_POST['email'], $_POST['senha'])) {
        // Limpar e preparar os dados
        $username = trim($_POST['new-username']);
        $email = trim($_POST['email']);
        $password = password_hash(trim($_POST['senha']), PASSWORD_BCRYPT);
        $nome = trim($_POST['nome'] ?? '');
        $apelido = trim($_POST['apelido'] ?? '');
        $endereco = trim($_POST['endereco'] ?? '');
        $telefone = trim($_POST['telefone'] ?? '');
        $nascimento = $_POST['nascimento'] ?? null;
        $genero = $_POST['genero'] ?? null;
    
        // Validação dos campos obrigatórios
        if (empty($username) || empty($email) || empty($_POST['senha']) || empty($nascimento)) {
            header("Location: login.html?error=" . urlencode("Preencha todos os campos obrigatórios."));
            exit();
        }
    
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("Location: login.html?error=" . urlencode("E-mail inválido."));
            exit();
        }
    
        // Calcular a idade com base na data de nascimento
        try {
            $nascimento_date = new DateTime($nascimento);
            $hoje = new DateTime();
            $idade = $nascimento_date->diff($hoje)->y;
        } catch (Exception $e) {
            header("Location: login.html?error=" . urlencode("Data de nascimento inválida."));
            exit();
        }
    
        // Inserir no banco de dados
        $sql_inserir = "INSERT INTO usuarios (username, email, senha, nome, apelido, endereco, telefone, nascimento, idade, genero) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql_inserir);
    
        if ($stmt) {
            $stmt->bind_param(
                "ssssssssss",
                $username,
                $email,
                $password,
                $nome,
                $apelido,
                $endereco,
                $telefone,
                $nascimento,
                $idade,
                $genero
            );
            if ($stmt->execute()) {
                // Redirecionar para loginUser.php após o sucesso
                header("Location: loginUser.php?success=" . urlencode("Usuário registrado com sucesso!"));
                exit();
            } else {
                echo "Erro ao registrar: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Erro na preparação do statement: " . $conn->error;
        }
        
        // Fechar a conexão
        $conn->close();
           
    }
    
}
      