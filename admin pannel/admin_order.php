<?php 
	include '../components/connect.php';
	if(isset($_COOKIE['seller_id'])){
      	$seller_id = $_COOKIE['seller_id'];
	   }else{
	      $seller_id = '';
	      header('location:login.php');
	   }
	//update order payment
	if (isset($_POST['update_order'])) {
		$order_id = $_POST['order_id'];
		$order_id = filter_var($order_id, FILTER_SANITIZE_STRING);

		$update_payment = $_POST['update_payment'];
		$update_payment = filter_var($update_payment, FILTER_SANITIZE_STRING);

		$update_pay = $conn->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
		$update_pay->execute([$update_payment, $order_id]);
		$success_msg[] = 'O estado da encomenda foi atualizado';
	}
	
	//detele order details

	if (isset($_POST['delete_order'])) {
		$delete_id = $_POST['order_id'];
		$delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

		$verify_delete = $conn->prepare("SELECT * FROM `orders` WHERE id=?");
		$verify_delete->execute([$delete_id]);

		if ($verify_delete->rowCount() > 0) {
			$delete_order = $conn->prepare("DELETE FROM `orders` WHERE id=?");
			$delete_order->execute([$delete_id]);
			$success_msg[] = 'Encomenda Eliminada';
		}else{
			$warning_msg[] = 'A encomenda já foi eliminada';
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
	<title>Admin - order placed page</title>
</head>
<body>
	<div class="main-container">
		<?php include '../components/admin_header.php'; ?>
		<section class="order-container">
			<div class="heading">
				<h1>Encomendas:</h1>
			</div>
			
			<div class="box-container">
				<?php 
					$select_order = $conn->prepare("SELECT * FROM `orders` WHERE seller_id=?");
					$select_order->execute([$seller_id]);
					if ($select_order->rowCount() > 0) {
						while($fetch_order = $select_order->fetch(PDO::FETCH_ASSOC)){


				?>
				<div class="box">
					<div class="status" style="color: <?php if($fetch_order['status'] == 'in progress'){echo "limegreen";}else{echo "coral";} ?>"><?= $fetch_order['status']; ?></div>
					<div class="detail">
						<p>Nome : <span><?= $fetch_order['name']; ?></span></p>
						<p>user id : <span><?= $fetch_order['user_id']; ?></span></p>
						<p>Data : <span><?= $fetch_order['date']; ?></span></p>
						<p>Numero : <span><?= $fetch_order['number']; ?></span></p>
						<p>email : <span><?= $fetch_order['email']; ?></span></p>
						<p>Montante total : <span><?= $fetch_order['price']; ?></span></p>
						<p>Metodo de pagamento : <span><?= $fetch_order['method']; ?></span></p>
						<p>Morada : <span><?= $fetch_order['address']; ?></span></p>
					</div>
					<form action="" method="post">
						<input type="hidden" name="order_id" value="<?= $fetch_order['id']; ?>">
						<select name="update_payment" class="box" style="width:90%;">
							<option value="pending">Em progresso</option>
							<option value="complete">Completa</option>
						</select>
						<div class="flex-btn">
							<input type="submit" name="update_order" value="Atualizar encomenda" class="btn">
							<input type="submit" name="delete_order" value="Apagar encomenda" class="btn" onclick="return confirm('Apagar esta encomenda?');">
						</div>
					</form>
				</div>
				<?php 
						}
					}else{
						echo '
							<div class="empty">
								<p>Nenhuma encomenda!</p>
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