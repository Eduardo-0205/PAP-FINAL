<?php
   include 'components/connect.php';
   if(isset($_COOKIE['user_id'])){
      $user_id = $_COOKIE['user_id'];
   }else{
      $user_id = '';
   }
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
        <h1>ABOUT</h1>
</section>
<!---about us conteudo -->
<section class="about-us">
    <div class="row">
<div class="about-col">
    <h1>About Us</h1>
    <p>Celebre com Classe é um projecto da Empresa Eduardo Creative Corp cuja funcionalidade é poder facilitar as pessoas a organização de eventos, entrando em contacto connosco iremos analisar a melhor forma de lhe fornecer um website para o seu evento, assim facilitando a gestão de convidados bem como toda a informação relacionada ao mesmo  </p>
    <a href="projecto.php" class="hero-btn blue-btn">EXPLORE AGORA</a>
</div>
<div class="about-col">
    <img src="image/about2.png">
</div>
</div>
</section>
<section class="course">
    <h1>Nossos Serviços</h1>
    <div class="row">
        <div class="course-col">
            <h3>Site do Evento</h3>
            <p>Informe os convidados do programa, localizações e todas as novidades sobre o evento.</p>
        </div>
        <div class="course-col">
            <h3>Gestor de Convidados</h3>
            <p>Gira facilmente a sua lista de convidados e peça-lhes confirmação de presença.</p>
        </div>
        <div class="course-col">
            <h3>Suporte rápido e eficaz!</h3>
            <p>Em caso de alguma duvida o nosso suporte está disponivel 24 horas por dia!</p>
        </div>
    </div>
</section>




<!---Footer-->
<section class="footer">
    <h4>About us</h4>
    <p>Eduardo Creative Corp </p>
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
