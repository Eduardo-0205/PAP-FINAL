<?php 
	include '../components/connect.php';
	if(isset($_COOKIE['seller_id'])){
      	$seller_id = $_COOKIE['seller_id'];
	   }else{
	      $seller_id = '';
	      header('location:login.php');
	   }

	//delete product from database
	if (isset($_POST['delete'])) {
		$p_id = $_POST['product_id'];
		$p_id = filter_var($p_id, FILTER_SANITIZE_STRING);

		$delete_product = $conn->prepare("DELETE FROM `products` WHERE id=?");
		$delete_product->execute([$p_id]);

		$success_msg[] = "Produto deletado com sucesso";
	}

?>
<style>
	<?php include '../css/admin_style.css'; ?>
</style>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- box icon cdn link  -->
   <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
	<title>Admin - add product page</title>
</head>
<body>
	<div class="main-container">
		
		<?php include '../components/admin_header.php'; ?>
		<section class="show-post">
			<div class="heading">
				<h1>Produtos</h1>
			</div>
			<div class="box-container">
				<?php 
					$select_post = $conn->prepare("SELECT * FROM `products` WHERE seller_id = ?");
					$select_post->execute([$seller_id]);
					if ($select_post->rowCount() > 0) {
						while ($fetch_post = $select_post->fetch(PDO::FETCH_ASSOC)) {
							
						
				?>
				
				<form action="" method="post" class="box">
					<input type="hidden" name="product_id" value="<?= $fetch_post['id']; ?>">
					<?php if($fetch_post['image'] != ''){ ?>
						<img src="../uploaded_files/<?= $fetch_post['image']; ?>" class="image">
					<?php } ?>
					<div class="price"><?=$fetch_post['price']; ?>€</div>
					<div class="content">
						
						<img src="../image/shape-19.png" alt="" class="shap">
						
						<div class="title"><?=$fetch_post['name']; ?></div>
						<div class="flex-btn">
							<a href="edit_post.php?id=<?= $fetch_post['id']; ?>" class="btn">editar</a>
							<button type="submit" name="delete" class="btn" onclick="return confirm('Deseja apagar este produto?');">eliminar</button>
							<a href="read_posts.php?post_id=<?= $fetch_post['id']; ?>" class="btn">ver produto</a>
						</div>
					</div>
				</form>
				<?php 
						}
					}else{
						echo '
							<div class="empty">
								<p>nenhum produto adicionado ainda<br><a href="add_product.php" class="btn" style="margin-top: 1.5rem;">Adicionar produto</a></p>
							</div>
						';
					}
				?>
			</div>
			
			
		</section>
	</div>
	
	<!-- sweetalert cdn link  -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

	<!-- custom js link  -->
	<script type="text/javascript" src="script.js"></script>

	<?php include '../components/alert.php'; ?>
</body>
</html>