let cartOpen = document.querySelector(".cart-btn");
let cartItem = document.querySelector(".cart-items");
let productDom = document.querySelector(".products-center");
let cartOverLay = document.querySelector(".cart-overlay");
let closeCart = document.querySelector(".close-cart");
let cartContent = document.querySelector(".cart-content");
let cartTotal = document.querySelector(".cart-total");
let clearCart = document.querySelector(".clear-cart");
let cartDom = document.querySelector(".cart");
let cartmessage = document.querySelector(".cartmessage")
let url = window.location.origin;
let cart = [];
let ButtonDom = [];
  console.log(email, userid)
class products {
  async getProduct() {
    try {
      let result = await fetch("http://127.0.0.1:8000/allorders");
      let data = await result.json();

      let product = data.success;
      product = product.map(function (item) {
        // console.log(item)
        // let { id } = item.sys;
        // let { title, price } = item.fields;
        // let image = item.fields.image.fields.file.url;
         return { id:item.id, title:item.title, price:item.price, image:item.image, category:item.category};
      });
      return product;
    } catch (error) {
      console.log(error);
    }
  }
}

class UI {
  displayItem(goods) {
    let cartgood =  localStorage.getItem("cart")? JSON.parse(localStorage.getItem("cart")): [];
    let result = "";
    goods.forEach(function (item) {
    let incart  =   cartgood.find((one) => one.id === item.id);
      if(incart){
        result += `
         <article class="product">
         <div class="img-container">
           <img src=${item.image} class="product-img">
           <button class="bag-btn" data-id=${item.id}>
            In Cart
         </button>
         </div>
         <h3>${item.title}</h3>
         <h4>&#x20A6;${item.price}</h4>
       </article>`;

      }else{
        result += `
        <article class="product">
        <div class="img-container">
          <img src=${item.image} class="product-img">
          <button class="bag-btn" data-id=${item.id}>
          <i class="fas fa-shopping-cart"></i>
          Add to cart
        </button>
        </div>
        <h3>${item.title}</h3>
        <h4>&#x20A6;${item.price}</h4>
      </article>`;
      }
    });
    productDom.innerHTML = result;


  let div = document.createElement("div");
  div.classList.add("cart-item");
  cartgood.map((item)=>{
    div.innerHTML += `<img src=${item.image}>
    <div>
      <h4>${item.title}</h4>
      <h5>&#x20A6;${item.price}</h5>
      <span class="remove-item" data-id=${item.id}>remove</span>
    </div>

    <div>
     <i class="fas fa-chevron-up" data-id=${item.id}></i>
     <p class="item-amount">${item.amount}</p>
     <i class="fas fa-chevron-down" data-id=${item.id}></i>
    </div>`;
  })

  cartContent.appendChild(div);

  }

  getButtons() {
    let buttons = [...document.querySelectorAll(".bag-btn")];
    ButtonDom = buttons;
    buttons.forEach(function (btn) {
      let id = btn.dataset.id;
      let inCart = cart.find((item) => item.id === id);
      if (inCart) {
        btn.innerText = "in cart";
        btn.disabled = true;
      }
      btn.addEventListener("click", function (e) {
        e.target.textContent = "in cart";
        e.target.disabled = true;

        storage.extraGood(id);

        let cartOne = { ...storage.extraGood(id), amount: 1 };
        cart = [...cart, cartOne];
        console.log(cart)
        storage.saveCart(cart);
        value(cart);

        showCart();
        setup();
        throwAll();
        displayInCart(cartOne);
      });
    });
  }
}

function value(cart) {
  let tempTotal = 0;
  let itemTotal = 0;
  cart.map((item) => {
    tempTotal += item.price * item.amount;
    itemTotal += item.amount;
  });
  cartItem.textContent = itemTotal;
  cartTotal.textContent = parseFloat(tempTotal.toFixed(2));
}

function displayInCart(item) {
  let div = document.createElement("div");
  div.classList.add("cart-item");
  div.innerHTML = `<img src=${item.image}>
   <div>
     <h4>${item.title}</h4>
     <h5>$${item.price}</h5>
     <span class="remove-item" data-id=${item.id}>remove</span>
   </div>

   <div>
    <i class="fas fa-chevron-up" data-id=${item.id}></i>
    <p class="item-amount">${item.amout}</p>
    <i class="fas fa-chevron-down" data-id=${item.id}></i>
   </div>`;
  cartContent.appendChild(div);

}

function showCart() {
  cartDom.classList.add("showCart");
  cartOverLay.classList.add("transparentBcg");
}

function setup() {
  cart = storage.getCart(cart);
  value(cart);
//   cartList(cart);
}

function hideCart() {
  cartDom.classList.remove("showCart");
  cartOverLay.classList.remove("transparentBcg");
}

function cartList(cart) {
  cart.forEach((one) => displayInCart(one));
}

cartOpen.addEventListener("click", function () {
  showCart();
});

closeCart.addEventListener("click", function () {
  hideCart();
});

function throwAll() {
  clearCart.addEventListener("click", function (e) {
    e.preventDefault();
    // choose();
    if(email && userid){
        let  tempTotal = 0;
        let answer =  cart.map((item)=>{
          tempTotal += item.price * item.amount;
          })


          var handler = PaystackPop.setup({
              key:'pk_test_5da9ec5d50346d4afd8c95a8dd43c6902c8ed70d', //put your public key here
              email: 'customer@email.com', //put your customer's email here
              amount: tempTotal * 100, //amount the customer is supposed to pay
              callback: function (response) {
                  let ref = response.reference
                  if(ref){
                      let hypelink = `${url}/paystack_verify/${ref}`
                      axios.get(hypelink).then(res=>{
                          if(res.data.status){
                              let answer =  cart.map((item)=>{
                                  tempTotal += item.price * item.amount;
                                      return { ...item, userid:userid, ref:ref}
                                  })

                              let data = JSON.stringify(answer)
                             let formData = new FormData();
                            formData.append("data", data)
                            formData.append('_token', token)
                              let sendlink =  `${url}/muitplepayment`
                              axios.post(sendlink, formData).then(res=>{
                              if(res.data.success){
                                cartDom.classList.remove("showCart");
                                cartOverLay.classList.remove("transparentBcg");
                                localStorage.removeItem("cart");
                                setTimeout(()=>{
                                    window.location.href = `${url}`
                                },3000)


                                  }
                                  })

                          }
                      })

                  }


              },
              onClose: function () {
                  //when the user close the payment modal
                  alert('Transaction cancelled');
              }
          });
          handler.openIframe()

    }else{

        cartmessage.innerText = 'please Register and Login'
        cartmessage.style.color = "red"
        setTimeout(()=>{
         window.location.href = `${url}/register`
        }, 3000)

    }




  });
  cartContent.addEventListener("click", function (e) {
    if (e.target.classList.contains("remove-item")) {
      let itemNow = e.target;
      let id = itemNow.dataset.id;
      cartContent.removeChild(e.target.parentElement.parentElement);
      storage.saveCart(cart);
      value(cart);
      removeId(id);
    } else if (e.target.classList.contains("fa-chevron-up")) {
      let itemAdd = e.target;
      console.log("id",itemAdd.dataset)
      let id = itemAdd.dataset.id;
      let itemSum = cart.find((item) => item.id == id);

      itemSum.amount = itemSum.amount + 1;
      storage.saveCart(cart);
      value(cart);
      itemAdd.nextElementSibling.textContent = itemSum.amount;
    } else if (e.target.classList.contains("fa-chevron-down")) {
      let itemSub = e.target;
      let id = itemSub.dataset.id;
      let itemDiff = cart.find((item) => item.id == id);
      itemDiff.amount = itemDiff.amount - 1;

      if (itemDiff.amount > 0) {
        value(cart);
        storage.saveCart(cart);
        itemSub.previousElementSibling.textContent = itemDiff.amount;
      } else {
        if (itemDiff.amount < 0) {
          removeId(id);
          cartContent.removeChild(e.target.parentElement.parentElement);
        }
      }
    }
  });
}

function choose() {
  let cartItems = cart.map((item) => item.id);
  cartItems.forEach((id) => removeId(id));

  if (cartContent.children.length > 0) {
    cartContent.removeChild(cartContent.children[0]);
  }
  hideCart();
}

function removeId(id) {
  cart = cart.filter((item) => item.id !== id);
  value(cart);
  storage.saveCart(cart);
  let button = btnArr(id);
  button.disabled = false;
  button.innerHTML = `<i class="fas fa-shopping-cart"></i>
 Add to cart`;
}

function btnArr(id) {
  return ButtonDom.find((button) => button.dataset.id === id);
}

class storage {
  static saveStorage(goods) {
    localStorage.setItem("goods", JSON.stringify(goods));
  }

  static extraGood(id) {
    let good = JSON.parse(localStorage.getItem("goods"));
    return good.find((item) => item.id == id);
  }
  static saveCart(cart) {
    localStorage.setItem("cart", JSON.stringify(cart));
  }
  static getCart(cart) {
    return localStorage.getItem("cart")
      ? JSON.parse(localStorage.getItem("cart"))
      : [];
  }
}

document.addEventListener("DOMContentLoaded", function () {
  const ui = new UI();
  const product = new products();
  setup();
  product
    .getProduct()
    .then(function (goods) {
      ui.displayItem(goods);

      storage.saveStorage(goods);
    })
    .then(() => {
      ui.getButtons();
      throwAll();
    });
});





