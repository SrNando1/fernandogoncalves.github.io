document.addEventListener("DOMContentLoaded", function () {
  // Variáveis dos elementos
  const dadosAcessoForm = document.getElementById("dados-de-acesso");
  const dadosPessoaisForm = document.getElementById("dados-pessoais");
  const historicoEncomendas = document.getElementById("historico-encomendas");
  const itensEncomenda = document.getElementById("itens-encomenda"); // Garantir que a tabela "Itens Encomenda" seja referenciada

  const dadosAcessoLink = document.getElementById("dados-acesso-link");
  const dadosPessoaisLink = document.getElementById("dados-pessoais-link");
  const historicoEncomendasLink = document.getElementById(
    "historico-encomendas-link"
  );

  // Função para esconder todas as seções
  function esconderTudo() {
    dadosAcessoForm.style.display = "none";
    dadosPessoaisForm.style.display = "none";
    historicoEncomendas.style.display = "none";
    itensEncomenda.style.display = "none"; // Esconde a tabela de itens de encomenda
  }

  // Exibe o histórico de encomendas e esconde os outros
  historicoEncomendasLink.addEventListener("click", function (e) {
    e.preventDefault();
    esconderTudo(); // Esconde todas as seções
    historicoEncomendas.style.display = "block"; // Exibe apenas o histórico de encomendas
    historicoEncomendasLink.classList.add("active"); // Marca o link de histórico de encomendas como ativo
    dadosAcessoLink.classList.remove("active"); // Remove o ativo do link de dados de acesso
    dadosPessoaisLink.classList.remove("active"); // Remove o ativo do link de dados pessoais
  });

  // Exibe o formulário de dados de acesso
  dadosAcessoLink.addEventListener("click", function (e) {
    e.preventDefault();
    esconderTudo();
    dadosAcessoForm.style.display = "block";
    dadosAcessoLink.classList.add("active");
    dadosPessoaisLink.classList.remove("active");
    historicoEncomendasLink.classList.remove("active");
  });

  // Exibe o formulário de dados pessoais
  dadosPessoaisLink.addEventListener("click", function (e) {
    e.preventDefault();
    esconderTudo();
    dadosPessoaisForm.style.display = "block";
    dadosPessoaisLink.classList.add("active");
    dadosAcessoLink.classList.remove("active");
    historicoEncomendasLink.classList.remove("active");
  });

  // Evento para cada link de "+ Detalhes" da tabela de histórico de encomendas
  const detalhesLinks = document.querySelectorAll(".detalhes-link");

  detalhesLinks.forEach(function (link) {
    link.addEventListener("click", function (e) {
      e.preventDefault(); // Impede o comportamento padrão do link
      esconderTudo(); // Esconde todas as seções
      itensEncomenda.style.display = "block"; // Exibe a tabela de itens da encomenda
      itensEncomenda.classList.add("active"); // Marca a tabela de itens como ativa
      historicoEncomendasLink.classList.remove("active"); // Remove o "ativo" do histórico
      dadosAcessoLink.classList.remove("active");
      dadosPessoaisLink.classList.remove("active");
    });
  });
});

document.addEventListener("DOMContentLoaded", function () {
  const detalhesLinks = document.querySelectorAll(".detalhes-link");
  const itensEncomenda = document.getElementById("itens-encomenda");
  const itensEncomendaBody = itensEncomenda.querySelector("tbody"); // Corpo da tabela de itens

  detalhesLinks.forEach(function (link) {
    link.addEventListener("click", function (e) {
      e.preventDefault();

      const encomendaId = this.getAttribute("data-encomenda-id");

      // Faz a requisição para carregar os itens da encomenda
      fetch(`carregar_itens.php?encomenda_id=${encomendaId}`)
        .then((response) => response.json())
        .then((data) => {
          // Limpa os itens antigos da tabela
          itensEncomendaBody.innerHTML = "";

          if (data.length > 0) {
            // Adiciona os itens na tabela
            data.forEach((item) => {
              const row = `
                <tr>
                  <td>${item.produto_nome}</td>
                  <td>${parseFloat(item.quantidade).toFixed(0)}</td>
                  <td>${parseFloat(item.preco_unitario).toFixed(2)}€</td>
                  <td>${parseFloat(item.subtotal).toFixed(2)}€</td>
                </tr>`;
              itensEncomendaBody.insertAdjacentHTML("beforeend", row);
            });
          } else {
            // Mensagem se não houver itens
            itensEncomendaBody.innerHTML = `
              <tr>
                <td colspan="4">Nenhum item encontrado para esta encomenda.</td>
              </tr>`;
          }

          // Exibe a tabela de itens e esconde as outras
          esconderTudo();
          itensEncomenda.style.display = "block";
        })
        .catch((error) =>
          console.error("Erro ao carregar itens da encomenda:", error)
        );
    });
  });
});
