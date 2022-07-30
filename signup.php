<?php
    include 'config.php';
    $errorInput = ["name" =>'', "email" =>'', "address" =>'', "tel" =>'',"password" =>""];
    $firstName = $lastName = $address = $tel = $email = $password = $rePassword = "";
    if(isset($_POST['submit'])){
        $firstName = htmlspecialchars($_POST['first-name']);
        $lastName = htmlspecialchars($_POST['last-name']);
        $address = htmlspecialchars($_POST['address']);
        $tel = htmlspecialchars($_POST['tel']);
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);
        $rePassword = htmlspecialchars($_POST['repassword']);
        if(empty($firstName)){
            $errorInput['name'] = 'name fields cannot be empty';
        }elseif(strlen($firstName) < 3){
            $errorInput['name'] = 'first and last name must be 3 characters long';
        }
        if(empty($lastName)){
            $errorInput['name'] = 'name fields cannot be empty';
        }elseif(strlen($lastName) < 3){
            $errorInput['name'] = 'first and last name must be 3 characters long';
        }

        if(empty($address)){
            $errorInput['address'] = 'address field cannot be empty';
        }
        if(empty($tel)){
            $errorInput['tel'] = 'phone number cannot be empty';
        }elseif(strlen($tel) < 11){
            $errorInput['tel'] = 'please enter valid telephone number';
        }

        if(empty($email)){
            $errorInput['email'] = 'email field cannot be empty';
        }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errorInput['email'] = 'please enter a valid email address';
        }
        if(empty($password)){
            $errorInput['password'] = 'password field cannot be empty';
        }elseif(strlen($password) < 8){
            $errorInput['password'] = 'password must be 8 characters long';
        }
        if($rePassword != $password){
            $errorInput['password'] = 'password does not match';
        }
        if(strlen($errorInput["name"]) === 0 && strlen($errorInput["email"]) === 0 && strlen($errorInput["address"]) === 0 && strlen($errorInput["password"]) === 0){
            $_firstName = mysqli_real_escape_string($conn, $firstName);
            $_lastName = mysqli_real_escape_string($conn, $lastName);
            $_address = mysqli_real_escape_string($conn, $address);
            $_tel = mysqli_real_escape_string($conn, $tel);
            $_email = mysqli_real_escape_string($conn, $email);
            $_password = mysqli_real_escape_string($conn, password_hash($password, PASSWORD_DEFAULT));
            try{
                $query = "INSERT INTO user(email, first_name, last_name, password, telephone_number) VALUES('$_email', '$_firstName', '$_lastName', '$_password', '$_tel')";
                $res = mysqli_query($conn, $query);
                if($res){
                    header('location: login.php');
                    exit;
                }
            }catch(Exception $e){
                echo $e;
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
<main class="signup-main">
    <div class="brand-section">
        <div class="logo">
            <p>Trendies</p>
            <p>Shop</p>
        </div>
        <p class="desc">Enjoy deals and shipping discounts</p>
    </div>
    <div class="form-container">
        <form action="signup.php" method="POST">
        <p class="title">Sign Up</p>
        <label for="">Full Name</label>
        <div class="name">
            <input type="text" placeholder="First Name" name="first-name" value="<?php echo $firstName; ?>">
            <input type="text" placeholder="Last Name" name="last-name" value="<?php echo $lastName; ?>">
        </div>
        <p class="error-input"><?php echo $errorInput['name'] ?></p>
        <label for="">Address</label>
        <input type="text" placeholder="Enter Your Address" name="address" value="<?php echo $address; ?>">
        <p class="error-input"><?php echo $errorInput['address'] ?></p>
        <label for="">Telephone Number</label>
        <input type="text" placeholder="Enter Your Telephone Number" name="tel" value="<?php echo $tel; ?>">
        <p class="error-input"><?php echo $errorInput['tel'] ?></p>
        <label for="">Email</label>
        <input type="text" placeholder="Enter Your Email" name="email" value="<?php echo $email; ?>">
        <p class="error-input"><?php echo $errorInput['email'] ?></p>
        <label for="">Password</label>
        <input type="password" placeholder="Enter Your Password" name="password" value="<?php echo $password; ?>">
        <p class="error-input"><?php echo $errorInput['password'] ?></p>
        <label for="">Re-enter Password</label>
        <input type="password" placeholder="Re-enter Your Password" name="repassword" value="<?php echo $rePassword; ?>">
        <a href="login.php">already have an account?</a>
        <input type="submit" value="Signup" name="submit">
    </form>
    </div>
    
</main>
<?php
include 'footer.php';
?>