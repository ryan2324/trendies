<?php 
    session_start();
    include 'config.php';
    if(isset($_GET['check-items'])){
        if(!empty($_SESSION['tdsid'])){
            try{
                $user = explode('-',$_SESSION['tdsid'])[0];
                $queryCartItem = "SELECT cart_item_id FROM cart_item WHERE user_id = $user";
                $fetchRes = mysqli_query($conn, $queryCartItem);
                $cart_item = mysqli_fetch_all($fetchRes, MYSQLI_ASSOC);
                $numOfItem = count($cart_item);
                echo $numOfItem;
            }catch(Exception $e){

            }
        }else{
            echo 0;
        }
        
    }

    $currentDate = date('Y-m-d h:i:s', time());
    if(isset($_POST['add-to-cart'])){
        try{
            if(!empty($_SESSION['tdsid'])){
                $user = explode('-',$_SESSION['tdsid']);
                $cartQuery = "SELECT cart_item_id FROM cart_item WHERE product_id = {$_POST['add-to-cart']} && user_id = $user[0]";
                $cartRes = mysqli_query($conn, $cartQuery);
                $cartItem = mysqli_fetch_all($cartRes, MYSQLI_ASSOC);
                if(count($cartItem) < 1){
                    $productQuery = "SELECT * FROM product WHERE product_id = {$_POST['add-to-cart']}";
                    $productRes = mysqli_query($conn, $productQuery);
                    $product = mysqli_fetch_all($productRes, MYSQLI_ASSOC);
                    $addToCartQuery = "INSERT INTO cart_item(user_id, product_id, quantity, total_price, created_at, price) VALUES($user[0], {$_POST['add-to-cart']}, 1, {$product[0]['price']}, '$currentDate', {$product[0]['price']})";
                    $addToCartRes = mysqli_query($conn, $addToCartQuery);
                    $existItemQuery = "SELECT cart_item_id FROM cart_item WHERE product_id = {$_POST['add-to-cart']} && user_id = $user[0]";
                    $existItemRes = mysqli_query($conn, $existItemQuery);
                    $existItem = mysqli_fetch_all($existItemRes, MYSQLI_ASSOC);
                    array_push($product[0], "cart_item_id");
                    array_push($product[0], "type");
                    $product[0]['type'] = 'new';
                    $product[0]['cart_item_id'] = $existItem[0]['cart_item_id'];
                    echo json_encode($product[0]);
                }else{
                    $item = ["id" => $cartItem[0]['cart_item_id'], "type" =>"exist"];
                    echo json_encode($item);
                }
                
            }else{
                echo 'unauthorized';
            }
            
        }catch(Exception $e){
            echo $e->getMessage();
        }
        
    }

    if(isset($_POST['qty']) && isset($_POST['cart-item-id'])){
        try{
            $user = explode('-',$_SESSION['tdsid'])[0];
            $query = "UPDATE cart_item SET quantity = $_POST[qty], total_price = $_POST[qty] * cart_item.price  WHERE user_id = $user && cart_item_id = {$_POST['cart-item-id']}";
            $res = mysqli_query($conn, $query);

            $queryCartItem = "SELECT price FROM cart_item WHERE user_id = $user && cart_item_id = {$_POST['cart-item-id']}";
            $fetchRes = mysqli_query($conn, $queryCartItem);
            $cart_item = mysqli_fetch_all($fetchRes, MYSQLI_ASSOC);
            echo $cart_item[0]['price'];
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }
    
    
    if(isset($_POST['del'])){
        $cartItemId = $_POST['del'];
        if(!empty($_SESSION['tdsid'])){
            try{
                $user = explode('-',$_SESSION['tdsid'])[0];
                $query = "DELETE FROM cart_item WHERE user_id = $user && cart_item_id = $cartItemId";
                $res = mysqli_query($conn, $query);
                echo $cartItemId;
            }catch(Exception $e){
                echo $e->getMessage();
            }
        }
        
    }