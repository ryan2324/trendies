const cart = document.querySelector('.backdrop');
const closeCart = document.querySelector('.backdrop .close-cart');
const cartBtn = document.querySelector('nav .cart-btn');
const cartContainer = document.querySelector('.backdrop .cart');
const productTitle = document.querySelectorAll('.products-container .product .details .title');
const profileMenuBtn = document.querySelector('nav .user-nav .profile-menu-btn');
const profileMenu = document.querySelector('nav .user-nav .profile-menu');
const logoutBtn = document.getElementById('logout');
const addToCartBtn = document.getElementById('add-to-cart-btn');
const cartProductList = document.querySelector('.cart .cart-items .product-list');
const cartItemsTitle = document.querySelectorAll('.cart .cart-items .product-list .product .title');
const decQuantity = document.querySelectorAll('.cart .cart-items .product-list .product .decrement');
const incQuantity = document.querySelectorAll('.cart .cart-items .product-list .product .increment');
const deleteCartItem = document.querySelectorAll('.cart .cart-items .product-list .product .delete');
const totalCartPrice = document.querySelector('.cart .cart-footer div .total-container p');
const checkoutBtn = document.getElementById('checkout-btn');
const http = new XMLHttpRequest;
let cartIsOpen = false;
try{
    cartBtn.addEventListener('click' , () =>{
        cart.style.display = "flex";
        cartIsOpen = true;
        setTimeout(() =>{
            cartContainer.style.left = '50%';
            if(document.body.clientWidth <= 768){
                cartContainer.style.left = '20%';
            }
            if(document.body.clientWidth <= 320){
                cartContainer.style.left = '0';
            }
        }, 100)
        document.body.style.overflow = 'hidden';
        checkNumberOfCartITems();
    })
    closeCart.addEventListener('click', () =>{
        cartIsOpen = false;
        cartContainer.style.left = '100%';
        setTimeout(() =>{
            cart.style.display = "none";
        }, 400)
        document.body.style.overflow = 'visible';
    })
}catch(e){

}

productTitle.forEach((title) =>{
    if(title.textContent.length >= 64){
        title.style.fontSize =  '12px';
    }
    if(document.body.clientWidth <= 768 && title.textContent.length >= 64){
        title.style.fontSize =  '10px';
    }
    if(document.body.clientWidth <= 320 && title.textContent.length >= 64){
        title.style.fontSize =  '8px';
    }
})
let profileMenuIsShow = false;
try{
    profileMenuBtn.addEventListener('click', () =>{
        if(profileMenuIsShow){
            profileMenuIsShow = false;
            profileMenu.style.display = 'none';
        }else{
            profileMenuIsShow = true;
            profileMenu.style.display = 'flex';
        }
    })
    logoutBtn.addEventListener('click', ()=>{
        http.onload = () =>{
            window.location.href = 'login.php';
        }
        http.open('POST', 'logout.php?logout=true', true);
        http.send();
    })
}catch(e){

}
cartItemsTitle.forEach((item) =>{
    if(item.textContent.length >= 50){
        item.style.fontSize = '12px';
    }
    if(document.body.clientWidth <= 320 && item.textContent.length >= 50){
        item.style.fontSize =  '8px';
    }
})
try{
    addToCartBtn.addEventListener('click', () =>{
        const loc = window.location;
        const param = new URLSearchParams(loc.search);
        
        http.onload = () =>{
            console.log(http.response)
            if(http.response == 'unauthorized'){
                window.location.href = 'login.php';
                return;
            }
            const response = JSON.parse(http.response);
            if(response.type === "exist"){
                const addQty =  document.querySelector(`.cart .cart-items .product-list .cart-item-id-${response.id} .increment`);
                incQuantityHander(addQty);
                return
            }   
            const product = response;
            const cartItem = document.createElement('div')
            cartItem.innerHTML = `
                <div class="product-img-container">
                    <img src="${product.image_path}" alt="">
                </div>
                <p class="title" style="font-size:${product.title.length >= 50 ? '12px': '16px' };">${product.title}</p>
                <div data-cart-item-id="${product.cart_item_id}"  class="quantity-container">
                    <button onclick="decQuantityHander(event)" class="decrement">-</button>
                    <p class="quantity">1</p>
                    <button onclick="incQuantityHander(event.target)" class="increment">+</button>
                </div>
                <p class="price">$${product.price}</p>
                <button onclick="deleteCartItemHandler(event)" data-cart-item-id="${product.cart_item_id}" class="delete">&#10006</button>
            `;
            cartItem.className = `cart-item-id-${product.cart_item_id} product`
            cartProductList.appendChild(cartItem);
            changeCartTotalPrice();
        }
        
        http.open('POST', 'cart-items.php', true);
        http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        http.send(`add-to-cart=${param.get('productid')}`);
    })

}catch(e){

}

const decQuantityHander = (e) =>{
    let quantity = parseInt(e.target.nextElementSibling.innerText);
        if(quantity > 1){
            quantity = parseInt(e.target.nextElementSibling.innerText) - 1;
        }
        http.onload = () =>{
            e.target.nextElementSibling.innerText = quantity;
            const price = document.querySelector(`.cart-item-id-${e.target.parentElement.getAttribute('data-cart-item-id')} .price`);
            price.textContent = `$${parseInt(http.response) * quantity}`;
            changeCartTotalPrice();
        }
        http.open('POST', 'cart-items.php', true);
        http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        http.send(`qty=${quantity}&cart-item-id=${e.target.parentElement.getAttribute('data-cart-item-id')}`)
}
const incQuantityHander = (e) =>{
        console.log(e);
        let quantity = parseInt(e.previousElementSibling.innerText) + 1;
        http.onload = () =>{
            e.previousElementSibling.innerText = quantity;
            const price = document.querySelector(`.cart-item-id-${e.parentElement.getAttribute('data-cart-item-id')} .price`);
            price.textContent = `$${parseInt(http.response) *quantity}`;
            changeCartTotalPrice();
        }
        http.open('POST', 'cart-items.php', true);
        http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        http.send(`qty=${quantity}&cart-item-id=${e.parentElement.getAttribute('data-cart-item-id')}`)
}
decQuantity.forEach((dec) =>{
    dec.addEventListener('click', (e) =>{
        decQuantityHander(e);
    })
})
incQuantity.forEach((inc) =>{
    inc.addEventListener('click', (e) =>{
        incQuantityHander(e.target);
    })
})
const deleteCartItemHandler = (e) =>{
    http.onload = () =>{
        document.querySelector(`.cart-item-id-${http.response}`).remove();
        changeCartTotalPrice();
        checkNumberOfCartITems();
    }
    http.open('POST', 'cart-items.php', true);
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    http.send(`del=${e.target.getAttribute('data-cart-item-id')}`)
    
}
deleteCartItem.forEach((del) =>{
    del.addEventListener('click', (e) =>{
        deleteCartItemHandler(e);
    })
})

const changeCartTotalPrice = () =>{
    const cartPrices = document.querySelectorAll('.cart .cart-items .product-list .product .price');
    let totalPrice = 0;
    cartPrices.forEach((price) =>{
        totalPrice += parseInt(price.textContent.substring(1));
    })
    try{
        totalCartPrice.textContent = totalPrice;
    }catch(e){

    }
    
}
changeCartTotalPrice();
const checkNumberOfCartITems = () =>{
    http.onload = () =>{
        try{
            if(http.response == 0){
                checkoutBtn.disabled = true;
            }else{
                checkoutBtn.disabled = false;
            }
        }catch(e){

        }
        
    }
    http.open('GET' ,'cart-items.php?check-items=""' );
    http.send();
}
checkNumberOfCartITems();
try{
    checkoutBtn.addEventListener('click', () =>{
        window.location.href = 'checkout.php'
    })
}catch(e){
    
}
