<?php
// Include your database connection file
include 'components/connect.php';

// Check if the user is logged in
if(isset($_COOKIE['user_id'])){
  $user_id = $_COOKIE['user_id'];
} else {
  header('location:login.php');
  exit;
}

// Retrieve the user's information from the database
$select_user = $conn->prepare("SELECT * FROM `users` WHERE id =?");
$select_user->execute([$user_id]);
$fetch_profile = $select_user->fetch(PDO::FETCH_ASSOC);

// Check if the user's profile picture exists
if(file_exists("uploaded_files/". $fetch_profile['image'])){
  $profile_pic = "uploaded_files/". $fetch_profile['image'];
} else {
  $profile_pic = "default_profile_pic.jpg"; // default profile picture
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile</title>
  <link rel="stylesheet" href="profile9.css"> <!-- link to your custom CSS file --> 
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
  <!-- Custom header -->
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

  <!-- Profile section -->
  <section class="profile">
  <div class="profile-pic">
    <img src="<?php echo $profile_pic;?>" alt="Profile Picture">
  </div>
  <div class="profile-info">
    <h2 class="username"><?php echo $fetch_profile['name'];?></h2>
    <p class="user-label">user</p>
  </div>
  <div class="profile-button-container">
  <button class="update-profile-button" onclick="redirectToUpdatePage()">Atualizar Perfil</button>
</div>
   <div class="box-container">
     <div class="box">
      <div class="flex">
        <i class="bx bxs-bookmarks"></i>
        <?php
          $stmt = $conn->prepare("SELECT COUNT(*) as total_orders FROM orders WHERE user_id = :user_id");
          $stmt->bindParam(":user_id", $user_id);
          $stmt->execute();
          $total_orders = $stmt->fetchColumn();
       ?>
        <h3><?= $total_orders;?></h3>
        <span>Sites Comprados</span>
      </div>
      <form action="order.php">
  <button class="btn ver-historico-btn" type="submit">Ver Historico</button>
</form>
    </div>
   </div>
<script>
  function redirectToUpdatePage() {
    window.location.href = "update.php";
  }
</script>
</section>

  <!-- Background image -->
  <div class="background-image">
    <img src="image/background-image.jpg" alt="Background Image">
  </div>

</body>
</section>
</html>