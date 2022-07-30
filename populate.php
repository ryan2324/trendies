<script src="script.js"></script>
<?php 
    $conn = mysqli_connect('127.0.0.1:3306', 'root', 'ryanjay2399', 'trendies');
    $imgOrder = 1;  
if(isset($_POST['data'])){
    $data = json_decode($_POST['data'], true);
    foreach ($data as $key => $value) {
        $title = mysqli_real_escape_string($conn, $value['title']);
        $price = mysqli_real_escape_string($conn, $value['price']);
        $description = mysqli_real_escape_string($conn, $value['description']);
        $query = "INSERT INTO product(title, price, image_path, description) VALUES('$title', '$price', './product_img/$imgOrder.jpg', '$description')";
        $res = mysqli_query($conn, $query);
        $imgOrder ++;
    }
}?>
