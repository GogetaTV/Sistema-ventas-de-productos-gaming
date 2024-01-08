<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}else{
    $user_id = '';
}

include 'components/whishlist_cart.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda</title>

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- custom css file link -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>

<!-- Seccion tienda -->

<section class="products">
    <h1 class="heading">Ultimos Productos</h1>

    <div class="box-container">
    <?php
       $select_products = $conn->prepare("SELECT * FROM `products`");
       $select_products->execute();
       if($select_products->rowCount() > 0){
        while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
    ?>
    <form action="" method="post" class="box">
    <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
    <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
    <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
    <input type="hidden" name="image" value="<?= $fetch_products['image_01']; ?>">
    <button type="submit" name="add_to_wishlist" class="fas fa-heart"></button>
    <a href="quick_view.php?pid=<?= $fetch_products['id']; ?>"  class="fas fa-eye"></a>
    <img src="uploaded_img/<?= $fetch_products['image_01']; ?>" class ="image" alt="">
    <div class="name"><?= $fetch_products['name']; ?></div>
    <div class="flex">
        <div class="price">S/.<span><?= $fetch_products['price']; ?></span></div>
        <input type="number" name="qty" class="qty" min="1" max="99" value="1" onkeypress="if(this.value.lenght == 2) return false;">
    </div>
    <input type="submit" value="Añadir al carro" name="add_to_cart" class="btn">
    </form>
    <?php
       }
    }else{
        echo'<p class="empty">Aun no hay productos nuevos!</p>';
    }
    ?>
    </div>


</section>

<!-- Seccion tienda -->















<?php include 'components/footer.php'?>


<!--Links de js personalizados -->

<script src="js/script.js"></script>
    
</body>
</html>