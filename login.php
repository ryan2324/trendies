<?php
    session_start();
    include 'config.php';
    $errorInput = ["email" =>"", "password" =>""];
    $email = $password = "";
    if(isset($_POST['submit'])){
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);
        if(empty($email)){
            $errorInput['email'] = 'email field cannot be empty';
        }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errorInput['email'] = 'please enter a valid email address';
        };
        if(empty($password)){
            $errorInput['password'] = 'password field cannot be empty';
        }

        if(strlen($errorInput['email']) === 0 && strlen($errorInput['password']) === 0){
            try{
                $query = "SELECT * FROM user WHERE email = '$email'";
                $res = mysqli_query($conn, $query);
                if($res){
                    $user = mysqli_fetch_all($res, MYSQLI_ASSOC);
                    if(count($user) > 0){
                        if(password_verify($password, $user[0]['password'])){
                            $_SESSION['tdsid'] = uniqid($user[0]['user_id'].'-', false);
                            header('location: index.php');
                            exit;
                        }else{
                            $errorInput["password"] = 'authentication failed';
                        }
                    }else{
                        $errorInput["password"] = 'authentication failed';
                    }
                    
                }
            }catch(Exception $e){

            }
        }
    }
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
<main class="login-main">
    <div class="brand-section">
        <div class="logo">
            <p>Trendies</p>
            <p>Shop</p>
        </div>
        <p class="desc">Enjoy deals and shipping discounts</p>
    </div>
    <div class="form-container">
        <form action="login.php" method="POST">
        <p class="title">Login</p>
        <label for="">Email</label>
        <input type="text" placeholder="Enter Your Email" name="email" value="<?php echo $email;?>">
        <p class="error-input"><?php echo $errorInput['email'];?></p>
        <label for="">Password</label>
        <input type="password" placeholder="Enter Your Password" name="password" value="<?php echo $password;?>">
        <p class="error-input"><?php echo $errorInput['password'];?></p>
        <a href="">forgot password?</a>
        <input type="submit" value="Login" name="submit">
        <a class="signup-link" href="signup.php">Need an account? Sign up.</a>
    </form>
    </div>
    
</main>
<?php
include 'footer.php';
?>