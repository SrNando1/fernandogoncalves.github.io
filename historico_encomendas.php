<?php
header('Content-Type: application/json');

require 'db_connectsql.php';

$data = json_decode(file_get_contents("php://input"), true);

if ($data) {
    $user_id = $data['user_id'];
    $username = $data['username'];
    $nome = $data['nome'];
    $apelido = $data['apelido'];
    $telefone = $data['telefone'];
    $endereco = $data['endereco'];
    $total = $data['total'];

    // Inserir dados na tabela historico_encomendas
    $sql = "INSERT INTO historico_encomendas (user_id, username, nome, apelido, telefone, endereco, total, data_encomenda) 
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssssd", $user_id, $username, $nome, $apelido, $telefone, $endereco, $total);

    // Executar a inserção e verificar o resultado
    if ($stmt->execute()) {
        // Recuperar o encomenda_id gerado pela inserção
        $encomenda_id = $conn->insert_id;
        
        // Retornar o encomenda_id gerado como parte da resposta
        echo json_encode(["message" => "Dados do formulário salvos com sucesso!", "encomenda_id" => $encomenda_id]);
    } else {
        echo json_encode(["message" => "Erro ao salvar dados do formulário."]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["message" => "Dados inválidos."]);
}
?>

