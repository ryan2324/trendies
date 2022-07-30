<?php include 'header.php' ?>
<?php include 'config.php' ?>
<?php
    $user = explode('-', $_SESSION['tdsid'])[0];
    if(empty($_SESSION['tdsid'])){
        header('location: login.php');
        exit;
    }
    try{
        $userQuery = "SELECT first_name, last_name, telephone_number FROM user WHERE user_id = $user";
        $userRes = mysqli_query($conn, $userQuery);
        $userInfo = mysqli_fetch_all($userRes, MYSQLI_ASSOC);
        $cartQuery = "SELECT * FROM cart_item JOIN product ON cart_item.product_id = product.product_id WHERE user_id = $user";
        $cartRes = mysqli_query($conn, $cartQuery);
        $cart_items = mysqli_fetch_all($cartRes, MYSQLI_ASSOC);
        if(count($cart_items) === 0){
            header('location: index.php');
            exit;
        }
    }catch(Exception $e){
    
    }
    $firstName = $userInfo[0]['first_name'];
    $lastName = $userInfo[0]['last_name'];
    $address = "";
    $telephoneNumber = $userInfo[0]['telephone_number'];
    $errorInput = ["name" => "", "telephoneNumber" => "", "address" => ""];
    if(isset($_POST['checkout'])){
        $firstName = htmlspecialchars($_POST['first_name']);
        $lastName = htmlspecialchars($_POST['last_name']);
        $address = htmlspecialchars($_POST['address']);
        $telephoneNumber = htmlspecialchars($_POST['telephone_number']);
        $paymentOption = htmlspecialchars($_POST['billing']);
        if(empty($firstName)){
            $errorInput['name'] = "name field cannot be empty";
        }
        if(empty($lastName)){
            $errorInput['name'] = "name field cannot be empty";
        }
        if(empty($telephoneNumber)){
            $errorInput['telephoneNumber'] = "contact number field cannot be empty";
        }
        if(empty($address)){
            $errorInput['address'] = "address field cannot be empty";
        }
        if(strlen($errorInput['name']) === 0 && strlen($errorInput['telephoneNumber']) === 0 && strlen($errorInput['address']) === 0 ){
            $currentDate = date('Y-m-d H:i:s', time());
            try{
                foreach($cart_items as $key => $val){
                    $orderQuery = "INSERT INTO order_item(product_id, delivery_address, user_id, quantity, total_price, created_at, payment_option) VALUES($val[product_id], '$address', $user, $val[quantity], $val[total_price], '$currentDate', '$paymentOption')";
                    $orderRes = mysqli_query($conn, $orderQuery);
                    
                }
                $moveCartItem = "DELETE FROM cart_item WHERE user_id = $user";
                $moveRes = mysqli_query($conn, $moveCartItem);
                if($moveRes){
                    header('location: index.php');
                    exit;
                }
            }catch(Exception $e){
                echo $e->getMessage();
            }
        }
    }
        // $query = "SELECT * FROM cart_item JOIN product ON cart_item.product_id = product.product_id WHERE user_id = $user";
        // $res = mysqli_query($conn, $query);
        // $cart_items = mysqli_fetch_all($res, MYSQLI_ASSOC);
        // print_r($cart_items);
?>  
    <main class="checkout-main">
        <form action="<?php $_SERVER['PHP_SELF']?>" method="POST">
            <div class="form-names">
                <input type="text" name="first_name" id="" placeholder="first name" value="<?php echo $firstName; ?>">
                <input type="text" name="last_name" id="" placeholder="last name" value="<?php echo $lastName; ?>">
            </div>
            <p class="error-input"><?php echo $errorInput['name'] ?></p>
            <input type="text" name="address" id="" placeholder="Delivery address">
            <p class="error-input"><?php echo $errorInput['address'] ?></p>
            <input type="text" name="telephone_number" id="" placeholder="Contact Number" value="<?php echo $telephoneNumber; ?>">
            <p class="error-input"><?php echo $errorInput['telephoneNumber'] ?></p>
            <p class="payment-opt-title">Payment Option</p>
            <div class="payment-option-container">
              <label for="paypal">
                <i class="fa-brands fa-cc-paypal"></i>
                <input type="radio" name="billing" id="paypal" checked value="paypal">
                <span></span>
            </label>
            <label for="cod">
                Cash On Delivery
                <input type="radio" name="billing" id="cod" value="cod">
                <span></span>
            </label>  
            </div>
            
            <input id="order-btn" type="submit" value="ORDER NOW" name="checkout">
        </form>
        <div class="orders">
            <p class="container-title">ORDERS</p>
            <div class="names">
                <p>Description</p>
                <p>Quantity</p>
                <p>Price</p>
            </div>
            <div class="order-items">
                <?php 
                    array_map(function($item){                    
                ?>
                <div class="product">
                    <div class="product-img-container">
                        <img src="<?php echo $item['image_path'] ?>" alt="">
                    </div>
                    <p class="title"><?php echo $item['title'] ?></p>
                    <p><?php echo $item['quantity'] ?></p>
                    <p>$<?php echo $item['total_price'] ?></p>
                </div>    
                <?php 
                    }, $cart_items)
                ?>
                
            </div>
            <div class="order-footer">
                <div>
                    <p>Shipping Fee</p>
                    <p>$5</p>
                    <p>Discount</p>
                    <p>0%</p>
                    <p>Total</p>
                    <p>$
                        <?php
                            $total = 5;
                            foreach($cart_items as $key => $val){
                                $total += $val['total_price'];
                            }
                            echo $total;
                        ?>
                    </p>
                </div>
                
            </div>
        </div>
    </main>
<?php include 'footer.php' ?>