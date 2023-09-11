<?php

require_once "connection.php";

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_POST['add_to_wishlist'])){

   $pid = $_POST['pid'];
   $p_name = $_POST['p_name'];
    $p_price = $_POST['p_price'];
   $p_image = $_POST['p_image'];

   $check_wishlist_numbers =mysqli_query($conn,"SELECT * FROM `wishlist` WHERE name = '$p_name' AND user_id = '$user_id'");

   $check_cart_numbers = mysqli_query($conn,"SELECT * FROM `cart` WHERE name = '$p_name' AND user_id = '$user_id'");


   if(mysqli_num_rows($check_wishlist_numbers) > 0){
      $message[] = 'already added to wishlist!';
   }elseif(mysqli_query($check_cart_numbers) > 0){
      $message[] = 'already added to cart!';
   }else{
    $insert_wishlist = mysqli_query($conn,"INSERT INTO `wishlist`(user_id, pid, name, price, image) VALUES('$user_id','$pid','$p_name','$p_price','$p_image')");
    $message[] = 'added to wishlist!';
   }

}

if(isset($_POST['add_to_cart'])){

    $pid = $_POST['pid'];
    $p_name = $_POST['name'];
    $p_price = $_POST['price2'];
    $p_image = $_POST['image'];
    $p_qty = $_POST['qty'];
 
    $check_cart_numbers = mysqli_query($conn,"SELECT * FROM `cart` WHERE name = '$p_name' AND user_id = '$user_id'");
    
 
    if(mysqli_num_rows($check_cart_numbers)> 0){
       $message[] = 'already added to cart!';
 
    }else{
 
       $check_wishlist_numbers = mysqli_query($conn,"SELECT * FROM `wishlist` WHERE name = '$p_name' AND user_id = '$user_id'");
 
       if(mysqli_num_rows($check_wishlist_numbers) > 0){
          $delete_wishlist = mysqli_query($conn,"DELETE FROM `wishlist` WHERE name = '$p_name' AND user_id = '$user_id'");
       }
 
       $insert_cart = mysqli_query($conn,"INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES('$user_id', '$pid', '$p_name', '$p_price', '$p_qty', '$p_image')") or die('query failed');
       $message[] = 'added to cart!';
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>category</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="products">

   <h1 class="title">products categories</h1>

   <div class="box-container">

   <?php
      $category_name = $_GET['category'];
      $select_products = mysqli_query($conn,"SELECT * FROM `products` WHERE category = '$category_name'");
      if(mysqli_num_rows($select_products) > 0){
         while($fetch_products = mysqli_fetch_assoc($select_products)){ 
   ?>
   <form action="" class="box" method="POST">
      <div class="price">$<span><?= $fetch_products['price']; ?></span>/-</div>
      <a href="view_page.php?pid=<?= $fetch_products['id']; ?>" class="fas fa-eye"></a>
      <img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="">
      <div class="name"><?= $fetch_products['name']; ?></div>
      <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
      <input type="hidden" name="p_name" value="<?= $fetch_products['name']; ?>">
      <input type="hidden" name="p_price" value="<?= $fetch_products['price']; ?>">
      <input type="hidden" name="p_image" value="<?= $fetch_products['image']; ?>">
      <input type="number" min="1" value="1" name="p_qty" class="qty">
      <input type="submit" value="add to wishlist" class="option-btn" name="add_to_wishlist">
      <input type="submit" value="add to cart" class="btn" name="add_to_cart">
   </form>
   <?php
         }
      }else{
         echo '<p class="empty">no products available!</p>';
      }
   ?>

   </div>

</section>







<?php include 'footer.php'; ?>

<script src="script.js"></script>

</body>
</html>