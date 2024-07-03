<?php

   include 'components/connect.php';

   if(isset($_COOKIE['user_id'])){
      $user_id = $_COOKIE['user_id'];
   }else{
      $user_id = '';
      
   }



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/user_style.css">
    <title>Blue Sky Summer - home page</title>
</head>
<body>
    <?php include './components/user_header.php'; ?>
    <!-- slider section -->
    <div class="slider-container" id="home">
        <div class="slider">
            <div class="slideBox active">
                <div class="textBox">
                    <h1>we pride ourselfs on <br> exceptional flavors</h1>
                    <a href="" class="btn">shop now</a>
                </div>
                <div class="imgBox">
                    <img src="image/teste2.jpg" alt="">
                </div>
            </div>
            <div class="slideBox">
                <div class="textBox">
                    <h1>cold treats are my kind <br> of comfort food</h1>
                    <a href="" class="btn">shop now</a>
                </div>
                <div class="imgBox">
                    <img src="image/teste2.jpg" alt="">
                </div>
            </div> 
        </div>
    </div>
    <!-- service -->
    <div class="service">
        <div class="box-container">
            <div class="box">
                <div class="icon">
                    <div class="icon-box">
                        <img src="image/services.png" alt="" class="img1">
                        <img src="image/services (1).png" alt="" class="img2">
                    </div>
                </div>
                <div class="detail">
                    <h4>delivry</h4>
                    <span>100% secure</span>
                </div>
            </div>
            <!-- service item -->
            <div class="box">
                <div class="icon">
                    <div class="icon-box">
                        <img src="image/services (2).png" alt="" class="img1">
                        <img src="image/services (3).png" alt="" class="img2">
                    </div>
                </div>
                <div class="detail">
                    <h4>payment</h4>
                    <span>100% secure</span>
                </div>
            </div>
            <!-- service item -->
            <div class="box">
                <div class="icon">
                    <div class="icon-box">
                        <img src="image/services (5).png" alt="" class="img1">
                        <img src="image/services (6).png" alt="" class="img2">
                    </div>
                </div>
                <div class="detail">
                    <h4>support</h4>
                    <span>24*7 hours</span>
                </div>
            </div>
            <!-- service item -->
            <div class="box">
                <div class="icon">
                    <div class="icon-box">
                        <img src="image/services (7).png" alt="" class="img1">
                        <img src="image/services (8).png" alt="" class="img2">
                    </div>
                </div>
                <div class="detail">
                    <h4>gift service</h4>
                    <span>support gift service</span>
                </div>
            </div>
            <!-- service item -->
            <div class="box">
                <div class="icon">
                    <div class="icon-box">
                        <img src="image/service.png" alt="" class="img1">
                        <img src="image/service (1).png" alt="" class="img2">
                    </div>
                </div>
                <div class="detail">
                    <h4>returns</h4>
                    <span>24*7 free returns</span>
                </div>
            </div>
            <!-- service item -->
            <div class="box">
                <div class="icon">
                    <div class="icon-box">
                        <img src="image/services.png" alt="" class="img1">
                        <img src="image/services (1).png" alt="" class="img2">
                    </div>
                </div>
                <div class="detail">
                    <h4>delivry</h4>
                    <span>100% secure</span>
                </div>
            </div>
        </div>
    </div>
    <!-- categories -->
    <div class="categories">
        <div class="heading">
            <h1>Categories Features</h1>
            <img src="image/separator-img.png" alt="">
        </div>
        <div class="box-container">
            <div class="box">
                <img src="image/categories.jpg" alt="">
                <a href="" class="btn">coconut</a>
            </div>
            <div class="box">
                <img src="image/categories0.jpg" alt="">
                <a href="" class="btn">chocolate</a>
            </div>
            <div class="box">
                <img src="image/categories2.jpg" alt="">
                <a href="" class="btn">strawberry</a>
            </div>
            <div class="box">
                <img src="image/categories1.jpg" alt="">
                <a href="" class="btn">corn</a>
            </div>
        </div>
    </div>
    <img src="image/menu-banner.jpg" alt="" class="menu-banner">
    <!-- taste -->
    <div class="taste">
        <div class="heading">
            <span>Taste</span>
            <h1>Buy any ice cream @ get One Free</h1>
            <img src="image/separator-img.png" alt="">
        </div>
        <div class="box-container">
            <div class="box">
                <img src="image/taste.webp" alt="">
                <div class="detail">
                    <h2>Natural Sweetness</h2>
                    <h1>Vanila</h1>
                </div>
            </div>
            
            <div class="box">
                <img src="image/taste0.webp" alt="">
                <div class="detail">
                    <h2>Natural Sweetness</h2>
                    <h1>Matcha</h1>
                </div>
            </div>
            <div class="box">
                <img src="image/taste1.webp" alt="">
                <div class="detail">
                    <h2>Natural Sweetness</h2>
                    <h1>Blueberry</h1>
                </div>
            </div>
        </div>
    </div>
    <!-- taste end-->
    <!-- container -->
    <div class="ice-container">
        <div class="overlay"></div>
        <div class="detail">
            <h1>Ice cream is cheaper than <br> therapy for stress</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, <br> sed do eiusmod tempor Lorem ipsum dolor sit amet, consectetur adipiscing elit,<br> sed do eiusmod tempor incididunt ut labore.</p>
            <a href="menu.php" class="btn">shop now</a>
        </div>
    </div>
    <!-- container -->
    <div class="taste2">
        <div class="t-banner">
            <div class="overlay"></div>
            <div class="detail">
                <h1>Find Your Taste of Desserts</h1>
                <p>Treat them to a delicious treat and send them some Luck 'o the Irish too!</p>
                <a href="menu.php" class="btn">shop now</a>
            </div>
        </div>
        <div class="box-container">
            <div class="box">
                <div class="box-overlay"></div>
                <img src="image/type4.jpg" alt="">
                <div class="box-details fadeIn-bottom">
                    <h1>strawberry</h1>
                    <p>Find Your Taste of Desserts</p>
                    <a href="menu.php" class="btn">explore more</a>
                </div>
            </div>
            <div class="box">
                <div class="box-overlay"></div>
                <img src="image/type.avif" alt="">
                <div class="box-details fadeIn-bottom">
                    <h1>strawberry</h1>
                    <p>Find Your Taste of Desserts</p>
                    <a href="shop.php" class="btn">explore more</a>
                </div>
            </div>
            <div class="box">
                <div class="box-overlay"></div>
                <img src="image/type0.jpg" alt="">
                <div class="box-details fadeIn-bottom">
                    <h1>strawberry</h1>
                    <p>Find Your Taste of Desserts</p>
                    <a href="shop.php" class="btn">explore more</a>
                </div>
            </div>
            <div class="box">
                <div class="box-overlay"></div>
                <img src="image/type1.png" alt="">
                <div class="box-details fadeIn-bottom">
                    <h1>strawberry</h1>
                    <p>Find Your Taste of Desserts</p>
                    <a href="shop.php" class="btn">explore more</a>
                </div>
            </div>
            <div class="box">
                <div class="box-overlay"></div>
                <img src="image/type2.png" alt="">
                <div class="box-details fadeIn-bottom">
                    <h1>strawberry</h1>
                    <p>Find Your Taste of Desserts</p>
                    <a href="shop.php" class="btn">explore more</a>
                </div>
            </div>
            <div class="box">
                <div class="box-overlay"></div>
                <img src="image/type0.avif" alt="">
                <div class="box-details fadeIn-bottom">
                    <h1>strawberry</h1>
                    <p>Find Your Taste of Desserts</p>
                    <a href="shop.php" class="btn">explore more</a>
                </div>
            </div>
        </div>
    </div>
    <!-- flavour -->
    <div class="flavour">
        <div class="box-container">
            <img src="image/left-banner2.webp" alt="">
            <div class="detail">
                <h1>Hot Deal ! Sale Up To <span>20% Off</span></h1>
                <p>Expired</p>
                <a href="" class="btn">shop now</a>
            </div>
        </div>
    </div>
    
    <!-- features -->
    <section class="usage" id="features">
        <div class="heading">
            <h1>how it works</h1>
            <img src="image/separator-img.png" alt="">
        </div>
        
        <div class="row">
            <div class="box-container">
                <div class="box">
                    <img src="image/icon.avif" alt="">
                    <div class="detail">
                        <h3>scoop ice-cream</h3>
                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Rem dolor nihil dicta eveniet quam nam explicabo, natus labore quia cupiditate.</p>
                    </div>
                </div>
                <div class="box">
                    <img src="image/icon0.avif" alt="">
                    <div class="detail">
                        <h3>scoop ice-cream</h3>
                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Rem dolor nihil dicta eveniet quam nam explicabo, natus labore quia cupiditate.</p>
                    </div>
                </div>
                <div class="box">
                    <img src="image/icon1.avif" alt="">
                    <div class="detail">
                        <h3>scoop ice-cream</h3>
                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Rem dolor nihil dicta eveniet quam nam explicabo, natus labore quia cupiditate.</p>
                    </div>
                </div>
            </div>
            <img src="image/sub-banner.png" alt="" class="divider">
            <div class="box-container">
                <div class="box">
                    <img src="image/icon2.avif" alt="">
                    <div class="detail">
                        <h3>scoop ice-cream</h3>
                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Rem dolor nihil dicta eveniet quam nam explicabo, natus labore quia cupiditate.</p>
                    </div>
                </div>
                <div class="box">
                    <img src="image/icon3.avif" alt="">
                    <div class="detail">
                        <h3>scoop ice-cream</h3>
                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Rem dolor nihil dicta eveniet quam nam explicabo, natus labore quia cupiditate.</p>
                    </div>
                </div>
                <div class="box">
                    <img src="image/icon4.avif" alt="">
                    <div class="detail">
                        <h3>scoop ice-cream</h3>
                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Rem dolor nihil dicta eveniet quam nam explicabo, natus labore quia cupiditate.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="pride">
        <div class="detail">
            <h1>We Pride Ourselves On <br> Exceptional Flavors.</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, <br> sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            <a href="shop.php" class="btn">shop now</a>
        </div>
    </div>
    <?php include 'components/footer.php'; ?>
    <script src="js/script.js"></script>
</body>
</html>