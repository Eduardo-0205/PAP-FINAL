<?php 
 include './components/connect.php';
 if(isset($_COOKIE['user_id'])){
      $user_id = $_COOKIE['user_id'];
   }else{
      $user_id = '';
      header('location:login.php');
   }
	
	if (isset($_POST['place_order'])) {

		$name = $_POST['name'];
		$name = filter_var($name, FILTER_SANITIZE_STRING);
		$number = $_POST['number'];
		$number = filter_var($number, FILTER_SANITIZE_STRING);
		$email = $_POST['email'];
		$email = filter_var($email, FILTER_SANITIZE_STRING);
		$address = $_POST['flat'].', '.$_POST['street'].', '.$_POST['city'].', '.$_POST['country'].', '. $_POST['pincode'];
		$address = filter_var($address, FILTER_SANITIZE_STRING);
		$address_type = $_POST['address_type'];
		$address_type = filter_var($address_type, FILTER_SANITIZE_STRING);
		$method = $_POST['method'];
		$method = filter_var($method, FILTER_SANITIZE_STRING);

	

		$varify_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id=?");
		$varify_cart->execute([$user_id]);

		if (isset($_GET['get_id'])) {
			$get_product = $conn->prepare("SELECT * FROM `products` WHERE id=? LIMIT 1");
			$get_product->execute([$_GET['get_id']]);
			if ($get_product->rowCount() > 0) {
				while($fetch_p = $get_product->fetch(PDO::FETCH_ASSOC)){
					$seller_id = $fetch_p['seller_id'];
					$insert_order = $conn->prepare("INSERT INTO `orders`(id, user_id, seller_id, name, number, email, address, address_type, method, product_id, price, qty) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)");
			        $insert_order->execute([unique_id(), $user_id, $seller_id, $name, $number, $email, $address, $address_type, $method, $fetch_p['id'], $fetch_p['price'], 1]);
			            header('location:order.php');
					
					
				}
			}else{
				$warning_msg[] = 'somthing went wrong';
			}
		}elseif ($varify_cart->rowCount()>0) {
			while($f_cart = $varify_cart->fetch(PDO::FETCH_ASSOC)){
				$s_products=$conn->prepare("SELECT * FROM `products` WHERE id=? LIMIT 1");
                $s_products->execute([$f_cart['product_id']]);
                $f_product = $s_products->fetch(PDO::FETCH_ASSOC);

                $seller_id = $f_product['seller_id'];
				$insert_order = $conn->prepare("INSERT INTO `orders`(id, user_id, seller_id, name, number, email, address, address_type, method, product_id, price, qty) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)");
			        $insert_order->execute([unique_id(), $user_id, $seller_id, $name, $number, $email, $address, $address_type, $method, $f_cart['product_id'], $f_cart['price'], $f_cart['qty']]);
			            header('location:order.php');
			}
			if ($insert_order) {
				$delete_cart_id = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
				$delete_cart_id->execute([$user_id]);
				header('location: order.php');
			}
		}else{
			$warning_msg[] = 'somthing went wrong';
		}

	}
	

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
	<link rel="stylesheet" href="./css/teste67.css">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,600,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style2.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<title>blue sky summer - checkout page</title>
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
		<section class="checkout">
                <div class="row">
                	<form method="post" class="form">

                		<input type="hidden" name="p_id" value="<?= $get_id; ?>">
                		<h3>Detalhes de Compra</h3>
                		<div class="flex">
                			<div class="box">
                				<div class="input-field">
                					<p>Nome Completo <span>*</span></p>
                					<input type="text" name="name" required maxlength="50" placeholder="O seu nome" class="input">
                				</div>
                				<div class="input-field">
                					<p>Número de Telemóvel <span>*</span></p>
                					<input type="number" name="number" required maxlength="10" placeholder="O seu número" class="input">
                				</div>
                				<div class="input-field">
                					<p>Email <span>*</span></p>
                					<input type="email" name="email" required maxlength="50" placeholder="O seu email" class="input">
                				</div>
                				<div class="input-field">
                					<p>Metodo de Pagamento <span>*</span></p>
                					<select name="method" class="input">
                						<option value="cash on delivery">Mbway</option>
                						<option value="credit or debit card">Cartão de crédito ou débito</option>
                						<option value="net banking">PayPal</option>
                						<option value="UPI or RuPay">PaySafe</option>
                						<option value="paytm">Skrill</option>
                					</select>
                				</div>
                			</div>
                			<div class="box">
                				<div class="input-field">
                					<p>Morada <span>*</span></p>
                					<input type="text" name="flat" required maxlength="50" placeholder="Morada" class="input">
                				</div>
                				<div class="input-field">
                					<p>Morada 2<span></span></p>
                					<input type="text" name="street"  maxlength="50" placeholder="(opcional)" class="input">
                				</div>
                				<div class="input-field">
                					<p>Cidade <span>*</span></p>
                					<input type="text" name="city" required maxlength="50" placeholder="A sua cidade" class="input">
                				</div>
                				<div class="input-field">
                					<p>codigo postal <span>*</span></p>
                					<input type="text" name="pincode" required maxlength="9" placeholder="4000-000	" min="0" max="999999" class="input">
                				</div>
                			</div>
                		</div>
                		<button type="submit" name="place_order" class="btn">Confirmar Compra</button>
                	</form>
                	<div class="summary">
                		<h3>O Meu Carrinho:</h3>
                		<div class="box-container">
                			<?php 
                				$grand_total=0;
                				if (isset($_GET['get_id'])) {
                					$select_get = $conn->prepare("SELECT * FROM `products` WHERE id=?");
                					$select_get->execute([$_GET['get_id']]);
                					while($fetch_get = $select_get->fetch(PDO::FETCH_ASSOC)){
                						$sub_total = $fetch_get['price'];
                						$grand_total+=$sub_total;
                					
                			?>
                			<div class="flex">
                				<img src="uploaded_files/<?=$fetch_get['image']; ?>" class="image">
                				<div>
                					<h3 class="name"><?=$fetch_get['name']; ?></h3>
                				</div>
                			</div>
                			<?php 
                					}
                				}else{
                					$select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id=?");
                					$select_cart->execute([$user_id]);
                					if ($select_cart->rowCount()>0) {
                						while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
                							$select_products=$conn->prepare("SELECT * FROM `products` WHERE id=?");
                							$select_products->execute([$fetch_cart['product_id']]);
                							$fetch_product = $select_products->fetch(PDO::FETCH_ASSOC);
                							$sub_total= ($fetch_cart['qty'] * $fetch_product['price']);
                							$grand_total += $sub_total;
                							
                						
                			?>
                			<div class="flex">
                				<img src="uploaded_files/<?=$fetch_product['image']; ?>">
                				<div>
                					<h3 class="name"><?=$fetch_product['name']; ?></h3>
                					<p class="price"><?=$fetch_product['price']; ?> € X <?=$fetch_cart['qty']; ?></p>
                				</div>
                			</div>
                			<?php 
                						}
                					}else{
                						echo '<p class="empty">o teu carrinho está vazio</p>';
                					}
                				}
                			?>
                		</div>
                		<div class="grand-total"><span>Montante total a pagar: </span><?= $grand_total ?>€</div>
                	</div>
			</div>
		</section>

    
	<!-- sweetalert cdn link  -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

	<!-- custom js link  -->
	<script type="text/javascript" src="script.js"></script>

	<?php include './components/alert.php'; ?>
</body>
</section>
</html>