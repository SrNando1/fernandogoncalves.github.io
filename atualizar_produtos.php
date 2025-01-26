<?php
require 'db_connect.php';

header('Content-Type: application/json');

try {
    // Recebe os dados da requisição
    $data = json_decode(file_get_contents('php://input'), true);
    
    // Processa alterações de stock
    if (isset($data['stock']) && count($data['stock']) > 0) {
        $query = "UPDATE Produtos SET Stock = :novoStock WHERE Produto_id = :produtoId";
        $stmt = $pdo->prepare($query);
        foreach ($data['stock'] as $alteracao) {
            $stmt->execute([
                ':novoStock' => $alteracao['novoStock'],
                ':produtoId' => $alteracao['produtoId'],
            ]);
        }
    }

    // Processa alterações de preço
    if (isset($data['preco']) && count($data['preco']) > 0) {
        $query = "UPDATE Produtos SET Preço = :novoPreco WHERE Produto_id = :produtoId";
        $stmt = $pdo->prepare($query);
        foreach ($data['preco'] as $alteracao) {
            $stmt->execute([
                ':novoPreco' => $alteracao['novoPreco'],
                ':produtoId' => $alteracao['produtoId'],
            ]);
        }
    }

    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>


