<?php 
    include 'components/connect.php'; 
    if (isset($_COOKIE['user_id'])){
        $user_id = $_COOKIE['user_id'];
    }else{
        setcookie('user_id', create_unique_id(), time() + 60*60*24*30);
    }

    if(isset($_GET['get_id'])){
        $get_id = $_GET['get_id'];
    }else{
        $get_id = '';
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <!-- css slider  -->
    <link rel="stylesheet"href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css"/>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <?php include 'components/header.php'; ?>

    <!-- home section starts  -->

    <section class="home" id="home">

        <div class="swiper mySwiper home-slider">

            <div class="swiper-wrapper wrapper">

                 <div class="swiper-slide slide">
                    <div class="content">
                        <span>our special dish</span>
                        <h3>spicy noodles</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Obcaecati quia placeat at?</p>
                        <a href="#" class="btn">order now</a>
                    </div>
                    <div class="image">
                        <img src="uploaded_files/home-1.png" alt="">
                    </div>
                </div>

                <div class="swiper-slide slide">
                    <div class="content">
                        <span>our special dish</span>
                        <h3>fried chicken</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Obcaecati quia placeat at?</p>
                        <a href="#" class="btn">order now</a>
                    </div>
                    <div class="image">
                        <img src="uploaded_files/home-2.jpg" alt="">
                    </div>
                </div>

                <div class="swiper-slide slide">
                    <div class="content">
                        <span>our special dish</span>
                        <h3>hot pizza</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Obcaecati quia placeat at?</p>
                        <a href="#" class="btn">order now</a>
                    </div>
                    <div class="image">
                        <img src="uploaded_files/home-3.jpg" alt="">
                    </div>
                </div>

            </div>
            
            <div class="swiper-pagination"></div>
        </div>

    </section>

    <!-- home section ends  -->

    <!-- about section starts  -->

    <section class="about" id="about">

        <!-- <div class="box-about"> -->
            <h3 class="sub-heading"> about us </h3>
            <h1 class="heading"> why choose us? </h1>

            <div class="row">

                <div class="image">
                    <img src="uploaded_files/home-1.png" alt="">
                </div>

                <div class="content">
                    <h3>best food in the country</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorum quisquam deleniti, illo, rerum iste accusantium, eveniet tenetur ea eligendi ipsa fugiat vero alias quidem nostrum veritatis? Dicta, laboriosam. Officia, vitae.</p>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Praesentium omnis natus in, deserunt pariatur vitae.</p>
                    <div class="icons-container">
                        <div class="icons">
                            <i class="fas fa-shipping-fast"></i>
                            <span>free delivery</span>
                        </div>
                        
                        <div class="icons">
                            <i class="fas fa-dollar-sign"></i>
                            <span>easy payments</span>
                        </div>

                        <div class="icons">
                            <i class="fas fa-headset"></i>
                            <span>24/7 servise</span>
                        </div>
                    </div>
                    <a href="view_product.php" class="btn">learn more</a>
                </div>

        <!-- </div> -->
        </div>

        

    </section>

    <!-- about section ends  -->




    <?php include 'components/footer.php' ?>

    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- custom js file link  -->
    <script src="js/script.js"></script>

    <?php include 'components/alert.php' ?>
</body>
</html>