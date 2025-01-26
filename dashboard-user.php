<?php
// Inicia a sessão
session_start();

// Inclui a conexão ao banco de dados
require 'db_connect.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

try {
    // Consulta SQL para buscar os dados do usuário
    $stmt = $pdo->prepare("SELECT username, email, nome, apelido, endereco, telefone, nascimento, genero, idade FROM usuarios WHERE id = :id");
    $stmt->bindParam(':id', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt->execute();

    // Busca os resultados
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$user) {
        echo "<p>Erro: Usuário não encontrado. Por favor, faça login novamente.</p>";
        exit();
    }

    // Define as variáveis para exibir no HTML
    $username = htmlspecialchars($user['username']);
    $email = htmlspecialchars($user['email']);
    $telefone = isset($user['telefone']) ? htmlspecialchars($user['telefone']) : 'Não definido';
    $nascimento = htmlspecialchars($user['nascimento']);
    $nome = isset($user['nome']) ? htmlspecialchars($user['nome']) : 'Não definido';
    $apelido = isset($user['apelido']) ? htmlspecialchars($user['apelido']) : 'Não definido';
    $endereco = isset($user['endereco']) ? htmlspecialchars($user['endereco']) : 'Não definido';
    $genero = isset($user['genero']) ? htmlspecialchars($user['genero']) : 'Não definido';

    //Calculo da Idade
    $data_atual = new DateTime();
    $data_nasc = new DateTime($nascimento);
    $idade = $data_atual->diff($data_nasc)->y;

    // ---------------- HISTÓRICO DE ENCOMENDAS ---------------- //
    // Consulta SQL para buscar o histórico de encomendas
    $stmtOrders = $pdo->prepare("SELECT encomenda_id, user_id, data_encomenda, status, total FROM historico_encomendas WHERE user_id = :id");
    $stmtOrders->bindParam(':id', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmtOrders->execute();

    // Busca os resultados
    $orders = $stmtOrders->fetchAll(PDO::FETCH_ASSOC);
    if (!$orders) {
        $orders = [];
    }

    // Verifica se o parâmetro encomenda_id foi passado na URL
    if (isset($_GET['encomenda_id'])) {
        $encomenda_id = $_GET['encomenda_id'];

        // Consulta os itens da encomenda
        $stmtItems = $pdo->prepare("SELECT itens_id, produto_id, quantidade, preco_unitario, subtotal FROM itens_encomenda WHERE encomenda_id = :encomenda_id");
        $stmtItems->bindParam(':encomenda_id', $encomenda_id, PDO::PARAM_INT);
        $stmtItems->execute();

        $items = $stmtItems->fetchAll(PDO::FETCH_ASSOC);
        if (!$items) {
            $items = [];
        }
    }
} catch (PDOException $e) {
    echo "<p>Erro ao acessar o banco de dados: " . htmlspecialchars($e->getMessage()) . "</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>
    <link rel="stylesheet" href="index.css" />
    <link rel="stylesheet" href="dashboard-user.css" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"
    ></script>
    <link
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css"
    rel="stylesheet"
    />
  </head>
  <body>
    <div class="header">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <button
            class="navbar-toggler"
            type="button"
            data-toggle="collapse"
            data-target="#navbarTogglerDemo01"
            aria-controls="navbarTogglerDemo01"
            aria-expanded="false"
            aria-label="Toggle navigation"
          >
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
            <a class="navbar-brand" href="index-user.php">Mercearia</a>
          </div>
          <div class="user-options">
                <a href="#">Olá, <strong><?php echo $username; ?></strong>!</a>
                <a href="logout.php">Sair</a>
                <a href="#">
                    <i class="bi bi-cart"></i>
                </a>
            </div>
        </nav>

        <div class="container my-4">
  <div class="row">
    <nav class="col-md-3">
      <ul class="list-group">
        <button class="list-group-item active" id="dados-acesso-link">
          <a>Dados de Acesso</a>
        </button>
        <button class="list-group-item" id="dados-pessoais-link">
          <a>Dados Pessoais</a>
        </button>
        <button class="list-group-item" id="historico-encomendas-link">
          <a>Histórico de Encomendas</a>
        </button>
      </ul>
    </nav>

    <!-- Formulário Dados de Acesso -->
    <form class="col-md-9" id="dados-de-acesso" action="update_user.php" method="POST">
      <h2>Dados de Acesso</h2>
      <div class="card p-3">
        <div class="mb-3">
          <label for="email" class="form-label"><strong>E-mail:</strong></label>
          <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" readonly />
        </div>
        <div class="mb-3">
          <label for="telefone" class="form-label"><strong>Contacto:</strong></label>
          <input type="tel" class="form-control" id="telefone" name="telefone" value="<?php echo $telefone; ?>" readonly />
        </div>
      </div>
    </form>

    <!-- Formulário Dados Pessoais -->
    <form class="col-md-9" id="dados-pessoais" action="update_user.php" method="POST" style="display: none;">
      <h2>Dados Pessoais</h2>
      <div class="card p-3">
        <div class="mb-3">
          <label for="username" class="form-label"><strong>Usuário:</strong></label>
          <input type="text" class="form-control" id="username" name="username" value="<?php echo $username; ?>" readonly />
        </div>
        <div class="mb-3">
          <label for="emaildp" class="form-label"><strong>E-mail:</strong></label>
          <input type="email" class="form-control" id="emaildp" name="emaildp" value="<?php echo $email; ?>"/>
        </div>
        <div class="mb-3">
          <label for="nome" class="form-label"><strong>Nome:</strong></label>
          <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $nome; ?>" />
        </div>
        <div class="mb-3">
          <label for="apelido" class="form-label"><strong>Apelido:</strong></label>
          <input type="text" class="form-control" id="apelido" name="apelido" value="<?php echo $apelido; ?>" />
        </div>
        <div class="mb-3">
          <label for="telefone" class="form-label"><strong>Contacto:</strong></label>
          <input type="tel" class="form-control" id="telefone" name="telefone" value="<?php echo $telefone; ?>" />
        </div>
        <div class="mb-3">
          <label for="endereco" class="form-label"><strong>Endereço:</strong></label>
          <input type="text" class="form-control" id="endereco" name="endereco" value="<?php echo $endereco; ?>" />
        </div>
        <div class="mb-3">
          <label for="genero" class="form-label"><strong>Genêro:</strong></label>
          <select class="form-select" id="genero" name="genero">
            <option value="Masculino" <?php echo $genero === 'Masculino' ? 'selected' : ''; ?>>Masculino</option>
            <option value="Feminino" <?php echo $genero === 'Feminino' ? 'selected' : ''; ?>>Feminino</option>
            <option value="Outro" <?php echo $genero === 'Outro' ? 'selected' : ''; ?>>Outro</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="idade" class="form-label"><strong>Idade:</strong></label>
          <input type="number" class="form-control" id="idade" name="idade" value="<?php echo $idade; ?>" readonly />
        </div>
        <div class="mb-3">
          <label for="tipo" class="form-label"><strong>Tipo:</strong></label>
          <input type="text" class="form-control" id="tipo" name="tipo" value="Particular" readonly />
        </div>
        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
      </div>
    </form>

    <!--Histórico de Encomendas -->
    <div id="historico-encomendas" class="col-md-9"  method="POST" style="display: none;">
      <h2>Histórico de Encomendas</h2>
            <div class="card p-3">
                <table class="table">
                  <thead>
                    <tr>
                      <th>Encomenda ID</th>
                      <th>Data da Encomenda</th>
                      <th>Estado</th>
                      <th>Valor Total</th>
                      <th>Detalhes</th>
                    </tr>
                  </thead>
                  <tbody>
                    
                  <?php foreach ($orders as $order) : ?>
                    <tr>
                      <td><?= htmlspecialchars($order['encomenda_id']); ?></td>
                      <td><?= htmlspecialchars($order['data_encomenda']); ?></td>
                      <td><?= htmlspecialchars($order['status']); ?></td>
                      <td><?= htmlspecialchars($order['total']); ?>€</td>
                      <td>
                        <button class="btn btn-link detalhes-link" data-encomenda-id="<?= htmlspecialchars($order['encomenda_id']); ?>">+Detalhes</button>
                    </td>
                    </tr>
                  <?php endforeach; ?>
                  </tbody>
            </table>
    </div>
    </div>
    <!-- Tabela de Itens da Encomenda -->
    <div id="itens-encomenda" class="col-md-9" style="display: none;">
  <h2>Itens da Encomenda</h2>
  <div class="card p-3">
  <table class="table">
  <thead>
    <tr>
      <th>Produto</th>
      <th>Quantidade kg/un</th>
      <th>Preço kg/un</th>
      <th>Subtotal</th>
    </tr>
  </thead>
  <tbody>
    <!-- Os itens serão carregados dinamicamente aqui -->
  </tbody>
</table>
  </div>
</div>
  </div>
        </div>
    </div>

  </body>
  <script src="dashboard-user.js">

  </script>
</html>
