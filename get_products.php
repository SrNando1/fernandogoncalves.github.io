<?php
// Inclui o arquivo de conexão com o banco de dados
require_once 'db_connect.php';

try {
    // Consulta SQL para buscar todos os produtos da tabela Produtos
    $query = "SELECT Produto_id, Nome, Categoria, Preço, Marca, Em_Promocao, Sem_Gluten, Sem_Lactose, Vegetariano, Vegan, Biologico, Destaque, Stock FROM Produtos";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    
    // Recupera todos os resultados
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Verifica se produtos foram encontrados
    if ($products) {
        // Se houver produtos, retorna os dados como um JSON
        echo json_encode($products);
    } else {
        // Se não houver produtos, retorna uma mensagem indicando
        echo json_encode(["message" => "Nenhum produto encontrado"]);
    }
} catch (PDOException $e) {
    // Caso haja um erro na execução da consulta ou na conexão
    echo json_encode([
        "error" => "Erro ao buscar produtos.",
        "details" => $e->getMessage()
    ]);
}

?>


