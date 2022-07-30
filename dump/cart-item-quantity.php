<?php
    session_start();
    $user = explode('-',$_SESSION['tdsid'])[0];
    include 'config.php';
    if(isset($_POST['qty']) && isset($_POST['cart-item-id'])){
        try{
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
    
    