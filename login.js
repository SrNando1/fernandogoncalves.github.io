document
  .getElementById("create-account")
  .addEventListener("click", function (e) {
    e.preventDefault(); // Previne o comportamento padrão do link
    document.getElementById("login-form").style.display = "none"; // Oculta o formulário de login
    document.getElementById("register-form").style.display = "block";
    document.getElementById("create-account").style.display = "none"; // Oculta o formulário de login
    document.getElementById("back-to-login").style.display = "block";
    document.getElementById("form-title").textContent = "Registrar";
  });

document
  .getElementById("back-to-login")
  .addEventListener("click", function (e) {
    e.preventDefault(); // Previne o comportamento padrão do link
    document.getElementById("login-form").style.display = "block";
    document.getElementById("register-form").style.display = "none";
    document.getElementById("create-account").style.display = "block";
    document.getElementById("forgot-password").style.display = "block";
    document.getElementById("back-to-login").style.display = "none";
    document.getElementById("form-title").textContent = "Login";
  });

// Captura o parâmetro "error" da URL
const urlParams = new URLSearchParams(window.location.search);
const error = urlParams.get("error");

// Exibe as mensagens de erro
if (error) {
  const errorMessage = document.createElement("div");
  errorMessage.style.color = "red";
  errorMessage.style.marginTop = "10px";

  if (error === "senha_incorreta") {
    errorMessage.textContent = "Senha incorreta.";
  } else if (error === "usuario_nao_encontrado") {
    errorMessage.textContent = "Usuário não encontrado.";
  }

  // Adiciona a mensagem ao formulário de login
  const loginForm = document.getElementById("login-form");
  loginForm.insertBefore(errorMessage, loginForm.firstChild);
}

document.addEventListener("DOMContentLoaded", function () {
  const usernameInput = document.getElementById("new-username");
  const erroDiv = document.getElementById("username-erro");
  const registrarBtn = document.getElementById("registrar-btn"); // Botão "Registrar" com ID único

  usernameInput.addEventListener("blur", function () {
    const username = this.value;

    // Limpar mensagem de erro e habilitar o botão antes de fazer nova verificação
    erroDiv.textContent = "";
    registrarBtn.disabled = false;

    if (username.trim() !== "") {
      const xhr = new XMLHttpRequest();
      xhr.open("POST", "verificar_username.php", true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

      xhr.onload = function () {
        if (xhr.status === 200) {
          const response = JSON.parse(xhr.responseText);
          if (!response.disponivel) {
            erroDiv.textContent = "Nome de usuário indisponível!";
            registrarBtn.disabled = true; // Desabilita o botão se o username não estiver disponível
          }
        } else {
          console.error("Erro ao verificar o username.");
        }
      };

      // Enviar o username para o servidor
      xhr.send("new-username=" + encodeURIComponent(username));
    }
  });
});
