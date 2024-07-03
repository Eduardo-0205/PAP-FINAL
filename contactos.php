<?php 
	include './components/connect.php';
	if(isset($_COOKIE['user_id'])){
      $user_id = $_COOKIE['user_id'];
   }else{
      $user_id = '';
      
   }

	//send message

	if (isset($_POST['send_message'])) {
		if ($user_id != '') {
			$id = unique_id();
			$name = $_POST['name'];
			$name = filter_var($name, FILTER_SANITIZE_STRING);

			$email = $_POST['email'];
			$email = filter_var($email, FILTER_SANITIZE_STRING);

			$subject = $_POST['subject'];
			$subject = filter_var($subject, FILTER_SANITIZE_STRING);

			$message = $_POST['message'];
			$message = filter_var($message, FILTER_SANITIZE_STRING);

			$verify_message = $conn->prepare("SELECT * FROM `message` WHERE user_id=? AND name = ? AND email = ? AND subject = ? AND message = ?");
			$verify_message->execute([$user_id, $name, $email, $subject, $message]);

			if ($verify_message->rowCount() > 0) {
				$warning_msg[] = 'Esta menssagem já foi enviada';
			}else{
				$insert_message = $conn->prepare("INSERT INTO `message`(id,user_id,name,email,subject,message) VALUES(?,?,?,?,?,?)");
				$insert_message->execute([$id, $user_id, $name, $email, $subject, $message]);
				$success_msg[] = 'Comentario enviado com sucesso';

			}


		}else{
			$warning_msg[] = 'Faça login Primeiro';
		}
	}
	

	

?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="with=device-widht, initial-scale=1.0">
    <title>Eduardo Creative CO</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,600,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style2.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body> 
    <section class="sub-header">
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
        <h1>Contact Us</h1>
</section>
<!---contactos -->
<section class="location">
    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d5967.1146286049525!2d-8.406168800000009!3d41.600458700000026!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1spt-PT!2spt!4v1703114507006!5m2!1spt-PT!2spt" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

</section>
<section class="contact-us">
    <div class="row">
        <div class="contact-col">
            <div>
                <i class="fa fa-home"></i>
                <span>
                    <h5>Rua da Presa 12-14</h5>
                    <p>Adaúfe, Braga</p>
                </span>
            </div>
            <div>
                <i class="fa fa-phone"></i>
                <span>
                    <h5>+351 913294188</h5>
                    <p>Segundas a Sextas, 10:00 às 18:00 </p>
                </span>
            </div>
            <div>
                <i class="fa fa-envelope-o"></i>
                <span>
                    <h5>supporteducorp@gmail.com</h5>
                    <p>Email de suporte</p>
                </span>
            </div>
        </div>
        <div class="contact-col">
        <form action="" method="post" >
				
				<div class="input-field">
					
					<input type="text" name="name" required placeholder="O seu nome">
				</div>
				<div class="input-field">
					<input type="email" name="email" required placeholder="O seu email">
				</div>
				<div class="input-field">
					<input type="text" name="subject" required placeholder="Tema">
				</div><div class="input-field">
					<textarea name="message" cols="30" rows="10" required placeholder="Comentário"></textarea>
				</div>
				<input type="submit" name="send_message" value="Enviar Menssagem" class="hero-btn blue-btn">
			</form>



        </div>
    </div>

</section>
<!---Footer-->
<section class="footer">
    <h4>About us</h4>
    <p>uma pequena empresa mas,<br>com grandes ideias </p>
    <div class="icons">
    <i class="fa fa-facebook"></i>
    <i class="fa fa-twitter"></i>
    <i class="fa fa-instagram"></i>
    <i class="fa fa-linkedin"></i>
</div>

</section>


	<!-- sweetalert cdn link  -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

	<!-- custom js link  -->
	<script type="text/javascript" src="./js/script.js"></script>

	<?php include './components/alert.php'; ?>

</body>    
</html>
