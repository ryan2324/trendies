<?php
    $user = explode('-', $_SESSION['tdsid']);
    try{
        $query = "SELECT * FROM cart_item JOIN product ON cart_item.product_id = product.product_id WHERE cart_item.user_id = {$user[0]}";
        $res = mysqli_query($conn, $query);
        $cartItems = mysqli_fetch_all($res, MYSQLI_ASSOC);
    }catch(Exception $e){
        echo $e->getMessage();
    }
?>
    <div class="backdrop">
        <div class="cart">
            <button class="close-cart">&#10006</button>
            <p class="container-title">My Shopping Cart</p>
            <div class="cart-items">
                <div class="names">
                    <p>Description</p>
                    <p>Quantity</p>
                    <p>Price</p>
                </div>
                <span></span>
                <div class="product-list">
                    <?php 
                        array_map(function($item){
                    ?>
                        <div  class="cart-item-id-<?php echo $item['cart_item_id'] ?> product">
                            <div class="product-img-container">
                                <img src="<?php echo $item['image_path'] ?>" alt="">
                            </div>
                            <p class="title"><?php echo $item['title'] ?></p>
                            <div data-cart-item-id="<?php echo $item['cart_item_id'] ?>"  class="quantity-container">
                                <button class="decrement">-</button>
                                <p class="quantity"><?php echo $item['quantity'] ?></p>
                                <button class="increment">+</button>
                            </div>
                            <p class="price">$<?php echo $item['total_price'] ?></p>
                            <button data-cart-item-id="<?php echo $item['cart_item_id'] ?>" class="delete">&#10006</button>
                        </div>
                    <?php
                        },$cartItems)
                    ?>
                    
                    
                </div>
        </div>
        <div class="cart-footer">
            <div>
                <form action="">
                    <input type="text" name="" id="" placeholder="Enter a promo code">
                    <button>Apply Promo Code</button>
                </form>
                <div class="total-container">
                    Total<p>$100.23</p>
                </div>
            </div>
            <button id="checkout-btn">CHECKOUT</button>
        </div>
        
        </div>
    </div>