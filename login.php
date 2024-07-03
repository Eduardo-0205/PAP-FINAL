<?php
include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}elseif(isset($_COOKIE['seller_id'])){
   $seller_id = $_COOKIE['seller_id'];
}else{
   $user_id = '';
   $seller_id = '';
}

if(isset($_POST['submit'])){
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);

   // Check if the user exists in the users table
   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? LIMIT 1");
   $select_user->execute([$email]);
   $row_user = $select_user->fetch(PDO::FETCH_ASSOC);

   // Check if the seller exists in the sellers table
   $select_seller = $conn->prepare("SELECT * FROM `sellers` WHERE email = ? LIMIT 1");
   $select_seller->execute([$email]);
   $row_seller = $select_seller->fetch(PDO::FETCH_ASSOC);

   if($select_user->rowCount() > 0){
      if($row_user['password'] == $pass){
         setcookie('user_id', $row_user['id'], time() + 60*60*24*30, '/');
         header('location:index.php');
      }else{
         $message[] = 'incorrect password!';
      }
   }elseif($select_seller->rowCount() > 0){
      if($row_seller['password'] == $pass){
         setcookie('seller_id', $row_seller['id'], time() + 60*60*24*30, '/');
         header('location:admin pannel/profile.php'); // Redirect to dashboard.php for sellers
      }else{
         $message[] = 'incorrect password!';
      }
   }else{
      $message[] = 'email not found!';
   }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form in HTML and CSS | Codehal</title>
    <link rel="stylesheet" href="style5.css">
    <link rel="stylesheet" href="style2.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,600,700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
<section class="header">
    <nav>
    <a href="index.php"><img src="image/celebre3.png" alt="Logo"></a>
    <div class="nav-links" id="navLinks">
    <i class="fa fa-times" onclick="hideMenu()"></i>
        <ul>
            <li><a href="index.php">HOME</a></li>
            <li><a href="about.php">ABOUT</a></li>
            <li><a href="projecto.php">MY EVENT</a></li>
            <li><a href="contactos.php">CONTACT</a></li>
            <?php if(isset($user_id) && !empty($user_id)): ?>
                <li><a href="profile.php">ACCOUNT</a></li>
                <li><a href="components/user_logout.php" onclick="return confirm('Logout from this website?');" class="btn">LOGOUT</a></li>
            <?php else: ?>
                <li><a href="login.php">LOGIN</a></li>
            <?php endif; ?>
            <?php
                $stmt = $conn->prepare("SELECT COUNT(*) as total_cart_items FROM cart WHERE user_id = :user_id");
                $stmt->bindParam(":user_id", $user_id);
                $stmt->execute();
                $total_cart_items = $stmt->fetchColumn();
            ?>
            <li>
                <a href="cart.php" class="cart-btn">
                    <i class="fa fa-shopping-cart"></i>
                    <sup><?= $total_cart_items; ?></sup>
                </a>
            </li>
        </ul>
    </div>
    <i class="fa fa-bars" onclick="showMenu()"></i>
</nav>
<?php if(isset($message)){?>
      <div class="error">
         <?php foreach($message as $error){ echo $error; }?>
      </div>
   <?php }?>
   <form action="" method="post" enctype="multipart/form-data" class="login">
    <div class="wrapper">
        <form action="">
            <h1>Login</h1>
            <div class="input-box">
            <input type="email" name="email" placeholder="O seu email" maxlength="50" required class="box">
                <i class='bx bxs-user'></i>
            </div>
            <div class="input-box">
            <input type="password" name="pass" placeholder="A sua password" maxlength="20" required class="box">
                <i class='bx bxs-lock-alt'></i>
            </div>

            <div class="remember-forgot">
            <label><input type="checkbox" name="remember"> Lembrar-me</label>
                <a href="#">Esqueceu a Password?</a>
            </div>

            <input type="submit" name="submit" value="Login" class="btn">

            <div class="register-link">
            <p class="link">Ainda não tens conta? <a href="register.php">registar Agora</a></p>
            </div>
        </form>
    </div>

</body>
</section>
</html>