<?php
// Inclui a conexão ao banco de dados
require 'db_connect.php';

// Inicia a sessão para exibir mensagens de feedback
session_start();

// Validar dados enviados
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['encomenda_id'], $_POST['status'])) {
    $encomenda_id = intval($_POST['encomenda_id']);
    $novo_status = $_POST['status'];

    // Verificar se o status é válido
    $status_permitidos = ['Pendente', 'Aprovada', 'Rejeitada'];
    if (in_array($novo_status, $status_permitidos, true)) {
        try {
            // Atualizar o status na tabela
            $stmt = $pdo->prepare("UPDATE historico_encomendas SET status = :status WHERE encomenda_id = :encomenda_id");
            $stmt->bindParam(':status', $novo_status, PDO::PARAM_STR);
            $stmt->bindParam(':encomenda_id', $encomenda_id, PDO::PARAM_INT);
            $stmt->execute();

            // Mensagem de sucesso
            $_SESSION['mensagem'] = "Status da encomenda ID {$encomenda_id} atualizado para '{$novo_status}'.";
        } catch (PDOException $e) {
            // Mensagem de erro
            $_SESSION['mensagem'] = "Erro ao atualizar o status: " . $e->getMessage();
        }
    } else {
        // Status inválido
        $_SESSION['mensagem'] = "Status inválido selecionado.";
    }
} else {
    // Dados inválidos enviados
    $_SESSION['mensagem'] = "Dados inválidos enviados.";
}

// Redireciona para a página anterior
header('Location: ' . $_SERVER['HTTP_REFERER']); // Retorna à página anterior
exit;
?>
