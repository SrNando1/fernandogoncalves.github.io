<?php
// Inicia a sessão
session_start();

// Inclui a conexão ao banco de dados
require 'db_connect.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: loginUser.php");
    exit();
}

if (isset($_SESSION['mensagem'])) {
  echo "<div class='alert alert-success'>" . htmlspecialchars($_SESSION['mensagem']) . "</div>";
  unset($_SESSION['mensagem']);
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

     // ---------------- TODOS OS USUÁRIOS ---------------- //
    // Consulta SQL para buscar todos os usuários da tabela usuarios
    $stmt = $pdo->prepare("SELECT id, username, nome, apelido, endereco, idade, email, telefone, nascimento, genero, data_registro FROM usuarios");
    $stmt->execute();
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

     // ---------------- HISTÓRICO DE ENCOMENDAS ---------------- //
    // Consulta SQL para buscar o histórico de encomenda
    $stmt = $pdo->prepare("SELECT encomenda_id, user_id, username, nome, apelido, nascimento, telefone, endereco, total, data_encomenda, status FROM historico_encomendas");
    $stmt->execute();
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);


}

catch (PDOException $e) {
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
                <a href="#">Olá Admin, <strong><?php echo $username; ?></strong>!</a>
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
        <button class="list-group-item" id="gestao-de-pedidos-link">
          <a>Gestão de Pedidos</a>
        </button>
        <button class="list-group-item" id="gestão-de-produtos-link">
          <a>Gestão de Produtos</a>
        </button>
        <button class="list-group-item" id="gestão-de-clientes-link">
          <a>Gestão de Clientes</a>
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

    <!--Gerenciamento de Pedidos-->
    <div id="gerenciamento-de-pedidos" class="col-md-9" style="display: none;">
    <h2>Gerenciamento de Pedidos</h2>
    <div class="card p-3 table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Encomenda ID</th>
                    <th>Username</th>
                    <th>Nome</th>
                    <th>Data da Encomenda</th>
                    <th>Estado</th>
                    <th>Valor Total</th>
                    <th>Detalhes</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($resultados as $linha): ?>
                    <tr>
                        <td><?= htmlspecialchars($linha['encomenda_id']); ?></td>
                        <td><?= htmlspecialchars($linha['username']); ?></td>
                        <td><?= htmlspecialchars($linha['nome']) ?> <?= htmlspecialchars($linha['apelido']); ?></td>
                        <td><?= htmlspecialchars($linha['data_encomenda']); ?></td>
                        <td>
                            <form method="POST" action="atualizar_status.php">
                                <input type="hidden" name="encomenda_id" value="<?= htmlspecialchars($linha['encomenda_id']); ?>">
                                <select name="status" class="form-select" onchange="this.form.submit()">
                                    <option value="Pendente" <?= $linha['status'] === 'Pendente' ? 'selected' : ''; ?>>Pendente</option>
                                    <option value="Aprovada" <?= $linha['status'] === 'Aprovada' ? 'selected' : ''; ?>>Aprovada</option>
                                    <option value="Rejeitada" <?= $linha['status'] === 'Rejeitada' ? 'selected' : ''; ?>>Rejeitada</option>
                                </select>
                            </form>
                        </td>
                        <td><?= htmlspecialchars($linha['total']); ?>€</td>
                        <td>
                            <button class="btn btn-link detalhes-link" data-encomenda-id="<?= htmlspecialchars($linha['encomenda_id']); ?>">+Detalhes</button>
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

    <!--Gestão de Produtos-->
   <div id="gestão-de-produtos" class="col-md-9" method="POST" style="display: none;">
      <h2>Lista de Produtos</h2>
            <div class="card p-3">
                <table class="table" id="tabela-produtos">
                  <thead>
                    <tr>
                      <th>Nome</th>
                      <th>Categoria</th>
                      <th>Preço</th>
                      <th>Marca</th>
                      <th>Stock</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
            </table>
    </div>
    
    <button id="confirmar-alterações" class="btn btn-primary">Confirmar Alterações</button>
    <button id="adicionar-produto-btn" class="btn btn-primary">Inserir Novo Produto</button>
    </div>

    <!--Formulario Para Novos Produtos-->
  <div id="adicionar-produto" class="col-md-9" style="display: none;">
    <h2>Adicionar Novo Produto</h2>
    <div class="card p-3">
      <form id="form-adicionar-produto" method="POST" action="adicionar_produto.php">
        <div class="mb-3">
          <label for="nome" class="form-label">Nome do Produto</label>
          <input type="text" id="nome" name="nome" class="form-control" required />
        </div>

        <div class="mb-3">
          <label for="categoria" class="form-label">Categoria</label>
          <?php
          // Verifica se a variável $categoria foi enviada pelo formulário
          $categoria = isset($_POST['categoria']) ? $_POST['categoria'] : ''; // Se não estiver definida, será uma string vazia
          ?>
          <select id="categoria" name="categoria" class="form-control" required>
            <option value="Frutas" <?php echo $categoria === 'Frutas' ? 'selected' : ''; ?>>Frutas</option>
            <option value="Legumes" <?php echo $categoria === 'Legumes' ? 'selected' : ''; ?>>Legumes</option>
            <option value="Laticínios" <?php echo $categoria === 'Laticínios' ? 'selected' : ''; ?>>Laticínios</option>
            <option value="Carnes" <?php echo $categoria === 'Carnes' ? 'selected' : ''; ?>>Carnes</option>
            <option value="Padaria" <?php echo $categoria === 'Padaria' ? 'selected' : ''; ?>>Padaria</option>
          </select>
        </div>

        <div class="mb-3">
          <label for="preco" class="form-label">Preço (€)</label>
          <input type="number" step="0.01" id="preco" name="preco" class="form-control" required />
        </div>

        <div class="mb-3">
          <label for="marca" class="form-label">Marca</label>
          <?php
          // Verifica se a variável $categoria foi enviada pelo formulário
          $marca = isset($_POST['marca']) ? $_POST['marca'] : ''; // Se não estiver definida, será uma string vazia
          ?>
          <select id="marca" name="marca" class="form-control" required>
            <option value="WhiteBrand" <?php echo $marca === 'WhiteBrand' ? 'selected' : ''; ?>>WhiteBrand</option>
            <option value="Mercearia" <?php echo $marca === 'Mercearia' ? 'selected' : ''; ?>>Mercearia</option>
            <option value="Deluxe" <?php echo $marca === 'Deluxe' ? 'selected' : ''; ?>>Deluxe</option>
          </select>
        </div>

        <div class="mb-3">
          <label for="stock" class="form-label">Quantidade em Stock</label>
          <input type="number" id="stock" name="stock" class="form-control" required />
        </div>

        <div class="mb-3">
          <label for="em_promocao" class="form-label">Em Promoção</label>
          <select id="em_promocao" name="em_promocao" class="form-select" required>
            <option value="1">Sim</option>
            <option value="0">Não</option>
          </select>
        </div>

        <div class="mb-3">
          <label for="sem_gluten" class="form-label">Sem Glúten</label>
          <select id="sem_gluten" name="sem_gluten" class="form-select" required>
            <option value="1">Sim</option>
            <option value="0">Não</option>
          </select>
        </div>

        <div class="mb-3">
          <label for="sem_lactose" class="form-label">Sem Lactose</label>
          <select id="sem_lactose" name="sem_lactose" class="form-select" required>
            <option value="1">Sim</option>
            <option value="0">Não</option>
          </select>
        </div>

        <div class="mb-3">
          <label for="vegetariano" class="form-label">Vegetariano</label>
          <select id="vegetariano" name="vegetariano" class="form-select" required>
            <option value="1">Sim</option>
            <option value="0">Não</option>
          </select>
        </div>

        <div class="mb-3">
          <label for="vegan" class="form-label">Vegan</label>
          <select id="vegan" name="vegan" class="form-select" required>
            <option value="1">Sim</option>
            <option value="0">Não</option>
          </select>
        </div>

        <div class="mb-3">
          <label for="biologico" class="form-label">Biológico</label>
          <select id="biologico" name="biologico" class="form-select" required>
            <option value="1">Sim</option>
            <option value="0">Não</option>
          </select>
        </div>

        <div class="mb-3">
          <label for="destaque" class="form-label">Em Destaque</label>
          <select id="destaque" name="destaque" class="form-select" required>
            <option value="1">Sim</option>
            <option value="0">Não</option>
          </select>
        </div>

        <button type="submit" class="btn btn-success">Adicionar Produto</button>
      </form>
    </div>
  </div>

<!-- Gestão de Clientes -->
<div id="gestão-de-clientes" class="col-md-9" method="POST" style="display: block;">
    <h2>Lista de Clientes</h2>
    <div class="card p-3">
        <table class="table" id="tabela-usuarios">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>Nome</th>
                    <th>Ficha de Cliente</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($usuarios): ?>
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($usuario['id']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['username']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['nome']); ?> <?php echo htmlspecialchars($usuario['apelido']); ?></td>
                            <td>
                              <button class="btn btn-link ficha-cliente-btn" data-id="<?php echo htmlspecialchars($usuario['id']); ?>">
                                  Ficha de Cliente
                              </button>
                          </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="4">Nenhum usuário encontrado.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Ficha de Cliente -->
<div id="ficha-cliente" class="col-md-9" style="display: none;">
    <h2>Ficha de Cliente</h2>
    <div class="card p-3">
        <!-- Campos de Ficha de Cliente -->
        <div class="mb-3">
            <label for="userid" class="form-label"><strong>User Id:</strong></label>
            <input type="number" class="form-control" id="userid" name="userid" readonly />
        </div>
        <div class="mb-3">
            <label for="usernamefc" class="form-label"><strong>Username:</strong></label>
            <input type="text" class="form-control" id="usernamefc" name="usernamefc" readonly />
        </div>
        <div class="mb-3">
            <label for="nomefc" class="form-label"><strong>Nome:</strong></label>
            <input type="text" class="form-control" id="nomefc" name="nomefc" readonly />
        </div>
        <div class="mb-3">
            <label for="apelidofc" class="form-label"><strong>Apelido:</strong></label>
            <input type="text" class="form-control" id="apelidofc" name="apelidofc" readonly />
        </div>
        <div class="mb-3">
            <label for="telefonefc" class="form-label"><strong>Contato:</strong></label>
            <input type="tel" class="form-control" id="telefonefc" name="telefonefc" readonly />
        </div>
        <div class="mb-3">
            <label for="enderecofc" class="form-label"><strong>Endereço:</strong></label>
            <input type="text" class="form-control" id="enderecofc" name="enderecofc" readonly />
        </div>
        <div class="mb-3">
            <label for="generofc" class="form-label"><strong>Gênero:</strong></label>
            <input type="text" class="form-control" id="generofc" name="generofc" readonly />
        </div>
        <div class="mb-3">
            <label for="nascimento" class="form-label"><strong>Data de Nascimento:</strong></label>
            <input type="date" class="form-control" id="nascimento" name="nascimento" readonly />
        </div>
        <div class="mb-3">
            <label for="emailfc" class="form-label"><strong>Email:</strong></label>
            <input type="email" class="form-control" id="emailfc" name="emailfc" readonly />
        </div>
        <div class="mb-3">
            <label for="data_registro" class="form-label"><strong>Data de Registro:</strong></label>
            <input type="date" class="form-control" id="data_registro" name="data_registro" readonly />
        </div>
    </div>
</div>


  </body>
  <script src="dashboard-admin.js">

  </script>
</html>