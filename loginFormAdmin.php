<!-- Importando o conteúdo de loginAdmin.php -->
<?php include 'loginAdmin.php'; ?>
<!doctype html>
<html lang="pt">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="login.css" />
    <link rel="stylesheet" href="index.css" />
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
    <title>Login</title>
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
        <a class="navbar-brand" href="loginUser.php">Mercearia</a>
      </div>
    </nav>
  </head>
  <body style="background-color: rgba(188, 187, 187, 0.458)">
    <!--LOGIN-->
    <div class="container">
      <div class="ilustration-container">
        <img src="https://placehold.jp/150x150.png" />
        <h2>
          Aceda aos diferentes sites e apps do Continente com uma só conta
        </h2>
      </div>
      <div class="login-container">
        <h2 id="form-title">Login</h2>
        <form id="login-form" action="loginAdmin.php" method="POST">
        <?php
    // Verificar se existe a variável 'success' na URL
    if (isset($_GET['success'])) {
        // Exibir mensagem de sucesso dentro de uma div
        echo "<div class='success-message'>" . htmlspecialchars($_GET['success']) . "</div>";
    }
    ?>
    <?php
    // Verificar se existe a variável 'error' na URL
    if (isset($_GET['error'])) {
        // Exibir mensagem de erro dentro de uma div
        echo "<div class='error-message'>" . htmlspecialchars($_GET['error']) . "</div>";
    }
    ?>
          <div class="input-group">
            <label for="username">Usuário</label>
            <input
              type="text"
              id="username"
              name="username"
              placeholder="Digite seu usuário"
              required
            />
          </div>
          <div class="input-group">
            <label for="password">Senha</label>
            <input
              type="password"
              id="password"
              name="password"
              placeholder="Digite sua senha"
              required
            />
          </div>
          <button type="submit" class="btn">Entrar</button>
        </form>

        <!-- Formulário de Registro -->
        <form
          id="register-form"
          action="login.php"
          method="POST"
          style="display: none"
        >
          <div class="input-group">
            <label for="new-username">Usuário</label>
            <input
              type="text"
              id="new-username"
              name="new-username"
              placeholder="Digite um nome de usuário"
              required
            />
          </div>
          <div id="username-erro" style="color: red;"></div>
          <div class="input-group">
            <label for="email">Email</label>
            <input
              type="email"
              id="email"
              name="email"
              placeholder="Digite seu email"
              required
            />
          </div>
          <div class="input-group">
            <label for="senha">Senha</label>
            <input
              type="password"
              id="senha"
              name="senha"
              placeholder="Digite uma senha"
              required
            />
          </div>
          <div class="input-group">
            <label for="nome">Nome</label>
            <input
              type="text"
              id="nome"
              name="nome"
              placeholder="Nome"
              required
            />
          </div>
          <div class="input-group">
            <label for="apelido">Apelido</label>
            <input
              type="text"
              id="apelido"
              name="apelido"
              placeholder="Apelido"
              required
            />
          </div>
          <div class="input-group">
            <label for="endereco">Endereço</label>
            <input
              type="text"
              id="endereco"
              name="endereco"
              placeholder="Endereço"
              required
            />
          </div>
          <div class="input-group">
            <label for="telefone">Telefone</label>
            <input
              type="tel"
              id="telefone"
              name="telefone"
              placeholder="Número de Telefone"
              required
            />
          </div>
          <div class="input-group">
            <label for="nascimento">Data de Nascimento</label>
            <input type="date" id="nascimento" name="nascimento" required />
          </div>
          <div class="input-group genero-group">
            <label for="genero">Gênero</label>
            <label for="Masculino">
              <input
                type="radio"
                id="Masculino"
                name="genero"
                value="Masculino"
                required
              />
              Masculino
            </label>
            <label for="Feminino">
              <input
                type="radio"
                id="Feminino"
                name="genero"
                value="Feminino"
                required
              />
              Feminino
            </label>
            <label for="outro">
              <input
                type="radio"
                id="outro"
                name="genero"
                value="Outro"
                required
              />
              Outro
            </label>
          </div>

          <button id="registrar-btn" type="submit" id="registar" class="btn">Registrar</button>
        </form>

        <div class="links">
          <a href="#" id="forgot-password">Esqueceu a senha?</a>
          <a href="#" id="create-account">Criar uma conta</a>
          <a href="#" id="back-to-login" style="display: none"
            >Voltar ao login</a
          >
        </div>
      </div>
    </div>
    
  </body>
  <script src="loginAdmin.js"></script>
</html>
