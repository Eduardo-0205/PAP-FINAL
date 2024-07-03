<?php 
	include './components/connect.php';
	
	error_reporting(0);
	if(isset($_COOKIE['user_id'])){
      $user_id = $_COOKIE['user_id'];
   }else{
      $user_id = '';
      header('location:login.php');
   }

	
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- box icon cdn link  -->
   <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
   <link rel="stylesheet" href="./css/teste69.css">
   <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,600,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style2.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<title>blue sky summer - my order page</title>
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
	<div class="orders">
		<div class="heading">
			<h1>Meu Histórico</h1>   
		</div>
		<div class="box-container">
			<?php 
				$select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id=? ORDER BY date DESC");
				$select_orders->execute([$user_id]);
				if ($select_orders->rowCount() > 0) {
					while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
						$product_id = $fetch_orders['product_id'];
						$select_products = $conn->prepare("SELECT * FROM `products` WHERE id=?");
						$select_products->execute([$fetch_orders['product_id']]);
						if ($select_products->rowCount() > 0) {
							while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){


			?>
			<div class="box" <?php if($fetch_orders['status']=='cancele'){echo 'style="border:2px solid red;';} ?>>
				<a href="view_order.php?get_id=<?= $fetch_orders['id']; ?>">
					<img src="uploaded_files/<?= $fetch_products['image']; ?>" class="image">
					<div class="content">
						<img src="image/shape-19.png" alt="" class="shap">
						<p class="date"><i class='bx bxs-calendar-alt'></i><span><?= $fetch_orders['date']; ?></span></p>
						
						<div class="row">
							<h3 class="name"><?= $fetch_products['name']; ?></h3>
							<p class="price">Preço : <?= $fetch_products['price']; ?>€</p>
							<p class="status" style="color:<?php if($fetch_orders['status']=='delivered'){echo "green";}elseif($fetch_orders['status']=='canceled'){echo "red";}else{echo "orange";} ?>"><?= ($fetch_orders['status']=='delivered') ? 'Entregue' : (($fetch_orders['status']=='canceled') ? 'Cancelado' : 'Em processamento'); ?></p>
						</div>
					</div>

				</a>
				
			</div>
			<?php 
							}
						}
					}
				}else{
						echo '<p class="empty">Nenhuma encomenda efetuada!</p>';
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