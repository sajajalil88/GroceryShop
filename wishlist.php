<?php
require_once "connection.php" ;
session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};
if(isset($_GET['delete'])){

    $delete_id = $_GET['delete'];
    $delete_wishlist_item = mysqli_query($conn,"DELETE FROM `wishlist` WHERE id = '$delete_id'");
    header('location:wishlist.php');
 
 }
 
 if(isset($_GET['delete_all'])){
 
    $delete_wishlist_item = mysqli_query($conn,"DELETE FROM `wishlist` WHERE user_id = '$user_id'");
    header('location:wishlist.php');
 }

 if(isset($_POST['add_to_cart'])){

    $pid = $_POST['pid'];
    $p_name = $_POST['p_name'];
    $p_price = $_POST["p_price"];
    $p_image = $_POST["p_image"];
    $p_qty = $_POST['p_qty'];

    $check_cart_numbers = mysqli_query($conn , "SELECT * FROM 'cart' WHERE 
    name = '$p_name' AND user_id = '$user_id'");

if(mysqli_num_rows($check_cart_numbers) > 0){
    $message[] = 'already added to cart!';
 }else{

    $check_wishlist_numbers =  mysqli_query($conn,"SELECT * FROM `wishlist` WHERE name = '$p_name' AND user_id = '$user_id'");
    

    if(mysqli_num_rows($check_wishlist_numbers)> 0){
       $delete_wishlist = mysqli_query($conn,"DELETE FROM `wishlist` WHERE name = '$p_name' AND user_id = '$user_id'");
       
    }

    $insert_cart = mysqli_query($conn,"INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES('$user_id','$pid','$p_name','$p_price','$p_image')");
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="style.css">
    <title>wishlist</title>
</head>
<body>

<?php include 'header.php'; ?>

<section class="wishlist">

   <h1 class="title">products added</h1>

   <div class="box-container">

   <?php
      $grand_total = 0;
      $select_wishlist = mysqli_query($conn,"SELECT * FROM `wishlist` WHERE user_id = '$user_id'");
     
      if(mysqli_num_rows($select_wishlist) > 0){
         while($fetch_wishlist = mysqli_fetch_assoc( $select_wishlist)){ 
   ?>
   <form action="" method="POST" class="box">
      <a href="wishlist.php?delete=<?= $fetch_wishlist['id']; ?>" class="fas fa-times" onclick="return confirm('delete this from wishlist?');"></a>
      <img src="uploaded_img/<?= $fetch_wishlist['image']; ?>" alt="">
      <div class="name"><?= $fetch_wishlist['name']; ?></div>
      <div class="price">$<?= $fetch_wishlist['price']; ?>/-</div>
      <input type="number" min="1" value="1" class="qty" name="p_qty">
      <input type="hidden" name="pid" value="<?= $fetch_wishlist['pid']; ?>">
      <input type="hidden" name="p_name" value="<?= $fetch_wishlist['name']; ?>">
      <input type="hidden" name="p_price" value="<?= $fetch_wishlist['price']; ?>">
      <input type="hidden" name="p_image" value="<?= $fetch_wishlist['image']; ?>">
      <input type="submit" value="add to cart" name="add_to_cart" class="btn">
   </form>
   <?php
      $grand_total += $fetch_wishlist['price'];
      }
   }else{
      echo '<p class="empty">your wishlist is empty</p>';
   }
   ?>
   </div>

   <div class="wishlist-total">
      <p>grand total : <span>$<?= $grand_total; ?>/-</span></p>
      <a href="shop.php" class="option-btn">continue shopping</a>
      <a href="wishlist.php?delete_all" class="delete-btn <?= ($grand_total > 1)?'':'disabled'; ?>">delete all</a>
   </div>

</section>
    
</body>
</html>