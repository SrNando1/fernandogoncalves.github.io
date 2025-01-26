<?php
// Inclui a conexão ao banco de dados
require 'db_connect.php';

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Prepara os dados recebidos do formulário
        $nome = $_POST['nome'];
        $categoria = $_POST['categoria'];
        $preco = $_POST['preco'];
        $marca = $_POST['marca'];
        $stock = $_POST['stock'];
        $em_promocao = $_POST['em_promocao'];
        $sem_gluten = $_POST['sem_gluten'];
        $sem_lactose = $_POST['sem_lactose'];
        $vegetariano = $_POST['vegetariano'];
        $vegan = $_POST['vegan'];
        $biologico = $_POST['biologico'];
        $destaque = $_POST['destaque'];

        // Consulta SQL para inserir o novo produto na base de dados
        $query = "INSERT INTO Produtos 
                  (Nome, Categoria, Preço, Marca, Stock, Em_Promocao, Sem_Gluten, Sem_Lactose, Vegetariano, Vegan, Biologico, Destaque) 
                  VALUES 
                  (:nome, :categoria, :preco, :marca, :stock, :em_promocao, :sem_gluten, :sem_lactose, :vegetariano, :vegan, :biologico, :destaque)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            ':nome' => $nome,
            ':categoria' => $categoria,
            ':preco' => $preco,
            ':marca' => $marca,
            ':stock' => $stock,
            ':em_promocao' => $em_promocao,
            ':sem_gluten' => $sem_gluten,
            ':sem_lactose' => $sem_lactose,
            ':vegetariano' => $vegetariano,
            ':vegan' => $vegan,
            ':biologico' => $biologico,
            ':destaque' => $destaque,
        ]);

        // Redireciona para a página anterior com uma mensagem de sucesso
        $_SESSION['sucesso'] = "Produto adicionado com sucesso!";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();

    } catch (PDOException $e) {
        // Se houver erro ao inserir, armazena a mensagem de erro na sessão
        $_SESSION['erro'] = "Erro ao adicionar produto: " . htmlspecialchars($e->getMessage());
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
} else {
    // Caso o método não seja POST, retorna um erro
    echo "<p>Método inválido. Por favor, use o formulário para enviar os dados.</p>";
}
?>

