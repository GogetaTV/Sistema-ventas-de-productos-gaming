<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}else{
    $user_id = '';
    header('location:user_login.php');
}

if(isset($_POST['delete'])){
    $cart_id = $_POST['cart_id'];
    $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
    $delete_cart->execute([$cart_id]);
    $message[] = "Articulo eliminado del carrito";
}

if(isset($_GET['delete_all'])){
    $delete_all = $_GET['delete_all'];
    $delete_all_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
    $delete_all_cart->execute([$user_id]);
    header('location:cart.php');
}

if(isset($_POST['update_qty'])){
    $cart_id = $_POST['cart_id'];
    $qty = $_POST['qty'];
    $update_qty = $conn->prepare("UPDATE `cart` SET quantity = ? WHERE id = ?");
    $update_qty->execute([$qty, $cart_id]);
    $message[] = 'Cantidad del producto actualizada!';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cart</title>

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- custom css file link -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>

<!-- seccion carrito de compras -->

<section class="products">

    <h1 class="heading">Carrito de compras</h1>

    <div class="box-container">
  
    <?php
    $grand_total = 0;
    $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
    $select_cart->execute([$user_id]);
    if($select_cart->rowCount() > 0){
        while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
    ?>
    <form action="" method="post" class="box">
        <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
        <a href="quick_view.php?pid=<?= $fetch_cart['pid']; ?>" class="fas fa-eye"></a>
        <img src="uploaded_img/<?= $fetch_cart['image']; ?>" class="image" alt="">
        <div class="name"><?= $fetch_cart['name']; ?></div>
        <div class="flex">
            <div class="price">S/.<span><?= $fetch_cart['price'] ?></span></div> 
            <input type="number" name="qty" class="qty" min="1" max="99" value="<?= $fetch_cart['quantity']; ?>" onkeypress="if(this.value.lenght == 2) return false;">
            <button type="submit" class="fas fa-edit" name="update_qty"></button>
        </div>
        <div class="sub-total">sub total : <span>S/.<?= $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?></span></div>
        <input type="submit" value="Quitar producto" onclick="return confirm('Quitar este producto del carrito?')" name="delete" class="delete-btn">
    </form>
    <?php
       $grand_total += $sub_total;
          } 
         }else{
            echo '<p class="empty"> Tu carrito esta vacio</p>';
         }
    ?>

    </div>

    <div class="grand-total">
        <p>Totalidad : <span>S/.<?= $grand_total; ?></span></p>
        <a href="shop.php" class="option-btn">Continuar comprando</a>
        <a href="cart.php?delete_all" class="delete-btn <?=($grand_total > 1)?'':'disabled'; ?>" onclick="return confirm('Eliminar todo del carrito?')">Eliminar todo</a>
        <a href="checkout.php" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>" >Proceder al pago</a>
    </div>

</section>

<!-- seccion carrito de compras -->
















<?php include 'components/footer.php'?>


<!--Links de js personalizados -->

<script src="js/script.js"></script>
    
</body>
</html>