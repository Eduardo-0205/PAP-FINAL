<?php 
	include './components/connect.php';
	error_reporting(0);
	if(isset($_COOKIE['user_id'])){
      $user_id = $_COOKIE['user_id'];
   }else{
      $user_id = '';
      header('location:login.php');
   }

	//update cart product quantity
	if (isset($_POST['update_cart'])) {
		$cart_id = $_POST['cart_id'];
		$cart_id = filter_var($cart_id, FILTER_SANITIZE_STRING);
		$qty = $_POST['qty'];
		$qty = filter_var($qty, FILTER_SANITIZE_STRING);

		$update_qty = $conn->prepare("UPDATE `cart` SET qty = ? WHERE id=?");
		$update_qty->execute([$qty, $cart_id]);

		$success_msg[] = 'Quantidade Alterada Com Sucesso!';
	}
	
	//delete product from cart
	if (isset($_POST['delete_item'])) {
		$cart_id = $_POST['cart_id'];
		$cart_id = filter_var($cart_id, FILTER_SANITIZE_STRING);

		$verify_delete_item = $conn->prepare("SELECT * FROM `cart` WHERE id=?");
		$verify_delete_item->execute([$cart_id]);

		if ($verify_delete_item->rowCount() > 0) {
			$delete_cart_id = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
			$delete_cart_id->execute([$cart_id]);

			$success_msg[] = 'Produto Retirado Do Carrinho Com Sucesso!';
		}else{
			$warning_msg[] = 'O Produto já não existe';
		}
	}

	//empty cart 

	if (isset($_POST['empty_cart'])) {
		$verify_empty_item = $conn->prepare("SELECT * FROM `cart` WHERE user_id=?");
		$verify_empty_item->execute([$user_id]);

		if ($verify_empty_item->rowCount() > 0) {
			$delete_cart_id = $conn->prepare("DELETE FROM `cart` WHERE user_id=?");
			$delete_cart_id->execute([$user_id]);
			$success_msg[] = 'Carrinho esvaziado com Sucesso';
		}else{
			$warning_msg[] = 'O carrinho já está limpo';
		}
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,600,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style2.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<!-- box icon cdn link  -->
   <link rel="stylesheet" href="./css/teste66.css">
	<title>blue sky summer - wishlist page</title>
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
	<section class="products">
		<div class="heading">
			<h1>Produtos no Carrinho</h1>
		</div>
		<div class="box-container">
			<?php 
				$grand_total = 0;
				$select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id=?");
				$select_cart->execute([$user_id]);
				if ($select_cart->rowCount() > 0) {
					while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
						$select_products = $conn->prepare("SELECT * FROM `products` WHERE id=?");
						$select_products->execute([$fetch_cart['product_id']]);
						if ($select_products->rowCount() > 0) {
							$fetch_products = $select_products->fetch(PDO::FETCH_ASSOC);
						
			?>
			<form action="" method="post" class="box <?php if($fetch_products['stock'] == 0){echo 'disabled';}; ?>">
				<input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
				<img src="uploaded_files/<?= $fetch_products['image']; ?>" class="image">
				<?php if ($fetch_products['stock'] > 9) { ?>
		         <span class="stock" style="color: green;"><i  style="margin-right: .5rem;"></i>Com Stock</span>
			      <?php }elseif($fetch_products['stock'] == 0){ ?>
			         <span class="stock" style="color: red;"><i  style="margin-right: .5rem;"></i>Sem Stock</span>
			      <?php }else{ ?>
			         <span class="stock" style="color: red;">Corre, só <?= $fetch_products['stock']; ?> unidades restantes</span>
			      <?php } ?>
				<div class="content">
					<img src="image/shape-19.png" alt="" class="shap">
					<h3 class="name"><?= $fetch_products['name']; ?></h3>
					<div class="flex-btn">
						<p class="price">Preço <?= $fetch_products['price']; ?>€</p>
						<input type="number" name="qty" required min="1" value="<?= $fetch_cart['qty']; ?>" max="99" maxlength="2" class="qty">
						<button type="submit" name="update_cart" class="fa fa-pencil-square"></button>
					</div>
					<div class="flex-btn">
						<p class="sub-total">sub total : <span><?= $sub_total = ($fetch_cart['qty']*$fetch_cart['price']); ?>€</span></p>
						<button type="submit" name="delete_item" class="btnteste" onclick="return confirm('Retirar este Produto?');">Retirar</button>
					</div>
				</div>
			</form>
			<?php 
						$grand_total+=$sub_total;
						}else{
							echo'
								<div class="empty">
									<p>Nenhum produto encontrado</p>
								</div>
							';
						}
					}
				}else{
					echo'
						<div class="empty">
							<p>Nenhum produto adicionado!</p>
						</div>
					';
				}
			?>
		</div>
		<?php 
			if ($grand_total != 0) {
				
		?>
		<div class="cart-total">
			<p>Montante a Pagar: <span> <?= $grand_total; ?>€</span></p>
			<div class="button">
				<form action="" method="post">
					<button type="submit" name="empty_cart" class="btn" onclick="return confirm('Tem a certeza que quer esvaziar o carrinho?');">Esvaziar o Carrinho</button>
				</form>
				<a href="checkout.php" class="btn">Finalizar a Compra</a>
			</div>
		</div>
		<?php }?>
	</section>
	<!-- sweetalert cdn link  -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

	<!-- custom js link  -->
	<script type="text/javascript" src="script.js"></script>

	<?php include './components/alert.php'; ?>
</body>
</section>
</html>