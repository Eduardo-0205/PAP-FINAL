<header>
	<div class="logo">
		<img src="../image/celebre3.png" width="150">
	</div>
	<div class="right">
		<div class="bx bxs-user" id="user-btn"></div>
		<div class="toggle-btn"><i class='bx bx-menu' ></i></div>
	</div>
	<div class="profile-detail">
		<?php 
			$select_profile = $conn->prepare("SELECT * FROM `sellers` WHERE id=?");
			$select_profile->execute([$seller_id]);
			if ($select_profile->rowCount() > 0) {
				$fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
			
		?>
		<div class="profile">
			<img src="../uploaded_files/<?= $fetch_profile['image']; ?>" class="logo-img" width="100">
			<p><?= $fetch_profile['name']; ?></p>
		</div>
		<div class="flex-btn">
			<a href="profile.php" class="btn">perfil</a>
			<a href="../components/admin_logout.php" onclick="return confirm('deseja fazer logout')" class="btn">logout</a>
		</div>
		<?php } ?>
	</div>
</header>
<div class="side-container">
	<div class="sidebar">
		<?php 
			$select_profile = $conn->prepare("SELECT * FROM `sellers` WHERE id=?");
			$select_profile->execute([$seller_id]);
			if ($select_profile->rowCount() > 0) {
				$fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
			
		?>
		<div class="profile">
			<img src="../uploaded_files/<?= $fetch_profile['image']; ?>" class="logo-img" width="100">
			<p><?= $fetch_profile['name']; ?></p>
		</div>
		<?php } ?>
		<h5>menu</h5>
		<div class="navbar">
			<ul>
				<li><a href="profile.php"><i class="bx bxs-home-smile"></i>perfil</a></li>
				<li><a href="add_product.php"><i class="bx bxs-shopping-bags"></i>adicionar produtos</a></li>
				<li><a href="view_posts.php"><i class="bx bxs-food-menu"></i>produtos</a></li>
				<li><a href="admin_order.php"><i class="bx bxs-food-menu"></i>Encomendas</a></li>
				<li><a href="admin_message.php"><i class="bx bxs-message"></i>menssagens</a></li>
				<li><a href="user_accounts.php"><i class="bx bxs-user-detail"></i>utilizadores</a></li>
				<li><a href="../components/admin_logout.php" onclick="return confirm('deseja fazer logout')"><i class="bx bx-log-out"></i>logout</a></li>
			</ul>
		</div>
		<h5>redes sociais</h5>
		<div class="social-links">
			<i class="bx bxl-facebook"></i>
			<i class="bx bxl-instagram-alt"></i>
			<i class="bx bxl-linkedin"></i>
			<i class="bx bxl-twitter"></i>
			<i class="bx bxl-pinterest-alt"></i>
		</div>
	</div>
</div>