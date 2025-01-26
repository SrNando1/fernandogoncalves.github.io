<?php
header('Content-Type: application/json'); // Assegure-se de que a saída seja JSON
require 'db_connectsql.php'; // Certifique-se de que a conexão está funcionando

// Habilitar exibição de erros
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    // Lê os dados enviados pelo JavaScript
    $data = json_decode(file_get_contents("php://input"), true);

    // Verificar se os dados do carrinho e o encomenda_id foram enviados
    if (!isset($data['cart']) || empty($data['cart'])) {
        echo json_encode(["success" => false, "message" => "Nenhum item recebido."]);
        exit();
    }

    if (!isset($data['encomenda_id']) || empty($data['encomenda_id'])) {
        echo json_encode(["success" => false, "message" => "Encomenda ID não fornecido."]);
        exit();
    }

    // Receber o ID da encomenda
    $encomenda_id = $data['encomenda_id'];

    // Inserir os itens do carrinho na tabela "itens_encomenda"
    $cart = $data['cart'];

    // Iniciar transação para garantir a consistência dos dados
    $conn->begin_transaction();

    $stmt = $conn->prepare("INSERT INTO itens_encomenda (encomenda_id, produto_id, nome, quantidade, preco_unitario, subtotal) 
                            VALUES (?, ?, ?, ?, ?, ?)");

    if (!$stmt) {
        echo json_encode(["success" => false, "message" => "Erro na preparação da query: " . $conn->error]);
        exit();
    }

    // Inserir cada item no banco e atualizar o estoque
    foreach ($cart as $item) {
        $produto_id = $item['id'];
        $nome = $item['name'];
        $quantidade = $item['qty'];
        $preco_unitario = $item['price'];
        $subtotal = $quantidade * $preco_unitario;

        // Verificar o estoque atual do produto
        $stock_stmt = $conn->prepare("SELECT Stock FROM produtos WHERE Produto_id = ?");
        $stock_stmt->bind_param("i", $produto_id);
        $stock_stmt->execute();
        $stock_result = $stock_stmt->get_result();
        
        if ($stock_result->num_rows > 0) {
            $produto = $stock_result->fetch_assoc();
            $stock_atual = $produto['Stock'];

            if ($stock_atual >= $quantidade) {
                // Atualizar o estoque
                $novo_estoque = $stock_atual - $quantidade;
                $update_stmt = $conn->prepare("UPDATE produtos SET Stock = ? WHERE Produto_id = ?");
                $update_stmt->bind_param("ii", $novo_estoque, $produto_id);
                $update_stmt->execute();
                
                // Inserir o item na tabela de itens_encomenda
                $stmt->bind_param("iisidd", $encomenda_id, $produto_id, $nome, $quantidade, $preco_unitario, $subtotal);
                if (!$stmt->execute()) {
                    echo json_encode(["success" => false, "message" => "Erro ao salvar os itens do carrinho: " . $stmt->error]);
                    $conn->rollback(); // Reverter a transação
                    exit();
                }
            } else {
                echo json_encode(["success" => false, "message" => "Estoque insuficiente para o produto: " . $nome]);
                $conn->rollback(); // Reverter a transação
                exit();
            }
        } else {
            echo json_encode(["success" => false, "message" => "Produto não encontrado no estoque."]);
            $conn->rollback(); // Reverter a transação
            exit();
        }
    }

    // Se tudo ocorreu corretamente, confirma a transação
    $conn->commit();

    // Sucesso
    echo json_encode(["success" => true, "message" => "Itens do carrinho salvos e estoque atualizado com sucesso!"]);

    $stmt->close();
    $conn->close();

} catch (Exception $e) {
    $conn->rollback(); // Reverter em caso de erro
    echo json_encode(["success" => false, "message" => "Erro inesperado: " . $e->getMessage()]);
    exit();
}
?>
