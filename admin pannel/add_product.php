<?php 
	include '../components/connect.php';
	if(isset($_COOKIE['seller_id'])){
      	$seller_id = $_COOKIE['seller_id'];
	   }else{
	      $seller_id = '';
	      header('location:login.php');
	   }

	//add product to database
	if (isset($_POST['publish'])) {
		$id = unique_id();
		$title = $_POST['title'];
		$title = filter_var($title, FILTER_SANITIZE_STRING);
		$price = $_POST['price'];
		$price = filter_var($price, FILTER_SANITIZE_STRING);
		$content = $_POST['content'];
		$content = filter_var($content, FILTER_SANITIZE_STRING);

		$stock = $_POST['stock'];
   		$stock = filter_var($stock, FILTER_SANITIZE_STRING);
		$status = 'active';

		$image = $_FILES['image']['name'];
		$image = filter_var($image, FILTER_SANITIZE_STRING);
		$image_size = $_FILES['image']['size'];
		$image_tmp_name = $_FILES['image']['tmp_name'];
		$image_folder = '../uploaded_files/'.$image;

		$select_image = $conn->prepare("SELECT * FROM `products` WHERE image = ? AND seller_id = ?");
		$select_image->execute([$image, $seller_id]);

		if (isset($image)) {
			if ($select_image->rowCount() > 0) {
				$warning_msg[] = 'O nome da imagem é igual';
			}elseif($image_size > 2000000){
				$warning_msg[] = 'imagem muito grande';
			}else{
				move_uploaded_file($image_tmp_name, $image_folder);
			}
		}else{
			$image = '';
		}
		if ($select_image->rowCount() > 0 AND $image !='') {
			$warning_msg[] = 'mude o nome da menssagem';
		}else{
			$insert_post = $conn->prepare("INSERT INTO `products`(id,seller_id,name,price,image,stock, product_detail,status) VALUES(?,?,?,?,?,?,?,?)");
			$insert_post->execute([$id,$seller_id,$title,$price,$image, $stock,$content,$status]);
			$success_msg[] = 'produto inserido com sucesso!';
		}
	}


	//save draft product to database
	if (isset($_POST['draft'])) {
		$id = unique_id();
		$title = $_POST['title'];
		$title = filter_var($title, FILTER_SANITIZE_STRING);
		$price = $_POST['price'];
		$price = filter_var($price, FILTER_SANITIZE_STRING);
		$content = $_POST['content'];
		$content = filter_var($content, FILTER_SANITIZE_STRING);

		$stock = $_POST['stock'];
   		$stock = filter_var($stock, FILTER_SANITIZE_STRING);
		$status = 'deactive';

		$image = $_FILES['image']['name'];
		$image = filter_var($image, FILTER_SANITIZE_STRING);
		$image_size = $_FILES['image']['size'];
		$image_tmp_name = $_FILES['image']['tmp_name'];
		$image_folder = '../uploaded_files/'.$image;

		$select_image = $conn->prepare("SELECT * FROM `products` WHERE image = ? AND seller_id = ?");
		$select_image->execute([$image, $seller_id]);

		if (isset($image)) {
			if ($select_image->rowCount() > 0) {
				$warning_msg[] = 'o nome da imagem é igual';
			}elseif($image_size > 2000000){
				$warning_msg[] = 'a imagem é muito grande';
			}else{
				move_uploaded_file($image_tmp_name, $image_folder);
			}
		}else{
			$image = '';
		}
		if ($select_image->rowCount() > 0 AND $image !='') {
			$warning_msg[] = 'mude o nome da imagem';
		}else{
			$insert_post = $conn->prepare("INSERT INTO `products`(id,seller_id,name,price,image,stock, product_detail,status) VALUES(?,?,?,?,?,?,?,?)");
			$insert_post->execute([$id,$seller_id,$title,$price,$image, $stock,$content,$status]);
			$success_msg[] = 'produto inserido com sucesso!';
		}
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
		<section class="post-editor">
			<div class="heading">
				<h1>adicionar produtos</h1>
			
			</div>
			
			
			<div class="form-container">
				<form action="" method="post" enctype="multipart/form-data" class="register">
					<div class="input-field">
						<p>nome do produto <span>*</span></p>
						<input type="text" name="title" maxlength="100" placeholder="titulo do produto" required class="box">
					</div>
					<div class="input-field">
						<label>preço do produto <sup>*</sup></label>
						<input type="number" name="price" maxlength="100" placeholder="preço do produto" required class="box">
					</div>
					<div class="input-field">
						<p>detalhes <span>*</span></p>
						<textarea name="content" required maxlength="10000" placeholder="detalhes do produto" class="box"></textarea>
					</div>
					<div class="input-field">
						<p>stock <span>*</span></p>
         				<input type="number" name="stock" required maxlength="10" placeholder="stock" min="0" max="9999999999" class="box">
					</div>
					<div class="input-field">
						<label>imagem do produto <sup>*</sup></label>
						<input type="file" name="image" accept="image/*" required class="box">
					</div>
					<div class="flex-btn">
						<input type="submit" name="publish" value="publicar agora" class="btn">
						<input type="submit" name="draft" value="Guardar" class="btn">
					</div>
				</form>
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