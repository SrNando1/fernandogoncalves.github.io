<?php
// Iniciar a sessão
session_start();

// Verificar se a sessão está ativa
if (isset($_SESSION['user_id'])) {
    // Limpar todas as variáveis da sessão
    session_unset();

    // Destruir a sessão
    session_destroy();

    // Redirecionar para a página de login com mensagem de logout
    header("Location: loginUser.php?success=Logout+feito+com+sucesso!");
    exit();
} else {
    // Caso não haja uma sessão ativa, redirecionar para a página de login
    header("Location: login.html");
    exit();
}
?>
