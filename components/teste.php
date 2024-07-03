<!-- header section starts -->
<header class="header">
   <section class="flex">
      <a href="home.php" class="logo">
         <img src="image/logo.png" width="130px" alt="Logo">
      </a>
      <nav class="navbar">
      <a href="order.php"><span>O meu website</span></a>
      <a href="menu.php"><span>Preços</span></a>
         <a href="about-us.php"><span>Sobre Nós</span></a>
         <a href="contact.php"><span>Contactos</span></a>
      </nav>

      <div class="icons">
         <div id="menu-btn" class="bx bx-list-plus"></div>
         <div id="search-btn" class="bx bx-search-alt-2"></div>
         <?php
            $stmt = $conn->prepare("SELECT COUNT(*) as total_wishlist_items FROM wishlist WHERE user_id = :user_id");
            $stmt->bindParam(":user_id", $user_id);
            $stmt->execute();
            $total_wishlist_items = $stmt->fetchColumn();
         ?>
         <a href="wishlist.php" class="cart-btn">
            <i class="bx bx-heart"></i>
            <sup><?= $total_wishlist_items; ?></sup>
         </a>
         <?php
            $stmt = $conn->prepare("SELECT COUNT(*) as total_cart_items FROM cart WHERE user_id = :user_id");
            $stmt->bindParam(":user_id", $user_id);
            $stmt->execute();
            $total_cart_items = $stmt->fetchColumn();
         ?>
         <a href="cart.php" class="cart-btn">
            <i class="bx bx-cart"></i>
            <sup><?= $total_cart_items; ?></sup>
         </a>
         <div id="user-btn" class="bx bxs-user"></div>
      </div>

      <div class="profile">
         <?php
            $stmt = $conn->prepare("SELECT * FROM users WHERE id = :user_id");
            $stmt->bindParam(":user_id", $user_id);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $fetch_profile = $stmt->fetch(PDO::FETCH_ASSOC);
         ?>
         
         <h3 style="margin-bottom: 1rem"><?= $fetch_profile['name']; ?></h3>
         <div class="flex-btn">
            <a href="profile.php" class="btn">View Profile</a>
            <a href="components/user_logout.php" onclick="return confirm('Logout from this website?');" class="btn">Logout</a>
         </div>
         <?php
            } else {
         ?>
         <h3 style="margin-bottom: 1rem">Please login or register</h3>
         <div class="flex-btn">
            <a href="login.php" class="btn">Login
            <a href="register.php" class="btn">register</a>
         </div>
         <?php
            }
         ?>
      </div>

   </section>

</header>

<!-- header section ends -->

<!-- side bar section starts  

<div class="side-bar">

   <div class="close-side-bar">
      <i class="fas fa-times"></i>
   </div>

   <div class="profile">
         <?php
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$user_id]);
            if($select_profile->rowCount() > 0){
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <img src="uploaded_files/<?= $fetch_profile['image']; ?>" alt="">
         <h3><?= $fetch_profile['name']; ?></h3>
         <span>student</span>
         <a href="profile.php" class="btn">view profile</a>
         <?php
            }else{
         ?>
         <h3>please login or register</h3>
          <div class="flex-btn" style="padding-top: .5rem;">
            <a href="login.php" class="option-btn">login</a>
            <a href="register.php" class="option-btn">register</a>
         </div>
         <?php
            }
         ?>
      </div>

   <nav class="navbar">
      <a href="home.php"><i class="fas fa-home"></i><span>home</span></a>
      <a href="about.php"><i class="fas fa-question"></i><span>about us</span></a>
      <a href="courses.php"><i class="fas fa-graduation-cap"></i><span>courses</span></a>
      <a href="teachers.php"><i class="fas fa-chalkboard-user"></i><span>teachers</span></a>
      <a href="contact.php"><i class="fas fa-headset"></i><span>contact us</span></a>
   </nav>

</div>

 side bar section ends --
 <!-- Add this script tag at the end of the HTML file -->
<script>
   const userBtn = document.getElementById('user-btn');
   const profileDropdown = document.querySelector('.profile');

   userBtn.addEventListener('click', () => {
      profileDropdown.classList.toggle('active');
   });

   // Add an event listener to close the dropdown when clicking outside
   document.addEventListener('click', (e) => {
      if (!profileDropdown.contains(e.target) && !userBtn.contains(e.target)) {
         profileDropdown.classList.remove('active');
      }
   });
</script>