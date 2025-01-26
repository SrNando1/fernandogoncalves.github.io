<?php
// Incluir o arquivo de conexão com o banco de dados
require 'db_connect.php';

// Verificar se o parâmetro encomenda_id foi enviado
if (isset($_GET['encomenda_id'])) {
    $encomenda_id = intval($_GET['encomenda_id']); // Garantir que é um número inteiro

    try {
        // Consulta SQL para buscar os itens e obter o nome do produto
        $stmt = $pdo->prepare("
            SELECT 
                i.itens_id, 
                p.Nome AS produto_nome,  -- Obter o nome do produto
                i.quantidade, 
                i.preco_unitario, 
                (i.quantidade * i.preco_unitario) AS subtotal 
            FROM itens_encomenda i
            INNER JOIN produtos p ON i.produto_id = p.produto_id -- Relacionar as tabelas
            WHERE i.encomenda_id = :encomenda_id
        ");
        $stmt->bindParam(':encomenda_id', $encomenda_id, PDO::PARAM_INT);
        $stmt->execute();

        // Buscar os resultados
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Retornar os dados no formato JSON
        header('Content-Type: application/json');
        echo json_encode($items);
        exit();
    } catch (PDOException $e) {
        // Em caso de erro, retornar a mensagem
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Erro ao acessar o banco de dados: ' . $e->getMessage()]);
        exit();
    }
} else {
    // Retornar erro caso o ID da encomenda não seja enviado
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Nenhum ID de encomenda fornecido.']);
    exit();
}
