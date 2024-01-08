<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}else{
    $user_id = '';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>orders</title>

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- custom css file link -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>

<!-- seccion pedidos -->

<section class="show-orders">

    <h1 class="heading">Tus pedidos</h1>

    <div class="box-container">    

    <?php
       $show_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ?");
       $show_orders->execute([$user_id]);
       if($show_orders->rowCount() > 0){
        while($fetch_orders = $show_orders->fetch(PDO::FETCH_ASSOC)){

    ?>
    <div class="box">
        <p>Pedido el : <span><?= $fetch_orders['placed_on']; ?></span> </p>
        <p>Nombre : <span><?= $fetch_orders['name']; ?></span> </p>
        <p>Numero : <span><?= $fetch_orders['number']; ?></span> </p>
        <p>Correo : <span><?= $fetch_orders['email']; ?></span> </p>
        <p>Direccion : <span><?= $fetch_orders['address']; ?></span> </p>
        <p>Tus pedidos : <span><?= $fetch_orders['total_products']; ?></span> </p>
        <p>Total a pagar : <span>S/.<?= $fetch_orders['total_price']; ?></span> </p>
        <p>Metodo de pago : <span><?= $fetch_orders['method']; ?></span> </p>
        <p>Estado del pago : <span style="color:<?php if($fetch_orders['payment_status'] == 'Pendiente'){echo 'red';}else{echo'green';} ?>"><?= $fetch_orders['payment_status'];?></span> </p> 
    </div>
    <?php
           }
        }else{
            echo '<p class="empty">Aun no tienes pedidos!</p>';
        } 
    
    ?>

    </div>

</section>

<!-- seccion pedidos -->

















<?php include 'components/footer.php'?>


<!--Links de js personalizados -->

<script src="js/script.js"></script>
    
</body>
</html>