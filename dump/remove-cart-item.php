<?php
    session_start();
    include 'config.php';
    $user = explode('-',$_SESSION['tdsid'])[0];
    if(isset($_POST['del'])){
        $cartItemId = $_POST['del'];
        try{
            $query = "DELETE FROM cart_item WHERE user_id = $user && cart_item_id = $cartItemId";
            $res = mysqli_query($conn, $query);
            echo $cartItemId;
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }