<?php
// Inclui o arquivo de conexão com o banco de dados
require_once 'db_connect.php';

try {
    // Consulta SQL para buscar todos os usuários da tabela Usuarios
    $query = "SELECT id, username, nome, apelido, endereco, idade, email, telefone, nascimento, genero, data_registro, is_admin FROM Usuarios";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    
    // Recupera todos os resultados
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Verifica se usuários foram encontrados
    if ($users && count($users) > 0) {
        // Retorna os dados como JSON com uma estrutura padrão
        echo json_encode([
            "success" => true,
            "data" => $users
        ]);
    } else {
        // Caso nenhum usuário seja encontrado
        echo json_encode([
            "success" => false,
            "message" => "Nenhum usuário encontrado"
        ]);
    }
} catch (PDOException $e) {
    // Caso haja um erro na execução da consulta ou na conexão
    echo json_encode([
        "success" => false,
        "error" => "Erro ao buscar usuários.",
        "details" => $e->getMessage()
    ]);
}
?>
