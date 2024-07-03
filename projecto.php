<?php 
	include './components/connect.php';
	
	if(isset($_COOKIE['user_id'])){
      $user_id = $_COOKIE['user_id'];
   }else{
      $user_id = '';
      
   }

	

	include './components/add_wishlist.php';
	include './components/add_cart.php';

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
<link rel="stylesheet" href="./css/teste65.css">
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
        <h1>Site do Evento</h1>
</section>
<section class="products">
		<div class="box-container">
		<?php 
			$select_products = $conn->prepare("SELECT * FROM `products` WHERE status = ?");
			$select_products->execute(['active']);
			if ($select_products->rowCount() > 0) {
				while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){


		?>
		<form action="" method="post" class="box <?php if($fetch_products['stock'] == 0){echo 'disabled';}; ?>">
			<img src="uploaded_files/<?= $fetch_products['image']; ?>" class="image">
			<?php if ($fetch_products['stock'] > 9) { ?>
		         <span class="stock" style="color: green;"><i class="" style="margin-right: .5rem;"></i>Com Stock</span>
		      <?php }elseif($fetch_products['stock'] == 0){ ?>
		         <span class="stock" style="color: red;"><i class="" style="margin-right: .5rem;"></i>Sem Stock</span>
		      <?php }else{ ?>
		         <span class="stock" style="color: red;">Corre, só <?= $fetch_products['stock']; ?> unidades restantes</span>
		      <?php } ?>
			<div class="content">
				<img src="image/shape-19.png" alt="" class="shap">
				<div class="button">
					<div><h3 class="name"><?= $fetch_products['name']; ?></h3></div>
					<div>
						<button type="submit" name="add_to_cart"><i class="fa fa-shopping-cart"></i></button>
						<button type="submit" name="add_to_wishlist"><i class="fa fa-heart-o"></i></button>
						<a href="view_page.php?pid=<?= $fetch_products['id']; ?>" class="fa fa-search"></a>
					</div>
				</div>
				<p class="price">Preço: <?= $fetch_products['price']; ?>€</p>
				<input type="hidden" name="product_id" value="<?= $fetch_products['id']; ?>">
				<div class="flex-btn">
					<a href="checkout.php?get_id=<?= $fetch_products['id']; ?>" class="btn">Compra Agora</a>
					<input type="number" name="qty" required min="1" value="1" max="99" maxlength="2" class="qty">
				</div>
			</div>
		</form>
		<?php 
				}
			}else{
				echo'
					<div class="empty">
						<p>Sem produtos ainda!</p>
					</div>
				';
			}
		?>
		

	</div>

	</section>
    <!-- sweetalert cdn link  -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- custom js link  -->
<script type="text/javascript" src="./js/script.js"></script>

<?php include './components/alert.php'; ?>


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





<!-----JavaScript para menu------->     
<script>
    var navLinks = document.getElementById("navLinks")
    function showMenu(){
        navLinks.style.right = "0"
    } 
    function hideMenu(){
        navLinks.style.right = "-200px"
    } 
</script>
</body>    
</html>














<!-- swiper js link  -->
<script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>

<!-- ficheiro javascript  -->
<script src="js/script.js"></script>

</body>
</html>