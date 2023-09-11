<?php
require_once "connection.php";


if(isset($_POST['submit'])){

    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $cpass = $_POST["cpassword"];

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    $rowCount = mysqli_num_rows($result);

    if($rowCount > 0)
    {
        $message[] = "Email already exists!";
    }
    else if($password != $cpass)
    {
        $message[] = 'confirm password not matched!';
    }
    else{
        $sql = "INSERT INTO users (name,email,password) VALUES (?,?,?)";
        //provide the connection variables conn
        $stmt = mysqli_stmt_init($conn);
        $prepareStmt = mysqli_stmt_prepare($stmt,$sql);

        if($prepareStmt)
        {
            //sss for three string fullname , email and password
            mysqli_stmt_bind_param($stmt,"sss",$name, $email, $password);
            mysqli_stmt_execute($stmt);
            $message[] = 'registered successfully!';
               header('location:login.php');
        }else{
            die("Something went wrong");
        }
       }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regsiter</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="components.css">
</head>
<body>
<?php

if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}

?>  

<section class="form-container">

<form action="" enctype="multipart/form-data" method="POST">
<h3>Register Now</h3>
<input type="text " name="name" class="box" placeholder="enter your name" required>
<input type="text " name="email" class="box" placeholder="enter your email" required>
<input type="password " name="password" class="box" placeholder="enter your password" required>
<input type="password" name="cpassword" class="box" placeholder="confirm your password" required>
<input type="submit" value="register now" class="btn" name="submit">
<p>already have an account? <a href="login.php">login now</a></p>
</form>


</section>
</body>
</html>
























<div class="box-container">

   <?php
      $select_product = mysqli_query($conn, "SELECT * FROM `products` LIMIT 3") or die('query failed');
      if(mysqli_num_rows($select_product) > 0){
         while($fetch_products = mysqli_fetch_assoc($select_product)){
   ?>
   <form action="" class="box" method="POST">
      <div class="price">$<span><?= $fetch_products['price']; ?></span>/-</div>
      <img class="img" src="uploaded_img/<?= $fetch_products['image']; ?>" alt="">
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
      echo '<p class="empty">no products added yet!</p>';
   }
   ?>
   </div>