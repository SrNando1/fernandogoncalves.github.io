document.addEventListener("DOMContentLoaded", function () {
  // Variáveis dos elementos
  const dadosAcessoForm = document.getElementById("dados-de-acesso");
  const dadosPessoaisForm = document.getElementById("dados-pessoais");
  const gestaoPedidos = document.getElementById("gerenciamento-de-pedidos");
  const gestaoProdutos = document.getElementById("gestão-de-produtos");
  const gestaoClientes = document.getElementById("gestão-de-clientes");
  const itensEncomenda = document.getElementById("itens-encomenda");
  const formProduto = document.getElementById("adicionar-produto");
  const fichaCliente = document.getElementById("ficha-cliente");

  const dadosAcessoLink = document.getElementById("dados-acesso-link");
  const dadosPessoaisLink = document.getElementById("dados-pessoais-link");
  const gestaoPedidosLink = document.getElementById("gestao-de-pedidos-link");
  const gestaoProdutosLink = document.getElementById("gestão-de-produtos-link");
  const gestaoClientesLink = document.getElementById("gestão-de-clientes-link");
  const formProdutoBtn = document.getElementById("adicionar-produto-btn");

  // Função para esconder todas as seções
  function esconderTudo() {
    dadosAcessoForm.style.display = "none";
    dadosPessoaisForm.style.display = "none";
    gestaoPedidos.style.display = "none";
    gestaoProdutos.style.display = "none"; // Esconde a tabela de itens de encomenda
    gestaoClientes.style.display = "none"; // Esconde a tabela de itens de encomenda
    itensEncomenda.style.display = "none";
    formProduto.style.display = "none";
    fichaCliente.style.display = "none";
  }

  // Exibe o formulário de Dados de Acesso ao carregar a página
  // Altere essa lógica para exibir a seção correta ao iniciar
  esconderTudo();
  dadosAcessoForm.style.display = "block"; // Inicialmente mostra Dados de Acesso

  // Exibe o formulário de Dados de Acesso
  dadosAcessoLink.addEventListener("click", function (e) {
    e.preventDefault();
    esconderTudo();
    dadosAcessoForm.style.display = "block";
    dadosAcessoLink.classList.add("active");
    dadosPessoaisLink.classList.remove("active");
    gestaoPedidosLink.classList.remove("active");
    gestaoProdutosLink.classList.remove("active");
    gestaoClientesLink.classList.remove("active");
  });

  // Exibe o formulário de Dados Pessoais
  dadosPessoaisLink.addEventListener("click", function (e) {
    e.preventDefault();
    esconderTudo();
    dadosPessoaisForm.style.display = "block";
    dadosPessoaisLink.classList.add("active");
    dadosAcessoLink.classList.remove("active");
    gestaoPedidosLink.classList.remove("active");
    gestaoProdutosLink.classList.remove("active");
    gestaoClientesLink.classList.remove("active");
  });

  // Exibe o formulário de Gerenciamento de Pedidos
  gestaoPedidosLink.addEventListener("click", function (e) {
    e.preventDefault();
    esconderTudo();
    gestaoPedidos.style.display = "block";
    gestaoPedidosLink.classList.add("active");
    dadosAcessoLink.classList.remove("active");
    dadosPessoaisLink.classList.remove("active");
    gestaoProdutosLink.classList.remove("active");
    gestaoClientesLink.classList.remove("active");
  });

  // Exibe o Gerenciamento de Pedidos
  gestaoPedidosLink.addEventListener("click", function (e) {
    e.preventDefault();
    esconderTudo();
    gestaoPedidos.style.display = "block";
    gestaoPedidosLink.classList.add("active");
    dadosAcessoLink.classList.remove("active");
    dadosPessoaisLink.classList.remove("active");
    gestaoProdutosLink.classList.remove("active");
    gestaoClientesLink.classList.remove("active");
  });

  // Exibe a Lista de Produtos
  gestaoProdutosLink.addEventListener("click", function (e) {
    e.preventDefault();
    esconderTudo();
    gestaoProdutos.style.display = "block";
    gestaoProdutosLink.classList.add("active");
    dadosAcessoLink.classList.remove("active");
    dadosPessoaisLink.classList.remove("active");
    gestaoPedidosLink.classList.remove("active");
    gestaoClientesLink.classList.remove("active");
  });

  // Exibe o Formulário de Novo Produto
  formProdutoBtn.addEventListener("click", function (e) {
    e.preventDefault();
    esconderTudo();
    formProduto.style.display = "block";
    gestaoProdutosLink.classList.add("active");
    dadosAcessoLink.classList.remove("active");
    dadosPessoaisLink.classList.remove("active");
    gestaoPedidosLink.classList.remove("active");
    gestaoClientesLink.classList.remove("active");
  });

  // Exibe a Lista de Clientes
  gestaoClientesLink.addEventListener("click", function (e) {
    e.preventDefault();
    esconderTudo();
    gestaoClientes.style.display = "block";
    gestaoClientesLink.classList.add("active");
    dadosAcessoLink.classList.remove("active");
    dadosPessoaisLink.classList.remove("active");
    gestaoPedidosLink.classList.remove("active");
    gestaoProdutosLink.classList.remove("active");
  });

  // Evento para cada link de "+ Detalhes" da tabela de histórico de encomendas
  const detalhesLinks = document.querySelectorAll(".detalhes-link");

  detalhesLinks.forEach(function (link) {
    link.addEventListener("click", function (e) {
      e.preventDefault(); // Impede o comportamento padrão do link
      esconderTudo(); // Esconde todas as seções
      itensEncomenda.style.display = "block"; // Exibe a tabela de itens da encomenda
      itensEncomenda.classList.add("active"); // Marca a tabela de itens como ativa
      gestaoPedidosLink.classList.remove("active"); // Remove o "ativo" do histórico
      dadosAcessoLink.classList.remove("active");
      dadosPessoaisLink.classList.remove("active");
      gestaoProdutosLink.classList.remove("active");
      gestaoClientesLink.classList.remove("active");
    });
  });

  // Evento para cada link de "Fichas de Cliente" da tabela de Lista de Clientes
  const fichaClienteBtn = document.querySelectorAll(".ficha-cliente-btn");

  fichaClienteBtn.forEach(function (link) {
    link.addEventListener("click", function (e) {
      e.preventDefault(); // Impede o comportamento padrão do link
      esconderTudo(); // Esconde todas as seções
      fichaCliente.style.display = "block"; // Exibe a tabela de itens da encomenda
      fichaCliente.classList.add("active"); // Marca a tabela de itens como ativa
      gestaoPedidosLink.classList.remove("active"); // Remove o "ativo" do histórico
      dadosAcessoLink.classList.remove("active");
      dadosPessoaisLink.classList.remove("active");
      gestaoProdutosLink.classList.remove("active");
      gestaoClientesLink.classList.remove("active");
    });
  });
});

document.addEventListener("DOMContentLoaded", function () {
  const tabelaItensEncomenda = document.querySelector("#itens-encomenda tbody");
  const itensEncomendaDiv = document.querySelector("#itens-encomenda");

  // Função para buscar os itens de uma encomenda
  function carregarItensEncomenda(encomendaId) {
    fetch(`carregar_itens.php?encomenda_id=${encomendaId}`)
      .then((response) => response.json())
      .then((data) => {
        if (data.error) {
          console.error("Erro ao carregar itens:", data.error);
          tabelaItensEncomenda.innerHTML = `
            <tr>
              <td colspan="4">Erro ao carregar itens: ${data.error}</td>
            </tr>`;
          return;
        }

        // Limpa a tabela antes de adicionar novos dados
        tabelaItensEncomenda.innerHTML = "";

        // Adiciona os itens na tabela
        if (data.length > 0) {
          data.forEach((item) => {
            const row = `
              <tr>
                <td>${item.produto_nome}</td>
                <td>${parseFloat(item.quantidade).toFixed(0)}</td>
                <td>${parseFloat(item.preco_unitario).toFixed(2)}€</td>
                <td>${parseFloat(item.subtotal).toFixed(2)}€</td>
              </tr>`;
            tabelaItensEncomenda.insertAdjacentHTML("beforeend", row);
          });
        } else {
          // Caso não haja itens
          tabelaItensEncomenda.innerHTML = `
            <tr>
              <td colspan="4">Nenhum item encontrado para esta encomenda.</td>
            </tr>`;
        }

        // Exibe a tabela de itens
        itensEncomendaDiv.style.display = "block";
      })
      .catch((error) => {
        console.error("Erro na requisição:", error);
        tabelaItensEncomenda.innerHTML = `
          <tr>
            <td colspan="4">Erro ao carregar os itens.</td>
          </tr>`;
      });
  }

  // Adiciona evento nos links de detalhes
  const detalhesLinks = document.querySelectorAll(".detalhes-link");
  detalhesLinks.forEach((link) => {
    link.addEventListener("click", function (e) {
      e.preventDefault();

      // Obtém o ID da encomenda a partir do atributo data-encomenda-id
      const encomendaId = this.getAttribute("data-encomenda-id");

      // Carrega os itens da encomenda correspondente
      carregarItensEncomenda(encomendaId);
    });
  });
});

document.addEventListener("DOMContentLoaded", function () {
  const tabelaProdutos = document.querySelector("#tabela-produtos tbody");
  const botaoConfirmarAlterações = document.querySelector(
    "#confirmar-alterações"
  );

  // Arrays para armazenar alterações
  let alteracoesStock = [];
  let alteracoesPreco = [];

  // Função para carregar produtos
  function carregarProdutos() {
    fetch("get_products.php")
      .then((response) => response.json())
      .then((data) => {
        if (data.error) {
          console.error("Erro ao carregar produtos:", data.error);
          tabelaProdutos.innerHTML = `
            <tr>
              <td colspan="6">Erro ao carregar produtos: ${data.error}</td>
            </tr>`;
          return;
        }

        tabelaProdutos.innerHTML = ""; // Limpa a tabela

        if (data.length > 0) {
          data.forEach((produto) => {
            const row = `
              <tr>
                <td>${produto.Nome}</td>
                <td>${produto.Categoria}</td>
                <td>
                  <input type="number" 
                         value="${parseFloat(produto.Preço).toFixed(2)}" 
                         data-produto-id="${produto.Produto_id}" 
                         class="input-preco form-control" 
                         style="max-width: 100px;" />
                </td>
                <td>${produto.Marca}</td>
                <td>
                  <input type="number" 
                         value="${produto.Stock}" 
                         data-produto-id="${produto.Produto_id}" 
                         class="input-stock form-control" 
                         style="max-width: 80px;" />
                </td>
              </tr>`;
            tabelaProdutos.insertAdjacentHTML("beforeend", row);
          });

          // Monitora alterações de preço e de estoque
          monitorarAlteracoesPreco();
          monitorarAlteracoesStock();
        } else {
          tabelaProdutos.innerHTML = `
            <tr>
              <td colspan="6">Nenhum produto encontrado.</td>
            </tr>`;
        }
      })
      .catch((error) => {
        console.error("Erro na requisição:", error);
        tabelaProdutos.innerHTML = `
          <tr>
            <td colspan="6">Erro ao carregar os produtos.</td>
          </tr>`;
      });
  }

  // Monitorar alterações no estoque
  function monitorarAlteracoesStock() {
    const inputsStock = document.querySelectorAll(".input-stock");

    inputsStock.forEach((input) => {
      input.addEventListener("change", function () {
        const produtoId = this.getAttribute("data-produto-id");
        const novoStock = this.value;

        // Verifica se já existe alteração para o produto
        const index = alteracoesStock.findIndex(
          (item) => item.produtoId === produtoId
        );

        if (index !== -1) {
          alteracoesStock[index].novoStock = novoStock;
        } else {
          alteracoesStock.push({ produtoId, novoStock });
        }

        console.log("Alterações de stock:", alteracoesStock);
      });
    });
  }

  // Monitorar alterações no preço
  function monitorarAlteracoesPreco() {
    const inputsPreco = document.querySelectorAll(".input-preco");

    inputsPreco.forEach((input) => {
      input.addEventListener("change", (event) => {
        const produtoId = event.target.getAttribute("data-produto-id");
        const novoPreco = parseFloat(event.target.value).toFixed(2);

        // Verifica se já existe alteração para o produto
        const index = alteracoesPreco.findIndex(
          (item) => item.produtoId === produtoId
        );

        if (index !== -1) {
          alteracoesPreco[index].novoPreco = novoPreco;
        } else {
          alteracoesPreco.push({ produtoId, novoPreco });
        }

        console.log("Alterações de preço:", alteracoesPreco);
      });
    });
  }

  // Função para confirmar alterações de stock e preço
  function confirmarAlteracoes() {
    if (alteracoesStock.length === 0 && alteracoesPreco.length === 0) {
      alert("Nenhuma alteração de stock ou preço para confirmar.");
      return;
    }

    const alteracoes = {
      stock: alteracoesStock,
      preco: alteracoesPreco,
    };

    fetch("atualizar_produtos.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(alteracoes), // Envia as alterações de stock e preço como JSON
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          alert("Alterações de stock e preço atualizadas com sucesso.");
          carregarProdutos(); // Atualiza a tabela após confirmar
          alteracoesStock = []; // Limpa as alterações de stock
          alteracoesPreco = []; // Limpa as alterações de preço
        } else {
          console.error("Erro ao atualizar produtos:", data.message);
          alert("Erro ao atualizar produtos.");
        }
      })
      .catch((error) => {
        console.error("Erro na requisição:", error);
        alert("Erro ao enviar alterações.");
      });
  }

  // Evento para confirmar alterações
  botaoConfirmarAlterações.addEventListener("click", confirmarAlteracoes);

  // Carrega os produtos ao iniciar
  carregarProdutos();
});

const fichaClienteBtn = document.querySelectorAll(".ficha-cliente-btn");
const fichaCliente = document.getElementById("ficha-cliente");
const gestaoClientes = document.getElementById("gestão-de-clientes");

// Adicionar evento de clique aos botões "Ficha de Cliente"
fichaClienteBtn.forEach((button) => {
  button.addEventListener("click", function () {
    const userId = this.getAttribute("data-id"); // Obtém o ID do usuário associado ao botão

    console.log("ID do Usuário:", userId); // Verifique no console se o ID está correto

    if (!userId) {
      console.log("ID do usuário não encontrado!");
      return; // Se não tiver ID, aborta a execução
    }

    // Faz a requisição AJAX para obter os detalhes do usuário
    fetch("get_user_details.php?id=" + userId)
      .then((response) => {
        if (!response.ok) {
          // Se a resposta não for ok (erro HTTP)
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
      })
      .then((data) => {
        console.log("Dados recebidos do servidor:", data); // Adicione este log

        if (data.success) {
          // Preencher os campos da ficha de cliente com os dados recebidos
          document.getElementById("userid").value = data.user.id;
          document.getElementById("usernamefc").value = data.user.username;
          document.getElementById("nomefc").value = data.user.nome;
          document.getElementById("apelidofc").value = data.user.apelido;
          document.getElementById("telefonefc").value = data.user.telefone;
          document.getElementById("enderecofc").value = data.user.endereco;
          document.getElementById("generofc").value = data.user.genero;

          // Ajuste de formato da data (YYYY-MM-DD) para os campos de data
          const nascimentoDate = data.user.nascimento.split(" ")[0]; // Remove a parte da hora
          const dataRegistroDate = data.user.data_registro.split(" ")[0]; // Remove a parte da hora

          document.getElementById("nascimento").value = nascimentoDate;
          document.getElementById("emailfc").value = data.user.email;
          document.getElementById("data_registro").value = dataRegistroDate;

          // Esconde a "Gestão de Clientes" e mostra a ficha do cliente
          gestaoClientes.style.display = "none"; // Esconde a lista de clientes
          fichaCliente.style.display = "block"; // Exibe a ficha de cliente
        } else {
          alert("Erro ao carregar os dados do cliente.");
        }
      })
      .catch((error) => {
        console.error("Erro na requisição AJAX:", error); // Log do erro detalhado
        alert(
          "Erro ao fazer a requisição AJAX. Veja o console para mais detalhes."
        );
      });
  });
});
