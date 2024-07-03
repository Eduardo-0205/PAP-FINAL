<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
   header('location:login.php');
}
$user_id = $_COOKIE['user_id'];
$stmt = $conn->prepare('SELECT * FROM users WHERE id = :user_id LIMIT 1');
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$fetch_user = $stmt->fetch(PDO::FETCH_ASSOC);
if(isset($_POST['submit'])){

   $select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ? LIMIT 1");
   $select_user->execute([$user_id]);
   $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);

   $prev_pass = $fetch_user['password'];
   $prev_image = $fetch_user['image'];

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);

   if(!empty($name)){
      $update_name = $conn->prepare("UPDATE `users` SET name = ? WHERE id = ?");
      $update_name->execute([$name, $user_id]);
      $message[] = 'username atualizado!';
   }

   if(!empty($email)){
      $select_email = $conn->prepare("SELECT email FROM `users` WHERE id = ? AND email = ?");
      $select_email->execute([$user_id, $email]);
      if($select_email->rowCount() > 0){
      }else{
         $update_email = $conn->prepare("UPDATE `users` SET email = ? WHERE id = ?");
         $update_email->execute([$email, $user_id]);
         $message[] = 'email atualizado!';
      }
   }

   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $ext = pathinfo($image, PATHINFO_EXTENSION);
   $rename = unique_id().'.'.$ext;
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_files/'.$rename;

   if(!empty($image)){
      if($image_size > 2000000){
         $message[] = 'a imagem é muito grande!';
      }else{
         $update_image = $conn->prepare("UPDATE `users` SET `image` = ? WHERE id = ?");
         $update_image->execute([$rename, $user_id]);
         move_uploaded_file($image_tmp_name, $image_folder);
         if($prev_image != '' AND $prev_image != $rename){
            unlink('uploaded_files/'.$prev_image);
         }
         $message[] = 'image atualizada!';
      }
   }

   $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
   $old_pass = sha1($_POST['old_pass']);
   $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
   $new_pass = sha1($_POST['new_pass']);
   $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
   $cpass = sha1($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   if($old_pass != $empty_pass){
      if($old_pass != $prev_pass){
         $message[] = 'a password atual não corresponde!';
      }elseif($new_pass != $cpass){
         $message[] = 'as passwords não correspondem!';
      }else{
         if($new_pass != $empty_pass){
            $update_pass = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ?");
            $update_pass->execute([$cpass, $user_id]);
            $message[] = 'password atualizada!';
         }else{
            $message[] = 'Digite a nova password!';
         }
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
   <title>home</title>

   <!-- box icon -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="teste.css">
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
<section class="form-container">
   <div class="heading">
      <h1>update profile</h1>
   </div>
   <form class="register" action="" method="post" enctype="multipart/form-data">
      
   <div class="flex">
    <div class="col">
        <p>O Seu Nome <span>*</span></p>
        <input type="text" name="name" value="<?php echo $fetch_user['name']; ?>" maxlength="50" class="box">
        <p>O Seu Email <span>*</span></p>
        <input type="email" name="email" value="<?php echo $fetch_user['email']; ?>" maxlength="20" class="box">
            <p>Alterar A Foto <span></span></p>
            <input type="file" name="image" accept="image/*" class="box">
         </div>
         <div class="col">
            <p>Password Atual <span>*</span></p>
            <input type="password" name="old_pass" placeholder="A sua password atual" maxlength="20" required class="box">
            <p>Nova Password <span>*</span></p>
            <input type="password" name="new_pass" placeholder="A nova password" maxlength="20" required class="box">
            <p>Confirmar A Password <span>*</span></p>
            <input type="password" name="cpass" placeholder="Confirme a password" maxlength="20" required class="box">
         </div>
      </div>
      <?php
            if (isset($message)) {
                foreach ($message as $msg) {
                    echo '<p style="color: red;">' . $msg . '</p>';
                }
            }
        ?>
        <input type="submit" name="submit" value="Atualizar o Perfil" class="btn update-profile-btn">
    </form>
</section>
<!-- custom js file link  -->
<script src="js/script.js"></script>
</body>
</section>
</html>

