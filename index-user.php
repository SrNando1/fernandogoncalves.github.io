<?php
// Inicia a sessão para acessar informações do usuário logado
session_start();

// Inclui a conexão ao banco de dados
require 'db_connect.php';

// Verificar se o usuário está logado
if (!isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id']; // Recupera o user_id da sessão
    // Redirecionar para login.html caso não esteja logado
    header("Location: loginUser.php");
    exit();
}

// Recuperar o user_id da sessão
$user_id = $_SESSION['user_id'];

$products = []; // Garante que a variável existe

try {
    // Busca dados JSON a partir de uma URL remota (API)
    $response = file_get_contents('http://localhost/Projeto%20Final%20Web%20Development/get_products.php');
    
    if ($response === FALSE) {
        throw new Exception("Erro ao obter dados da API.");
    }

    // Decodifica o JSON para array associativo
    $products = json_decode($response, true); 

    // Verifica se a resposta da API é válida
    if ($products === NULL) {
        throw new Exception("Erro ao decodificar o JSON.");
    }

} catch (Exception $e) {
    error_log("Erro ao buscar produtos: " . $e->getMessage());
    // Opcional: pode exibir uma mensagem amigável para o usuário em caso de falha na requisição
}


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
// Consulta SQL para buscar os dados do usuário
$stmt = $pdo->prepare("SELECT username, email, nome, apelido, endereco, telefone, nascimento, genero, is_admin, idade FROM usuarios WHERE id = :id");
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
$is_admin = (bool) $user['is_admin'];  // Converte o tinyint para um valor booleano


?>


<!DOCTYPE html>
<html lang="pt">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width" />
    
    <link rel="stylesheet" href="index-user.css"/>
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

    <title>Mercearia</title>
  </head>
  <body>
  <div id="main-content">
    <div class="header">
      <!-- Barra de Pesquisa e navegação do usuário -->
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

        <div class="search">
          <input id="search-field" name="search" class="form-control mr-sm-2" type="text" placeholder="Buscar produtos..." aria-label="Search">
        </div>
        <button id="search-btn" class="btn btn-outline-success my-2 my-sm-0" type="button">Pesquisar</button>

        <div class="user-options">
          <a href="<?php echo $is_admin ? 'dashboard-admin.php' : 'dashboard-user.php'; ?>">
            <?php 
              echo $is_admin ? "Olá Admin, <strong>" . htmlspecialchars($_SESSION['username']) . "</strong>!" : "Olá, <strong>" . htmlspecialchars($_SESSION['username']) . "</strong>!";
            ?>
          </a>
          <a href="logout.php">Sair</a>
          <div id="cart-icon" onclick="toggleCart()">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
                <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
            </svg>
          </div>
          <p id="cart-subtotal-top">€0</p>
          <p id="items-total">0</p>

          <!-- Carrinho Lateral -->
          <div id="side-cart-container" class="side-cart-container">
            <div class="cart-header">
              <h2>O seu carrinho</h2>
              <span class="close-btn" onclick="toggleCart()">✖</span>
            </div>
            <div class="cart-items"></div>
            <div class="cart-footer">
                <div class="subtotal">
                <span>Subtotal</span>
                <span id="cart-subtotal-footer">0€</span>
                </div>
                <button id="checkout-btn">COMPRAR</button>
            </div>
          </div>
        </div>
      </nav>

      
    </div>

    <!-- Carrossel de Produtos -->
    <div id="carouselExampleIndicators" class="carousel slide">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="img/1.png" class="d-block w-100" alt="..." />
        </div>
        <div class="carousel-item">
          <img src="img/2.png" class="d-block w-100" alt="..." />
        </div>
        <div class="carousel-item">
          <img src="img/3.png" class="d-block w-100" alt="..." />
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
      </button>
    </div>

    <!-- Produtos em Destaque -->
    <h1 class="h1-destaque">Produtos em destaque</h1>
    <div class="carousel-gallery-container">
      <button class="carousel-nav-prev" type="button">
        <span class="carousel-nav-prev-icon" aria-hidden="true"></span>
      </button>
      <div class="carousel-gallery">
        <!-- Produtos serão carregados aqui -->
      </div>
      <button class="carousel-nav-next" type="button">
        <span class="carousel-nav-next-icon" aria-hidden="true"></span>
      </button>
    </div>

    <!-- Todos os Produtos -->
    <h1 class="h1-todos-os-produtos">Todos os Produtos</h1>
    <div class="todos-os-produtos">

    <!--SIDE BAR FILTRAGEM DE PRODUTOS-->
    <div class="sidebar">
        <h3>Filtrar Produtos</h3>

        <!-- Filtro por categoria -->
        <div class="filter-section">
          <h4>Categoria</h4>
          <ul>
            <li>
              <input
                type="checkbox"
                id="category1"
                name="category"
                value="Fruta"
              />
              Fruta
            </li>
            <li>
              <input
                type="checkbox"
                id="category2"
                name="category"
                value="Legumes"
              />
              Legumes
            </li>
            <li>
              <input
                type="checkbox"
                id="category3"
                name="category"
                value="Laticínios"
              />
              Laticínios
            </li>
            <li>
              <input
                type="checkbox"
                id="category4"
                name="category"
                value="Carnes"
              />
              Carnes
            </li>
            <li>
              <input
                type="checkbox"
                id="category5"
                name="category"
                value="Padaria"
              />
              Padaria
            </li>
          </ul>
        </div>

        <!-- Filtro por preço -->
        <div class="filter-section">
          <h4>Preço</h4>
          <input
            type="range"
            id="price-range"
            min="0"
            max="100"
            step="1"
            value="50"
          />
          <p>Até €<span id="price-value">50</span></p>
        </div>

        <!-- Filtro por Marca -->
        <div class="filter-section">
          <h4>Marcas</h4>
          <ul>
            <li>
              <input
                type="checkbox"
                id="mark1"
                name="mark"
                value="WhiteBrand"
              />
            WhiteBrand
            </li>
            <li>
              <input
                type="checkbox"
                id="mark2"
                name="mark"
                value="Mercearia"
              />
            Mercearia
            </li>
            <li>
              <input
                type="checkbox"
                id="mark3"
                name="mark"
                value="Deluxe"
              />
              Deluxe
            </li>
          </ul>
        </div>
        <div class="filter-section">
          <h4>Em Promoção</h4>
          <ul>
            <li>
              <input
                type="checkbox"
                id="promo"
                name="promo"
                value="promo"
              />
            Produtos em Promoção
            </li>
          </ul>
        </div>

        <!-- Alergenicos -->
        <div class="filter-section">
          <h4>Sem Glúten</h4>
          <ul>
            <li>
              <input
                type="checkbox"
                id="glutenfree"
                name="glutenfree"
                value="glutenfree"
              />
            Produtos sem Glúten
            </li>
          </ul>
        </div>
        <div class="filter-section">
          <h4>Sem Lactose</h4>
          <ul>
            <li>
              <input
                type="checkbox"
                id="lactosefree"
                name="lactosefree"
                value="lactosefree"
              />
            Produtos sem Lactose
            </li>
          </ul>
        </div>
        <div class="filter-section">
          <h4>Vegetariano</h4>
          <ul>
            <li>
              <input
                type="checkbox"
                id="vegetarian"
                name="vegetarian"
                value="vegetarian"
              />
            Produtos Vegetarianos
            </li>
          </ul>
        </div>
        <div class="filter-section">
          <h4>Vegan</h4>
          <ul>
            <li>
              <input
                type="checkbox"
                id="vegan"
                name="vegan"
                value="vegan"
              />
            Produtos Vegan
            </li>
          </ul>
        </div>
        <div class="filter-section">
          <h4>Biológico</h4>
          <ul>
            <li>
              <input
                type="checkbox"
                id="bio"
                name="bio"
                value="bio"
              />
            Produtos Biológicos
            </li>
          </ul>
        </div>

        <!-- Botão de aplicar filtros -->
        <button class="apply-filters">Aplicar Filtros</button>
      </div>

      <main class="product-grid" id="product-container">
        <!--Galeria de Produtos com Filtragem no JS-->
      </main>
    </div>
  </div>

    <!--Checkout Formulário-->
       <!-- Modal do Checkout -->
       <div id="checkout-modal" class="hidden">
          <div class="modal-overlay"></div>
            <div id="checkout" class="checkout-form">
              <h2>Formulário de Checkout</h2>
              <form>
                <!--User ID campo oculto-->
                <input type="hidden" id="user-id" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>" />

                <label for="username" class="form-label"><strong>Usuário:</strong></label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo $username; ?>" readonly />
              
                <label for="nome" class="form-label"><strong>Nome:</strong></label>
                <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $nome;?>" required />
              
                <label for="apelido" class="form-label"><strong>Apelido:</strong></label>
                <input type="text" class="form-control" id="apelido" name="apelido" value="<?php echo $apelido; ?>" required />

                <label for="data-de-nascimento" class="form-label"><strong>Data de Nascimento:</strong></label>
                <input type="text" class="form-control" id="data-de-nascimento" name="data-de-nascimento" value="<?php echo $nascimento; ?>" required />
              
                <label for="telefone" class="form-label"><strong>Contacto:</strong></label>
                <input type="tel" class="form-control" id="telefone" name="telefone" value="<?php echo $telefone; ?>" required />
              
                <label for="endereco" class="form-label"><strong>Endereço:</strong></label>
                <input type="text" class="form-control" id="endereco" name="endereco" value="<?php echo $endereco; ?>" required />

                <div class="checkout-total">
                      <span>Total</span>
                      <span id="checkout-form-total">0€</span>
                      </div>

                <button type="button" id="confirmar-btn">Confirmar</button>
                <button type="button" id="close-checkout-btn">Fechar</button>
              </form>
            </div>
          </div>
        </div>

    <footer>
      <div class="footer-container">
        <div class="newsletter-container">
          <h3>Subscreva a nossa Newsletter</h3>
          <form class="newsletter-form" action="#" method="POST">
            <input id="email-field" type="email" name="email" placeholder="Digite o seu e-mail" required />
            <button type="submit">Submeter</button>
          </form>
        </div>
      </div>
    </footer>

    <script src="index_user.js"></script>
    <script>
  const products = <?php echo json_encode($products); ?>;
  </script>
  </body>
</html>
