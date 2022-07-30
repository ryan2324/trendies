<?php 
    session_start(); 
    include 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://kit.fontawesome.com/a4e4f824b7.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./styles/index.css">
</head>
<body>
    <span id="disclaimer-top">THIS WEBSITE IS A DUMMY PROJECT ONLY AND IT WILL NOT SELL ANY PRODUCT POSTED</span>
    <nav>
        <ul class="parent-ul">
            <li class="home-nav">
                <a href="index.php">
                    <p>TRENDIES</p>
                    <p>SHOP</p>
                </a>
            </li>
            <li class="pages-nav">
                <a id="home" href="index.php">HOME</a>
                <a href="">ABOUT US</a>
                <!-- <a href="">PRODUCTS</a> -->
                <a href="#contact">CONTACT</a>
            </li>
            <li class="user-nav">
                <?php 
                    if(!empty($_SESSION['tdsid'])){
                        echo "
                        <button class='profile-menu-btn'><i class='fa-solid fa-caret-down'></i></button>
                        <p class='cart-btn'>
                            <i class='fa-solid fa-cart-shopping'></i>
                        </p>
                        <div class='profile-menu'>
                            <ul>
                                <li><i class='fa-solid fa-user'></i>Profile</li>
                                <li><i class='fa-solid fa-rectangle-list'></i>Orders</li>
                                <li id='logout'><i class='fa-solid fa-right-from-bracket'></i>Logout</li>
                            </ul>
                        </div>
                        ";
                    }else{
                        echo "
                            <a href='login.php'>Log In</a>
                            <a class='signup-link' href='signup.php'>Sign Up</a>
                        ";
                    }
                ?>
                
            </li>
        </ul>
    </nav>