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
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- box icon cdn link  -->
   <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
   <link rel="stylesheet" href="./css/user_style.css">
	<title>blue sky summer - contact us page</title>
</head>
<body>
	<?php include './components/user_header.php'; ?>

	<div class="services">
		<div class="heading">
            <h1>our services</h1>
            <p style="text-align: center;">Just A Few Click To Make The Reservation Online For Saving Your Time And Money</p>
            <img src="image/separator-img.png" alt="">
        </div>
		<div class="box-container">
			<div class="box">
				<img src="image/0.png">
				<div>
					<h1>Free shipping fast</h1>
					Lorem ipsum dolor sit amet consectetur adipisicing elit.
				</div>
			</div>
			<div class="box">
				<img src="image/1.png">
				<div>
					<h1>money back & guarantee</h1>
					Lorem ipsum dolor sit amet consectetur adipisicing elit.
				</div>
			</div>
			<div class="box">
				<img src="image/2.png">
				<div>
					<h1>online support 24/7</h1>
					Lorem ipsum dolor sit amet consectetur adipisicing elit.
				</div>
			</div>
		</div>
	</div>
	<div class="contact">
		<div class="heading">
            <h1>Drop Us A Line</h1>
            <p style="text-align: center;">Just A Few Click To Make The Reservation Online For Saving Your Time And Money</p>
            <img src="image/separator-img.png" alt="">
        </div>
		<div class="form-container">
			<form action="" method="post" class="register">
				
				<div class="input-field">
					<label>name <sup>*</sup></label>
					<input type="text" name="name" required placeholder="Enter Your Name">
				</div>
				<div class="input-field">
					<label>email <sup>*</sup></label>
					<input type="email" name="email" required placeholder="Enter Your Email">
				</div>
				<div class="input-field">
					<label>subject <sup>*</sup></label>
					<input type="text" name="subject" required placeholder="reason">
				</div><div class="input-field">
					<label>comment <sup>*</sup></label>
					<textarea name="message" cols="30" rows="10" required placeholder="add any comment you think necessary"></textarea>
				</div>
				<input type="submit" name="send_message" value="send message" class="btn">
			</form>
		</div>
	</div>
	<div class="address">
		<div class="heading">
            <h1>our contact details</h1>
            <p style="text-align: center;">Just A Few Click To Make The Reservation Online For Saving Your Time And Money</p>
            <img src="image/separator-img.png" alt="">
        </div>
		<div class="box-container">
			<div class="box">
				<i class="bx bxs-map-alt"></i>
				<div>
					<h4>address</h4>
					<p>1093 Marigold Lane, Coral Way <br>Miami, Florida, 33169</p>
				</div>
			</div>
			<div class="box">
				<i class="bx bxs-phone-incoming"></i>
				<div>
					<h4>phone number</h4>
					<p>3316955333</p>
					<p>3316955333</p>
				</div>
			</div>
			<div class="box">
				<i class="bx bxs-envelope"></i>
				<div>
					<h4>email</h4>
					<p>selenaAnsari@gmail.com</p>
					<p>selenaansari47@gmail.com</p>
				</div>
			</div>
		</div>
	</div>
	<?php include './components/footer.php'; ?>
	<!-- sweetalert cdn link  -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

	<!-- custom js link  -->
	<script type="text/javascript" src="./js/script.js"></script>

	<?php include './components/alert.php'; ?>
</body>
</html>