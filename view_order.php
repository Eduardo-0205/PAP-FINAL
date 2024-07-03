<?php 
	include './components/connect.php';
	if(isset($_COOKIE['user_id'])){
      $user_id = $_COOKIE['user_id'];
   }else{
      $user_id = '';
      header('location:login.php');
   }

	if (isset($_GET['get_id'])) {
		$get_id = $_GET['get_id'];
	}else{
		$get_id = '';
		header("location:order.php");
	}

	if (isset($_POST['cancle'])) {
		$update_order = $conn->prepare("UPDATE `orders` SET status=? WHERE id=?");
		$update_order->execute(['canceled', $get_id]);
		header('location:order.php');
	}
	
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- box icon cdn link  -->
   <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
	<link rel="stylesheet" href="./css/teste68.css">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,600,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style2.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<title>blue sky summer - contact us page</title>
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
	
	
	<div class="order-detail">
		<div class="heading">
			<h1>Detalhes do meu pedido</h1> 
		</div>
		<div class="box-container">
			<?php 
				$grand_total = 0;
				$select_order = $conn->prepare("SELECT * FROM `orders` WHERE id=? LIMIT 1");
				$select_order->execute([$get_id]);
				if ($select_order->rowCount() > 0) {
					while($fetch_order = $select_order->fetch(PDO::FETCH_ASSOC)){
						$select_product = $conn->prepare("SELECT * FROM `products` WHERE id=? LIMIT 1");
						$select_product->execute([$fetch_order['product_id']]);
						if ($select_product->rowCount() > 0) {
							while($fetch_product = $select_product->fetch(PDO::FETCH_ASSOC)){
								$sub_total = ($fetch_order['price']*$fetch_order['qty']);
								$grand_total+= $sub_total;
							
			?>
			<div class="box">
				<div class="col">
					<p class="title"><i class='bx bxs-calendar-alt'></i><?= $fetch_order['date']; ?></p>
					<img src="uploaded_files/<?= $fetch_product['image']; ?>" class="image">
					<h3 class="name"><?= $fetch_product['name']; ?></h3>
					<p class="grand-total">Montante: <span><?= $grand_total; ?>€</span></p>
				</div>
				<div class="col">
					<p class="title">Dados de Faturação:</p>
					<p class="user"><i class="bi bi-person-bounding-box"></i><?= $fetch_order['name']; ?></p>
					<p class="user"><i class="bi bi-phone"></i><?= $fetch_order['number']; ?></p>
					<p class="user"><i class="bi bi-envelope"></i><?= $fetch_order['email']; ?></p>
					<p class="user"><i class="bi bi-pin-map-fill"></i><?= $fetch_order['address']; ?></p>
					<p class="title">status do pedido:</p>
					<p class="status" style="color:<?php echo ($fetch_order['status']=='delivered')? 'green' : (($fetch_order['status']=='canceled')? 'red' : 'orange');?>"><?= ($fetch_order['status']=='delivered')? 'Entregue' : (($fetch_order['status']=='canceled')? 'Cancelado' : 'Em processamento');?></p>
					<?php if ($fetch_order['status']=='canceled') { ?>
						<a href="checkout.php?get_id=<?= $fetch_product['id']; ?>" class="btn">Voltar a Comprar</a>
					<?php }else{ ?>
						<form action="" method="post">
							<button type="submit" name="cancle" class="btn" onclick="return confirm('Queres cancelar esta compra?');">cancelar</button>
						</form>
					<?php } ?>		
				</div>
			</div>
			<?php 
							}
						}
					}
				}else{
						echo '<p class="empty">Não tens nenhuma compra!</p>';
				}
			?>
		</div>
	</div>
	
	<!-- sweetalert cdn link  -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

	<!-- custom js link  -->
	<script type="text/javascript" src="./js/script.js"></script>

	<?php include './components/alert.php'; ?>
</body>
</section>
</html>