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

   $check_wishlist_numbers = mysqli_query($conn,"SELECT * FROM `wishlist` WHERE name = '$p_name' AND user_id = '$user_id'");

   $check_cart_numbers = mysqli_query($conn,"SELECT * FROM `cart` WHERE name = '$p_name' AND user_id = '$user_id'");

   if(mysqli_num_rows($check_wishlist_numbers) > 0){
      $message[] = 'already added to wishlist!';
   }elseif(mysqli_num_rows($check_cart_numbers) > 0){
      $message[] = 'already added to cart!';
   }else{
      $insert_wishlist = mysqli_query($conn,"INSERT INTO `wishlist`(user_id, pid, name, price, image) VALUES('$user_id','$pid','$p_name','$p_price','$p_image')");
      $message[] = 'added to wishlist!';
   }

}


if(isset($_POST['add_to_cart'])){

    $pid = $_POST['pid'];
    $p_name = $_POST['p_name'];
    $p_price = $_POST['p_price'];
    $p_image = $_POST['p_image'];
   $p_qty = $_POST['p_qty'];

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
    <title>Responsive Product Slider</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<style>
@import url('components.css');
*{
    margin: 0;
    padding: 0;
}

body{
    overflow: hidden;
}

a{
    text-decoration: none;
}

.slider{
   padding:20px;
    margin: 25px;
    width: 300px;
    justify-content: center;
    align-items: flex-start;
    background-color: #fff;
    overflow: hidden;
    border-radius: .5rem;
}

.image{
    position: relative;
}

.image img{
   
    width: 100%;
    object-fit: cover;
    box-sizing: border-box;
}

.product-name{
    display: flex;
    flex-direction: column;
}
.container .slider .qty{
    margin:.5rem 0;
    border-radius: .5rem;
    padding:1.2rem 1.4rem;
    font-size: 1.8rem;
    color:black;
    width: 100%;
    border :.2rem solid  black;
 }
.product-name a{
    color: black;
    margin: 10px 0px;
    font-size: 20px;
    font-weight: bolder;
}

span{
    color: rgb(228, 225, 225);
}

.image:hover .Button{
    visibility: visible;
    animation: animation 1s;
}

@keyframes animation{
    0%{
        opacity: 0;
    }
    100%{
        opacity: 1;
    }
}

.container{
    display: flex;
    position: relative;
    height: 580px;
    width: 3300px;
    padding:2rem;
    text-align: center;
    margin: 1 30px auto;
    transform: translateX(0);
    transition: all 0.5s ease-in-out;
}

.arrow{
    position: absolute;
    top: 2700px;
    right: 0px;
    color: #fff;
    font-size: 125px;
    cursor: pointer;
}
.container .slider .name{
   font-size:20px;
}


 .container .slider .price{
   color:black;
    font-size: 1.5rem;
     font-weight :bold;
     color:orange;
 }
 .container .slider .price span{
   color:black;
    font-size: 1.5rem;
    
 }

</style>
<body>

    <div class="container">
    <?php
      $select_product = mysqli_query($conn, "SELECT * FROM `products` WHERE id > 14 ") or die('query failed');
      if(mysqli_num_rows($select_product) > 0){
         while($fetch_products = mysqli_fetch_assoc($select_product)){
   ?>
        <form action="" class="slider" method="POST">
            <div class="image">
            <img src="uploaded_img/<?= $fetch_products['image']; ?>">
            </div>
            <div class="price">$ <?= $fetch_products['price']; ?></div>
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
        
            <i class="fas fa-chevron-right arrow"></i>
        </div>
    </div>

    <script type="text/javascript">
        const arrows = document.querySelectorAll(".arrow");
        const container= document.querySelectorAll(".container");

        arrows.forEach((arrow, i) => {
            const ItemNo = container[i].querySelectorAll("img").length;
            let clickitem = 0;
            arrow.addEventListener("click", () => {
                clickitem++;
                if(ItemNo - (5 + clickitem) >= 0){
                    container[i].style.transform = `translateX(${
                        container[i].computedStyleMap().get("transform")[0].x.value
                        - 455}px)`;
                }else{
                    container[i].style.transform = "translateX(0)";
                    clickitem = 0;
                }
            });
        });
    </script>
   
</body>
</html>