<?php
session_start();
require 'db_connect.php';

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        // Atualiza os dados do usuário no banco
        $stmt = $pdo->prepare("UPDATE usuarios SET email = :email, telefone = :telefone, nome = :nome, apelido = :apelido, endereco = :endereco, genero = :genero, idade = :idade WHERE id = :id");
        $stmt->execute([
            ':email' => $_POST['emaildp'],
            ':telefone' => $_POST['telefone'],
            ':nome' => $_POST['nome'],
            ':apelido' => $_POST['apelido'],
            ':endereco' => $_POST['endereco'],
            ':genero' => $_POST['genero'],
            ':idade' => $_POST['idade'],
            ':id' => $_SESSION['user_id'] // Certifique-se de que a variável de sessão 'user_id' está configurada
        ]);

        // Verifica se a atualização foi bem-sucedida
        if ($stmt->rowCount() > 0) {
            // Salva a mensagem de sucesso
            $_SESSION['sucesso'] = "Dados alterados com sucesso!";
        } else {
            // Caso nenhuma alteração tenha sido feita
            $_SESSION['erro'] = "Nenhuma alteração foi feita. Verifique os dados.";
        }
    } catch (PDOException $e) {
        // Caso ocorra algum erro ao atualizar
        $_SESSION['erro'] = "Erro ao atualizar dados: " . $e->getMessage();
    }

    // Redireciona para a página anterior
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}
?>


