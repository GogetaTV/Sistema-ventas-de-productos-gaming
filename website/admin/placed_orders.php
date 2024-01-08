<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
    header('location:admin_login.php');
};

if(isset($_POST['update_payment'])){

    $order_id = $_POST['order_id'];
    $payment_status = $_POST['payment_status'];
    $update_status = $conn->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
    $update_status->execute([$payment_status, $order_id]);
    $message[] = 'payment status updated!';

}

if(isset($_GET['delete'])){

    $delete_id = $_GET['delete'];
    $delete_order = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
    $delete_order->execute([$delete_id]);
    header('location:placed_orders.php');

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos realizados</title>

   <!-- font awesome cdn link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

   <!-- custom css file link -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php' ?>

<!-- Seccion de pedidos realizados -->

<section class="placed-orders">

    <h1 class="heading">Pedidos realizados</h1>

    <div class="box-container">

    <?php
       $select_orders = $conn->prepare("SELECT * FROM `orders`");
       $select_orders->execute();
       if($select_orders->rowCount() > 0){
          while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
    ?>
    <div class="box">
        <p> ID Usuario:<span><?= $fetch_orders['user_id']; ?></span> </p>
        <p> Pedido en: <span><?= $fetch_orders['placed_on']; ?></span> </p>
        <p> Nombre: <span><?= $fetch_orders['name']; ?></span> </p>
        <p> E-mail: <span><?= $fetch_orders['email']; ?></span> </p>
        <p> Numero: <span><?= $fetch_orders['number']; ?></span> </p>
        <p> Direccion: <span><?= $fetch_orders['address']; ?></span> </p>
        <p> Total de productos: <span><?= $fetch_orders['total_products']; ?></span> </p>
        <p> Precio total: <span>s/.<?= $fetch_orders['total_price']; ?></span> </p>
        <p> Metodo de pago: <span><?= $fetch_orders['method']; ?></span> </p>
        <form action="" method="POST">
            <input type="hidden" name = "order_id" value="<?= $fetch_orders['id']; ?>">
            <select name="payment_status" class="drop-down">
                <option value="" selected disabled><?= $fetch_orders ['payment_status']; ?></option>
                <option value="pending">Pendiente</option>
                <option value="Completado">Completado</option>
            </select>
            <div class="flex-btn">
                <input type="submit" value="Actualizar" class="btn" name="update_payment">
                <a href="placed_orders.php?delete=<?= $fetch_orders['id']; ?>" class="delete-btn" onclick="return confirm('Eliminar este pedido?');">Eliminar</a>
            </div>
        </form>
    </div>
    <?php
       }
    }else{
       echo '<p class="empty">Aun no hay pedidos realizados!</p>';
    }
    
    ?>



    </div>

</section>

<!-- Seccion de pedidos realizados -->









<!--Links de js personalizados -->

<script src="../js/admin_script.js"></script>

</body>
</html>