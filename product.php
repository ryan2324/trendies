<?php include 'header.php' ?>
<?php include 'config.php' ?>
<?php
    if(!empty($_SESSION['tdsid'])){
        include 'cart.php';
    } 
    ?>
<?php
    try{
        $productId = mysqli_real_escape_string($conn, htmlspecialchars($_GET['productid']));
        $query = "SELECT * FROM product WHERE product_id = $productId LIMIT 1   ";
        $res = mysqli_query($conn, $query);
        $product = mysqli_fetch_all($res, MYSQLI_ASSOC);
    }catch(Exception $e){

    }
?>
    <main class="product-main">
        <div class="product-container">
            <div class="images-container">
                <div class="images-menu-container">
                    <!-- 3 small images goes here -->
                <div class="small-images">
                    <img src="<?php echo $product[0]['image_path'] ?>" alt="">
                </div>
                <div class="small-images">
                    <img src="<?php echo $product[0]['image_path'] ?>" alt="">
                </div>
                <div class="small-images">
                    <img src="<?php echo $product[0]['image_path'] ?>" alt="">
                </div>
                </div>
                <div class="main-image-container">
                    <img src="<?php echo $product[0]['image_path'] ?>" alt="">
                </div>
            </div>
            <div class="product-detail-container">
                <!-- title, price, delivery info, add to cart btn -->
                <p><?php echo $product[0]['title'] ?></p>
                <span></span>
                <p>$<?php echo $product[0]['price'] ?></p>
                <span></span>
                <p class="delivery-info"><i class="fa-solid fa-truck-fast"></i>Delivery within 5-7 days</p>
                <span></span>
                <button id="add-to-cart-btn">ADD TO CART</button>
            </div>
        </div>
        <div class="product-description-container">
            <p class="title">Product Description</p>
            <div class="description">
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
            </div>
        </div>
    </main>
    <?php include 'footer.php' ?>