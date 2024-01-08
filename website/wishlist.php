<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}else{
    $user_id = '';
    header('location:user_login.php');
}

include 'components/whishlist_cart.php';

if(isset($_POST['delete'])){
    $wishlist_id = $_POST['wishlist_id'];
    $delete_wishlist = $conn->prepare("DELETE FROM `whishlist` WHERE id = ?");
    $delete_wishlist->execute([$wishlist_id]);
    $message[] = "Articulo eliminado de la lista de deseos";
}

if(isset($_GET['delete_all'])){
    $delete_all = $_GET['delete_all'];
    $delete_all_wishlist = $conn->prepare("DELETE FROM `whishlist` WHERE user_id = ?");
    $delete_all_wishlist->execute([$user_id]);
    header('location:wishlist.php');
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>wishlist</title>

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- custom css file link -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>

<!-- seccion lista de deseados -->

<section class="products">

    <h1 class="heading">Tu lista de deseados</h1>

    <div class="box-container">
  
    <?php
    $grand_total = 0;
    $select_wishlist = $conn->prepare("SELECT * FROM `whishlist` WHERE user_id = ?");
    $select_wishlist->execute([$user_id]);
    if($select_wishlist->rowCount() > 0){
        while($fetch_wishlist = $select_wishlist->fetch(PDO::FETCH_ASSOC))
        {
            $grand_total += $fetch_wishlist['price'];
    ?>
    <form action="" method="post" class="box">
        <input type="hidden" name="pid" value="<?= $fetch_wishlist['pid']; ?>">
        <input type="hidden" name="name" value="<?= $fetch_wishlist['name']; ?>">
        <input type="hidden" name="price" value="<?= $fetch_wishlist['price']; ?>">
        <input type="hidden" name="image" value="<?= $fetch_wishlist['image']; ?>">
        <input type="hidden" name="wishlist_id" value="<?= $fetch_wishlist['id']; ?>">
        <a href="quick_view.php?pid=<?= $fetch_wishlist['pid']; ?>" class="fas fa-eye"></a>
        <img src="uploaded_img/<?= $fetch_wishlist['image']; ?>" class="image" alt="">
        <div class="name"><?= $fetch_wishlist['name']; ?></div>
        <div class="flex">
            <div class="price">S/.<span><?= $fetch_wishlist['price'] ?></span></div> 
            <input type="number" name="qty" class="qty" min="1" max="99" value="1" onkeypress="if(this.value.lenght == 2) return false;">
        </div>
        <input type="submit" value="Añadir al carrito" name="add_to_cart" class="btn">
        <input type="submit" value="Quitar" onclick="return confirm('Quitar este producto de su lista de deseados?')" name="delete" class="delete-btn">
    </form>
    <?php
          } 
         }else{
            echo '<p class="empty"> Tu lista de deseados esta vacia</p>';
         }
    ?>

    </div>

    <div class="grand-total">
        <p>Totalidad : <span>S/.<?= $grand_total; ?></span></p>
        <a href="shop.php" class="option-btn">Continuar comprando</a>
        <a href="wishlist.php?delete_all" class="delete-btn <?=($grand_total > 1)?'':'disabled'; ?>" onclick="return confirm('Eliminar todo de la lista de deseos?')">Eliminar todo</a>
    </div>

</section>

<!-- seccion lista de deseados -->
















<?php include 'components/footer.php'?>


<!--Links de js personalizados -->

<script src="js/script.js"></script>
    
</body>
</html>