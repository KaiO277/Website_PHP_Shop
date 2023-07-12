<?php 
    include 'components/connect.php';
    // components/connect.php
    

    if (isset($_COOKIE['user_id'])){
        $user_id = $_COOKIE['user_id'];
    }else{
        setcookie('user_id', create_unique_id(), time() + 60*60*24*30);
    }

    if(isset($_GET['get_id'])){
        $get_id = $_GET['get_id'];
    }else{
        $get_id = '';
        header('location:orders.php');
    }

    if(isset($_POST['cancel'])){
        $update_order = $conn->prepare("UPDATE `orders` SET status= ? 
        WHERE id = ?");
        $update_order->execute(['cancelled', $get_id]);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Order</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>

<!-- hearder section starts  -->
    <?php include 'components/header.php'; ?>
<!-- hearder section ends  -->

<!-- view orders section starts  -->

    <section class="view-order">

        <h1 class="heading">order details</h1>

        <?php 
        $grand_total = 0;
            $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE id = ? ORDER BY date DESC");
            $select_orders->execute([$get_id]);
            if ($select_orders->rowCount() > 0){
                while($fetch_order=$select_orders->fetch(PDO::FETCH_ASSOC)){
                    $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ? LIMIT 1");
                    $select_products->execute([$fetch_order['product_id']]);
                    if($select_products->rowCount() > 0){ 
                    while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){      
                        $sub_total = ($fetch_product['price'] * $fetch_order['qty']);
                        $grand_total += $sub_total;              
        ?>

        <div class="row">

            <div class="col">
                <p class="title"><i class="fas fa-calendar"></i> <?= $fetch_order['date']; ?> </p>
                <img src="uploaded_files/<?= $fetch_product['image']; ?>" alt="" class="image">
                <h3 class="name"><?= $fetch_product['name']; ?></h3>
                <p class="price"><i class="fas fa-dollar-sign"></i><?= $fetch_product['price']; ?> x <?= $fetch_order['qty']; ?></p>
                <p class="grand-total">grand total: <span><i class="fas fa-dollar-sign"></i><?= $grand_total; ?></span></p>
            </div>

            <div class="col">
                <p class="title">billing address</p>
                <p class="user"><i class="fas fa-user"></i><?= $fetch_order['name']; ?></p>
                <p class="user"><i class="fas fa-phone"></i><?= $fetch_order['number']; ?></p>
                <p class="user"><i class="fas fa-envelope"></i><?= $fetch_order['email']; ?></p> 
                <p class="user"><i class="fas fa-map-marker-alt"></i><?= $fetch_order['address']; ?></p>
                <p class="title">status</p>
                <p class="status" style="color:<?php if($fetch_order['status'] == 'canceled'){echo 'red';}
                elseif($fetch_order['status'] == 'delivered'){echo 'green';}else{echo 'orange';} ?>"><?= $fetch_order['status']; ?></p>
                <?php if($fetch_order['status'] == 'cancelled'){ ?>
                    <a href="checkout.php?get_id=<?= $fetch_order['product_id']; ?>" class="btn">order again</a>
                <?php }else{ ?>
                    <form action="" method="POST">
                        <input type="submit" value="cancel order" name="cancel" 
                        class="delete-btn" onclick="return confirm('cancel this order?');">
                    </form>
                <?php } ?>    
            </div>

        </div>

        <?php 
            }
            }else{
                echo '<p class="empty">product not found!</p>';
            }    
                }
                }else{
                    echo '<p class="empty">orders was not found!</p>';
                }
        ?>

    </section>

<!-- view orders section ends  -->









<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- custom js file link  -->
<script src="js/script.js"></script>

<?php include 'components/alert.php' ?>
</body>
</html>