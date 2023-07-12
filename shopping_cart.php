<?php 
    include 'components/connect.php';
    // components/connect.php
    

    if (isset($_COOKIE['user_id'])){
        $user_id = $_COOKIE['user_id'];
    }else{
        setcookie('user_id', create_unique_id(), time() + 60*60*24*30);
    }

    if(isset($_POST['update_cart'])){
        $cart_id = $_POST['cart_id'];
        $cart_id = filter_var($cart_id, FILTER_SANITIZE_STRING);
        $qty = $_POST['qty'];
        $qty = filter_var($qty, FILTER_SANITIZE_STRING);

        $update_cart = $conn->prepare("UPDATE `cart` SET qty = ? WHERE id = ?");
        $update_cart->execute([$qty, $cart_id]);

        $success_msg[] = 'Cart quantity update!';
    }

    if(isset($_POST['delete_item'])){
        $cart_id = $_POST['cart_id'];
        $cart_id = filter_var($cart_id, FILTER_SANITIZE_STRING);

        $verify_delete_item = $conn->prepare("SELECT * FROM `cart` WHERE id = ? ");
        $verify_delete_item->execute([$cart_id]);
        if($verify_delete_item->rowCount() > 0){
            $delete_item = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
            $delete_item->execute([$cart_id]);
            $success_msg[] = 'Cart item remove!';
        }else{
            $warning_msg[] = 'Cart item already delete!'; 
        }
    }

    if(isset($_POST['empty_cart'])){
        $verify_empty_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ? ");
        $verify_empty_cart->execute([$user_id]);
        if($verify_empty_cart->rowCount() > 0){
            $empty_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
            $empty_cart->execute([$user_id]);
            $success_msg[] = 'Remove all from cart!';
        }else{
            $warning_msg[] = 'Already remove all!'; 
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Order</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>

<!-- hearder section starts  -->
    <?php include 'components/header.php'; ?>
<!-- hearder section ends  -->

<!-- shopping cart section starts  -->

<section class="products">

<h1 class="heading">shopping cart</h1>

<div class="box-container">

    <?php 
    
        $grand_total = 0;
        $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
        $select_cart->execute([$user_id]);
        if ($select_cart-> rowCount() > 0){
            while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
                
                $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
                $select_products->execute([$fetch_cart['product_id']]);
                if ($select_products->rowCount() > 0){
                    while ($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
                
        
    
    ?>
    <form action="" method="POST" class="box">
        <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
        <img src="uploaded_files/<?= $fetch_product['image']; ?>" class="image" alt="">
        <h3 class="name"><?= $fetch_product['name']; ?></h3>
        <div class="flex">
            <p class="price"><i class="fas fa-dollar-sign"></i><?= $fetch_product['price']; ?></p>
            <input type="number" name="qty" maxlength="2" class="qty" min="1" value="<?= $fetch_cart['qty']; ?>" max="99" require id="">
            <button type="submit" class="fas fa-edit" name="update_cart"></button>
        </div>
        <p class="sub-total">subtotal: <span><i class="fas fa-dollar-sign"></i> <?= $sub_total = ($fetch_product['price'] * $fetch_cart['qty']); ?></span>  </p>
        <input type="submit" value="delete item" class="delete-btn" name="delete_item" onclick="return comfirm('Delete this item?')">
    </form>
    <?php 
        $grand_total += $sub_total;            }
     }else{
        echo '<p class="empty">no products found!</p>';
     } 
    }
    }else{
            echo '<p class="empty">shopping cart is empty!</p>';
        }
    
    ?>
        
    </div>

    <?php if($grand_total != 0){ ?>
        <div class="grand-total">
            <p>grand total: <span><i class="fas fa-dollar-sign"></i><?= $grand_total ?></span></p>
            <a href="checkout.php" class="btn">proceed to checkout</a>
            <form action="" method="POST">
                <input type="submit" value="empty cart" name="empty_cart" class="delete-btn" onclick="return confirm('empty your cart!');">
            </form>
        </div>
    <?php } ?>

    

    </section>


<!-- shopping cart section ends  -->









<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- custom js file link  -->
<script src="js/script.js"></script>

<?php include 'components/alert.php' ?>
</body>
</html>