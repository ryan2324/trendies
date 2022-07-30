<?php include 'header.php' ?>
    <?php
    if(!empty($_SESSION['tdsid'])){
        include 'cart.php';
    } 
    ?>
    <?php
        try{
            $query = "SELECT * FROM product";
            $res = mysqli_query($conn, $query);
            $products = mysqli_fetch_all($res, MYSQLI_ASSOC);
        }catch(Exception $e){

        }
        
    ?>
    <main>
        <div class="hero-img-container">
            <img class="hero-img" src="./assets/banner-trendies.jpg" alt="">
        </div>
        <div class="brands-container">
            <p>Top Brands</p>
            <div>
                <i class="fa-brands fa-apple"></i>
                <i class="fa-brands fa-xbox"></i>
                <i class="fa-brands fa-dhl"></i>
                <i class="fa-brands fa-windows"></i>
            </div>
        </div>
        <div class="products-list-container">
            <p class="container-title">Popular products</p>
            <div class="products-container">
            <?php
                array_map(function($product){
                    ?>
                    <div class="product">
                    <div class="product-img-container">
                        <img src="<?php echo $product['image_path'] ?>" alt="">
                    </div>
                    <div class="details">
                        <p class="title"><?php echo $product['title'] ?></p>
                        <p class="price">$<?php echo $product['price'] ?></p>
                    </div>
                    <div class="stocks-detail">
                        <p>44 stocks left</p>
                        <span class="outer-bar">
                            <span class="inner-bar"></span>
                        </span>
                    </div>
                    <a class="product-backdrop" href="product.php?productid=<?php echo $product['product_id']; ?>"></a>
                </div>
                <?php }, $products)
                ?>
            </div>
        </div>
    </main>
    <?php include 'footer.php' ?>