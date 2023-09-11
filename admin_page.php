<?php
require_once "connection.php";

session_start();

$admin_id = $_SESSION['admin_id'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="admin_style.css">
</head>
<body>
<?php include 'admin_header.php'; ?> 


   <section class="dashboard">
   <h1 class="title">dashboard</h1>
   <div class="box-container">
   <div class="box">
      <?php
         $total_pendings = 0;
         $select_pending = mysqli_query($conn, "SELECT * FROM `orders` WHERE payment_status = 'pending'") or die('query failed');
         if(mysqli_num_rows($select_pending) > 0){
            $fetch_pending = mysqli_fetch_assoc($select_pending);
            $total_pendings  = $fetch_pending['total_price'];
         };
      ?>
      <h3>$<?= $total_pendings; ?>/-</h3>
      <p>total pendings</p>
      <a href="admin_orders.php" class="btn">see orders</a>
      </div>

      <div class="box">
      <?php
         $total_completed = 0;
         $select_completed = mysqli_query($conn, "SELECT * FROM `orders` WHERE payment_status = 'completed'") or die('query failed');
         if(mysqli_num_rows($select_completed) > 0){
            $fetch_completed= mysqli_fetch_assoc($select_completed);
            $total_completed  = $fetch_completed['total_price'];
         };
      ?>
      <h3>$<?= $ $total_completed; ?>/-</h3>
      <p>total completed</p>
      <a href="admin_orders.php" class="btn">see orders</a>
      </div>

         <div class="box">
         <?php
         $select_orders = mysqli_query($conn, "SELECT count(id) FROM `orders` ") or die('query failed');
         $number_of_orders = mysqli_fetch_row($select_orders)[0];
         ?>
         <h3><?= $number_of_orders; ?></h3>
         <p>orders placed</p>
         <a href="admin_orders.php" class="btn">see orders</a>
         </div>

         <div class="box">
         <?php
         $select_products = mysqli_query($conn, "SELECT count(id) FROM `products` ") or die('query failed');
         $number_of_products = mysqli_fetch_row($select_products)[0];
         ?>
         <h3><?= $number_of_products; ?></h3>
         <p>products added</p>
         <a href="admin_product.php" class="btn">see products</a>
         </div>
         

         <div class="box">
         <?php
         /*$sql = "SELECT COUNT(id) FROM persons";
         $result = mysqli_query($connection,$sql);
         $rows = mysqli_fetch_row($result);
         return $rows[0]; */
         $select_users = mysqli_query($conn, "SELECT count(id) FROM `users` WHERE user_type = 'user' ") or die('query failed');
         $number_of_users = mysqli_fetch_row($select_users)[0];
         ?>
         <h3><?= $number_of_users; ?></h3>
         <p>total users</p>
         <a href="admin_users.php" class="btn">see accounts</a>
         </div>

         <div class="box">
         <?php
         $select_admins = mysqli_query($conn, "SELECT count(id) FROM `users` WHERE user_type = 'admin' ") or die('query failed');
         $number_of_admins = mysqli_fetch_row($select_admins)[0];
         ?>
         <h3><?= $number_of_admins; ?></h3>
         <p>total admins</p>
         <a href="admin_users.php" class="btn">see accounts</a>
         </div>

         <div class="box">
         <?php
         $select_accounts = mysqli_query($conn, "SELECT count(id) FROM `users` ") or die('query failed');
         $number_of_accounts = mysqli_fetch_row($select_accounts)[0];
         ?>
         <h3><?= $number_of_accounts; ?></h3>
         <p>total accounts</p>
         <a href="admin_users.php" class="btn">see accounts</a>
         </div>

         <div class="box">
         <?php
         $select_messages = mysqli_query($conn, "SELECT count(id) FROM `message` ") or die('query failed');
         $number_of_messages = mysqli_fetch_row($select_messages)[0];
         ?>
         <h3><?= $number_of_messages; ?></h3>
         <p>total messages</p>
         <a href="admin_contacts.php" class="btn">see messages</a>
         </div>
</div>

</div>
</section>

</body>
<script src="script.js"></script>
</html>