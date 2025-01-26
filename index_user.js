let cart = []; // Array para armazenar os itens do carrinho

/**
 * Alterna a visibilidade do carrinho
 */
function toggleCart() {
  const sideCart = document.getElementById("side-cart-container");
  sideCart.classList.toggle("active");
}

//Vincula eventos para os botões "Adicionar ao Carrinho"
function attachAddToCartEvents() {
  const buttons = document.querySelectorAll(".add-to-cart-btn:not(.disabled)");

  if (!buttons.length) {
    console.warn("Nenhum botão 'Adicionar ao Carrinho' encontrado!");
    return;
  }

  console.log("Vinculando eventos aos botões 'Adicionar ao Carrinho'...");

  // Adiciona um evento de clique a cada botão
  buttons.forEach((button) => {
    button.addEventListener("click", (e) => {
      const productId = e.target.getAttribute("data-id");
      const productNameElement = e.target.parentElement.querySelector("h5");
      const productPriceElement = e.target.parentElement.querySelector("p");

      if (!productNameElement || !productPriceElement) {
        console.warn("Estrutura HTML inválida para o produto.");
        return;
      }

      const productName = productNameElement.innerText;
      const productPriceText = productPriceElement.innerText;
      const productPrice = parseFloat(
        productPriceText.replace(/[^\d.-]+/g, "")
      );

      console.log("Produto clicado:", { productId, productName, productPrice });

      // Adiciona o produto ao carrinho
      addToCart({
        id: productId,
        name: productName,
        price: productPrice,
      });
    });
  });
}

function attachAddToCartEvents1() {
  const buttons = document.querySelectorAll(".add-to-cart-btn1");

  if (!buttons.length) {
    console.warn("Nenhum botão 'Adicionar ao Carrinho' encontrado!");
    return;
  }

  console.log("Vinculando eventos aos botões 'Adicionar ao Carrinho'...");

  // Adiciona um evento de clique a cada botão
  buttons.forEach((button) => {
    button.addEventListener("click", (e) => {
      const productId = e.target.getAttribute("data-id");
      const productNameElement = e.target.parentElement.querySelector("h5");
      const productPriceElement = e.target.parentElement.querySelector("p");

      if (!productNameElement || !productPriceElement) {
        console.warn("Estrutura HTML inválida para o produto.");
        return;
      }

      const productName = productNameElement.innerText;
      const productPriceText = productPriceElement.innerText;
      const productPrice = parseFloat(
        productPriceText.replace(/[^\d.-]+/g, "")
      );

      console.log("Produto clicado:", { productId, productName, productPrice });

      // Adiciona o produto ao carrinho
      addToCart({
        id: productId,
        name: productName,
        price: productPrice,
      });
    });
  });
}

/**
 * Função para adicionar produtos ao carrinho
 * @param {Object} product
 */
function addToCart(product) {
  console.log("Tentando adicionar produto ao carrinho:", product);

  // Verificar se o produto já está no carrinho
  const existingProduct = cart.find((item) => item.id === product.id);

  if (existingProduct) {
    // Se o produto já existe no carrinho, aumentar a quantidade
    existingProduct.qty++;
    console.log("Quantidade atualizada:", existingProduct);
  } else {
    // Caso contrário, adicionar o produto ao carrinho com quantidade 1
    cart.push({ ...product, qty: 1 });
    console.log("Produto adicionado ao carrinho:", product);
  }

  // Exibir o carrinho atualizado
  renderCart();
}

// Função para atualizar o HTML do carrinho
function updateCartUI() {
  const cartContainer = document.querySelector(".cart-items");
  const cartSubtotalTop = document.getElementById("cart-subtotal-top");
  const cartSubtotalFooter = document.getElementById("cart-subtotal-footer");
  const checkoutFormTotal = document.getElementById("checkout-form-total");

  if (
    !cartContainer ||
    !cartSubtotalTop ||
    !cartSubtotalFooter ||
    !checkoutFormTotal
  ) {
    console.error("Elementos do carrinho não encontrados!");
    return;
  }

  cartContainer.innerHTML = ""; // Limpar carrinho
  let total = 0; // Resetar o total

  cart.forEach((item) => {
    const cartItem = `
      <div class="cart-item">
        <h5>${item.name}</h5>
        <button class="decrease-qty-btn" data-id="${item.id}">-</button>
        <p>€${item.price.toFixed(2)} x ${item.qty}</p>
        <button class="increase-qty-btn" data-id="${item.id}">+</button>
        <p>€${(item.price * item.qty).toFixed(2)}</p>
        <button class="remove-btn" data-id="${item.id}">Remover</button>
      </div>
    `;
    cartContainer.innerHTML += cartItem;
    total += item.price * item.qty;
  });

  // Atualizar subtotal no HTML
  cartSubtotalTop.innerText = `€${total.toFixed(2)}`;
  cartSubtotalFooter.innerText = `€${total.toFixed(2)}`;
  checkoutFormTotal.innerText = `€${total.toFixed(2)}`;

  // Atualizar a contagem de IDs únicos no HTML
  const uniqueItemCount = countUniqueItemIds(cart);
  document.getElementById("items-total").innerText = uniqueItemCount;

  // Associar eventos aos botões
  addEventListeners();
}

// Função para contar IDs únicos
function countUniqueItemIds(cart) {
  const uniqueIds = new Set(cart.map((item) => item.id));
  return uniqueIds.size;
}

// Função para associar os eventos aos botões
function addEventListeners() {
  document.querySelectorAll(".decrease-qty-btn").forEach((btn) => {
    btn.addEventListener("click", (e) => {
      const itemId = e.target.getAttribute("data-id");
      decreaseQuantity(itemId);
    });
  });

  document.querySelectorAll(".increase-qty-btn").forEach((btn) => {
    btn.addEventListener("click", (e) => {
      const itemId = e.target.getAttribute("data-id");
      increaseQuantity(itemId);
    });
  });

  document.querySelectorAll(".remove-btn").forEach((btn) => {
    btn.addEventListener("click", (e) => {
      const itemId = e.target.getAttribute("data-id");
      removeItem(itemId);
    });
  });
}

// Função para aumentar a quantidade de um item
function increaseQuantity(itemId) {
  const cartItem = cart.find((item) => item.id === itemId);
  if (cartItem && cartItem.qty < 99) {
    cartItem.qty += 1;
    updateCartUI(); // Atualiza o carrinho
  } else if (cartItem) {
    alert("A quantidade máxima é 99.");
  }
}

// Função para diminuir a quantidade de um item
function decreaseQuantity(itemId) {
  const cartItem = cart.find((item) => item.id === itemId);
  if (cartItem) {
    cartItem.qty -= 1;
    if (cartItem.qty <= 0) {
      removeItem(itemId); // Remover o item se a quantidade for 0
    } else {
      updateCartUI(); // Atualiza o carrinho
    }
  }
}

// Função para remover um item do carrinho
function removeItem(itemId) {
  const index = cart.findIndex((item) => item.id === itemId);
  if (index > -1) {
    cart.splice(index, 1);
    updateCartUI(); // Atualiza o carrinho
  }
}

// Inicializar o carrinho
function renderCart() {
  console.log("Renderizando o carrinho...");

  const cartContainer = document.querySelector(".cart-items");
  const cartSubtotalTop = document.getElementById("cart-subtotal-top");
  const cartSubtotalFooter = document.getElementById("cart-subtotal-footer");
  const checkoutFormTotal = document.getElementById("checkout-form-total");

  if (
    !cartContainer ||
    !cartSubtotalTop ||
    !cartSubtotalFooter ||
    !checkoutFormTotal
  ) {
    console.error("Elementos do carrinho não encontrados!");
    return;
  }

  // Limpar o conteúdo anterior
  cartContainer.innerHTML = "";
  let total = 0;

  cart.forEach((item) => {
    const cartItem = `
      <div class="cart-item">
        <h5>${item.name}</h5>
        <button class="decrease-qty-btn" data-id="${item.id}">-</button>
        <p>€${item.price.toFixed(2)} x ${item.qty}</p>
        <button class="increase-qty-btn" data-id="${item.id}">+</button>
        <p>€${(item.price * item.qty).toFixed(2)}</p>
        <button class="remove-btn" data-id="${item.id}">Remover</button>
      </div>
    `;
    cartContainer.innerHTML += cartItem;
    total += item.price * item.qty;
  });

  // Atualizar subtotal no HTML
  cartSubtotalTop.innerText = `€${total.toFixed(2)}`;
  cartSubtotalFooter.innerText = `€${total.toFixed(2)}`;
  checkoutFormTotal.innerText = `€${total.toFixed(2)}`;

  // Atualizar a contagem de IDs únicos no HTML
  const uniqueItemCount = countUniqueItemIds(cart);
  document.getElementById("items-total").innerText = uniqueItemCount;

  // Associar eventos aos botões
  addEventListeners();
}

// Exemplo de inicialização do carrinho
document.addEventListener("DOMContentLoaded", () => {
  renderCart(); // Chama renderCart ao carregar a página
});

/**
 * Inicializa os eventos e o carregamento dos produtos
 */
document.addEventListener("DOMContentLoaded", () => {
  fetchHighlightedProducts(); // Busca e renderiza os produtos destacados
});

/**
 * Busca produtos com destaque do servidor e adiciona ao carrossel
 */
function fetchHighlightedProducts() {
  console.log("Buscando produtos destacados...");

  fetch("get_products.php")
    .then((response) => {
      if (!response.ok) {
        throw new Error("Erro ao buscar produtos.");
      }
      return response.json();
    })
    .then((products) => {
      console.log("Produtos recebidos do servidor:", products);
      const highlightedProducts = products.filter(
        (product) => product.Destaque == 1
      );
      console.log("Produtos destacados filtrados:", highlightedProducts);
      renderCarouselGallery(highlightedProducts);
    })
    .catch((error) => {
      console.error("Erro ao buscar produtos destacados:", error);
    });
}

/**
 * Renderiza os produtos destacados na galeria do carrossel
 * @param {Array} products
 */ function renderCarouselGallery(products) {
  const carouselGallery = document.querySelector(".carousel-gallery");
  carouselGallery.innerHTML = ""; // Limpar o conteúdo atual

  products.forEach((product) => {
    // Determinar a mensagem de estoque e estado do botão
    const stockMessage =
      product.Stock === 0
        ? `<p class="out-of-stock">Indisponível</p>` // Exibe "Indisponível" se o estoque for 0
        : `<p>Estoque: ${product.Stock}</p>`; // Exibe o valor do estoque caso contrário

    const buttonClass =
      product.Stock === 0 ? "add-to-cart-btn disabled" : "add-to-cart-btn";

    // Criar o HTML do produto com base no estoque
    const productCard = `
      <div class="product-item">
        <img src="https://placehold.jp/150x150.png" alt="${product.Nome}" />
        <h5>${product.Nome}</h5>
        <h6>${product.Marca}</h6>
        <p>€${parseFloat(product.Preço).toFixed(2)}</p>
        ${stockMessage}
        <button class="${buttonClass}" data-id="${product.Produto_id}" ${
      product.Stock === 0 ? "disabled" : ""
    }>
          Adicionar ao Carrinho
        </button>
      </div>
    `;

    // Adicionar o productCard ao carrossel
    carouselGallery.innerHTML += productCard;
  });

  // Vincula os eventos aos botões
  attachAddToCartEvents1();

  // Configura a navegação do carrossel
  setupCarouselNavigation();
}

/**
 * Configura a navegação do carrossel
 */
function setupCarouselNavigation() {
  const gallery = document.querySelector(".carousel-gallery");
  const prevButton = document.querySelector(".carousel-nav-prev");
  const nextButton = document.querySelector(".carousel-nav-next");

  if (!gallery || !prevButton || !nextButton) return; // Verifica se os elementos existem

  const productWidth = gallery.querySelector(".product-item").offsetWidth + 20; // Largura do item + margem

  // Navegação para a esquerda
  prevButton.addEventListener("click", () => {
    gallery.scrollLeft -= productWidth; // Move um produto para a esquerda
  });

  // Navegação para a direita
  nextButton.addEventListener("click", () => {
    gallery.scrollLeft += productWidth; // Move um produto para a direita
  });
}

//BARRA DE FILTROS LÓGICA

document.addEventListener("DOMContentLoaded", () => {
  const productContainer = document.getElementById("product-container");
  const applyFiltersBtn = document.querySelector(".apply-filters");
  const searchField = document.getElementById("search-field");
  const searchButton = document.getElementById("search-btn");

  let allProducts = []; // Inicializa o array de produtos

  // Função para buscar os produtos da base de dados
  function fetchProducts() {
    fetch("get_products.php")
      .then((response) => response.json())
      .then((data) => {
        if (data.message) {
          console.log(data.message); // Exibir mensagem caso não haja produtos
          productContainer.innerHTML = "<p>Nenhum produto encontrado.</p>"; // Mostra mensagem na UI
        } else {
          // Mapear os produtos para o formato esperado
          allProducts = data.map((product) => ({
            id: product.Produto_id,
            name: product.Nome,
            category: product.Categoria,
            price: parseFloat(product.Preço),
            brand: product.Marca,
            promo: product.Em_Promocao === 1, // Assume que o valor é 0 ou 1
            glutenFree: product.Sem_Gluten === 1, // Assume que o valor é 0 ou 1
            lactoseFree: product.Sem_Lactose === 1, // Assume que o valor é 0 ou 1
            vegetarian: product.Vegetariano === 1, // Assume que o valor é 0 ou 1
            vegan: product.Vegan === 1, // Assume que o valor é 0 ou 1
            bio: product.Biologico === 1, // Assume que o valor é 0 ou 1
            stock: product.Stock,
          }));

          updateProductDisplay(allProducts); // Atualiza a interface com os produtos carregados
        }
      })
      .catch((error) => {
        console.error("Erro ao buscar produtos:", error);
        productContainer.innerHTML =
          "<p>Erro ao carregar os produtos. Tente novamente mais tarde.</p>";
      });
  }

  // Função para atualizar os produtos na UI
  function updateProductDisplay(filteredProducts) {
    productContainer.innerHTML = ""; // Limpar os produtos exibidos
    if (filteredProducts.length === 0) {
      productContainer.innerHTML =
        "<p>Nenhum produto corresponde aos filtros selecionados.</p>";
      return;
    }

    filteredProducts.forEach((product) => {
      const stockMessage =
        product.stock === 0
          ? `<p class="out-of-stock">Indisponível</p>` // Exibe "Indisponível" se stock for 0
          : `<p>Estoque: ${product.stock}</p>`; // Exibe o valor do estoque caso contrário

      const buttonClass =
        product.stock === 0 ? "add-to-cart-btn disabled" : "add-to-cart-btn";

      const productCard = `
        <div class="product-card">
          <img src="https://placehold.jp/150x150.png" alt="${product.name}" />
          <h5>${product.name}</h5>
          <h6>${product.brand}</h6>
          <p>Preço: €${product.price.toFixed(2)}</p>
          ${stockMessage}
          <button class="${buttonClass}" data-id="${product.id}" ${
        product.stock === 0 ? "disabled" : ""
      }>
            Adicionar ao Carrinho
          </button>
        </div>
      `;

      productContainer.innerHTML += productCard;
    });

    attachAddToCartEvents(); // Vincula eventos após atualizar os produtos
  }

  // Função para aplicar os filtros
  function applyFilters() {
    const selectedCategories = Array.from(
      document.querySelectorAll('input[name="category"]:checked')
    ).map((input) => input.value);

    const selectedBrands = Array.from(
      document.querySelectorAll('input[name="mark"]:checked')
    ).map((input) => input.value);

    const maxPrice = parseInt(document.getElementById("price-range").value);

    const isPromo = document.getElementById("promo").checked;
    const isGlutenFree = document.getElementById("glutenfree").checked;
    const isLactoseFree = document.getElementById("lactosefree").checked;
    const isVegetarian = document.getElementById("vegetarian").checked;
    const isVegan = document.getElementById("vegan").checked;
    const isBio = document.getElementById("bio").checked;

    const filteredProducts = allProducts.filter((product) => {
      const categoryMatch =
        selectedCategories.length === 0 ||
        selectedCategories.includes(product.category);
      const brandMatch =
        selectedBrands.length === 0 || selectedBrands.includes(product.brand);
      const priceMatch = product.price <= maxPrice;
      const promoMatch = !isPromo || product.promo;
      const glutenFreeMatch = !isGlutenFree || product.glutenFree;
      const lactoseFreeMatch = !isLactoseFree || product.lactoseFree;
      const vegetarianMatch = !isVegetarian || product.vegetarian;
      const veganMatch = !isVegan || product.vegan;
      const bioMatch = !isBio || product.bio;

      return (
        categoryMatch &&
        brandMatch &&
        priceMatch &&
        promoMatch &&
        glutenFreeMatch &&
        lactoseFreeMatch &&
        vegetarianMatch &&
        veganMatch &&
        bioMatch
      );
    });

    updateProductDisplay(filteredProducts); // Atualiza a exibição dos produtos
  }

  // Função para filtrar produtos pela busca
  function filterProductsBySearch(term) {
    const filteredProducts = allProducts.filter((product) =>
      product.name.toLowerCase().includes(term.toLowerCase())
    );
    updateProductDisplay(filteredProducts);
  }

  // Evento para o botão de busca
  searchButton.addEventListener("click", () => {
    const searchTerm = searchField.value.trim();
    filterProductsBySearch(searchTerm);
  });

  // Evento para buscar enquanto digita
  searchField.addEventListener("input", () => {
    const searchTerm = searchField.value.trim();
    filterProductsBySearch(searchTerm);
  });

  // Atualizar o valor do preço selecionado
  const priceRange = document.getElementById("price-range");
  const priceValue = document.getElementById("price-value");
  priceRange.addEventListener("input", () => {
    priceValue.textContent = priceRange.value;
  });

  // Evento para aplicar os filtros
  applyFiltersBtn.addEventListener("click", applyFilters);

  // Carregar os produtos quando a página for carregada
  fetchProducts();
});

//Checkout
// Referências
const toggleCheckoutBtn = document.getElementById("checkout-btn");
const checkoutModal = document.getElementById("checkout-modal");
const closeCheckoutBtn = document.getElementById("close-checkout-btn");
const mainContent = document.getElementById("main-content"); // Agora só o conteúdo principal

// Abrir o formulário de checkout
toggleCheckoutBtn.addEventListener("click", () => {
  console.log("Abrindo modal...");
  checkoutModal.classList.remove("hidden");
  mainContent.style.filter = "blur(5px)"; // Aplica o blur ao conteúdo principal
});

//Fechar o formulário de checkout
closeCheckoutBtn.addEventListener("click", () => {
  console.log("Fechando modal...");
  checkoutModal.classList.add("hidden");
  mainContent.style.filter = "none"; // Remove o blur do conteúdo principal
});

//Função para Esvaziar Carrinho Após o checkout
function clearAndUpdateCartUI() {
  // Limpar o contêiner do carrinho
  const cartContainer = document.getElementById("cart-container");
  if (cartContainer) {
    cartContainer.innerHTML = ""; // Limpar carrinho visual
  }

  // Atualizar totais e contagem de itens (após a compra, por exemplo)
  const cartSubtotalTop = document.getElementById("cart-subtotal-top");
  const cartSubtotalFooter = document.getElementById("cart-subtotal-footer");
  const checkoutFormTotal = document.getElementById("checkout-form-total");
  const itemsTotal = document.getElementById("items-total");

  // Resetar os totais (caso o carrinho tenha sido esvaziado)
  const total = 0;

  if (cartSubtotalTop) cartSubtotalTop.innerText = `€${total.toFixed(2)}`;
  if (cartSubtotalFooter) cartSubtotalFooter.innerText = `€${total.toFixed(2)}`;
  if (checkoutFormTotal) checkoutFormTotal.innerText = `€${total.toFixed(2)}`;
  if (itemsTotal) itemsTotal.innerText = "0"; // Sem itens no carrinho após a compra

  // Garantir que o carrinho seja esvaziado
  cart.length = 0; // Esvaziar a array do carrinho

  // Recarregar a UI do carrinho se necessário (caso algum item tenha sido re-adicionado)
  updateCartUI();

  // Redirecionar para a página "index-user.php"
  window.location.href = "index-user.php";
}

// ARMAZENAR DADOS DE FORMULÁRIO CHECKOUT E ITENS DE ENCOMENDA
document.getElementById("confirmar-btn").addEventListener("click", function () {
  console.log("Botão Confirmar clicado!");

  // Coletar dados do formulário
  const userId = document.getElementById("user-id").value;
  const username = document.getElementById("username").value;
  const nome = document.getElementById("nome").value;
  const apelido = document.getElementById("apelido").value;
  const nascimento = document.getElementById("data-de-nascimento").value;
  const telefone = document.getElementById("telefone").value;
  const endereco = document.getElementById("endereco").value;

  // Verificar se algum campo obrigatório está vazio
  if (!nome || !apelido || !nascimento || !telefone || !endereco) {
    alert("Por favor, preencha todos os campos obrigatórios.");
    return; // Impede a continuação da função
  }

  // Verificar maioridade (simples cálculo de anos)
  const hoje = new Date();
  const nascimentoDate = new Date(nascimento); // Converte a data para objeto Date

  let idade = hoje.getFullYear() - nascimentoDate.getFullYear();
  const mes = hoje.getMonth() - nascimentoDate.getMonth();

  if (mes < 0 || (mes === 0 && hoje.getDate() < nascimentoDate.getDate())) {
    idade--;
  }

  if (idade < 18) {
    alert("Você deve ser maior de 18 anos para concluir esta ação.");
    return; // Impede a continuação da função
  }

  // Verificar se o userId foi carregado corretamente
  if (!userId) {
    alert("Erro: ID do usuário não foi carregado corretamente.");
    return; // Impede a continuação da função
  }

  // Verificar se há itens no carrinho
  if (!cart || cart.length === 0) {
    alert("O carrinho está vazio!");
    return; // Impede a continuação da função
  }

  // Dados do formulário de checkout
  const formData = {
    user_id: userId,
    username,
    nome,
    apelido,
    nascimento,
    telefone,
    endereco,
    total: document
      .getElementById("checkout-form-total")
      .innerText.replace("€", ""),
  };

  console.log("Dados do formulário coletados:", formData);

  // Função para salvar os dados do formulário
  function saveFormData() {
    return new Promise((resolve, reject) => {
      const xhr = new XMLHttpRequest();
      xhr.open("POST", "historico_encomendas.php", true);
      xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

      xhr.onload = function () {
        try {
          const response = JSON.parse(xhr.responseText);
          if (xhr.status === 200 && response.encomenda_id) {
            resolve(response.encomenda_id); // Retorna o encomenda_id gerado
          } else {
            reject(response.message || "Erro ao salvar dados do formulário.");
          }
        } catch (e) {
          console.error("Resposta inválida do servidor:", xhr.responseText);
          reject("Erro ao processar a resposta do servidor.");
        }
      };

      xhr.onerror = function () {
        reject("Erro de conexão com o servidor.");
      };

      xhr.send(JSON.stringify(formData));
    });
  }

  // Função para buscar os produtos e o estoque
  function fetchProductsStock() {
    return fetch("get_products.php")
      .then((response) => response.json())
      .then((data) => {
        if (data && Array.isArray(data)) {
          return data.reduce((acc, product) => {
            acc[product.Produto_id] = product.Stock; // Mapear o estoque por produto_id
            return acc;
          }, {});
        } else {
          throw new Error("Erro ao carregar os dados dos produtos.");
        }
      });
  }

  // Função para verificar o estoque
  function checkStockAvailability(cartData, productsStock) {
    for (let i = 0; i < cartData.length; i++) {
      const item = cartData[i];
      const availableStock = productsStock[item.id];

      if (!availableStock || item.qty > availableStock) {
        alert(
          `Quantidade de ${item.name} indisponível! Estoque disponível: ${availableStock}`
        );
        return false; // Se algum item não tiver estoque suficiente, interrompe a função
      }
    }
    return true; // Se todos os itens passarem na verificação
  }

  // Função para salvar os itens do carrinho e atualizar o estoque
  function saveCartData(encomendaId, productsStock) {
    const cartData = cart.map((item) => ({
      id: item.id, // produto_id
      name: item.name, // nome
      price: item.price, // preco_unitario
      qty: item.qty, // quantidade
      subtotal: item.price * item.qty, // subtotal
    }));

    // Verificar a disponibilidade de estoque antes de enviar os dados
    if (!checkStockAvailability(cartData, productsStock)) {
      return; // Interrompe a função se o estoque não for suficiente
    }

    // Enviar os dados do carrinho para o backend
    return fetch("itens_encomenda.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ encomenda_id: encomendaId, cart: cartData }),
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error(`Erro HTTP! Status: ${response.status}`);
        }
        return response.json();
      })
      .then((data) => {
        if (data.success) {
          alert("Itens do carrinho salvos e estoque atualizado com sucesso!");

          // Limpar o carrinho e atualizar a interface
          cart = []; // Esvaziar o array do carrinho
          clearAndUpdateCartUI(); // Atualizar a interface do carrinho
        } else {
          alert(`Erro ao processar a compra: ${data.message}`);
        }
      })

      .catch((error) => {
        console.error("Erro ao salvar dados do carrinho:", error);
        alert("Erro ao processar a compra. Tente novamente.");
      });
  }

  // Primeiro, salva os dados do formulário
  saveFormData()
    .then((encomendaId) => {
      console.log("encomenda_id gerado:", encomendaId);

      // Buscar o estoque dos produtos e, em seguida, salvar os itens do carrinho
      return fetchProductsStock().then((productsStock) => {
        return saveCartData(encomendaId, productsStock); // Passa o estoque e o encomendaId para a função de salvar os itens
      });
    })
    .then(() => {
      // Ocultar o indicador de carregamento após o processo completo
      document.getElementById("loading-spinner").style.display = "none";
    })
    .catch((error) => {
      // Ocultar o indicador de carregamento em caso de erro
      document.getElementById("loading-spinner").style.display = "none";

      console.error("Erro ao salvar dados:", error);
      alert("Erro ao salvar os dados. Tente novamente.");
    });
});
