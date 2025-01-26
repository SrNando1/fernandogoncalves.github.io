<?php
header('Content-Type: application/json');
include 'login.php';
include 'db_connect.php';

// Verifica se o parâmetro 'username' foi enviado via POST
if (isset($_POST['new-username'])) {
    $username = $_POST['new-username'];

    // Consulta SQL para verificar se o nome de usuário já existe no banco de dados
    $sql = "SELECT COUNT(*) AS total FROM usuarios WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // Responde com a disponibilidade do nome de usuário
    echo json_encode(['disponivel' => $row['total'] == 0]);
}
?>