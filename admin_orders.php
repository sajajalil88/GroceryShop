<?php
require_once "connection.php";
session_start();


if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
     mysqli_query($conn, "DELETE FROM `orders` WHERE id = '$delete_id'") or die('query failed');
    //$delete_wishlist = mysqli_query($conn,"DELETE FROM `wishlist` WHERE pid = '$delete_id'");
    //$delete_cart = mysqli_query($conn,"DELETE FROM `cart` WHERE pid = '$delete_id'");
    header('location: admin_orders.php');

 }; 
 if(isset($_POST['update_order'])){

    $order_id = $_POST['order_id'];
    $update_payment = $_POST['update_payment'];
    $update_orders = mysqli_query($conn,"UPDATE `orders` SET payment_status = '$update_payment' WHERE id = '$order_id'");
    $message[] = 'payment has been updated!';
 
 };
 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="admin_style.css">
</head>
<body>
<?php include 'admin_header.php'; ?>
<section class="placed-orders">

<h1 class="title">placed orders</h1>

<div class="box-container">
<?php
      $select_order = mysqli_query($conn, "SELECT * FROM `orders`") or die('query failed');
      if(mysqli_num_rows($select_order) > 0){
         while($fetch_orders = mysqli_fetch_assoc($select_order)){
   ?>
      <div class="box">
      <p> user id : <span><?= $fetch_orders['user_id']; ?></span> </p>
         <p> placed on : <span><?= $fetch_orders['placed_on']; ?></span> </p>
         <p> name : <span><?= $fetch_orders['name']; ?></span> </p>
         <p> email : <span><?= $fetch_orders['email']; ?></span> </p>
         <p> number : <span><?= $fetch_orders['number']; ?></span> </p>
         <p> address : <span><?= $fetch_orders['address']; ?></span> </p>
         <p> total products : <span><?= $fetch_orders['total_products']; ?></span> </p>
         <p> total price : <span>$<?= $fetch_orders['total_price']; ?>/-</span> </p>
         <p> payment method : <span><?= $fetch_orders['method']; ?></span> </p>

         <form action="" method = "POST">
         <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
            <select name="update_payment" class="drop-down">
               <option value="" selected disabled><?= $fetch_orders['payment_status']; ?></option>
               <option value="pending">pending</option>
               <option value="completed">completed</option>
            </select>
            <div class="flex-btn">
               <input type="submit" name="update_order" class="option-btn" value="udate">
               <a href="admin_orders.php?delete=<?= $fetch_orders['id']; ?>" class="delete-btn" onclick="return confirm('delete this order?');">delete</a>
            </div>
         </form>
      </div>
   </div>
   <?php
     }
    }else{
        echo '<p class="empty">no orders placed yet!</p>';
    }

   ?>

</div>

</section>
    
</body>
</html>