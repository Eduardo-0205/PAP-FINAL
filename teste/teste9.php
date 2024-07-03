<?php
// Include your database connection file
include 'components/connect.php';

// Check if the user is logged in
if(isset($_COOKIE['user_id'])){
  $user_id = $_COOKIE['user_id'];
} else {
  header('location:login.php');
  exit;
}

// Retrieve the user's information from the database
$select_user = $conn->prepare("SELECT * FROM `users` WHERE id =?");
$select_user->execute([$user_id]);
$fetch_profile = $select_user->fetch(PDO::FETCH_ASSOC);

// Check if the user's profile picture exists
if(file_exists("uploaded_files/". $fetch_profile['image'])){
  $profile_pic = "uploaded_files/". $fetch_profile['image'];
} else {
  $profile_pic = "default_profile_pic.jpg"; // default profile picture
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile</title>
  <link rel="stylesheet" href="teste.css"> <!-- link to your custom CSS file -->
</head>
<body>
  <!-- Custom header -->
  <header>
    <img src="image/header-image.jpg" alt="Header Image">
    <h1>Profile</h1>
  </header>

  <!-- Profile section -->
  <section class="profile">
    <div class="profile-pic">
      <img src="<?php echo $profile_pic;?>" alt="Profile Picture">
    </div>
    <div class="profile-info">
      <h2><?php echo $fetch_profile['name'];?></h2>
      <p>Email: <?php echo $fetch_profile['email'];?></p>
      <p>Username: <?php echo $fetch_profile['username'];?></p>
      <!-- Add more information from the "users" table as needed -->
    </div>
  </section>

  <!-- Background image -->
  <div class="background-image">
    <img src="image/background-image.jpg" alt="Background Image">
  </div>

</body>
</html>