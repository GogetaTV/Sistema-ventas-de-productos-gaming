<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}else{
    $user_id = '';
    header('location:user_login.php');
}

if(isset($_POST['order'])){

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $method = $_POST['method'];
    $method = filter_var($method, FILTER_SANITIZE_STRING);
    $address = 'flat no. '. $_POST['flat'] .', '. $_POST['street'] .', '. $_POST['city'] .', '. $_POST['state'] .', '. $_POST['country'] .' - '. $_POST['pin_code'];
    $address = filter_var($address, FILTER_SANITIZE_STRING);
    $total_products = $_POST['total_products'];
    $total_products = filter_var($total_products, FILTER_SANITIZE_STRING);
    $total_price = $_POST['total_price'];
    $total_price = filter_var($total_price, FILTER_SANITIZE_STRING);

    $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
    $check_cart->execute([$user_id]);

    if($check_cart->rowCount() > 0){
        $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price) VALUES(?,?,?,?,?,?,?,?)");
        $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $total_price]);
        
        $message[] = 'Pedido realizado exitosamente';

        $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
        $delete_cart->execute([$user_id]);

    }else{
        $message[] = 'Tu carrito esta vacio!';
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>checkout</title>

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- custom css file link -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>

<!-- Seccion de verificacion -->

<section class="checkout">

    <h1 class="heading">Tus pedidos</h1>

    <div class="display-orders">
    <?php
    $grand_total = 0;
    $cart_items[] = '';
    $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
    $select_cart->execute([$user_id]);
    if($select_cart->rowCount() > 0){
       while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
          $cart_items[] = $fetch_cart['name'].' ('.$fetch_cart['price'].' x '. $fetch_cart['quantity'].') - ';
          $total_products = implode($cart_items);
          $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
 ?>
    <p> <?= $fetch_cart['name']; ?> <span>s/.<?= $fetch_cart['price']; ?> x <?= $fetch_cart['quantity']; ?></span> </p>
    <?php
          } 
         }else{
            echo '<p class="empty"> Tu carrito esta vacio</p>';
         }
    ?>
    
    </div>

    <p class="grand-total">Totalidad : <span>S/.<?= $grand_total; ?></span></p>

    <form action="" method="post">

    <h1 class="heading">Hacer pedido</h1>

    <input type="hidden" name="total_products" value="<?= $total_products; ?>">
    <input type="hidden" name="total_price" value="<?= $grand_total; ?>">
        <div class="flex">
            <div class="inputBox">
                <span>Tu nombre :</span>
                <input type="text" maxlength="20" placeholder="Ingrese su nombre" required class="box" name="name">
            </div>
            <div class="inputBox">
                <span>Tu numero :</span>
                <input type="number" min="0" max="999999999" onkeypress="if(this.value.length == 10) return false;" placeholder="Ingrese su numero" required class="box" name="number">
            </div>
            <div class="inputBox">
                <span>Tu correo :</span>
                <input type="email" maxlength="20" placeholder="Ingrese su correo" required class="box" name="email">
            </div>
            <div class="inputBox">
                <span>Metodo de pago :</span>
                <select name="method" class="box">
                    <option value="Pago en contraentrega">Pago en contraentrega</option>
                    <option value="Tarjeta de credito">Tarjeta de credito</option>
                    <option value="Paypal">paypal</option>
                    <option value="Paytm">paytm</option>
                </select>
            </div>
            <div class="inputBox">
                <span>Direccion linea 1 :</span>
                <input type="text" maxlength="50" placeholder="Direccion" required class="box" name="flat">
            </div>
            <div class="inputBox">
                <span>Direccion linea 2 :</span>
                <input type="text" maxlength="50" placeholder="Calle" required class="box" name="street">
            </div>
            <div class="inputBox">
                <span>Ciudad :</span>
                <input type="text" maxlength="50" placeholder="Puno" required class="box" name="city">
            </div>
            <div class="inputBox">
                <span>Departamento :</span>
                <input type="text" maxlength="50" placeholder="Puno" required class="box" name="state">
            </div>
            <div class="inputBox">
                <span>Pais :</span>
                <input type="text" maxlength="50" placeholder="Perú" required class="box" name="country">
            </div>
            <div class="inputBox">
                <span>Codigo postal :</span>
                <input type="number" min="0" max="999999" placeholder="21001" required class="box" name="pin_code" onkeypress="if(this.value.length == 6) return false;">
            </div>
        </div>

        <input type="submit" value="Realizar pedido" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>" name="order">

    </form>

</section>

<!-- Seccion de verificacion -->














<?php include 'components/footer.php'?>


<!--Links de js personalizados -->

<script src="js/script.js"></script>
    
</body>
</html>