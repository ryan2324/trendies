<?php
    session_start();
    include 'config.php';
    $currentDate = date('Y-m-d h:i:s', time());
    
    if(isset($_POST['add-to-cart'])){
        try{
            if(!empty($_SESSION['tdsid'])){
                $user = explode('-',$_SESSION['tdsid']);
                $productQuery = "SELECT * FROM product WHERE product_id = {$_POST['add-to-cart']}";
                $productRes = mysqli_query($conn, $productQuery);
                $product = mysqli_fetch_all($productRes, MYSQLI_ASSOC);
                $addToCartQuery = "INSERT INTO cart_item(user_id, product_id, quantity, total_price, created_at, price) VALUES($user[0], {$_POST['add-to-cart']}, 1, {$product[0]['price']}, '$currentDate', {$product[0]['price']})";
                $addToCartRes = mysqli_query($conn, $addToCartQuery);
                $cartQuery = "SELECT cart_item_id FROM cart_item WHERE product_id = {$_POST['add-to-cart']}";
                $cartRes = mysqli_query($conn, $cartQuery);
                $cartItem = mysqli_fetch_all($cartRes, MYSQLI_ASSOC);
                array_push($product[0], "cart_item_id");
                $product[0]['cart_item_id'] = $cartItem[0]['cart_item_id'];
                echo json_encode($product[0]);
            }else{
                echo 'unauthorized';
            }
            
        }catch(Exception $e){
            echo $e->getMessage();
        }
        
    }